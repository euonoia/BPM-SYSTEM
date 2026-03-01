<?php

namespace App\Http\Controllers\hr4;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\PayrollRecord;
use App\Models\CompensationAdjustment;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_employees' => Employee::count(),
            'active_employees' => Employee::active()->count(),
            'pending_compensations' => CompensationAdjustment::pending()->count(),
            'total_payroll_this_month' => PayrollRecord::whereMonth('payroll_date', now()->month)->sum('net_pay'),
            'on_leave' => Employee::where('status', 'on_leave')->count(),
            'departments' => Employee::distinct('department')->count('department'),
        ];

        $recent_employees = Employee::latest()->take(10)->get();

        return view('hr4.admin.dashboard', compact('stats', 'recent_employees'));
    }

    public function employees()
    {
        $employees = Employee::with(['payrollRecords', 'compensationAdjustments'])
                            ->paginate(20);
        return view('hr4.admin.employees', compact('employees'));
    }

    public function show($id)
    {
        $employee = Employee::with(['payrollRecords' => function($query) {
            $query->orderBy('payroll_date', 'desc')->take(12);
        }, 'compensationAdjustments'])->findOrFail($id);

        return view('hr4.admin.employee_show', compact('employee'));
    }

    public function payrolls()
    {
        $payrolls = PayrollRecord::with('employee')
                                ->orderBy('payroll_date', 'desc')
                                ->paginate(20);
        return view('hr4.admin.payrolls', compact('payrolls'));
    }

    public function compensations()
    {
        $compensations = CompensationAdjustment::with('employee')
                                              ->orderBy('created_at', 'desc')
                                              ->paginate(20);
        return view('hr4.admin.compensations', compact('compensations'));
    }

    public function approveCompensation($id)
    {
        $compensation = CompensationAdjustment::findOrFail($id);

        $compensation->update([
            'status' => 'approved',
            'approved_by' => auth('admin')->id(),
            'approved_at' => now()
        ]);

        $employee = Employee::find($compensation->employee_id);
        if ($employee) {
            $employee->update([
                'basic_salary' => $compensation->proposed_salary,
                'job_grade' => $compensation->proposed_grade
            ]);
        }

        return redirect()->back()->with('success', 'Compensation approved and applied!');
    }

    public function rejectCompensation($id)
    {
        $compensation = CompensationAdjustment::findOrFail($id);

        $compensation->update([
            'status' => 'rejected',
            'approved_by' => auth('admin')->id(),
            'approved_at' => now()
        ]);

        return redirect()->back()->with('info', 'Compensation rejected.');
    }

    public function settings()
    {
        return view('hr4.admin.settings');
    }
}