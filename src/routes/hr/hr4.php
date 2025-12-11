<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HR\HR4Controller;

Route::prefix('hr/hr4')->name('hr.hr4.')->group(function () {
    // Main index
    Route::get('/', [HR4Controller::class, 'index'])->name('index');

    // Nested routes
    Route::get('/policies', [HR4Controller::class, 'policies'])->name('policies');
    Route::get('/reports', [HR4Controller::class, 'reports'])->name('reports');
});
