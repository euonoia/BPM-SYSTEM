<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\core1\User as CoreUser;

class CoreAuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('core')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            $user = Auth::guard('core')->user();

            return match ($user->role) {
                'admin' => redirect()->route('admin.dashboard'),
                'doctor' => redirect()->route('doctor.dashboard'),
                'nurse' => redirect()->route('nurse.dashboard'),
                'patient' => redirect()->route('patient.dashboard'),
                'receptionist' => redirect()->route('receptionist.dashboard'),
                'billing' => redirect()->route('billing.dashboard'),
                default => abort(403),
            };
        }

        throw ValidationException::withMessages([
            'email' => 'Invalid credentials.',
        ]);
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users_core1,email',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = CoreUser::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'patient',
            'status' => 'active',
        ]);

        Auth::guard('core')->login($user);
        $request->session()->regenerate();

        return redirect()->route('patient.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::guard('core')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
