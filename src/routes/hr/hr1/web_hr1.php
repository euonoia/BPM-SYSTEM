<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController_hr1;
use App\Http\Controllers\ApplicantController_hr1;
use App\Http\Controllers\JobController_hr1;
use App\Http\Controllers\ApplicationController_hr1;
use App\Http\Controllers\RecognitionController_hr1;
use App\Http\Controllers\OnboardingController_hr1;
use App\Http\Controllers\LearningModuleController_hr1;
use App\Http\Controllers\EvaluationController_hr1;

Route::get('/dashboard_hr1', [DashboardController_hr1::class, 'index'])->middleware('auth')->name('dashboard_hr1');

// API Routes
Route::prefix('api/hr1')->group(function () {
    // Applicants
    Route::get('/applicants', [ApplicantController_hr1::class, 'index']);
    Route::post('/applicants', [ApplicantController_hr1::class, 'store']);
    Route::get('/applicants/{id}', [ApplicantController_hr1::class, 'show']);
    Route::patch('/applicants/{id}/status', [ApplicantController_hr1::class, 'updateStatus']);

    // Jobs
    Route::get('/jobs', [JobController_hr1::class, 'index']);
    Route::post('/jobs', [JobController_hr1::class, 'store']);
    Route::delete('/jobs/{id}', [JobController_hr1::class, 'destroy']);

    // Applications
    Route::post('/applications', [ApplicationController_hr1::class, 'store']);
    Route::post('/applications/{id}/interview', [ApplicationController_hr1::class, 'scheduleInterview']);

    // Recognitions
    Route::get('/recognitions', [RecognitionController_hr1::class, 'index']);
    Route::post('/recognitions', [RecognitionController_hr1::class, 'store']);
    Route::post('/recognitions/{id}/congratulate', [RecognitionController_hr1::class, 'congratulate']);
    Route::post('/recognitions/{id}/boost', [RecognitionController_hr1::class, 'boost']);
    Route::delete('/recognitions/{id}', [RecognitionController_hr1::class, 'destroy']);

    // Onboarding
    Route::get('/tasks', [OnboardingController_hr1::class, 'index']);
    Route::post('/tasks', [OnboardingController_hr1::class, 'store']);
    Route::patch('/tasks/{id}/status', [OnboardingController_hr1::class, 'updateStatus']);

    // Learning Modules
    Route::get('/modules', [LearningModuleController_hr1::class, 'index']);
    Route::post('/modules', [LearningModuleController_hr1::class, 'store']);
    Route::post('/modules/assign/{userId}', [LearningModuleController_hr1::class, 'assign']);

    // Evaluation
    Route::get('/evaluation-criteria', [EvaluationController_hr1::class, 'index']);
    Route::post('/evaluation-criteria', [EvaluationController_hr1::class, 'store']);
    Route::delete('/evaluation-criteria/{id}', [EvaluationController_hr1::class, 'destroy']);
});

