<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

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
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Redirect based on role and position
            return $this->redirectByRole($user);
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
            'firstname' => 'required|string|max:255',
            'lastname'  => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email',
            'password'   => 'required|confirmed|min:6',
            'role'       => 'required|in:admin,user',
            'position'   => 'nullable|in:employee,user,manager',
        ]);

        $user = User::create([
            'firstname' => $request->firstname,
            'lastname'  => $request->lastname,
            'email'      => $request->email,
            'password'   => $request->password, // hashed by model mutator
            'role'       => $request->role,
            'position'   => $request->position,
        ]);

        Auth::login($user);

        return $this->redirectByRole($user);
    }

    /**
     * Logout user
     */
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    /**
     * Redirect user based on role and position
     */
    private function redirectByRole(User $user)
    {
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        if ($user->role === 'user') {
            switch ($user->position) {
                case 'employee':
                    return redirect()->route('hr.dashboard');
                case 'user':
                    return redirect()->route('core.dashboard');
                case 'manager':
                    return redirect()->route('hr.dashboard'); // Example, can change
                default:
                    return redirect()->route('home');
            }
        }

        return redirect()->route('home');
    }
}
