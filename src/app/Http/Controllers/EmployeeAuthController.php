<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\Employee;

class EmployeeAuthController extends Controller
{
    public function showLogin()
    {
        return view('portal.login');
    }
public function login(Request $request)
{
    $credentials = $request->validate([
        'email'    => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::guard('employee')->attempt($credentials)) {
        $request->session()->regenerate();

        $employee = Auth::guard('employee')->user();

        // Safety check
        if (!$employee instanceof \App\Models\Employee) {
            Auth::guard('employee')->logout();
            abort(403, 'Unauthorized access.');
        }

        // Redirect based on role only
        if ($employee->isAdmin()) {
            return redirect()->route('admin.dashboard'); // HR2 admin
        }

        if ($employee->isHr()) {
            return redirect()->route('hr2.dashboard'); // HR2 user
        }

        // Unknown role
        Auth::guard('employee')->logout();
        abort(403, 'Unauthorized role.');
    }

    throw ValidationException::withMessages([
        'email' => 'Invalid credentials.',
    ]);
}

    public function logout(Request $request)
    {
        Auth::guard('employee')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('portal.login');
    }
}
