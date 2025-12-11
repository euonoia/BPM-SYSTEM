<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HR\HR3Controller;

Route::prefix('hr/hr3')->name('hr.hr3.')->group(function () {
    // Main index
    Route::get('/', [HR3Controller::class, 'index'])->name('index');

    // Nested routes
    Route::get('/policies', [HR3Controller::class, 'policies'])->name('policies');
    Route::get('/reports', [HR3Controller::class, 'reports'])->name('reports');
});
