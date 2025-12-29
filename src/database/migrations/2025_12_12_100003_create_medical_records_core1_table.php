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
        Schema::create('medical_records_core1', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients_core1')->onDelete('cascade');
            $table->foreignId('doctor_id')->nullable()->constrained('users_core1')->onDelete('set null');
            $table->enum('record_type', ['diagnosis', 'treatment', 'prescription', 'lab_result', 'xray', 'surgery', 'other'])->default('diagnosis');
            $table->text('diagnosis')->nullable();
            $table->text('treatment')->nullable();
            $table->text('prescription')->nullable();
            $table->text('notes')->nullable();
            $table->dateTime('record_date');
            $table->json('attachments')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_records_core1');
    }
};

