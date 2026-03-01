<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\hr4\HR4Controller;
use App\Http\Controllers\hr4\PayrollController;
use App\Http\Controllers\hr4\CompensationController;
use App\Http\Controllers\hr4\HumanCapitalController;
use App\Http\Controllers\hr4\AnalyticsController;
use App\Http\Controllers\hr4\AdminController;

Route::prefix('hr/hr4')->name('hr.hr4.')->group(function () {
    
    // EMPLOYEE/USER ROUTES (protected by user guard)
    Route::middleware('auth:user')->group(function () {
        
        // Main Dashboard
        Route::get('/', [HR4Controller::class, 'index'])->name('index');
        Route::get('/policies', [HR4Controller::class, 'policies'])->name('policies');
        Route::get('/reports', [HR4Controller::class, 'reports'])->name('reports');
        
        // PAYROLL MODULE
        Route::prefix('payroll')->name('payroll.')->group(function () {
            Route::get('/', [PayrollController::class, 'index'])->name('index');
            Route::get('/input', [PayrollController::class, 'input'])->name('input');
            Route::post('/validate', [PayrollController::class, 'validateData'])->name('validate');
            Route::get('/compute', [PayrollController::class, 'compute'])->name('compute');
            Route::post('/store', [PayrollController::class, 'store'])->name('store');
            Route::get('/time-keeping', [PayrollController::class, 'timeKeeping'])->name('time-keeping');
            Route::get('/computation', [PayrollController::class, 'computation'])->name('computation');
            Route::get('/payslip/{id?}', [PayrollController::class, 'payslip'])->name('payslip');
        });
            
        // COMPENSATION PLANNING MODULE
        Route::prefix('compensation')->name('compensation.')->group(function () {
            Route::get('/', [CompensationController::class, 'index'])->name('index');
            Route::get('/input', [CompensationController::class, 'input'])->name('input');
            Route::post('/validate', [CompensationController::class, 'validateData'])->name('validate');
            Route::get('/calculate', [CompensationController::class, 'calculate'])->name('calculate');
            Route::post('/submit', [CompensationController::class, 'submit'])->name('submit');
            Route::get('/job-grading', [CompensationController::class, 'jobGrading'])->name('job-grading');
            Route::get('/performance', [CompensationController::class, 'performance'])->name('performance');
            Route::get('/review', [CompensationController::class, 'review'])->name('review');
        });
            
        // HUMAN CAPITAL MODULE
        Route::prefix('human-capital')->name('human-capital.')->group(function () {
            Route::get('/', [HumanCapitalController::class, 'index'])->name('index');
            Route::get('/process', [HumanCapitalController::class, 'process'])->name('process');
            Route::post('/check-employee', [HumanCapitalController::class, 'checkEmployee'])->name('check-employee');
            Route::post('/save', [HumanCapitalController::class, 'save'])->name('save');
            Route::get('/validate-record', [HumanCapitalController::class, 'validateRecord'])->name('validate-record');
            Route::post('/confirm-save', [HumanCapitalController::class, 'confirmSave'])->name('confirm-save');
            Route::get('/edit', [HumanCapitalController::class, 'edit'])->name('edit');
            Route::get('/records', [HumanCapitalController::class, 'records'])->name('records');
            Route::get('/recruitment', [HumanCapitalController::class, 'recruitment'])->name('recruitment');
            Route::get('/leave-scheduling', [HumanCapitalController::class, 'leaveScheduling'])->name('leave-scheduling');
        });
            
        // ANALYTICS MODULE
        Route::prefix('analytics')->name('analytics.')->group(function () {
            Route::get('/', [AnalyticsController::class, 'index'])->name('index');
            Route::get('/collect', [AnalyticsController::class, 'collect'])->name('collect');
            Route::post('/analyze', [AnalyticsController::class, 'analyze'])->name('analyze');
            Route::get('/generate', [AnalyticsController::class, 'generate'])->name('generate');
            Route::get('/clean', [AnalyticsController::class, 'clean'])->name('clean');
            Route::get('/kpi-dashboard', [AnalyticsController::class, 'kpiDashboard'])->name('kpi-dashboard');
            Route::get('/cost-analytics', [AnalyticsController::class, 'costAnalytics'])->name('cost-analytics');
            Route::get('/manpower-reports', [AnalyticsController::class, 'manpowerReports'])->name('manpower-reports');
        });
        
    });

    // ADMIN ROUTES (protected by admin guard)
    Route::prefix('admin')->name('admin.')->middleware('auth:admin')->group(function () {
        Route::get('/', [AdminController::class, 'dashboard'])->name('index');
        Route::get('/employees', [AdminController::class, 'employees'])->name('employees');
        Route::get('/employees/{id}', [AdminController::class, 'show'])->name('employees.show');
        Route::get('/payrolls', [AdminController::class, 'payrolls'])->name('payrolls');
        Route::get('/compensations', [AdminController::class, 'compensations'])->name('compensations');
        Route::post('/compensations/{id}/approve', [AdminController::class, 'approveCompensation'])->name('compensations.approve');
        Route::post('/compensations/{id}/reject', [AdminController::class, 'rejectCompensation'])->name('compensations.reject');
        Route::get('/settings', [AdminController::class, 'settings'])->name('settings');

        // Admin user management
        Route::prefix('admins')->name('admins.')->group(function () {
            Route::get('/', [\App\Http\Controllers\hr4\AdminManagementController::class, 'index'])->name('index');
            Route::get('/create', [\App\Http\Controllers\hr4\AdminManagementController::class, 'create'])->name('create');
            Route::post('/', [\App\Http\Controllers\hr4\AdminManagementController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [\App\Http\Controllers\hr4\AdminManagementController::class, 'edit'])->name('edit');
            Route::put('/{id}', [\App\Http\Controllers\hr4\AdminManagementController::class, 'update'])->name('update');
            Route::delete('/{id}', [\App\Http\Controllers\hr4\AdminManagementController::class, 'destroy'])->name('destroy');
        });
    });


});