<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\hr2\HR2Controller;


Route::prefix('hr/hr2')->name('hr.hr2.')->group(function () {

    // HR2 public routes
    Route::get('/', [HR2Controller::class, 'index'])->name('index');
    Route::get('/policies', [HR2Controller::class, 'policies'])->name('policies');
    Route::get('/reports', [HR2Controller::class, 'reports'])->name('reports');
});
