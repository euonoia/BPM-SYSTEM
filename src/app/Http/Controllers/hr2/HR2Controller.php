<?php

namespace App\Http\Controllers\hr2;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class HR2Controller extends Controller
{
    public function index() {
        return view('hr2.index');
    }

    public function policies() {
        return view('hr2.policies');
    }

    public function reports() {
        return view('hr2.reports');
    }

    public function dashboard() {
        $admin = Auth::guard('admin')->user();
        if (!$admin) return redirect()->route('hr.hr2.admin.login');

        $tables = [
            'employees' => 'Employees',
            'competencies' => 'Competencies',
            'learning_modules' => 'Learning Modules',
            'training_sessions' => 'Trainings',
            'succession_positions' => 'Succession Positions',
            'ess_request' => 'ESS Requests',
        ];

        $counts = [];
        foreach ($tables as $table => $label) {
            $counts[$label] = DB::table($table)->count();
        }

        return view('hr2.modules.hr2.admin.admin-dashboard', [
            'admin' => $admin,
            'counts' => $counts,
        ]);
    }
}
