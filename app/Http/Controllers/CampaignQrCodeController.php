<?php

namespace App\Http\Controllers;

use App\Models\CampaignQrCode;
use Illuminate\Http\Request;


class CampaignQrCodeController extends Controller
{
    public function blob(Request $request, $campaign_id, $qr_id)
    {
        $campaignPhoto = CampaignQrCode::where(['campaign_id' => $campaign_id, 'id' => $qr_id])->first()->toArray();
        $photoBlob = file_get_contents($campaignPhoto['path']);

        $mime = mime_content_type($campaignPhoto['path']);

        return response($photoBlob)->header('Content-type', $mime);
    }
}
