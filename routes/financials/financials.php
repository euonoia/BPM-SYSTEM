<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Financials\FinancialsController;

Route::prefix('financials')->name('financials.')->group(function () {
    // Main index
    Route::get('/', [FinancialsController::class, 'index'])->name('index');

    // Nested routes (example)
    Route::get('/reports', [FinancialsController::class, 'reports'])->name('reports');
    Route::get('/budgets', [FinancialsController::class, 'budgets'])->name('budgets');
});
