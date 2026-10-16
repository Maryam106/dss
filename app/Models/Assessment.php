<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    protected $fillable = [
        'user_id', 'university_name', 'assessment_date', 'assessor_name',
        'assessor_role', 'impact_criteria', 'cloud_system_name', 'asset_category',
        'asset_description', 'cloud_service_model', 'cloud_deployment_model',
        'primary_custodian', 'sensitivity_classification', 'tech_container',
        'network_container', 'physical_container', 'human_container',
        'cia_dimensions', 'selected_threats', 'notes', 'status',
    ];

    protected $casts = [
    'cia_dimensions'  => 'array',
    'selected_threats' => 'array',
    'risk_scores'     => 'array',
    'mitigation_plan' => 'array',
    'assessment_date' => 'date',
];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}