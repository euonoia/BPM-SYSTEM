<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnalyticsReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_name',
        'report_type',
        'date_from',
        'date_to',
        'total_employees',
        'total_payroll_cost',
        'total_overtime_cost',
        'avg_cost_per_employee',
        'turnover_rate',
        'avg_attendance_rate',
        'kpi_data',
        'status',
        'notes'
    ];

    protected $casts = [
        'date_from' => 'date',
        'date_to' => 'date',
        'total_employees' => 'integer',
        'total_payroll_cost' => 'decimal:2',
        'total_overtime_cost' => 'decimal:2',
        'avg_cost_per_employee' => 'decimal:2',
        'turnover_rate' => 'decimal:2',
        'avg_attendance_rate' => 'decimal:2',
        'kpi_data' => 'array'
    ];

    public static function generateFromRange($dateFrom, $dateTo, $reportName = null)
    {
        $payrollData = PayrollRecord::whereBetween('payroll_date', [$dateFrom, $dateTo])->get();
        $employeeCount = Employee::active()->count();
        
        $totalPayroll = $payrollData->sum('net_pay');
        $totalOvertime = $payrollData->sum('overtime_pay');
        
        $report = new self([
            'report_name' => $reportName ?? 'HR Analytics Report ' . now()->format('Y-m-d'),
            'report_type' => 'kpi',
            'date_from' => $dateFrom,
            'date_to' => $dateTo,
            'total_employees' => $employeeCount,
            'total_payroll_cost' => $totalPayroll,
            'total_overtime_cost' => $totalOvertime,
            'avg_cost_per_employee' => $employeeCount > 0 ? $totalPayroll / $employeeCount : 0,
            'turnover_rate' => 0,
            'avg_attendance_rate' => 95.00,
            'kpi_data' => [
                'total_payrolls' => $payrollData->count(),
                'avg_overtime_hours' => $payrollData->avg('overtime_hours'),
                'total_deductions' => $payrollData->sum('late_deduction') + $payrollData->sum('absent_deduction')
            ],
            'status' => 'generated'
        ]);
        
        return $report;
    }

    public function scopeOfType($query, $type)
    {
        return $query->where('report_type', $type);
    }
}