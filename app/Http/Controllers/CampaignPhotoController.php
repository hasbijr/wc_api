<?php

namespace App\Http\Controllers;

use App\Models\CampaignPhoto;
use Illuminate\Http\Request;


class CampaignPhotoController extends Controller
{
    public function blob(Request $request, $campaign_id, $photo_id)
    {
        $campaignPhoto = CampaignPhoto::where(['campaign_id' => $campaign_id, 'id' => $photo_id])->first()->toArray();
        $photoBlob = file_get_contents($campaignPhoto['path']);

        $mime = mime_content_type($campaignPhoto['path']);

        return response($photoBlob)->header('Content-type', $mime);
    }
}
