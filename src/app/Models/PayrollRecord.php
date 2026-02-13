<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'payroll_period',
        'payroll_date',
        'days_worked',
        'overtime_hours',
        'night_diff_hours',
        'leaves_taken',
        'late_minutes',
        'absent_days',
        'basic_pay',
        'overtime_pay',
        'night_diff_pay',
        'late_deduction',
        'absent_deduction',
        'gross_pay',
        'total_deductions',
        'net_pay'
    ];

    protected $casts = [
        'payroll_date' => 'date',
        'days_worked' => 'integer',
        'overtime_hours' => 'decimal:2',
        'night_diff_hours' => 'decimal:2',
        'late_minutes' => 'integer',
        'absent_days' => 'integer',
        'basic_pay' => 'decimal:2',
        'overtime_pay' => 'decimal:2',
        'night_diff_pay' => 'decimal:2',
        'late_deduction' => 'decimal:2',
        'absent_deduction' => 'decimal:2',
        'net_pay' => 'decimal:2'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function calculateNetPay()
    {
        $this->net_pay = $this->basic_pay 
                       + $this->overtime_pay 
                       + $this->night_diff_pay
                       - $this->late_deduction
                       - $this->absent_deduction;
        return $this->net_pay;
    }

    public function scopeForPeriod($query, $period)
    {
        return $query->where('payroll_period', $period);
    }
}