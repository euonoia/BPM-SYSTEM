<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeAuthController;
use App\Http\Controllers\hr2\DashboardController;
use App\Http\Controllers\hr2\CompetencyController;
use App\Http\Controllers\hr2\LearningController;
use App\Http\Controllers\hr2\TrainingController;
use App\Http\Controllers\hr2\SuccessionController;
use App\Http\Controllers\hr2\EssController;

// Admin Controllers
use App\Http\Controllers\hr2\Admin\AdminDashboardController;
use App\Http\Controllers\hr2\Admin\AdminCompetencyController;
use App\Http\Controllers\hr2\Admin\AdminLearningController;
use App\Http\Controllers\hr2\Admin\AdminTrainingController;
use App\Http\Controllers\hr2\Admin\AdminSuccessionController;
use App\Http\Controllers\hr2\Admin\AdminEssController;
use App\Http\Controllers\hr2\Admin\AdminController;

// ---------------- Login Routes ----------------
Route::get('/login', [EmployeeAuthController::class, 'showLogin'])->name('portal.login');
Route::post('/login', [EmployeeAuthController::class, 'login'])->name('portal.login.submit');
Route::post('/logout', [EmployeeAuthController::class, 'logout'])->name('portal.logout');

// ---------------- Employee / HR Routes ----------------
Route::middleware('auth:employee')->prefix('hr2')->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('hr2.dashboard');

    Route::get('/competencies', [CompetencyController::class, 'index'])->name('hr2.competencies');
    Route::get('/learning', [LearningController::class, 'index'])->name('hr2.learning');
    Route::get('/training', [TrainingController::class, 'index'])->name('hr2.training');
    Route::get('/succession', [SuccessionController::class, 'index'])->name('hr2.succession');
    Route::get('/ess', [EssController::class, 'index'])->name('hr2.ess');

    // Actions
    Route::post('/ess', [EssController::class, 'store'])->name('hr2.ess.store');
    Route::post('/learning/enroll/{course_id}', [LearningController::class, 'enroll'])->name('hr2.learning.enroll');
    Route::post('/training/enroll/{training_id}', [TrainingController::class, 'enroll'])->name('hr2.training.enroll');
});

// ---------------- Admin Routes ----------------
Route::middleware('auth:employee')->prefix('hr2/admin')->group(function () {

    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('hr2.admin.dashboard');

    // Competency
    Route::get('/competency', [AdminCompetencyController::class, 'index'])->name('hr2.admin.competency');
    Route::post('/competency', [AdminCompetencyController::class, 'store'])->name('hr2.admin.competency.store');
    Route::delete('/competency/{id}', [AdminCompetencyController::class, 'destroy'])->name('hr2.admin.competency.destroy');

    // Learning
    Route::get('/learning', [AdminLearningController::class, 'index'])->name('hr2.admin.learning');
    Route::post('/learning', [AdminLearningController::class, 'store'])->name('hr2.admin.learning.store');
    Route::delete('/learning/{id}', [AdminLearningController::class, 'destroy'])->name('hr2.admin.learning.destroy');

    // Training
    Route::get('/training', [AdminTrainingController::class, 'index'])->name('hr2.admin.training');
    Route::post('/training', [AdminTrainingController::class, 'store'])->name('hr2.admin.training.store');
    Route::delete('/training/{id}', [AdminTrainingController::class, 'destroy'])->name('hr2.admin.training.destroy');

    // Succession
    Route::get('/succession', [AdminSuccessionController::class, 'index'])->name('hr2.admin.succession');
    Route::post('/succession/position', [AdminSuccessionController::class, 'storePosition'])->name('hr2.admin.succession.storePosition');
    Route::post('/succession/candidate', [AdminSuccessionController::class, 'storeCandidate'])->name('hr2.admin.succession.storeCandidate');
    Route::delete('/succession/position/{id}', [AdminSuccessionController::class, 'destroyPosition'])->name('hr2.admin.succession.destroyPosition');
    Route::delete('/succession/candidate/{id}', [AdminSuccessionController::class, 'destroyCandidate'])->name('hr2.admin.succession.destroyCandidate');

    // ESS
    Route::get('/ess', [AdminEssController::class, 'index'])->name('hr2.admin.ess');
    Route::post('/ess/{id}/update', [AdminEssController::class, 'updateStatus'])->name('hr2.admin.ess.updateStatus');

    // Add Admin
    Route::get('/add-admin', [AdminController::class, 'create'])->name('admin.add');
    Route::post('/add-admin', [AdminController::class, 'store'])->name('admin.add.store');
});
