<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('appointments_core1', function (Blueprint $table) {
            $table->id();
            $table->string('appointment_id')->unique()->nullable();
            $table->foreignId('patient_id')->constrained('patients_core1')->onDelete('cascade');
            $table->foreignId('doctor_id')->nullable()->constrained('users_core1')->onDelete('set null');
            $table->date('appointment_date');
            $table->dateTime('appointment_time');
            $table->enum('type', ['consultation', 'follow-up', 'emergency', 'surgery', 'checkup'])->default('consultation');
            $table->enum('status', ['scheduled', 'confirmed', 'completed', 'cancelled', 'no-show'])->default('scheduled');
            $table->text('notes')->nullable();
            $table->text('reason')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments_core1');
    }
};

