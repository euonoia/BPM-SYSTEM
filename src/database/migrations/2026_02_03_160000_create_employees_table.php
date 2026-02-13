<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('employee_id')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->date('birth_date')->nullable();
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->string('contact_number')->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            
            // Employment details
            $table->string('department');
            $table->string('position');
            $table->integer('job_grade')->default(1);
            $table->enum('employment_type', ['regular', 'probationary', 'contractual', 'part-time'])->default('regular');
            $table->date('date_hired');
            $table->decimal('basic_salary', 12, 2);
            
            // Emergency contact
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_number')->nullable();
            
            // Status
            $table->enum('status', ['active', 'inactive', 'terminated', 'on_leave'])->default('active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};