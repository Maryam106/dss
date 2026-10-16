<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AssessmentController;

Route::get('/', function () {
    return view('welcome');
});

// Protected routes — must be logged in
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/assessments/create', [AssessmentController::class, 'create'])->name('assessments.create');
    Route::post('/assessments', [AssessmentController::class, 'store'])->name('assessments.store');
    Route::get('/assessments/{assessment}/risks', [AssessmentController::class, 'addRisk'])->name('assessments.risks.create');
    Route::post('/assessments/{assessment}/risks', [AssessmentController::class, 'storeRisk'])->name('assessments.risks.store');
    Route::get('/assessments/{assessment}/mitigation', [AssessmentController::class,'mitigation'])->name('assessments.mitigation.create');
    Route::post('/assessments/{assessment}/mitigation', [AssessmentController::class,'storeMitigation'])->name('assessments.mitigation.store');
    Route::get('/assessments/{assessment}/report', [AssessmentController::class,'report'])->name('assessments.report');
    Route::get('/assessments', [AssessmentController::class, 'index'])->name('assessments.index');
    Route::delete('/assessments/{assessment}', [AssessmentController::class, 'destroy'])->name('assessments.destroy');
});

require __DIR__.'/auth.php';