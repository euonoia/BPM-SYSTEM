<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('compensation_adjustments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
            
            // Current vs Proposed
            $table->integer('current_grade');
            $table->decimal('current_salary', 12, 2);
            $table->integer('proposed_grade')->nullable();
            $table->decimal('proposed_salary', 12, 2);
            
            // Performance data
            $table->integer('performance_rating');
            $table->decimal('kpi_achievement', 5, 2);
            $table->decimal('attendance_score', 5, 2);
            $table->text('special_achievements')->nullable();
            
            // Adjustments breakdown
            $table->decimal('promotion_raise', 12, 2)->default(0);
            $table->decimal('performance_bonus', 12, 2)->default(0);
            $table->decimal('kpi_incentive', 12, 2)->default(0);
            $table->decimal('longevity_bonus', 12, 2)->default(0);
            $table->decimal('total_increase', 12, 2);
            $table->decimal('increase_percentage', 5, 2);
            
            // Workflow status
            $table->enum('status', ['draft', 'pending', 'approved', 'rejected', 'implemented'])->default('draft');
            $table->foreignId('requested_by')->nullable()->constrained('employees');
            $table->foreignId('approved_by')->nullable()->constrained('employees');
            $table->timestamp('approved_at')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('compensation_adjustments');
    }
};