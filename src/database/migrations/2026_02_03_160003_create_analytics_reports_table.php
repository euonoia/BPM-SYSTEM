<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('analytics_reports', function (Blueprint $table) {
            $table->id();
            $table->string('report_name');
            $table->enum('report_type', ['kpi', 'cost', 'manpower', 'custom']);
            
            // Period
            $table->date('date_from');
            $table->date('date_to');
            
            // Data summary
            $table->integer('total_employees');
            $table->decimal('total_payroll_cost', 12, 2);
            $table->decimal('total_overtime_cost', 12, 2);
            $table->decimal('avg_cost_per_employee', 12, 2);
            $table->decimal('turnover_rate', 5, 2);
            $table->decimal('avg_attendance_rate', 5, 2);
            
            // KPIs
            $table->json('kpi_data')->nullable();
            
            // Status
            $table->enum('status', ['draft', 'generated', 'validated', 'archived'])->default('draft');
            $table->text('notes')->nullable();
            $table->foreignId('generated_by')->nullable()->constrained('employees');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('analytics_reports');
    }
};