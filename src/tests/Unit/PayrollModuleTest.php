<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Employee;
use App\Models\PayrollRecord;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PayrollModuleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that payroll records can be created
     */
    public function test_payroll_record_can_be_created()
    {
        $employee = Employee::create([
            'employee_id' => 'TEST001',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'department' => 'IT',
            'position' => 'Developer',
            'date_hired' => now()->subYear(),
            'basic_salary' => 50000,
        ]);

        $payroll = PayrollRecord::create([
            'employee_id' => $employee->id,
            'payroll_period' => now()->format('Y-m'),
            'payroll_date' => now(),
            'days_worked' => 20,
            'overtime_hours' => 5,
            'night_diff_hours' => 2,
            'leaves_taken' => 0,
            'late_minutes' => 30,
            'absent_days' => 1,
            'basic_pay' => 45454.55,
            'overtime_pay' => 1135.68,
            'night_diff_pay' => 227.14,
            'late_deduction' => 113.64,
            'absent_deduction' => 2272.73,
            'gross_pay' => 46817.37,
            'total_deductions' => 2386.37,
            'net_pay' => 44431.00,
            'status' => 'approved'
        ]);

        $this->assertNotNull($payroll);
        $this->assertEquals($employee->id, $payroll->employee_id);
        $this->assertEquals(44431.00, $payroll->net_pay);
    }

    /**
     * Test employee has many payroll records
     */
    public function test_employee_has_many_payroll_records()
    {
        $employee = Employee::create([
            'employee_id' => 'TEST002',
            'first_name' => 'Jane',
            'last_name' => 'Smith',
            'department' => 'HR',
            'position' => 'Manager',
            'date_hired' => now()->subYear(),
            'basic_salary' => 60000,
        ]);

        for ($i = 0; $i < 3; $i++) {
            PayrollRecord::create([
                'employee_id' => $employee->id,
                'payroll_period' => now()->subMonths($i)->format('Y-m'),
                'payroll_date' => now()->subMonths($i),
                'days_worked' => 22,
                'basic_pay' => 60000,
                'overtime_pay' => 0,
                'night_diff_pay' => 0,
                'late_deduction' => 0,
                'absent_deduction' => 0,
                'gross_pay' => 60000,
                'total_deductions' => 0,
                'net_pay' => 60000,
                'status' => 'approved'
            ]);
        }

        $this->assertEquals(3, $employee->payrollRecords()->count());
    }
}
