<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = DB::table('employees')->where('email', $request->email)->first();

        if ($user && password_verify($request->password, $user->password)) {
            session([
                'employee_id' => $user->id,
                'employee_name' => $user->name,
                'role' => $user->role,
            ]);

            return redirect()->route('dashboard');
        }

        return back()->with('message', 'Invalid email or password.');
    }

    public function dashboard()
    {
        if (!session()->has('employee_id')) {
            return redirect()->route('login');
        }

        $employee_id = session('employee_id');

        $counts = [
            'Competencies' => DB::table('competencies')->count(),
            'Courses' => DB::table('course_enrolls')->where('employee_id', $employee_id)->count(),
            'Trainings' => DB::table('training_enrolls')->where('employee_id', $employee_id)->count(),
            'ESS Requests' => DB::table('ess_request')->where('employee_id', $employee_id)->count()
        ];

        return view('index', compact('counts'));
    }

    public function logout()
    {
        session()->flush();
        return redirect()->route('login');
    }
}
