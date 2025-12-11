<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Logistics\Logistics1Controller;

Route::prefix('logistics/logistics1')->name('logistics.logistics1.')->group(function () {
    // Main index
    Route::get('/', [Logistics1Controller::class, 'index'])->name('index');

    // Nested routes
    Route::get('/policies', [Logistics1Controller::class, 'policies'])->name('policies');
    Route::get('/reports', [Logistics1Controller::class, 'reports'])->name('reports');
});
