<?php
namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;

class CoreAuthController extends BaseAuthController
{
    protected string $guard = 'core1';

    protected function redirectAfterLogin()
    {
        $user = Auth::guard($this->guard)->user();

        return match ($user->role) {
            'admin' => redirect()->route('core1.admin.dashboard'),
            'doctor' => redirect()->route('core1.doctor.dashboard'),
            'nurse', 'head_nurse' => redirect()->route('core1.nurse.dashboard'),
            'patient' => redirect()->route('core1.patient.dashboard'),
            'billing' => redirect()->route('core1.billing.dashboard'),
            default => redirect('/'),
        };
    }
}
