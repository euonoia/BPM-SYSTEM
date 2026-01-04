<?php
namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;

class CoreAuthController extends BaseAuthController
{
    protected string $guard = 'core';

    protected function redirectAfterLogin()
    {
        $user = Auth::guard($this->guard)->user();

        return match ($user->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'doctor' => redirect()->route('doctor.dashboard'),
            'nurse' => redirect()->route('nurse.dashboard'),
            'patient' => redirect()->route('patient.dashboard'),
            'billing' => redirect()->route('billing.dashboard'),
            default => redirect('/'),
        };
    }
}
