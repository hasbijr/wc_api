<?php

namespace App\Http\Controllers;

use App\Models\OutcomeDistributionPointEvidence;
use Illuminate\Http\Request;


class OutcomeDistributionPointEvidenceController extends Controller
{
    public function blob(Request $request, $evidence_id)
    {
        $outcome_evidence = OutcomeDistributionPointEvidence::where([
            'id' => $evidence_id
        ])
            ->first()
            ->toArray();

        $evidence = file_get_contents($outcome_evidence['path']);

        $mime = mime_content_type($outcome_evidence['path']);

        return response($evidence)->header('Content-type', $mime);
    }
}
