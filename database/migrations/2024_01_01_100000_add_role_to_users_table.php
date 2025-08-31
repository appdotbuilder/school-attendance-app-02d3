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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'operator', 'principal', 'teacher', 'student', 'parent'])->default('student')->after('email');
            $table->string('phone')->nullable()->after('role');
            $table->string('address')->nullable()->after('phone');
            $table->date('birth_date')->nullable()->after('address');
            $table->enum('gender', ['male', 'female'])->nullable()->after('birth_date');
            $table->string('nip')->nullable()->comment('Employee ID for teachers/staff')->after('gender');
            $table->string('nisn')->nullable()->comment('Student ID')->after('nip');
            $table->boolean('is_active')->default(true)->after('nisn');
            
            // Indexes for performance
            $table->index('role');
            $table->index('nip');
            $table->index('nisn');
            $table->index(['role', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['role']);
            $table->dropIndex(['nip']);
            $table->dropIndex(['nisn']);
            $table->dropIndex(['role', 'is_active']);
            
            $table->dropColumn([
                'role', 'phone', 'address', 'birth_date', 
                'gender', 'nip', 'nisn', 'is_active'
            ]);
        });
    }
};