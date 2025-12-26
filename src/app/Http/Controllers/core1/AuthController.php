<?php

namespace App\Http\Controllers\core1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\core1\User;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirectToDashboard(Auth::user());
        }
        
        return view('core1.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'role' => 'required|in:admin,doctor,nurse,patient,receptionist,billing',
        ]);

        // For demo purposes, we'll authenticate based on role
        // In production, use proper authentication
        $user = User::where('email', $request->email)
            ->where('role', $request->role)
            ->first();

        if (!$user) {
            // Create demo user if doesn't exist
            $user = $this->createDemoUser($request->role, $request->email);
        }

        Auth::login($user);

        return $this->redirectToDashboard($user);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    private function redirectToDashboard($user)
    {
        return match($user->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'doctor' => redirect()->route('doctor.dashboard'),
            'nurse' => redirect()->route('nurse.dashboard'),
            'patient' => redirect()->route('patient.dashboard'),
            'receptionist' => redirect()->route('receptionist.dashboard'),
            'billing' => redirect()->route('billing.dashboard'),
            default => redirect()->route('login'),
        };
    }

    private function createDemoUser($role, $email)
    {
        $demoUsers = [
            'admin' => [
                'name' => 'John Admin',
                'employee_id' => 'ADM001',
                'department' => null,
                'specialization' => null,
            ],
            'doctor' => [
                'name' => 'Dr. Sarah Smith',
                'employee_id' => 'DOC001',
                'department' => 'Cardiology',
                'specialization' => 'Interventional Cardiology',
            ],
            'nurse' => [
                'name' => 'Emily Johnson',
                'employee_id' => 'NUR001',
                'department' => 'ICU',
                'specialization' => null,
            ],
            'patient' => [
                'name' => 'Michael Brown',
                'employee_id' => 'HMS-2025-00001',
                'department' => null,
                'specialization' => null,
            ],
            'receptionist' => [
                'name' => 'Lisa Anderson',
                'employee_id' => 'REC001',
                'department' => null,
                'specialization' => null,
            ],
            'billing' => [
                'name' => 'Robert Wilson',
                'employee_id' => 'BIL001',
                'department' => null,
                'specialization' => null,
            ],
        ];

        $userData = $demoUsers[$role] ?? $demoUsers['admin'];
        
        return User::create([
            'name' => $userData['name'],
            'email' => $email,
            'password' => bcrypt('password'),
            'role' => $role,
            'employee_id' => $userData['employee_id'],
            'department' => $userData['department'],
            'specialization' => $userData['specialization'],
            'status' => 'active',
        ]);
    }
}

