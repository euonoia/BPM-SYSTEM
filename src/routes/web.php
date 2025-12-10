<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;

Route::get('/', function () {
    return view('index');
});

Route::get('/hr2', function () {
    return view('hr2.index');  
})->name('hr2');

Route::resource('patients', PatientController::class);
