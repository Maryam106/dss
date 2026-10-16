<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('university_name');
            $table->date('assessment_date');
            $table->string('assessor_name');
            $table->string('assessor_role');
            $table->string('impact_criteria')->default('standard');
            $table->string('cloud_system_name');
            $table->string('asset_category');
            $table->text('asset_description')->nullable();
            $table->string('cloud_service_model');
            $table->string('cloud_deployment_model');
            $table->string('primary_custodian')->nullable();
            $table->string('sensitivity_classification');
            $table->string('tech_container')->nullable();
            $table->string('network_container')->nullable();
            $table->string('physical_container')->nullable();
            $table->string('human_container')->nullable();
            $table->json('cia_dimensions')->nullable();
            $table->json('selected_threats')->nullable();
            $table->text('notes')->nullable();
            $table->string('status')->default('draft');
            $table->json('risk_scores')->nullable();
            $table->json('mitigation_plan')->nullable(); 
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assessments');
    }
};