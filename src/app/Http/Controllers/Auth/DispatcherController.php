<?php
namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;

class AuthDispatcherController
{
    public function login(Request $request)
    {
        return match ($request->input('subsystem')) {
            'hr' => app(HrAuthController::class)->login($request),
            default => back()->withErrors(['subsystem' => 'Invalid subsystem']),
        };
    }
}
