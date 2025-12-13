<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\hr2\HR2Controller;

Route::prefix('hr/hr2')->name('hr.hr2.')->group(function () {
    // Main index
    Route::get('/', [hr2Controller::class, 'index'])->name('index');

    // Nested routes
    Route::get('/policies', [hr2Controller::class, 'policies'])->name('policies');
    Route::get('/reports', [hr2Controller::class, 'reports'])->name('reports');
});
