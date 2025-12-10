<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
Route::get('/', function () {
    return view('index');
});

Route::get('/hr2', function () {
    return view('hr2.index');  
})->name('hr2');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/', [AuthController::class, 'dashboard'])->name('dashboard')->middleware('auth.employee');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
