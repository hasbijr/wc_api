<?php

namespace App\Http\Controllers;

use App\Models\OutcomeDistribution;
use App\Models\OutcomeDistributionPoint;
use App\Models\OutcomeDistributionPointEvidence;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use ZipArchive;

class OutcomeDistributionPointController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['only' => ['create', 'update']]);
        $this->middleware('permission:create-distribution-point', ['only' => ['create']]);
    }

    public function create(Request $request, $outcome_distribution_id)
    {
        $this->validate($request, [
            'distribution_points.*.distribution_type_id' => 'required|exists:distribution_types,id',
            'distribution_points.*.nama_point' => 'required',
            'distribution_points.*.tanggal' => 'required',
            'distribution_points.*.jumlah_dana' => 'required',
            'distribution_points.*.jumlah_paket' => 'required',
            'distribution_points.*.deskripsi' => 'required',
            'distribution_points.*.evidence.*.file' => 'required|max:10000|image',
            'distribution_status' => 'required|boolean',
        ]);

        $auth = auth()->user()->id;
        DB::beginTransaction();

        try {

            $distribution = OutcomeDistribution::with(['campaignAgent'])
                ->where('id', $outcome_distribution_id)
                ->first();

            if (empty($distribution)) {
                return $this->writeResponse(self::HTTP_STATUS_NOT_FOUND, '', false);
            }

            if ($distribution->campaignAgent->user_id != $auth) {
                return $this->writeResponse(self::HTTP_STATUS_FORBIDDEN, 'forbidden', false);
            }

            $distribution->status = $request->distribution_status;
            if (!$distribution->save()) {
                throw new Exception('saving distri', 500);
            }

            foreach ($request->distribution_points as $req) {

                $model = new OutcomeDistributionPoint();
                $model->outcome_distribution_id = $outcome_distribution_id;
                $model->distribution_type_id = $req['distribution_type_id'];
                $model->nama_point = $req['nama_point'];
                $model->tanggal = $req['tanggal'];
                $model->jumlah_dana = $req['jumlah_dana'];
                $model->jumlah_paket = $req['jumlah_paket'];
                $model->deskripsi = $req['deskripsi'];

                if (!$model->save()) {
                    throw new Exception('saving', 500);
                }

                foreach ($req['evidence'] as $evidences) {
                    $evidenceuploaded = $evidences['file'];
                    $evidencename = pathinfo($evidenceuploaded->getClientOriginalName(), PATHINFO_FILENAME);;
                    $evidenceext = $evidenceuploaded->getClientOriginalExtension();
                    $evidencesize = $evidenceuploaded->getSize();
                    $evidencefilename = $evidencename . '-' . uniqid() . '-' . time() . '.' . $evidenceext;
                    $evidencepath = '..' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'outcome_evidences';
                    $evidenceuploaded->move($evidencepath, $evidencefilename);

                    if (!file_exists($evidencepath . DIRECTORY_SEPARATOR . $evidencefilename)) {
                        throw new Exception('error: upload evidence code', 500);
                    }

                    $outcomeDistPointEvidence_y = new OutcomeDistributionPointEvidence();
                    $outcomeDistPointEvidence_y->outcome_distribution_point_id = $model->id;
                    $outcomeDistPointEvidence_y->nama_file = $evidenceuploaded->getClientOriginalName();
                    $outcomeDistPointEvidence_y->path = $evidencepath . DIRECTORY_SEPARATOR . $evidencefilename;
                    $outcomeDistPointEvidence_y->ekstensi = $evidenceext;
                    $outcomeDistPointEvidence_y->ukuran = $evidencesize;
                    if (!$outcomeDistPointEvidence_y->save()) {
                        throw new Exception('saving outcome dist point evidence yayasan', 500);
                    }
                }
            }

            DB::commit();
            return $this->writeResponseBody(self::HTTP_STATUS_CREATED, '', [], true);
        } catch (Exception $e) {
            DB::rollBack();
            return $this->writeResponse(self::HTTP_STATUS_ERROR, $e->getMessage(), false);
        }
    }

    public function update(Request $request, $outcome_distribution_id)
    {
        $this->validate($request, [
            'distribution_points.*.id' => 'required|exists:outcome_distribution_points,id',
            'distribution_points.*.distribution_type_id' => 'required|exists:distribution_types,id',
            'distribution_points.*.nama_point' => 'required',
            'distribution_points.*.tanggal' => 'required',
            'distribution_points.*.jumlah_dana' => 'required',
            'distribution_points.*.jumlah_paket' => 'required',
            'distribution_points.*.deskripsi' => 'required',
            'distribution_points.*.evidence.*.file' => 'max:10000|image',
            'distribution_status' => 'required|boolean',
        ]);

        $auth = auth()->user()->id;
        DB::beginTransaction();

        try {

            $distribution = OutcomeDistribution::with(['campaignAgent'])
                ->where('id', $outcome_distribution_id)
                ->first();

            if (empty($distribution)) {
                return $this->writeResponse(self::HTTP_STATUS_NOT_FOUND, '', false);
            }

            if ($distribution->campaignAgent->user_id != $auth) {
                return $this->writeResponse(self::HTTP_STATUS_FORBIDDEN, 'forbidden', false);
            }

            $distribution->status = $request->distribution_status;
            if (!$distribution->save()) {
                throw new Exception('saving distri', 500);
            }

            foreach ($request->distribution_points as $req) {

                $model = OutcomeDistributionPoint::where('id', $req['id'])->first();

                if (empty($model)) {
                    throw new Exception('distribution point not found', 500);
                }

                if ($model->outcome_distribution_id != $outcome_distribution_id) {
                    return $this->writeResponse(self::HTTP_STATUS_FORBIDDEN, 'forbidden: unable to update distri point.', false);
                }

                $model->distribution_type_id = $req['distribution_type_id'];
                $model->nama_point = $req['nama_point'];
                $model->tanggal = $req['tanggal'];
                $model->jumlah_dana = $req['jumlah_dana'];
                $model->jumlah_paket = $req['jumlah_paket'];
                $model->deskripsi = $req['deskripsi'];

                if (!$model->save()) {
                    throw new Exception('saving', 500);
                }

                $list_evidences_before = [];
                $list_evidences_after = [];

                $evidences_before = OutcomeDistributionPointEvidence::where('outcome_distribution_point_id', $model->id)
                    ->get()
                    ->toArray();

                foreach ($evidences_before as $eb) {
                    $list_evidences_before[] = $eb['id'];
                }

                if (!empty($req['evidence'])) {
                    foreach ($req['evidence'] as $evidences) {
                        $evidenceuploaded = $evidences['file'];
                        $evidencename = pathinfo($evidenceuploaded->getClientOriginalName(), PATHINFO_FILENAME);;
                        $evidenceext = $evidenceuploaded->getClientOriginalExtension();
                        $evidencesize = $evidenceuploaded->getSize();
                        $evidencefilename = $evidencename . '-' . uniqid() . '-' . time() . '.' . $evidenceext;
                        $evidencepath = '..' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'outcome_evidences';
                        $evidenceuploaded->move($evidencepath, $evidencefilename);

                        if (!file_exists($evidencepath . DIRECTORY_SEPARATOR . $evidencefilename)) {
                            throw new Exception('error: upload evidence code', 500);
                        }

                        $outcomeDistPointEvidence = new OutcomeDistributionPointEvidence;

                        if (!empty($evidences['id'])) {
                            $checkOutcomeDistPointEvidence = OutcomeDistributionPointEvidence::where('outcome_distribution_point_id', $model->id)
                                ->where('id', $evidences['id'])
                                ->first();

                            if (!empty($checkOutcomeDistPointEvidence)) {
                                $outcomeDistPointEvidence = $checkOutcomeDistPointEvidence;
                                if (file_exists($outcomeDistPointEvidence->path)) {
                                    unlink($outcomeDistPointEvidence->path);
                                }
                            }
                        }

                        $outcomeDistPointEvidence->outcome_distribution_point_id = $model->id;
                        $outcomeDistPointEvidence->nama_file = $evidenceuploaded->getClientOriginalName();
                        $outcomeDistPointEvidence->path = $evidencepath . DIRECTORY_SEPARATOR . $evidencefilename;
                        $outcomeDistPointEvidence->ekstensi = $evidenceext;
                        $outcomeDistPointEvidence->ukuran = $evidencesize;
                        if (!$outcomeDistPointEvidence->save()) {
                            throw new Exception('saving outcome dist point evidence yayasan', 500);
                        }

                        $list_evidences_after[] = $outcomeDistPointEvidence->id;
                    }
                }

                // delete
                foreach ($list_evidences_before as $before) {
                    if (!in_array($before, $list_evidences_after)) {
                        $evidence_delete = OutcomeDistributionPointEvidence::where('id', $before)->first();
                        if (!empty($evidence_delete)) {
                            $evidence_delete->delete();
                            if (file_exists($evidence_delete->path)) {
                                unlink($evidence_delete->path);
                            }
                        }
                    }
                }
            }

            DB::commit();
            return $this->writeResponseBody(self::HTTP_STATUS_CREATED, '', [], true);
        } catch (Exception $e) {
            DB::rollBack();
            return $this->writeResponse(self::HTTP_STATUS_ERROR, $e->getMessage(), false);
        }
    }

    public function packEvindence(Request $request, $point_id)
    {
        $evidences = OutcomeDistributionPointEvidence::where('outcome_distribution_point_id', $point_id)
            ->get()
            ->toArray();

        $zip = new ZipArchive;

        $uniq = uniqid() . time();
        $tmp_file = '..' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'tmp' . DIRECTORY_SEPARATOR . $uniq . '.zip';
        if ($zip->open($tmp_file,  ZipArchive::CREATE)) {

            foreach ($evidences as $e) {
                $zip->addFile($e['path'], $e['nama_file']);
            }

            $zip->close();

            header('Content-disposition: attachment; filename=evidences-' . $point_id . '-' . $uniq . '.zip');
            header('Content-type: application/zip');

            echo file_get_contents($tmp_file);
        } else {
            echo 'Failed!';
        }
    }
}
