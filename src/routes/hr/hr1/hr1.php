<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\hr1\HR1Controller;

Route::prefix('hr/hr1')->name('hr.hr1.')->group(function () {
    // Main index
    Route::get('/', [hr1Controller::class, 'index'])->name('index');

    // Nested routes
    Route::get('/policies', [hr1Controller::class, 'policies'])->name('policies');
    Route::get('/reports', [hr1Controller::class, 'reports'])->name('reports');
});
