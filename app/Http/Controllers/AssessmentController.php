<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assessment;

class AssessmentController extends Controller
{
   public function index()
{
    $assessments = Assessment::where('user_id', auth()->id())
        ->latest()
        ->get();

    return view('assessments.index', compact('assessments'));
}

    public function create()
    {
        return view('assessments.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'university_name'           => 'required|string|max:255',
            'assessment_date'           => 'required|date',
            'assessor_name'             => 'required|string|max:255',
            'assessor_role'             => 'required|string|max:255',
            'cloud_system_name'         => 'required|string|max:255',
            'asset_category'            => 'required|string',
            'cloud_service_model'       => 'required|string',
            'cloud_deployment_model'    => 'required|string',
            'sensitivity_classification'=> 'required|string',
        ]);

        $assessment = Assessment::create([
            'user_id'                   => auth()->id(),
            'university_name'           => $request->university_name,
            'assessment_date'           => $request->assessment_date,
            'assessor_name'             => $request->assessor_name,
            'assessor_role'             => $request->assessor_role,
            'impact_criteria'           => $request->impact_criteria ?? 'standard',
            'cloud_system_name'         => $request->cloud_system_name,
            'asset_category'            => $request->asset_category,
            'asset_description'         => $request->asset_description,
            'cloud_service_model'       => $request->cloud_service_model,
            'cloud_deployment_model'    => $request->cloud_deployment_model,
            'primary_custodian'         => $request->primary_custodian,
            'sensitivity_classification'=> $request->sensitivity_classification,
            'tech_container'            => $request->tech_container,
            'network_container'         => $request->network_container,
            'physical_container'        => $request->physical_container,
            'human_container'           => $request->human_container,
            'cia_dimensions'            => $request->cia ?? [],
            'selected_threats'          => $request->threats ?? [],
            'notes'                     => $request->notes,
            'status'                    => 'draft',
        ]);

        return redirect()->route('assessments.risks.create', $assessment->id)->with('success', 'Asset saved. Now score your risks.');
    }
        public function addRisk($assessment)
    {
        $assessment = Assessment::findOrFail($assessment);
        $threats = $assessment->selected_threats ?? [];
        return view('assessments.risks', compact('assessment', 'threats'));
    }
    public function storeRisk(Request $request, $id)
{
    $assessment = Assessment::findOrFail($id);

    $risks = [];
    foreach ($request->input('likelihood', []) as $threatId => $likelihood) {
        $impact = (int) $request->input("impact.$threatId", 1);
        $score  = (int) $likelihood * $impact;

        $risks[] = [
            'threat_id'  => $threatId,
            'name'       => $request->input("threat_name.$threatId", ''),
            'likelihood' => (int) $likelihood,
            'impact'     => $impact,
            'score'      => $score,
            'cia'        => $request->input("threat_cia.$threatId", ''),
        ];
    }

    $assessment->risk_scores    = $risks;
    $assessment->status         = 'scored';
    $assessment->save();

    return redirect()->route('assessments.mitigation.create', $assessment->id)
                     ->with('success', 'Risk scores saved.');
}

    
    public function mitigation($id)
    {   
    $assessment = Assessment::findOrFail($id);
    
    $rawScores = $assessment->risk_scores;
    
    // Handle if stored as JSON string instead of array
    if (is_string($rawScores)) {
        $rawScores = json_decode($rawScores, true) ?? [];
    }
    
    $risks = collect($rawScores)
        ->filter(fn($r) => is_array($r))
        ->sortByDesc('score')
        ->values()
        ->toArray();
    
    return view('assessments.mitigation', compact('assessment', 'risks'));
    }
    public function storeMitigation(Request $request, $id)
{
    $assessment = Assessment::findOrFail($id);

    // ISO 27001:2022 Annex A controls mapped per threat
    $isoControls = [
        '01' => ['A.5.12','A.5.33','A.8.11','A.8.12'],
        '02' => ['A.8.9','A.8.20','A.5.37','A.8.25'],
        '03' => ['A.5.15','A.5.16','A.5.17','A.8.3'],
        '04' => ['A.6.3','A.5.17','A.8.5','A.5.20'],
        '05' => ['A.6.2','A.6.4','A.5.15','A.8.18'],
        '06' => ['A.8.7','A.8.13','A.5.26','A.8.16'],
        '07' => ['A.8.20','A.8.21','A.5.30','A.8.13'],
        '08' => ['A.5.19','A.5.20','A.5.21','A.5.22'],
        '09' => ['A.8.5','A.5.16','A.8.2','A.8.17'],
        '10' => ['A.8.13','A.8.14','A.5.33','A.8.9'],
        '11' => ['A.8.15','A.8.16','A.8.17','A.5.25'],
        '12' => ['A.8.24','A.8.26','A.8.29','A.8.20'],
        '13' => ['A.8.2','A.8.18','A.5.15','A.8.5'],
        '14' => ['A.5.31','A.5.34','A.5.36','A.5.32'],
        '15' => ['A.7.1','A.7.2','A.7.4','A.7.8'],
    ];

    $plan = [];
    foreach ($request->input('treatment', []) as $threatId => $treatment) {
        $tid = str_pad((string)$threatId, 2, '0', STR_PAD_LEFT);
        $plan[] = [
            'threat_id' => $tid,
            'treatment' => $treatment,
            'notes'     => $request->input("notes.$threatId") ?? '',
            'controls'  => $isoControls[$tid] ?? [],
        ];
    }

    $assessment->mitigation_plan = $plan;
    $assessment->status = 'mitigated';
    $assessment->save();

    return redirect()->route('assessments.report', $assessment->id)
                     ->with('success', 'Mitigation plan saved.');
}
    public function report($id)
    {
    $assessment = Assessment::findOrFail($id);

    $rawScores = $assessment->risk_scores;
    if (is_string($rawScores)) {
        $rawScores = json_decode($rawScores, true) ?? [];
    }

    $risks = collect($rawScores)
        ->filter(fn($r) => is_array($r))
        ->sortByDesc('score')
        ->values()
        ->toArray();

    return view('assessments.report', compact('assessment', 'risks'));
    }
    public function destroy($id)
{
    $assessment = Assessment::where('id', $id)
        ->where('user_id', auth()->id())
        ->firstOrFail();
    $assessment->delete();
    return redirect()->route('assessments.index')->with('success', 'Assessment deleted.');
}
}