<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\CampaignPhoto;
use App\Models\CampaignQrCode;
use App\Models\File;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CampaignController extends Controller
{

    const DEFAULT_PAGING_NUM = 15;

    /**
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['only' => ['create', 'update', 'delete']]);
        $this->middleware('permission:create-campaign', ['only' => ['create']]);
        $this->middleware('permission:update-campaign', ['only' => ['update']]);
        $this->middleware('permission:delete-campaign', ['only' => ['delete']]);
    }

    public function create(Request $request)
    {
        $campaign_validation = Campaign::getValidationRules();
        $qr_code_validation = CampaignQrCode::getValidationRules();
        $evidence_validation = [
            'campaign_photos.file' => 'required|max:10000|image',
            'campaign_qr_codes.file' => 'required|max:10000|image'
        ];

        $validation = array_merge($campaign_validation, $qr_code_validation, $evidence_validation);
        $this->validate($request, $validation);

        DB::beginTransaction();

        try {
            $campaign = new Campaign();
            $campaign->nama = $request->nama;
            $campaign->tanggal_mulai = $request->tanggal_mulai;
            if (!empty($request->tanggal_selesai)) {
                $campaign->tanggal_selesai = $request->tanggal_selesai;
            }
            $campaign->deskripsi = $request->deskripsi;
            $campaign->is_publish = $request->is_publish;

            if ($campaign->save()) {
                $photouploaded = $request->file('campaign_photos.file');
                $photoname = pathinfo($photouploaded->getClientOriginalName(), PATHINFO_FILENAME);;
                $photoext = $photouploaded->getClientOriginalExtension();
                $photosize = $photouploaded->getSize();
                $photofilename = $photoname . '-' . uniqid() . '-' . time() . '.' . $photoext;
                $photopath = 'campaign_assets' . DIRECTORY_SEPARATOR . 'photos';
                $photouploaded->move($photopath, $photofilename);

                if (!file_exists($photopath . DIRECTORY_SEPARATOR . $photofilename)) {
                    throw new Exception('error: upload photo', 500);
                }

                $campaignPhoto = new CampaignPhoto();
                $campaignPhoto->campaign_id = $campaign->id;
                $campaignPhoto->nama_file = $photouploaded->getClientOriginalName();
                $campaignPhoto->path = $photopath . DIRECTORY_SEPARATOR . $photofilename;
                $campaignPhoto->ekstensi = $photoext;
                $campaignPhoto->ukuran = $photosize;

                $qruploaded = $request->file('campaign_qr_codes.file');
                $qrname = pathinfo($qruploaded->getClientOriginalName(), PATHINFO_FILENAME);;
                $qrext = $qruploaded->getClientOriginalExtension();
                $qrsize = $qruploaded->getSize();
                $qrfilename = $qrname . '-' . uniqid() . '-' . time() . '.' . $qrext;
                $qrpath = 'campaign_assets' . DIRECTORY_SEPARATOR . 'qr_codes';
                $qruploaded->move($qrpath, $qrfilename);

                if (!file_exists($qrpath . DIRECTORY_SEPARATOR . $qrfilename)) {
                    throw new Exception('error: upload qr code', 500);
                }

                $campaignQr = new CampaignQrCode();
                $campaignQr->campaign_id = $campaign->id;
                $campaignQr->nama_linkaja = $request->input('campaign_qr_codes.nama_linkaja');
                $campaignQr->nama_file = $qruploaded->getClientOriginalName();
                $campaignQr->path = $qrpath . DIRECTORY_SEPARATOR . $qrfilename;
                $campaignQr->ekstensi = $qrext;
                $campaignQr->ukuran = $qrsize;

                // save
                if (!$campaignPhoto->save() || !$campaignQr->save()) {
                    throw new Exception('error: saving dependencies', 500);
                }
            }

            DB::commit();
            return $this->writeResponseBody(self::HTTP_STATUS_CREATED, '', $campaign, true);
        } catch (QueryException $e) {
            DB::rollBack();
            return $this->writeResponse(self::HTTP_STATUS_ERROR, $e->getMessage(), false);
        }
    }

    public function list(Request $request)
    {
        $show = $request->get('show') ?? 'published';
        $methodName = 'campaign' . ucfirst($show);

        if (method_exists($this, $methodName)) {
            return $this->writeResponseData($this->{$methodName}($request));
        }

        return $this->writeResponse(self::HTTP_STATUS_NOT_FOUND, '', false);
    }

    private function campaignUrgent($request)
    {
        $urgent = $this->listData($request)
            ->orderBy('tanggal_selesai', 'asc')
            ->where('is_publish', 1)
            ->paginate(static::DEFAULT_PAGING_NUM)
            ->appends(['show' => $request->get('show'), 'nama' => $request->get('nama')])
            ->toArray();

        return $urgent;
    }

    private function campaignCarousel($request)
    {
        $carousel = $this->listData($request)
            ->orderBy('tanggal_mulai', 'desc')
            ->where('is_publish', 1)
            ->limit(5)
            ->get()
            ->toArray();

        return $carousel;
    }

    private function campaignAll($request)
    {
        $all = $this->listData($request)
            ->paginate(static::DEFAULT_PAGING_NUM)
            ->appends(['show' => $request->get('show'), 'nama' => $request->get('nama')]);

        return $all;
    }

    private function campaignPublished($request)
    {
        $published = $this->listData($request)
            ->where('is_publish', 1)
            ->paginate(static::DEFAULT_PAGING_NUM)
            ->appends(['show' => $request->get('show'), 'nama' => $request->get('nama')]);

        return $published;
    }

    private function campaignDrafted($request)
    {
        $drafted = $this->listData($request)
            ->where('is_publish', 0)
            ->paginate(static::DEFAULT_PAGING_NUM)
            ->appends(['show' => $request->get('show'), 'nama' => $request->get('nama')]);

        return $drafted;
    }

    private function listData($request)
    {
        $list = Campaign::with(['campaignPhoto', 'campaignQrCode', 'campaignAgents']);

        if ($request->filled('nama')) {
            $list = $list->where('nama', 'like', '%' . $request->get('nama') . '%');
        }

        return $list;
    }

    public function view(Request $request, $campaign_id)
    {
        $view = Campaign::with(['campaignPhoto', 'campaignQrCode', 'campaignAgents.user.userinformation'])->where('id', $campaign_id)->where('is_publish', 1);
        $data = $view->first();

        if ($data) {
            return $this->writeResponseData($data->toArray());
        } else {
            return $this->writeResponse(self::HTTP_STATUS_NOT_FOUND, '', false);
        }
    }

    public function update(Request $request, $campaign_id)
    {
        $campaign_validation = Campaign::getValidationRules();
        $qr_code_validation = CampaignQrCode::getValidationRules();
        $evidence_validation = [
            'campaign_photos.file' => 'max:10000|mimes:jpg,jpeg,png,',
            'campaign_qr_codes.file' => 'max:10000|mimes:jpg,jpeg,png,'
        ];

        $validation = array_merge($campaign_validation, $qr_code_validation, $evidence_validation);
        $this->validate($request, $validation);

        DB::beginTransaction();

        try {
            $campaign = Campaign::where('id', $campaign_id)->first();

            if (!$campaign) {
                return $this->writeResponse(self::HTTP_STATUS_NOT_FOUND, '', false);
            }

            $campaign->nama = $request->nama;
            $campaign->tanggal_mulai = $request->tanggal_mulai;
            if (!empty($request->tanggal_selesai)) {
                $campaign->tanggal_selesai = $request->tanggal_selesai;
            }
            $campaign->deskripsi = $request->deskripsi;
            $campaign->is_publish = $request->is_publish;

            if ($campaign->save()) {
                if (!empty($request->campaign_photos['file'])) {
                    $campaignPhoto = CampaignPhoto::where('campaign_id', $campaign_id)->first();

                    $photouploaded = $request->file('campaign_photos.file');
                    $photoname = pathinfo($photouploaded->getClientOriginalName(), PATHINFO_FILENAME);;
                    $photoext = $photouploaded->getClientOriginalExtension();
                    $photosize = $photouploaded->getSize();
                    $photofilename = $photoname . '-' . uniqid() . '-' . time() . '.' . $photoext;
                    $photopath = 'campaign_assets' . DIRECTORY_SEPARATOR . 'photos';
                    $photouploaded->move($photopath, $photofilename);

                    if (!file_exists($photopath . DIRECTORY_SEPARATOR . $photofilename)) {
                        throw new Exception('error: upload photo', 500);
                    }

                    if (file_exists($campaignPhoto->path)) {
                        unlink($campaignPhoto->path);
                    }

                    // $campaignPhoto->campaign_id = $campaign->id;
                    $campaignPhoto->nama_file = $photouploaded->getClientOriginalName();
                    $campaignPhoto->path = $photopath . DIRECTORY_SEPARATOR . $photofilename;
                    $campaignPhoto->ekstensi = $photoext;
                    $campaignPhoto->ukuran = $photosize;

                    // save
                    if (!$campaignPhoto->save()) {
                        throw new Exception('error: saving dependencies', 500);
                    }
                }

                if (!empty($request->campaign_qr_codes)) {
                    $campaignQr = CampaignQrCode::where('campaign_id', $campaign_id)->first();
                    // $campaignQr->campaign_id = $campaign->id;
                    $campaignQr->nama_linkaja = $request->input('campaign_qr_codes.nama_linkaja');

                    if (!empty($request->campaign_qr_codes['file'])) {
                        $qruploaded = $request->file('campaign_qr_codes.file');
                        $qrname = pathinfo($qruploaded->getClientOriginalName(), PATHINFO_FILENAME);;
                        $qrext = $qruploaded->getClientOriginalExtension();
                        $qrsize = $qruploaded->getSize();
                        $qrfilename = $qrname . '-' . uniqid() . '-' . time() . '.' . $qrext;
                        $qrpath = 'campaign_assets' . DIRECTORY_SEPARATOR . 'qr_codes';
                        $qruploaded->move($qrpath, $qrfilename);

                        if (!file_exists($photopath . DIRECTORY_SEPARATOR . $photofilename)) {
                            throw new Exception('error: upload qr code', 500);
                        }

                        if (file_exists($campaignQr->path)) {
                            unlink($campaignQr->path);
                        }

                        $campaignQr->nama_file = $qruploaded->getClientOriginalName();
                        $campaignQr->path = $qrpath . DIRECTORY_SEPARATOR . $qrfilename;
                        $campaignQr->ekstensi = $qrext;
                        $campaignQr->ukuran = $qrsize;
                    }

                    // save
                    if (!$campaignQr->save()) {
                        throw new Exception('error: saving dependencies', 500);
                    }
                }
            }

            DB::commit();
            return $this->writeResponseBody(self::HTTP_STATUS_CREATED, '', $campaign, true);
        } catch (QueryException $e) {
            DB::rollBack();
            return $this->writeResponse(self::HTTP_STATUS_ERROR, $e->getMessage(), false);
        }
    }

    public function delete(Request $request, $campaign_id)
    {
        $model = Campaign::where('id', $campaign_id);

        if ($model && $model->delete()) {
            return $this->writeResponse(self::HTTP_STATUS_SUCCESS, '', true);
        }

        return $this->writeResponse(self::HTTP_STATUS_NOT_FOUND, '', false);
    }
}
