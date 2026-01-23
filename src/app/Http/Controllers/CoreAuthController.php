<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\core1\User as CoreUser;

class CoreAuthController extends Controller
{
    /**
     * Show the Core login page
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Handle login request for Core users
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('core')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            $user = Auth::guard('core')->user();

            // Redirect based on role
            return match ($user->role) {
                'admin'        => redirect()->route('admin.dashboard'),
                'doctor'       => redirect()->route('doctor.dashboard'),
                'nurse'        => redirect()->route('nurse.dashboard'),
                'patient'      => redirect()->route('patient.dashboard'),
                'receptionist' => redirect()->route('receptionist.dashboard'),
                'billing'      => redirect()->route('billing.dashboard'),
                default        => abort(403),
            };
        }

        throw ValidationException::withMessages([
            'email' => 'Invalid credentials.',
        ]);
    }

    /**
     * Show the Core registration page
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Handle registration request for Core users
     */
    public function register(Request $request)
    {
        $data = $request->validate([
            'name'           => 'required|string|max:255',
            'email'          => 'required|email|unique:users_core1,email',
            'password'       => 'required|min:8|confirmed',
            'role'           => 'required|string|in:admin,doctor,nurse,receptionist,patient,billing',
            'phone'          => 'nullable|string|max:20',
            'department'     => 'nullable|string|max:255',
            'specialization' => 'nullable|string|max:255',
        ]);

        $user = CoreUser::create([
            'name'           => $data['name'],
            'email'          => $data['email'],
            'password'       => Hash::make($data['password']),
            'role'           => $data['role'],
            'phone'          => $data['phone'] ?? null,
            'department'     => $data['department'] ?? null,
            'specialization' => $data['specialization'] ?? null,
            'status'         => 'active',
        ]);

        Auth::guard('core')->login($user);
        $request->session()->regenerate();

        return redirect()->route('core.home');
    }

    /**
     * Handle logout for Core users
     */
    public function logout(Request $request)
    {
        Auth::guard('core')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('core.login'); // matches web.php
    }
}
