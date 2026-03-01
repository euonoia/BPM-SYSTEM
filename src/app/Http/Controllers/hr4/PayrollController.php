<?php

namespace App\Http\Controllers\hr4;

use App\Http\Controllers\Controller;
use App\Http\Requests\PayrollInputRequest;
use App\Models\Employee;
use App\Models\PayrollRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PayrollController extends Controller
{
    /**
     * Display paginated list of payroll records
     */
    public function index()
    {
        try {
            $payrolls = PayrollRecord::with('employee')
                                    ->orderBy('payroll_date', 'desc')
                                    ->paginate(10);
            
            $statistics = [
                'total_payrolls' => PayrollRecord::count(),
                'total_amount' => PayrollRecord::sum('net_pay'),
                'this_month' => PayrollRecord::whereMonth('payroll_date', now()->month)
                                             ->whereYear('payroll_date', now()->year)
                                             ->count(),
            ];

            return view('hr4.payroll.index', compact('payrolls', 'statistics'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to load payroll records: ' . $e->getMessage());
        }
    }

    /**
     * Show payroll input form
     */
    public function input()
    {
        $employees = Employee::where('status', 'active')
                             ->select('id', 'employee_id', 'first_name', 'last_name', 'department', 'position', 'basic_salary')
                             ->orderBy('employee_id')
                             ->get();
        
        return view('hr4.payroll.input', compact('employees'));
    }

    /**
     * Validate payroll input data
     */
    public function validateData(PayrollInputRequest $request)
    {
        try {
            $data = $request->validated();

            // Verify employee exists in database
            $employee = Employee::where('employee_id', $data['employee_id'])->first();
            if (!$employee) {
                return redirect()->back()
                               ->with('error', 'Employee not found in system.')
                               ->withInput();
            }

            // Check completeness
            $is_complete = !empty($data['employee_id'])
                        && !empty($data['employee_name'])
                        && !empty($data['department'])
                        && $data['days_worked'] > 0;

            // Store in session
            session(['payroll_data' => $data, 'is_complete' => $is_complete, 'employee_db_id' => $employee->id]);

            return view('hr4.payroll.validation', [
                'data' => $data,
                'is_complete' => $is_complete,
                'employee' => $employee
            ]);
        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Validation failed: ' . $e->getMessage())
                           ->withInput();
        }
    }

    /**
     * Compute payroll based on session data
     */
    public function compute()
    {
        try {
            $data = session('payroll_data');
            $employee_db_id = session('employee_db_id');

            if (!$data || !$employee_db_id) {
                return redirect()->route('hr.hr4.payroll.input')
                               ->with('error', 'Session expired or no data found. Please start again.');
            }

            $employee = Employee::findOrFail($employee_db_id);
            
            // Calculate payroll amounts
            $computation = $this->calculatePayroll($employee, $data);

            session(['payroll_computation' => $computation]);

            return view('hr4.payroll.computation', [
                'data' => $data,
                'computation' => $computation,
                'employee' => $employee
            ]);
        } catch (\Exception $e) {
            return redirect()->route('hr.hr4.payroll.input')
                           ->with('error', 'Computation failed: ' . $e->getMessage());
        }
    }

    /**
     * Helper method to calculate payroll
     */
    private function calculatePayroll($employee, $data)
    {
        $basicSalary = $employee->basic_salary ?? 50000;
        $daily_rate = $basicSalary / 22;
        $hourly_rate = $daily_rate / 8;

        $basic_pay = round($data['days_worked'] * $daily_rate, 2);
        $overtime_pay = round(($data['overtime_hours'] ?? 0) * $hourly_rate * 1.25, 2);
        $night_diff_pay = round(($data['night_diff_hours'] ?? 0) * $hourly_rate * 0.10, 2);
        $late_deduction = round((($data['late_minutes'] ?? 0) / 60) * $hourly_rate, 2);
        $absent_deduction = round(($data['absent_days'] ?? 0) * $daily_rate, 2);

        $gross_pay = $basic_pay + $overtime_pay + $night_diff_pay;
        $total_deductions = $late_deduction + $absent_deduction;
        $net_pay = round($gross_pay - $total_deductions, 2);

        return [
            'basic_pay' => $basic_pay,
            'overtime_pay' => $overtime_pay,
            'night_diff_pay' => $night_diff_pay,
            'late_deduction' => $late_deduction,
            'absent_deduction' => $absent_deduction,
            'gross_pay' => $gross_pay,
            'total_deductions' => $total_deductions,
            'net_pay' => $net_pay
        ];
    }

    /**
     * Store payroll record to database
     */
    public function store(Request $request)
    {
        try {
            $data = session('payroll_data');
            $computation = session('payroll_computation');
            $employee_db_id = session('employee_db_id');

            if (!$data || !$computation || !$employee_db_id) {
                return redirect()->route('hr.hr4.payroll.input')
                               ->with('error', 'Session expired. Please start again.');
            }

            $employee = Employee::findOrFail($employee_db_id);

            // Use transaction to ensure data integrity
            DB::beginTransaction();
            try {
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
                    'gross_pay' => $computation['gross_pay'],
                    'total_deductions' => $computation['total_deductions'],
                    'net_pay' => $computation['net_pay'],
                    'status' => 'approved',
                    'remarks' => 'Payroll processed on ' . now()->format('Y-m-d H:i:s')
                ]);

                DB::commit();

                // Clear session
                session()->forget(['payroll_data', 'payroll_computation', 'is_complete', 'employee_db_id']);

                return redirect()->route('hr.hr4.payroll.payslip', ['id' => $payroll->id])
                                ->with('success', 'Payroll successfully stored and processed!');

            } catch (\Exception $e) {
                DB::rollback();
                throw $e;
            }

        } catch (\Exception $e) {
            return redirect()->route('hr.hr4.payroll.input')
                           ->with('error', 'Failed to store payroll: ' . $e->getMessage());
        }
    }

    /**
     * Show time-keeping module
     */
    public function timeKeeping()
    {
        $employees = Employee::where('status', 'active')
                             ->select('id', 'employee_id', 'first_name', 'last_name')
                             ->get();
        
        return view('hr4.payroll.time-keeping', compact('employees'));
    }

    /**
     * Redirect to compute or show computation page
     */
    public function computation()
    {
        if (!session('payroll_data')) {
            return redirect()->route('hr.hr4.payroll.input')
                           ->with('error', 'No payroll data in session. Start from input page.');
        }
        return $this->compute();
    }

    /**
     * Display payslip
     */
    public function payslip($id = null)
    {
        try {
            $id = $id ?? request('id');
            
            if ($id) {
                $payroll = PayrollRecord::with('employee')->findOrFail($id);
                return view('hr4.payroll.payslip', compact('payroll'));
            }

            // If no ID provided, try to get latest payroll from session
            $employee_db_id = session('employee_db_id');
            if ($employee_db_id) {
                $payroll = PayrollRecord::with('employee')
                                      ->where('employee_id', $employee_db_id)
                                      ->latest()
                                      ->firstOrFail();
                return view('hr4.payroll.payslip', compact('payroll'));
            }

            return redirect()->route('hr.hr4.payroll.input')
                           ->with('error', 'No payroll record found.');

        } catch (\Exception $e) {
            return redirect()->route('hr.hr4.payroll.index')
                           ->with('error', 'Payroll record not found: ' . $e->getMessage());
        }
    }

    /**
     * API endpoint to fetch employee details
     */
    public function checkEmployee(Request $request)
    {
        $employee_id = $request->input('employee_id');
        
        $employee = Employee::where('employee_id', $employee_id)
                           ->where('status', 'active')
                           ->first();

        if (!$employee) {
            return response()->json(['success' => false, 'message' => 'Employee not found'], 404);
        }

        return response()->json([
            'success' => true,
            'employee' => [
                'id' => $employee->id,
                'employee_id' => $employee->employee_id,
                'name' => $employee->first_name . ' ' . $employee->last_name,
                'department' => $employee->department,
                'position' => $employee->position,
                'basic_salary' => $employee->basic_salary
            ]
        ]);
    }
}
