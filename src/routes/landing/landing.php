<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingPageController;

Route::prefix('landing')->name('landing.landingPage.')->group(function () {
    // Landing page index
    Route::get('/', [LandingPageController::class, 'index'])->name('index');

    // Optional additional landing routes
    // Route::get('/features', [LandingPageController::class, 'features'])->name('features');
});
