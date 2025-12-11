<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;

// Homepage
Route::get('/', function () {
    return view('index');
});

// Dynamically load all module route files
foreach (glob(__DIR__.'/core/*.php') as $file) {
    require $file;
}

foreach (glob(__DIR__.'/logistics/*.php') as $file) {
    require $file;
}

foreach (glob(__DIR__.'/hr/*.php') as $file) {
    require $file;
}

foreach (glob(__DIR__.'/financials/*.php') as $file) {
    require $file;
}

Route::resource('patients', PatientController::class);