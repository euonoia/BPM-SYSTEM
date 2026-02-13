<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employee;
use App\Models\Admin;
use App\Models\PayrollRecord;
use App\Models\CompensationAdjustment;
use App\Models\AnalyticsReport;
use Illuminate\Support\Facades\Hash;

class HR4Seeder extends Seeder
{
    public function run()
    {
        $departments = ['HR', 'Finance', 'Operations', 'IT', 'Nursing', 'Medical'];
        $positions = ['Manager', 'Supervisor', 'Staff', 'Nurse', 'Doctor', 'Technician'];

        // Ensure admin exists for login (admin@example.com or admin@hr4.com)
        Admin::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'HR4 Admin',
                'password' => Hash::make('password'),
                'role' => 'super_admin',
            ]
        );

        for ($i = 1; $i <= 10; $i++) {
            $isFirst = ($i === 1);
            $employee = Employee::create([
                'employee_id' => 'EMP' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'first_name' => fake()->firstName(),
                'last_name' => fake()->lastName(),
                'birth_date' => fake()->dateTimeBetween('-50 years', '-20 years'),
                'gender' => fake()->randomElement(['male', 'female']),
                'contact_number' => fake()->phoneNumber(),
                'email' => $isFirst ? 'employee@hr4.com' : fake()->unique()->safeEmail(),
                'password' => $isFirst ? Hash::make('password') : null,
                'address' => fake()->address(),
                'department' => fake()->randomElement($departments),
                'position' => fake()->randomElement($positions),
                'job_grade' => fake()->numberBetween(1, 10),
                'employment_type' => 'regular',
                'date_hired' => fake()->dateTimeBetween('-5 years', '-1 month'),
                'basic_salary' => fake()->randomFloat(2, 30000, 100000)
            ]);

            for ($j = 0; $j < 3; $j++) {
                $daysWorked = fake()->numberBetween(20, 22);
                $dailyRate = $employee->basic_salary / 22;
                $hourlyRate = $dailyRate / 8;

                $overtimeHours = fake()->randomFloat(2, 0, 10);
                $nightDiffHours = fake()->randomFloat(2, 0, 8);
                $lateMinutes = fake()->numberBetween(0, 60);
                $absentDays = fake()->numberBetween(0, 2);

                $basicPay = $daysWorked * $dailyRate;
                $overtimePay = $overtimeHours * ($hourlyRate * 1.25);
                $nightDiffPay = $nightDiffHours * ($hourlyRate * 0.10);
                $lateDeduction = ($lateMinutes / 60) * $hourlyRate;
                $absentDeduction = $absentDays * $dailyRate;
                $grossPay = $basicPay + $overtimePay + $nightDiffPay;
                $totalDeductions = $lateDeduction + $absentDeduction;
                $netPay = round($grossPay - $totalDeductions, 2);

                PayrollRecord::create([
                    'employee_id' => $employee->id,
                    'payroll_period' => now()->subMonths($j)->format('Y-m'),
                    'payroll_date' => now()->subMonths($j)->endOfMonth(),
                    'days_worked' => $daysWorked,
                    'overtime_hours' => $overtimeHours,
                    'night_diff_hours' => $nightDiffHours,
                    'leaves_taken' => fake()->numberBetween(0, 5),
                    'late_minutes' => $lateMinutes,
                    'absent_days' => $absentDays,
                    'basic_pay' => round($basicPay, 2),
                    'overtime_pay' => round($overtimePay, 2),
                    'night_diff_pay' => round($nightDiffPay, 2),
                    'late_deduction' => round($lateDeduction, 2),
                    'absent_deduction' => round($absentDeduction, 2),
                    'gross_pay' => round($grossPay, 2),
                    'total_deductions' => round($totalDeductions, 2),
                    'net_pay' => $netPay
                ]);
            }
        }

        $employees = Employee::take(3)->get();
        foreach ($employees as $employee) {
            CompensationAdjustment::create([
                'employee_id' => $employee->id,
                'current_grade' => $employee->job_grade,
                'current_salary' => $employee->basic_salary,
                'proposed_grade' => $employee->job_grade + 1,
                'proposed_salary' => $employee->basic_salary * 1.15,
                'performance_rating' => fake()->numberBetween(4, 5),
                'kpi_achievement' => fake()->randomFloat(2, 90, 120),
                'attendance_score' => fake()->randomFloat(2, 85, 100),
                'promotion_raise' => $employee->basic_salary * 0.15,
                'performance_bonus' => $employee->basic_salary * 0.10,
                'kpi_incentive' => $employee->basic_salary * 0.02,
                'longevity_bonus' => $employee->years_in_position >= 5 ? $employee->basic_salary * 0.05 : 0,
                'total_increase' => $employee->basic_salary * 0.27,
                'increase_percentage' => 27,
                'status' => fake()->randomElement(['pending', 'approved', 'rejected'])
            ]);
        }

        AnalyticsReport::create([
            'report_name' => 'Monthly HR Summary - ' . now()->format('F Y'),
            'report_type' => 'kpi',
            'date_from' => now()->startOfMonth(),
            'date_to' => now()->endOfMonth(),
            'total_employees' => Employee::count(),
            'total_payroll_cost' => PayrollRecord::sum('net_pay'),
            'total_overtime_cost' => PayrollRecord::sum('overtime_pay'),
            'avg_cost_per_employee' => PayrollRecord::avg('net_pay'),
            'turnover_rate' => 5.5,
            'avg_attendance_rate' => 95.5,
            'kpi_data' => [
                'total_payrolls' => PayrollRecord::count(),
                'avg_overtime_hours' => PayrollRecord::avg('overtime_hours'),
                'total_deductions' => PayrollRecord::sum('late_deduction') + PayrollRecord::sum('absent_deduction')
            ],
            'status' => 'generated',
            'notes' => 'Auto-generated report'
        ]);

        $this->command->info('HR4 module seeded successfully!');
        $this->command->info('');
        $this->command->info('Login credentials:');
        $this->command->info('  Admin:  admin@example.com / password');
        $this->command->info('  User:   employee@hr4.com / password');
    }
}