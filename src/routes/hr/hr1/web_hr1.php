<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\hr1\DashboardController_hr1;
use App\Http\Controllers\ApplicantController_hr1;
use App\Http\Controllers\JobController_hr1;
use App\Http\Controllers\ApplicationController_hr1;
use App\Http\Controllers\RecognitionController_hr1;
use App\Http\Controllers\OnboardingController_hr1;
use App\Http\Controllers\LearningModuleController_hr1;
use App\Http\Controllers\EvaluationController_hr1;

// HR1 Index Route
Route::prefix('hr/hr1')->name('hr.hr1.')->group(function () {
    Route::get('/', fn () => view('hr1.index'))->name('index');
});

// Change FROM:
Route::get('/dashboard_hr1', [DashboardController_hr1::class, 'index'])->name('dashboard_hr1');

// API Routes
Route::prefix('api/hr1')->group(function () {
    // Applicants
    Route::get('/applicants', [ApplicantController_hr1::class, 'index']);
    Route::post('/applicants', [ApplicantController_hr1::class, 'store']);
    Route::get('/applicants/{id}', [ApplicantController_hr1::class, 'show']);
    Route::patch('/applicants/{id}', [ApplicantController_hr1::class, 'update']);
    Route::patch('/applicants/{id}/status', [ApplicantController_hr1::class, 'updateStatus']);

    // Jobs
    Route::get('/jobs', [JobController_hr1::class, 'index']);
    Route::post('/jobs', [JobController_hr1::class, 'store']);
    Route::patch('/jobs/{id}', [JobController_hr1::class, 'update']);
    Route::delete('/jobs/{id}', [JobController_hr1::class, 'destroy']);

    // Applications
    Route::post('/applications', [ApplicationController_hr1::class, 'store']);
    Route::post('/applications/{id}/interview', [ApplicationController_hr1::class, 'scheduleInterview']);

    // Recognitions
    Route::get('/recognitions', [RecognitionController_hr1::class, 'index']);
    Route::post('/recognitions', [RecognitionController_hr1::class, 'store']);
    Route::patch('/recognitions/{id}', [RecognitionController_hr1::class, 'update']);
    Route::post('/recognitions/{id}/congratulate', [RecognitionController_hr1::class, 'congratulate']);
    Route::post('/recognitions/{id}/boost', [RecognitionController_hr1::class, 'boost']);
    Route::delete('/recognitions/{id}', [RecognitionController_hr1::class, 'destroy']);
    
    // Task Sets
    Route::get('/task-sets', [OnboardingController_hr1::class, 'taskSets']);
    Route::post('/task-sets', [OnboardingController_hr1::class, 'storeTaskSet']);
    Route::patch('/task-sets/{id}', [OnboardingController_hr1::class, 'updateTaskSet']);
    Route::delete('/task-sets/{id}', [OnboardingController_hr1::class, 'destroyTaskSet']);
    
    // Question Sets
    Route::get('/question-sets', [EvaluationController_hr1::class, 'questionSets']);
    Route::post('/question-sets', [EvaluationController_hr1::class, 'storeQuestionSet']);
    Route::patch('/question-sets/{id}', [EvaluationController_hr1::class, 'updateQuestionSet']);
    Route::delete('/question-sets/{id}', [EvaluationController_hr1::class, 'destroyQuestionSet']);
    
    // Admin Profile
    Route::patch('/admin/profile', [DashboardController_hr1::class, 'updateProfile']);

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

