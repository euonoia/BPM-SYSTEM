<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payroll_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
            $table->string('payroll_period');
            $table->date('payroll_date');
            
            // Timekeeping
            $table->integer('days_worked')->default(0);
            $table->decimal('overtime_hours', 8, 2)->default(0);
            $table->decimal('night_diff_hours', 8, 2)->default(0);
            $table->integer('leaves_taken')->default(0);
            $table->integer('late_minutes')->default(0);
            $table->integer('absent_days')->default(0);
            
            // Computations
            $table->decimal('basic_pay', 12, 2);
            $table->decimal('overtime_pay', 12, 2)->default(0);
            $table->decimal('night_diff_pay', 12, 2)->default(0);
            $table->decimal('late_deduction', 12, 2)->default(0);
            $table->decimal('absent_deduction', 12, 2)->default(0);
            
            // Deductions
            $table->decimal('sss_contribution', 12, 2)->default(0);
            $table->decimal('philhealth_contribution', 12, 2)->default(0);
            $table->decimal('pagibig_contribution', 12, 2)->default(0);
            $table->decimal('tax_withheld', 12, 2)->default(0);
            
            // Net pay
            $table->decimal('gross_pay', 12, 2);
            $table->decimal('total_deductions', 12, 2);
            $table->decimal('net_pay', 12, 2);
            
            // Status
            $table->enum('status', ['pending', 'computed', 'approved', 'released'])->default('pending');
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payroll_records');
    }
};