<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\hr2\DashboardController;
use App\Http\Controllers\hr2\CompetencyController;
use App\Http\Controllers\hr2\LearningController;
use App\Http\Controllers\hr2\TrainingController;
use App\Http\Controllers\hr2\SuccessionController;
use App\Http\Controllers\hr2\EssController;

// HR2 Dashboard
Route::middleware('auth')->prefix('hr2')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('hr2.dashboard');
    
    Route::get('/competencies', [CompetencyController::class, 'index'])->name('hr2.competencies');
    Route::get('/learning', [LearningController::class, 'index'])->name('hr2.learning');
    Route::get('/training', [TrainingController::class, 'index'])->name('hr2.training');
    Route::get('/succession', [SuccessionController::class, 'index'])->name('hr2.succession');
    Route::get('/ess', [EssController::class, 'index'])->name('hr2.ess');
    Route::post('/ess', [EssController::class, 'store'])->name('hr2.ess.store');

    // Enrollment routes
    Route::get('/learning/enroll/{course}', [LearningController::class, 'enroll'])->name('hr2.learning.enroll');
    Route::get('/training/enroll/{training}', [TrainingController::class, 'enroll'])->name('hr2.training.enroll');
});
