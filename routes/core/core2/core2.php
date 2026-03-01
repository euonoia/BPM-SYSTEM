<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\core2\core2Controller;

Route::prefix('core/core2')->name('core.core2.')->group(function () {
    // Main index
    Route::get('/', [core2Controller::class, 'index'])->name('index');
    // Nested routes
    Route::get('/policies', [core2Controller::class, 'policies'])->name('policies');
    Route::get('/reports', [core2Controller::class, 'reports'])->name('reports');
});