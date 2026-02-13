<?php

namespace App\Http\Controllers\hr4;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\PayrollRecord;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    public function index()
    {
        $payrolls = PayrollRecord::with('employee')
                                ->orderBy('payroll_date', 'desc')
                                ->paginate(10);
        return view('hr4.payroll.index', compact('payrolls'));
    }

    public function input()
    {
        return view('hr4.payroll.input');
    }

    public function validateData(Request $request)
    {
        $data = $request->validate([
            'employee_id' => 'required|string',
            'employee_name' => 'required|string',
            'department' => 'required|string',
            'position' => 'required|string',
            'days_worked' => 'required|integer|min:0|max:31',
            'overtime_hours' => 'nullable|numeric|min:0',
            'night_diff_hours' => 'nullable|numeric|min:0',
            'leaves_taken' => 'nullable|integer|min:0',
            'late_minutes' => 'nullable|integer|min:0',
            'absent_days' => 'nullable|integer|min:0',
        ]);

        $is_complete = !empty($data['employee_id'])
                    && !empty($data['employee_name'])
                    && !empty($data['department'])
                    && $data['days_worked'] > 0;

        session(['payroll_data' => $data, 'is_complete' => $is_complete]);

        return view('hr4.payroll.validation', [
            'data' => $data,
            'is_complete' => $is_complete
        ]);
    }

    public function compute()
    {
        $data = session('payroll_data');

        if (!$data) {
            return redirect()->route('hr.hr4.payroll.input')
                           ->with('error', 'No data found. Please start again.');
        }

        $employee = Employee::where('employee_id', $data['employee_id'])->first();
        $basicSalary = $employee ? $employee->basic_salary : 50000;

        $daily_rate = $basicSalary / 22;
        $hourly_rate = $daily_rate / 8;
        $overtime_rate = $hourly_rate * 1.25;
        $night_diff_rate = $hourly_rate * 0.10;

        $computation = [
            'basic_pay' => round($data['days_worked'] * $daily_rate, 2),
            'overtime_pay' => round(($data['overtime_hours'] ?? 0) * $overtime_rate, 2),
            'night_diff_pay' => round(($data['night_diff_hours'] ?? 0) * $night_diff_rate, 2),
            'late_deduction' => round((($data['late_minutes'] ?? 0) / 60) * $hourly_rate, 2),
            'absent_deduction' => round(($data['absent_days'] ?? 0) * $daily_rate, 2),
        ];

        $computation['net_pay'] = round(
            $computation['basic_pay']
            + $computation['overtime_pay']
            + $computation['night_diff_pay']
            - $computation['late_deduction']
            - $computation['absent_deduction'],
            2
        );

        session(['payroll_computation' => $computation]);

        return view('hr4.payroll.computation', [
            'data' => $data,
            'computation' => $computation
        ]);
    }

    public function store(Request $request)
    {
        $data = session('payroll_data');
        $computation = session('payroll_computation');

        if (!$data || !$computation) {
            return redirect()->route('hr.hr4.payroll.input')
                           ->with('error', 'Session expired. Please start again.');
        }

        $employee = Employee::where('employee_id', $data['employee_id'])->firstOrFail();

        $grossPay = $computation['basic_pay'] + $computation['overtime_pay'] + $computation['night_diff_pay'];
        $totalDeductions = $computation['late_deduction'] + $computation['absent_deduction'];

        $payroll = PayrollRecord::create([
            'employee_id' => $employee->id,
            'payroll_period' => now()->format('Y-m'),
            'payroll_date' => now(),
            'days_worked' => $data['days_worked'],
            'overtime_hours' => $data['overtime_hours'] ?? 0,
            'night_diff_hours' => $data['night_diff_hours'] ?? 0,
            'leaves_taken' => $data['leaves_taken'] ?? 0,
            'late_minutes' => $data['late_minutes'] ?? 0,
            'absent_days' => $data['absent_days'] ?? 0,
            'basic_pay' => $computation['basic_pay'],
            'overtime_pay' => $computation['overtime_pay'],
            'night_diff_pay' => $computation['night_diff_pay'],
            'late_deduction' => $computation['late_deduction'],
            'absent_deduction' => $computation['absent_deduction'],
            'gross_pay' => $grossPay,
            'total_deductions' => $totalDeductions,
            'net_pay' => $computation['net_pay']
        ]);

        session()->forget(['payroll_data', 'payroll_computation', 'is_complete']);

        return redirect()->route('hr.hr4.payroll.payslip', ['id' => $payroll->id])
                        ->with('success', 'Payroll processed successfully!');
    }

    public function timeKeeping()
    {
        return view('hr4.payroll.time-keeping');
    }

    public function computation()
    {
        if (!session('payroll_data')) {
            return redirect()->route('hr.hr4.payroll.input');
        }
        return $this->compute();
    }

    public function payslip($id = null)
    {
        $id = $id ?? request('id');
        if ($id) {
            $payroll = PayrollRecord::with('employee')->findOrFail($id);
            return view('hr4.payroll.payslip', compact('payroll'));
        }

        $employee = Employee::where('employee_id', session('payroll_data.employee_id'))->first();
        $payroll = $employee
            ? PayrollRecord::with('employee')
                ->where('employee_id', $employee->id)
                ->latest()
                ->first()
            : null;

        if (!$payroll) {
            return redirect()->route('hr.hr4.payroll.input')
                           ->with('error', 'No payroll record found.');
        }

        return view('hr4.payroll.payslip', compact('payroll'));
    }
}