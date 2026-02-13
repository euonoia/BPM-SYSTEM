<?php

namespace App\Http\Controllers\hr4;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\PayrollRecord;
use App\Models\CompensationAdjustment;

class HR4Controller extends Controller
{
    public function index()
    {
        $stats = [
            'total_employees' => Employee::count(),
            'active_employees' => Employee::active()->count(),
            'pending_compensations' => CompensationAdjustment::pending()->count(),
            'total_payrolls_this_month' => PayrollRecord::whereMonth('payroll_date', now()->month)->count(),
        ];

        return view('hr4.index', compact('stats'));
    }

    public function policies()
    {
        return view('hr4.policies');
    }

    public function reports()
    {
        return view('hr4.reports');
    }
}