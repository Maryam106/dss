<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
public function index()
{
    $assessments = \App\Models\Assessment::where('user_id', auth()->id())
        ->latest()->get();

    $totalAssessments = $assessments->count();

    $totalRisks = $assessments->sum(function($a) {
        return count($a->selected_threats ?? []);
    });

    $criticalRisks = $assessments->sum(function($a) {
        return collect($a->risk_scores ?? [])->where('score', '>=', 17)->count();
    });

    $completedAssessments = $assessments->where('status', 'scored')->count();

    return view('dashboard.index', compact(
        'assessments',
        'totalAssessments',
        'totalRisks',
        'criticalRisks',
        'completedAssessments'
    ));
}
}