<?php

namespace App\Http\Controllers;

use App\CustomHelpers;
use App\Models\CampaignAgent;
use App\Models\Outcome;
use App\Models\OutcomeDistribution;
use App\Models\OutcomeDistributionPoint;
use App\Models\OutcomeDistributionPointEvidence;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class OutcomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['only' => ['create', 'view', 'excel']]);
        $this->middleware('permission:create-outcome', ['only' => ['create']]);
        $this->middleware('permission:view-outcome', ['only' => ['view', 'excel']]);
    }

    public function create(Request $request, $campaign_id)
    {

        $validation_y = [];
        if (!empty($request->outcome['agents'])) {
            $validation_a = [
                'outcome.agents.*.campaign_agent_id' => 'required|exists:campaign_agents,id',
                'outcome.agents.*.nominal' => 'required|numeric',
            ];
        }

        $validation_a = [];
        if (!empty($request->outcome['yayasan'])) {
            $validation_y = [
                'outcome.yayasan.nama_yayasan' => 'required|string',
                'outcome.yayasan.nominal' => 'required|numeric',
                'outcome.yayasan.file' => 'required|max:10000|image',
            ];
        }

        $validation = array_merge($validation_a, $validation_y);
        $this->validate($request, $validation);

        DB::beginTransaction();

        try {
            $outcome = new Outcome();
            $outcome->campaign_id = $campaign_id;
            if (!$outcome->save()) {
                throw new Exception('saving outcome', 500);
            }

            // by agent
            if (!empty($request->outcome['agents'])) {
                if (is_array($request->outcome['agents'])) {
                    foreach ($request->outcome['agents'] as $agent) {

                        $campaignAgent = CampaignAgent::where('id', $agent['campaign_agent_id'])->first();

                        if ($campaignAgent->campaign_id != $campaign_id) {
                            return $this->writeResponse(self::HTTP_UNPROCESSABLE, 'agent tidak di-assign di campaign ini', false);
                        }

                        $outcomeDist_a = new OutcomeDistribution();
                        $outcomeDist_a->biaya_administrasi = $request->outcome['biaya_administrasi_agent'] ?? 0;
                        $outcomeDist_a->outcome_id = $outcome->id;
                        $outcomeDist_a->campaign_agent_id = $agent['campaign_agent_id'];
                        $outcomeDist_a->tipe = 'agen';
                        $outcomeDist_a->nominal = $agent['nominal'];
                        $outcomeDist_a->status = 0;

                        if (!$outcomeDist_a->save()) {
                            throw new Exception('saving outcome agent', 500);
                        }
                    }
                }
            }


            // by yayasan
            if (!empty($request->outcome['yayasan'])) {
                $outcomeDist_y = new OutcomeDistribution();
                $outcomeDist_y->outcome_id = $outcome->id;
                $outcomeDist_y->biaya_administrasi = $request->outcome['biaya_administrasi_yayasan'] ?? 0;
                $outcomeDist_y->campaign_agent_id = null;
                $outcomeDist_y->tipe = 'yayasan';
                $outcomeDist_y->nominal = $request->outcome['yayasan']['nominal'];
                $outcomeDist_y->status = 1;

                if (!$outcomeDist_y->save()) {
                    throw new Exception('saving outcome dist yayasan', 500);
                }

                $outcomeDistPoint_y = new OutcomeDistributionPoint();
                $outcomeDistPoint_y->outcome_distribution_id = $outcomeDist_y->id;
                $outcomeDistPoint_y->nama_point = $request->outcome['yayasan']['nama_yayasan'];
                $outcomeDistPoint_y->tanggal = null;
                $outcomeDistPoint_y->jumlah_dana = $request->outcome['yayasan']['nominal'];
                $outcomeDistPoint_y->jumlah_paket = null;
                $outcomeDistPoint_y->deskripsi = null;
                if (!$outcomeDistPoint_y->save()) {
                    throw new Exception('saving outcome dist point yayasan', 500);
                }

                $evidenceuploaded = $request->file('outcome.yayasan.file');
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
                $outcomeDistPointEvidence_y->outcome_distribution_point_id = $outcomeDistPoint_y->id;
                $outcomeDistPointEvidence_y->nama_file = $evidenceuploaded->getClientOriginalName();
                $outcomeDistPointEvidence_y->path = $evidencepath . DIRECTORY_SEPARATOR . $evidencefilename;
                $outcomeDistPointEvidence_y->ekstensi = $evidenceext;
                $outcomeDistPointEvidence_y->ukuran = $evidencesize;
                if (!$outcomeDistPointEvidence_y->save()) {
                    throw new Exception('saving outcome dist point evidence yayasan', 500);
                }
            }

            DB::commit();
            return $this->writeResponseBody(self::HTTP_STATUS_CREATED, '', $outcome, true);
        } catch (QueryException $e) {
            DB::rollBack();
            return $this->writeResponse(self::HTTP_STATUS_ERROR, $e->getMessage(), false);
        }
    }

    public function view(Request $request, $campaign_id, $outcome_id)
    {
        $outcome = Outcome::with(['campaign'])
            ->where('campaign_id', $campaign_id)
            ->where('id', $outcome_id)
            ->first();

        if (!$outcome) {
            return $this->writeResponse(self::HTTP_STATUS_NOT_FOUND, '', false);
        }

        $outcome = $outcome->toArray();

        $outcome_dist = OutcomeDistribution::with([
            'outcomeDistributionPoints.outcomeDistributionPointEvidences',
            'campaignAgent.user.userinformation'
        ])
            ->where('outcome_id', $outcome['id'])
            ->get()
            ->toArray();

        $outcome['outcome_distribution_points'] = $outcome_dist;

        return $this->writeResponseData($outcome);
    }

    public function excel(Request $request, $campaign_id, $outcome_id)
    {
        $outcome = Outcome::with(['campaign'])
            ->where('campaign_id', $campaign_id)
            ->where('id', $outcome_id)
            ->first();

        if (!$outcome) {
            return $this->writeResponse(self::HTTP_STATUS_NOT_FOUND, '', false);
        }

        $outcome_dist = OutcomeDistribution::with([
            'outcomeDistributionPoints.outcomeDistributionPointEvidences',
            'user.userinformation'
        ])
            ->where('outcome_id', $outcome['id'])
            ->get()
            ->toArray();

        $style = [
            'borders' => [
                'outline' => [
                    'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                ]
            ]
        ];

        $array_data = [];

        // title
        $array_data[] = [$outcome->campaign->nama];
        $array_data[] = [];
        $array_data[] = ['Biaya Administrasi Agen', $outcome->biaya_administrasi_agent];

        // header
        $array_data[] = [
            // 'Tipe',
            'NIK Agen',
            'Nama Agen',
            'Nama Distribution Point',
            'Jumlah Dana Disalurkan',
            'Jumlah Paket Disalurkan',
            'Tanggal Penyaluran',
        ];

        $jmlrow = 6;
        foreach ($outcome_dist as $key => $r) {

            if ($r['tipe'] == 'agen') {

                if (!empty($r['outcome_distribution_points'])) {
                    foreach ($r['outcome_distribution_points'] as $point) {
                        $array_data[] = [
                            $r['user']['username'],
                            $r['user']['userinformation']['nama'],
                            $point['nama_point'],
                            $point['jumlah_dana'],
                            $point['jumlah_paket'],
                            date('Y-m-d H:i:s', strtotime($point['tanggal'])),
                        ];

                        $jmlrow++;
                    }
                } else {
                    $array_data[] = [
                        $r['user']['username'],
                        $r['user']['userinformation']['nama'],
                    ];
                }
            }
        }

        $array_data[] = [];
        $jmlrow++;

        $array_data[] = ['Biaya Administrasi Yayasan', $outcome->biaya_administrasi_yayasan];
        $jmlrow++;

        // header 2
        $array_data[] = [
            'Tempat Donasi',
            'Jumlah Dana Disalurkan',
        ];
        $jmlrow++;

        foreach ($outcome_dist as $key => $r) {

            if ($r['tipe'] == 'yayasan') {
                foreach ($r['outcome_distribution_points'] as $point) {

                    $array_data[] = [
                        $point['nama_point'],
                        $point['jumlah_dana'],
                    ];

                    $jmlrow++;
                }
            }

            $jmlrow++;
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->fromArray($array_data);

        $sheet->getStyle("A3:D{$jmlrow}")->applyFromArray($style);

        $writer = new Xlsx($spreadsheet);

        $fileName = 'outcome-' . CustomHelpers::slugify($outcome->campaign->nama, '-') . date('Ymd-His') . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . urlencode($fileName) . '"');
        $writer->save('php://output');
    }
}
