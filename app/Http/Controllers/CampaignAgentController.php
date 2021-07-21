<?php

namespace App\Http\Controllers;

use App\Models\CampaignAgent;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CampaignAgentController extends Controller
{
    /**
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['only' => ['create']]);
        $this->middleware('permission:assign-agent', ['only' => ['create']]);
    }

    public function create(Request $request, $campaign_id)
    {
        $this->validate($request, CampaignAgent::getValidationRules());

        DB::beginTransaction();

        try {
            $existing = CampaignAgent::where('campaign_id', $campaign_id)->get()->toArray();
            $existing_ids = array_column($existing, 'user_id');
            $request_ids = is_array($request->input('campaign_agents')['id'])
                ? $request->input('campaign_agents')['id']
                : [];

            $delete_ids = array_diff($existing_ids, $request_ids);

            foreach ($delete_ids as $delid) {
                CampaignAgent::where('user_id', $delid)->where('campaign_id', $campaign_id)->delete();
            }

            foreach ($request_ids as $reqid) {
                $campaign_exists = CampaignAgent::where('user_id', $reqid)->where('campaign_id', $campaign_id)->exists();
                if (!$campaign_exists) {
                    $campaignAgent = new CampaignAgent();
                    $campaignAgent->campaign_id = $campaign_id;
                    $campaignAgent->user_id = $reqid;

                    // save
                    if (!$campaignAgent->save()) {
                        throw new Exception('error: saving dependencies', 500);
                    }
                }
            }

            DB::commit();
            return $this->writeResponse(self::HTTP_STATUS_CREATED, '', true);
        } catch (Exception $e) {
            DB::rollBack();
            return $this->writeResponse(self::HTTP_STATUS_ERROR, $e->getMessage(), false);
        }
    }

    public function list(Request $request, $campaign_id)
    {
        $agents = CampaignAgent::with(['user.userinformation'])->where('campaign_id', $campaign_id)->get()->toArray();

        return $this->writeResponseData($agents);
    }
}
