<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;

// Homepage
Route::get('/', fn () => view('index'));

/*
|--------------------------------------------------------------------------
| Modular Route Loading
|--------------------------------------------------------------------------
| - core, hr, logistics  => nested
| - financials          => flat
*/

$nestedModules = ['core', 'hr', 'logistics'];
$flatModules   = ['financials'];

// Nested modules
foreach ($nestedModules as $module) {
    foreach (glob(__DIR__ . "/{$module}/**/*.php") as $file) {
        require $file;
    }
}

// Flat modules
foreach ($flatModules as $module) {
    foreach (glob(__DIR__ . "/{$module}/*.php") as $file) {
        require $file;
    }
}

// Resources
Route::resource('patients', PatientController::class);
