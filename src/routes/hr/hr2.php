<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HR\HR2Controller;

Route::prefix('hr/hr2')->name('hr.hr2.')->group(function () {
    // Main index
    Route::get('/', [HR2Controller::class, 'index'])->name('index');

    // Nested routes
    Route::get('/policies', [HR2Controller::class, 'policies'])->name('policies');
    Route::get('/reports', [HR2Controller::class, 'reports'])->name('reports');
});
