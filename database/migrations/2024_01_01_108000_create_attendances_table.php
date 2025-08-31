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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('class_id')->constrained()->cascadeOnDelete();
            $table->foreignId('subject_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('teacher_id')->constrained('users')->cascadeOnDelete();
            $table->date('date');
            $table->time('time')->nullable()->comment('Time when attendance was recorded');
            $table->enum('status', ['present', 'absent', 'late', 'excused', 'sick'])->default('absent');
            $table->text('notes')->nullable();
            $table->enum('session', ['morning', 'afternoon', 'full_day'])->default('full_day');
            $table->timestamps();
            
            // Prevent duplicate attendance records
            $table->unique(['student_id', 'class_id', 'subject_id', 'date', 'session']);
            
            // Indexes for reporting
            $table->index(['date', 'status']);
            $table->index(['class_id', 'date']);
            $table->index(['student_id', 'date']);
            $table->index(['teacher_id', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};