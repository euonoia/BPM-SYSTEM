<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\core1\Admin\AdminDashboardController;
use App\Http\Controllers\core1\Doctor\DoctorDashboardController;
use App\Http\Controllers\core1\Nurse\NurseDashboardController;
use App\Http\Controllers\core1\Patient\PatientDashboardController;
use App\Http\Controllers\core1\Receptionist\ReceptionistDashboardController;
use App\Http\Controllers\core1\Billing\BillingDashboardController;
use App\Http\Controllers\core1\PatientManagementController;
use App\Http\Controllers\core1\AppointmentController;
use App\Http\Controllers\core1\InpatientController;
use App\Http\Controllers\core1\OutpatientController;
use App\Http\Controllers\core1\MedicalRecordController;
use App\Http\Controllers\core1\BillingController;
use App\Http\Controllers\core1\DischargeController;
use App\Http\Controllers\core1\StaffManagementController;
use App\Http\Controllers\core1\ReportsController;
use App\Http\Controllers\core1\SettingsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Authentication Routes
// Note: Root route '/' is handled in main web.php to show index.blade.php
// Login and logout routes are handled by the main AuthController

// Protected Routes - Require Authentication
Route::middleware(['multiAuth'])->group(function () {
    
    // Dashboard Routes by Role
    Route::prefix('admin')->middleware('role:admin')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('/overview', [AdminDashboardController::class, 'overview'])->name('admin.overview');
    });
    
    Route::prefix('doctor')->middleware('role:doctor')->group(function () {
        Route::get('/dashboard', [DoctorDashboardController::class, 'index'])->name('doctor.dashboard');
        Route::get('/overview', [DoctorDashboardController::class, 'overview'])->name('doctor.overview');
    });
    
    Route::prefix('nurse')->middleware('role:nurse')->group(function () {
        Route::get('/dashboard', [NurseDashboardController::class, 'index'])->name('nurse.dashboard');
        Route::get('/overview', [NurseDashboardController::class, 'overview'])->name('nurse.overview');
    });
    
    Route::prefix('patient')->middleware('role:patient')->group(function () {
        Route::get('/dashboard', [PatientDashboardController::class, 'index'])->name('patient.dashboard');
        Route::get('/overview', [PatientDashboardController::class, 'overview'])->name('patient.overview');
    });
    
    Route::prefix('receptionist')->middleware('role:receptionist')->group(function () {
        Route::get('/dashboard', [ReceptionistDashboardController::class, 'index'])->name('receptionist.dashboard');
        Route::get('/overview', [ReceptionistDashboardController::class, 'overview'])->name('receptionist.overview');
    });
    
    Route::prefix('billing')->middleware('role:billing')->group(function () {
        Route::get('/dashboard', [BillingDashboardController::class, 'index'])->name('billing.dashboard');
        Route::get('/overview', [BillingDashboardController::class, 'overview'])->name('billing.overview');
    });
    
    // Shared Feature Routes
    Route::middleware('role:admin,doctor,nurse,receptionist')->group(function () {
        Route::get('/patients', [PatientManagementController::class, 'index'])->name('patients.index');
        Route::get('/patients/create', [PatientManagementController::class, 'create'])->name('patients.create');
        Route::post('/patients', [PatientManagementController::class, 'store'])->name('patients.store');
        Route::get('/patients/{patient}', [PatientManagementController::class, 'show'])->name('patients.show');
        Route::get('/patients/{patient}/edit', [PatientManagementController::class, 'edit'])->name('patients.edit');
        Route::put('/patients/{patient}', [PatientManagementController::class, 'update'])->name('patients.update');
        Route::delete('/patients/{patient}', [PatientManagementController::class, 'destroy'])->name('patients.destroy');
    });
    
    Route::middleware('role:admin,doctor,patient,receptionist')->group(function () {
        Route::get('/appointments/check-availability', [AppointmentController::class, 'checkAvailability'])->name('appointments.check-availability');
        Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');
        Route::get('/appointments/create', [AppointmentController::class, 'create'])->name('appointments.create');
        Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
        Route::get('/appointments/{appointment}', [AppointmentController::class, 'show'])->name('appointments.show');
        Route::put('/appointments/{appointment}', [AppointmentController::class, 'update'])->name('appointments.update');
        Route::delete('/appointments/{appointment}', [AppointmentController::class, 'destroy'])->name('appointments.destroy');
    });
    
    Route::middleware('role:admin,doctor,nurse')->group(function () {
        Route::get('/inpatient', [InpatientController::class, 'index'])->name('inpatient.index');
        Route::get('/outpatient', [OutpatientController::class, 'index'])->name('outpatient.index');
        Route::get('/discharge', [DischargeController::class, 'index'])->name('discharge.index');
    });
    
    Route::middleware('role:admin,doctor,nurse,patient')->group(function () {
        Route::get('/medical-records', [MedicalRecordController::class, 'index'])->name('medical-records.index');
        Route::get('/medical-records/{record}', [MedicalRecordController::class, 'show'])->name('medical-records.show');
    });
    
    Route::middleware('role:admin,billing,patient')->group(function () {
        Route::get('/billing', [BillingController::class, 'index'])->name('billing.index');
        Route::get('/billing/{bill}', [BillingController::class, 'show'])->name('billing.show');
    });
    
    Route::middleware('role:admin')->group(function () {
        Route::get('/staff', [StaffManagementController::class, 'index'])->name('staff.index');
        Route::get('/staff/create', [StaffManagementController::class, 'create'])->name('staff.create');
        Route::post('/staff', [StaffManagementController::class, 'store'])->name('staff.store');
    });
    
    Route::middleware('role:admin')->group(function () {
        Route::get('/reports', [ReportsController::class, 'index'])->name('reports.index');
    });
    
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
});

