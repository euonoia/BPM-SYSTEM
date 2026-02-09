<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users_hr1', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone')->nullable();
            $table->string('profile_picture')->nullable();
            $table->enum('role', ['admin', 'staff', 'candidate'])->default('candidate');
            $table->string('position')->nullable();
            $table->enum('status', ['Applied', 'Evaluation', 'Interviewing', 'Offer', 'Onboarding', 'Rejected'])->default('Applied');
            $table->date('applied_date')->nullable();
            $table->integer('score')->default(0);
            $table->text('skills')->nullable();
            $table->text('notes')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users_hr1');
    }
};

