<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Authenticate;
use App\Models\core1\User as Core1User;

class AuthController extends Controller
{
    /**
     * Allowed subsystems for registration
     */
    private const ALLOWED_SUBSYSTEMS = ['hr', 'core1'];

    /**
     * Allowed HR roles
     */
    private const HR_ROLES = ['hr', 'employee'];

    /**
     * Allowed Core1 roles
     */
    private const CORE1_ROLES = ['admin', 'doctor', 'nurse', 'receptionist', 'patient', 'billing'];

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

        $email = $request->email;
        $password = $request->password;

        // Try HR system authentication first
        $hrUser = Authenticate::where('email', $email)->first();
        if ($hrUser && Hash::check($password, $hrUser->password)) {
            // Manually log in HR user
            Auth::login($hrUser, $request->filled('remember'));
            $request->session()->regenerate();
            
            // Directly redirect - don't check Auth::check() as it might fail with different models
            return $this->redirectByRole($hrUser, 'hr');
        }

        // Try Core1 system authentication
        $core1User = Core1User::where('email', $email)->first();
        if ($core1User && Hash::check($password, $core1User->password)) {
            // Store user info in session manually first
            $request->session()->put('core1_user_id', $core1User->id);
            $request->session()->put('core1_user_role', $core1User->role);
            $request->session()->put('core1_user', $core1User->toArray());
            
            // Try to login using Auth (may not work due to provider config, but try anyway)
            try {
                Auth::login($core1User, $request->filled('remember'));
            } catch (\Exception $e) {
                // If Auth::login fails, we still have the user in session
                \Log::warning('Auth::login failed for Core1User', ['error' => $e->getMessage()]);
            }
            
            $request->session()->regenerate();
            
            // Directly redirect - don't check Auth::check() as it might fail with different models
            return $this->redirectByRole($core1User, 'core1');
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
        $subsystem = $request->input('subsystem');

        // Validate subsystem
        if (!in_array($subsystem, self::ALLOWED_SUBSYSTEMS)) {
            return back()->withErrors(['subsystem' => 'Invalid subsystem selected.'])->withInput();
        }

        if ($subsystem === 'hr') {
            return $this->registerHrUser($request);
        } elseif ($subsystem === 'core1') {
            return $this->registerCore1User($request);
        }

        return back()->withErrors(['subsystem' => 'Invalid subsystem.'])->withInput();
    }

    /**
     * Register HR system user
     */
    private function registerHrUser(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:150',
            'last_name'  => 'required|string|max:150',
            'email'      => 'required|email|unique:employees_hr2,email',
            'password'   => 'required|confirmed|min:6',
            'role'       => 'required|in:' . implode(',', self::HR_ROLES),
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
            'role'       => $request->role,
            'position'   => $request->position,
            'branch'     => $request->branch,
            'hire_date'  => $request->hire_date,
        ]);

        Auth::login($employee);
        $request->session()->regenerate();

        return $this->redirectByRole($employee, 'hr');
    }

    /**
     * Register Core1 system user
     */
    private function registerCore1User(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:users_core1,email',
            'password'      => 'required|confirmed|min:6',
            'role'          => 'required|in:' . implode(',', self::CORE1_ROLES),
            'phone'         => 'nullable|string|max:20',
            'department'    => 'nullable|string|max:255',
            'specialization' => 'nullable|string|max:255',
        ]);

        $user = Core1User::create([
            'name'          => $request->name,
            'email'         => $request->email,
            'password'      => Hash::make($request->password),
            'role'          => $request->role,
            'phone'         => $request->phone,
            'department'    => $request->department,
            'specialization' => $request->specialization,
            'status'         => 'active',
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return $this->redirectByRole($user, 'core1');
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
     * Redirect user based on role and subsystem
     */
    private function redirectByRole($user, string $subsystem)
    {
        try {
            if ($subsystem === 'hr') {
                if ($user->role === 'hr' || $user->role === 'employee') {
                    return redirect()->route('hr2.dashboard');
                }
                // Fallback: redirect to homepage if role doesn't match
                return redirect('/');
            }

            if ($subsystem === 'core1') {
                $role = $user->role ?? null;
                
                if (!$role) {
                    return redirect('/')->withErrors(['error' => 'User role not found']);
                }

                // Map roles to dashboard routes
                $dashboardRoutes = [
                    'admin' => 'admin.dashboard',
                    'doctor' => 'doctor.dashboard',
                    'nurse' => 'nurse.dashboard',
                    'patient' => 'patient.dashboard',
                    'receptionist' => 'receptionist.dashboard',
                    'billing' => 'billing.dashboard',
                ];

                if (isset($dashboardRoutes[$role])) {
                    $routeName = $dashboardRoutes[$role];
                    
                    // Try to get the route URL directly
                    try {
                        // Check if route exists before redirecting
                        if (\Route::has($routeName)) {
                            $url = route($routeName);
                            return redirect($url);
                        } else {
                            // Route doesn't exist, try direct URL based on role
                            $url = '/' . $role . '/dashboard';
                            return redirect($url);
                        }
                    } catch (\Exception $e) {
                        // If route() fails, try direct URL
                        $url = '/' . $role . '/dashboard';
                        return redirect($url);
                    }
                }

                return redirect('/')->withErrors(['error' => 'Unknown role: ' . $role]);
            }

            // Fallback: redirect to homepage if subsystem doesn't match
            return redirect('/');
        } catch (\Exception $e) {
            // Log the error and redirect to homepage
            \Log::error('Redirect error', [
                'error' => $e->getMessage(),
                'subsystem' => $subsystem,
                'user_role' => $user->role ?? 'no role',
                'trace' => $e->getTraceAsString()
            ]);
            return redirect('/')->withErrors(['error' => 'Redirect failed: ' . $e->getMessage()]);
        }
    }
}
