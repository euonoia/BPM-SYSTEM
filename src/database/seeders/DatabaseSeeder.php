<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Schema;
use App\Models\Employee;
use App\Models\PayrollRecord;
use App\Models\CompensationAdjustment;
use App\Models\AnalyticsReport;
use Illuminate\Support\Str;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // (Removed seeding of generic `users` table — HR4-only seeding below)

        // Create an admin account if admins table exists
        if (Schema::hasTable('admins')) {
            \App\Models\Admin::firstOrCreate(
                ['email' => 'admin@example.com'],
                [
                    'name' => 'Super Admin',
                    'password' => \Illuminate\Support\Facades\Hash::make('password'),
                ]
            );
        }

        $faker = \Faker\Factory::create();

        // Create sample employees
        $employees = [];
        for ($i = 1; $i <= 8; $i++) {
            $emp = Employee::create([
                'employee_id' => 'EMP' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'birth_date' => $faker->date('Y-m-d', '-20 years'),
                'gender' => $faker->randomElement(['male','female']),
                'contact_number' => $faker->phoneNumber,
                'email' => $faker->unique()->safeEmail,
                'address' => $faker->address,
                'department' => $faker->randomElement(['HR','Finance','Logistics','Operations']),
                'position' => $faker->jobTitle,
                'job_grade' => $faker->numberBetween(1,10),
                'employment_type' => 'regular',
                'date_hired' => $faker->dateTimeBetween('-2 years', 'now')->format('Y-m-d'),
                'basic_salary' => $faker->randomFloat(2,20000,80000),
                'password' => $i === 1 ? \Illuminate\Support\Facades\Hash::make('password') : null, // First employee has password for testing
                'status' => $faker->randomElement(['active','on_leave','inactive']),
            ]);
            $employees[] = $emp;
        }

        // Create payroll records for first 5 employees
        foreach (array_slice($employees, 0, 5) as $emp) {
            PayrollRecord::create([
                'employee_id' => $emp->id,
                'payroll_period' => '2026-01',
                'payroll_date' => now()->toDateString(),
                'days_worked' => 22,
                'overtime_hours' => 5,
                'night_diff_hours' => 0,
                'leaves_taken' => 0,
                'late_minutes' => 0,
                'absent_days' => 0,
                'basic_pay' => $emp->basic_salary,
                'overtime_pay' => 500,
                'night_diff_pay' => 0,
                'late_deduction' => 0,
                'absent_deduction' => 0,
                'sss_contribution' => 200,
                'philhealth_contribution' => 150,
                'pagibig_contribution' => 100,
                'tax_withheld' => 1000,
                'gross_pay' => $emp->basic_salary + 500,
                'total_deductions' => 1450,
                'net_pay' => ($emp->basic_salary + 500) - 1450,
                'status' => 'computed',
            ]);
        }

        // Create a sample compensation adjustment
        CompensationAdjustment::create([
            'employee_id' => $employees[0]->id,
            'current_grade' => 3,
            'current_salary' => $employees[0]->basic_salary,
            'proposed_grade' => 4,
            'proposed_salary' => $employees[0]->basic_salary * 1.1,
            'performance_rating' => 4,
            'kpi_achievement' => 85.5,
            'attendance_score' => 98.0,
            'promotion_raise' => 0,
            'performance_bonus' => 5000,
            'kpi_incentive' => 2000,
            'longevity_bonus' => 0,
            'total_increase' => 7000,
            'increase_percentage' => 10.00,
            'status' => 'pending',
            'requested_by' => $employees[0]->id,
        ]);

        // A sample analytics report
        AnalyticsReport::create([
            'report_name' => 'Monthly HR Summary Jan 2026',
            'report_type' => 'kpi',
            'date_from' => now()->startOfMonth()->toDateString(),
            'date_to' => now()->endOfMonth()->toDateString(),
            'total_employees' => Employee::count(),
            'total_payroll_cost' => PayrollRecord::sum('net_pay'),
            'total_overtime_cost' => PayrollRecord::sum('overtime_pay'),
            'avg_cost_per_employee' => PayrollRecord::avg('net_pay') ?? 0,
            'turnover_rate' => 2.5,
            'avg_attendance_rate' => 96.5,
            'kpi_data' => json_encode(['hiring' => 2, 'turnover' => 1]),
            'status' => 'generated',
            'generated_by' => $employees[0]->id,
        ]);
    }
}
