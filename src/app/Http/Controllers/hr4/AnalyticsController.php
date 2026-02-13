<?php

namespace App\Http\Controllers\hr4;

use App\Http\Controllers\Controller;
use App\Models\AnalyticsReport;
use App\Models\Employee;
use App\Models\PayrollRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function index()
    {
        $recentReports = AnalyticsReport::orderBy('created_at', 'desc')
                                       ->take(5)
                                       ->get();
        return view('hr4.analytics.index', compact('recentReports'));
    }

    public function collect()
    {
        return view('hr4.analytics.collect');
    }

    public function analyze(Request $request)
    {
        $data = $request->validate([
            'payroll_data' => 'nullable|array',
            'hr_data' => 'nullable|array',
            'date_from' => 'required|date',
            'date_to' => 'required|date|after_or_equal:date_from'
        ]);

        $payrollData = PayrollRecord::whereBetween('payroll_date', [$data['date_from'], $data['date_to']])->get();
        $employeeCount = Employee::active()->count();

        $totalPayroll = $payrollData->sum('net_pay');
        $totalOvertime = $payrollData->sum('overtime_pay');
        $totalDeductions = $payrollData->sum('late_deduction') + $payrollData->sum('absent_deduction');

        $analysis = [
            'total_payroll' => round($totalPayroll, 2),
            'overtime_costs' => round($totalOvertime, 2),
            'benefits_costs' => round($totalPayroll * 0.15, 2),
            'total_labor_cost' => 0,
            'headcount' => $employeeCount,
            'turnover_rate' => rand(5, 20),
            'avg_attendance' => rand(85, 98),
            'total_deductions' => round($totalDeductions, 2),
            'avg_overtime_hours' => round($payrollData->avg('overtime_hours'), 2),
            'cost_per_employee' => 0
        ];

        $analysis['total_labor_cost'] = $analysis['total_payroll'] + $analysis['overtime_costs'] + $analysis['benefits_costs'];
        $analysis['cost_per_employee'] = $employeeCount > 0 ? round($analysis['total_labor_cost'] / $employeeCount, 2) : 0;

        $is_accurate = $analysis['avg_attendance'] > 90;

        session([
            'analytics_data' => $data,
            'analysis' => $analysis,
            'is_accurate' => $is_accurate,
            'date_from' => $data['date_from'],
            'date_to' => $data['date_to']
        ]);

        return view('hr4.analytics.analysis', [
            'analysis' => $analysis,
            'is_accurate' => $is_accurate,
            'date_from' => $data['date_from'],
            'date_to' => $data['date_to']
        ]);
    }

    public function generate()
    {
        $data = session('analytics_data');
        $analysis = session('analysis');

        if (!$data || !$analysis) {
            return redirect()->route('hr.hr4.analytics.collect')
                           ->with('error', 'No analysis data found. Please analyze first.');
        }

        $report = AnalyticsReport::create([
            'report_name' => 'HR Analytics Report ' . now()->format('Y-m-d H:i'),
            'report_type' => 'kpi',
            'date_from' => $data['date_from'],
            'date_to' => $data['date_to'],
            'total_employees' => $analysis['headcount'],
            'total_payroll_cost' => $analysis['total_payroll'],
            'total_overtime_cost' => $analysis['overtime_costs'],
            'avg_cost_per_employee' => $analysis['cost_per_employee'],
            'turnover_rate' => $analysis['turnover_rate'],
            'avg_attendance_rate' => $analysis['avg_attendance'],
            'kpi_data' => [
                'total_deductions' => $analysis['total_deductions'],
                'avg_overtime_hours' => $analysis['avg_overtime_hours'],
                'benefits_costs' => $analysis['benefits_costs']
            ],
            'status' => 'generated'
        ]);

        session()->forget(['analytics_data', 'analysis', 'is_accurate', 'date_from', 'date_to']);

        return redirect()->route('hr.hr4.analytics.kpi-dashboard')
                        ->with('success', 'KPI Report generated successfully!');
    }

    public function clean()
    {
        session()->forget(['analytics_data', 'analysis', 'is_accurate', 'date_from', 'date_to']);
        return redirect()->route('hr.hr4.analytics.collect')
                        ->with('info', 'Data cleaned. Please re-analyze.');
    }

    public function kpiDashboard()
    {
        $latestReport = AnalyticsReport::orderBy('created_at', 'desc')->first();
        $monthlyData = AnalyticsReport::where('report_type', 'kpi')
                                     ->where('created_at', '>=', now()->subMonths(6))
                                     ->get();
        return view('hr4.analytics.kpi-dashboard', compact('latestReport', 'monthlyData'));
    }

    public function costAnalytics()
    {
        $driver = DB::connection()->getDriverName();
        $monthExpr = $driver === 'sqlite'
            ? "strftime('%Y-%m', payroll_date)"
            : "DATE_FORMAT(payroll_date, '%Y-%m')";
        $costData = PayrollRecord::selectRaw("{$monthExpr} as month")
                                ->selectRaw('SUM(net_pay) as total_payroll')
                                ->selectRaw('SUM(overtime_pay) as total_overtime')
                                ->groupBy('month')
                                ->orderBy('month', 'desc')
                                ->take(12)
                                ->get();
        return view('hr4.analytics.cost-analytics', compact('costData'));
    }

    public function manpowerReports()
    {
        $departmentData = Employee::select('department')
                                 ->selectRaw('COUNT(*) as count')
                                 ->selectRaw('AVG(basic_salary) as avg_salary')
                                 ->groupBy('department')
                                 ->get();

        $gradeData = Employee::select('job_grade')
                            ->selectRaw('COUNT(*) as count')
                            ->groupBy('job_grade')
                            ->orderBy('job_grade')
                            ->get();

        return view('hr4.analytics.manpower-reports', compact('departmentData', 'gradeData'));
    }
}