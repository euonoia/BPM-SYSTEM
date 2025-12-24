<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Authenticate;

class AuthController extends Controller
{
    /**
     * Show login form
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Process login
     */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $employee = Auth::user();

            // Redirect based on role and position
            return $this->redirectByRole($employee);
        }

        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ]);
    }

    /**
     * Show registration form
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Process registration
     */
    public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:150',
            'last_name'  => 'required|string|max:150',
            'email'      => 'required|email|unique:employees_hr2,email',
            'password'   => 'required|confirmed|min:6',
            'role'       => 'required|in:hr,employee', // removed admin
            'position'   => 'nullable|string|max:100',
            'branch'     => 'nullable|string|max:100',
            'hire_date'  => 'nullable|date',
        ]);

        $employee = Authenticate::create([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'name'       => $request->first_name . ' ' . $request->last_name,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'role'       => $request->role, // only hr or employee allowed
            'position'   => $request->position,
            'branch'     => $request->branch,
            'hire_date'  => $request->hire_date,
        ]);

        Auth::login($employee);

        return $this->redirectByRole($employee);
    }

    /**
     * Logout user
     */
    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/');
    }

    /**
     * Redirect user based on role and position
     */
    private function redirectByRole(Authenticate $employee)
    {
        if ($employee->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        if ($employee->role === 'hr') {
            return redirect()->route('hr2.dashboard');
        }

        if ($employee->role === 'employee') {
            return redirect()->route('hr2.dashboard');
        }

        return redirect()->route('home');
    }
}
