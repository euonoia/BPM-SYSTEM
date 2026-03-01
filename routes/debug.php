<?php

use Illuminate\Support\Facades\Route;

Route::get('/debug/employee-login', function () {
    $emp = \App\Models\Employee::first();
    return [
        'email' => $emp->email,
        'has_password' => !empty($emp->password),
        'password_hash' => substr($emp->password, 0, 10) . '...',
    ];
});

Route::get('/debug/auth-status', function () {
    return [
        'admin_auth' => auth('admin')->check() ? auth('admin')->user()->email : null,
        'user_auth' => auth('user')->check() ? auth('user')->user()->email : null,
    ];
});
