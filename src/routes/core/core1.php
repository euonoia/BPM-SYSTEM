<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CORE\CORE1Controller;

Route::prefix('core/core1')->name('core.core1.')->group(function () {
    // Main index
    Route::get('/', [CORE1Controller::class, 'index'])->name('index');
    // Nested routes
    Route::get('/policies', [CORE1Controller::class, 'policies'])->name('policies');
    Route::get('/reports', [CORE1Controller::class, 'reports'])->name('reports');
});
