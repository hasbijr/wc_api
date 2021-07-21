<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\CampaignAgent;
use App\Models\OutcomeDistribution;
use Illuminate\Http\Request;


class OutcomeDistributionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['only' => ['listForAgent']]);
        $this->middleware('permission:list-campaign-agent', ['only' => ['listForAgent', 'view']]);
    }

    public function listForAgent(Request $request)
    {
        $auth_id = auth()->user()->id;

        $campaign_agents = CampaignAgent::where('user_id', $auth_id)->get()->toArray();
        $campaign_agent_ids = [];

        foreach ($campaign_agents as $agent) {
            $campaign_agent_ids[] = $agent['id'];
        }

        $campaigns = OutcomeDistribution::with([
            'outcome.campaign',
            'outcomeDistributionPoints.outcomeDistributionPointEvidences'
        ])
            // ->select([
            //     'campaigns.nama'
            // ])
            ->whereIn('campaign_agent_id', $campaign_agent_ids)
            ->where('tipe', 'agen')
            ->get()
            ->toArray();

        return $this->writeResponseData($campaigns);
    }

    public function view(Request $request, $outcome_distribution_id)
    {
        $auth_id = auth()->user()->id;

        $campaign_agents = CampaignAgent::where('user_id', $auth_id)->get()->toArray();
        $campaign_agent_ids = [];

        foreach ($campaign_agents as $agent) {
            $campaign_agent_ids[] = $agent['id'];
        }

        $campaign = OutcomeDistribution::with([
            'outcome.campaign',
            'outcomeDistributionPoints.outcomeDistributionPointEvidences'
        ])
            ->whereIn('campaign_agent_id', $campaign_agent_ids)
            ->where('id', $outcome_distribution_id)
            ->where('tipe', 'agen')
            ->first()
            ->toArray();

        return $this->writeResponseData($campaign);
    }
}
