<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class EmployeeAuthController extends Controller
{
    /**
     * Show login page
     */
    public function showLogin()
    {
        return view('portal.login');
    }

    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Attempt login with employee guard
        if (!Auth::guard('employee')->attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => 'Invalid credentials.',
            ]);
        }

        // Regenerate session
        $request->session()->regenerate();

        /** @var Employee $employee */
        $employee = Auth::guard('employee')->user();

        if (!$employee instanceof Employee) {
            Auth::guard('employee')->logout();
            abort(403, 'Invalid user model.');
        }

        // ---------------- Redirect based on role ----------------
        if ($employee->isAdmin()) {
            return redirect()->route('hr2.admin.dashboard');
        }

        // Default employee dashboard
        return redirect()->route('hr2.dashboard');
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        Auth::guard('employee')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('portal.login');
    }
}
