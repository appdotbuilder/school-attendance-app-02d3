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
        Schema::create('student_parents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('parent_id')->constrained('users')->cascadeOnDelete();
            $table->enum('relation', ['father', 'mother', 'guardian', 'grandparent', 'other'])->default('father');
            $table->boolean('is_primary')->default(false)->comment('Primary contact');
            $table->timestamps();
            
            // Prevent duplicate relationships
            $table->unique(['student_id', 'parent_id']);
            
            // Indexes
            $table->index(['student_id', 'is_primary']);
            $table->index('relation');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_parents');
    }
};