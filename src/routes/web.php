<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::get('/hr2', function () {
    return view('hr2.index');  
})->name('hr2');

