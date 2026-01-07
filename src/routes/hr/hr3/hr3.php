<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\hr3\HR3Controller;

Route::prefix('hr/hr3')->name('hr.hr3.')->group(function () {
    // Main index
    Route::get('/', [hr3Controller::class, 'index'])->name('index');

    // Nested routes
    Route::get('/policies', [hr3Controller::class, 'policies'])->name('policies');
    Route::get('/reports', [hr3Controller::class, 'reports'])->name('reports');
});
