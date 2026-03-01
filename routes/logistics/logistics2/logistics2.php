<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Logistics2\Logistics2Controller;

Route::prefix('logistics/logistics2')
    ->name('logistics.logistics2.')
    ->group(function () {
        Route::get('/', [Logistics2Controller::class, 'index'])->name('index');
        Route::get('/policies', [Logistics2Controller::class, 'policies'])->name('policies');
        Route::get('/reports', [Logistics2Controller::class, 'reports'])->name('reports');
    });
