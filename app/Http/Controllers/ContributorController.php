<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Contributor;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContributorController extends Controller
{
    public function create(Request $request, $campaign_id)
    {

        $this->validate($request, [
            'nama' => 'required',
            'nik' => 'required',
            'handphone' => 'required',
            'agreement' => 'required',
        ]);

        $campaign = Campaign::where('id', $campaign_id)->exists();

        if (!$campaign) {
            return $this->writeResponse(self::HTTP_STATUS_NOT_FOUND, '', false);
        }

        DB::beginTransaction();

        try {
            $contributor = new Contributor();
            $contributor->campaign_id = $campaign_id;
            $contributor->nama = $request->nama;
            $contributor->nik = $request->nik;
            $contributor->handphone = $request->handphone;
            $contributor->agreement = $request->agreement;
            $contributor->save();

            DB::commit();
            return $this->writeResponseBody(self::HTTP_STATUS_CREATED, '', $contributor, true);
        } catch (QueryException $e) {
            DB::rollBack();
            return $this->writeResponse(self::HTTP_STATUS_ERROR, $e->getMessage(), false);
        }
    }
}
