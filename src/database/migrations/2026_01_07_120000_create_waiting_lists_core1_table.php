<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('waiting_lists_core1', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients_core1')->onDelete('cascade');
            $table->foreignId('doctor_id')->constrained('users_core1')->onDelete('cascade');
            $table->date('preferred_date')->nullable();
            $table->time('preferred_time')->nullable();
            $table->enum('status', ['pending', 'notified', 'converted', 'cancelled'])->default('pending');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('waiting_lists_core1');
    }
};
