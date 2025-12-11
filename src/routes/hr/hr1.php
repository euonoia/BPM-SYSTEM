<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HR\HR1Controller;

Route::prefix('hr/hr1')->name('hr.hr1.')->group(function () {
    // Main index
    Route::get('/', [HR1Controller::class, 'index'])->name('index');

    // Nested routes
    Route::get('/policies', [HR1Controller::class, 'policies'])->name('policies');
    Route::get('/reports', [HR1Controller::class, 'reports'])->name('reports');
});
