<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\core1\core1Controller;

Route::prefix('core/core1')->name('core.core1.')->group(function () {
    // Main index
    Route::get('/', [core1Controller::class, 'index'])->name('index');
    // Nested routes
    Route::get('/policies', [core1Controller::class, 'policies'])->name('policies');
    Route::get('/reports', [core1Controller::class, 'reports'])->name('reports');
});
