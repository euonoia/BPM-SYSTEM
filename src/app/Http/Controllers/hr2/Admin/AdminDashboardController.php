<?php

namespace App\Http\Controllers\Hr2\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Authenticate; // Optional if admin is part of users table
use App\Models\Hr2\Admin\CompetencyHr2;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Use authenticated user instead of raw session
        $admin = Auth::authenticate();

        // Dashboard counts (map table names to labels)
        $tables = [
            'employees_hr2' => 'Employees',
            'competencies_hr2' => 'Competencies',
            'learning_modules_hr2' => 'Learning Modules',
            'training_sessions_hr2' => 'Trainings',
            'succession_positions_hr2' => 'Succession Positions',
            'ess_request_hr2' => 'ESS Requests',
        ];

        $counts = [];
        foreach ($tables as $table => $label) {
            $counts[$label] = DB::table($table)->count();
        }

        return view('hr2.admin.dashboard', compact('admin', 'counts'));
    }
}
