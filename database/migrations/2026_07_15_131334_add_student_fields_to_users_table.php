<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Personal Info Fields
            $table->string('first_name')->nullable()->after('id');
            $table->string('last_name')->nullable()->after('first_name');
            $table->date('dob')->nullable()->after('last_name');
            $table->string('phone')->nullable()->after('dob');

            // Academic Info Fields
            $table->string('school')->nullable()->after('phone');
            $table->string('student_number')->nullable()->after('school');
            $table->string('course')->nullable()->after('student_number');
            $table->decimal('gpa', 3, 2)->nullable()->after('course');
            $table->string('year_level')->nullable()->after('gpa');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'first_name', 'last_name', 'dob', 'phone', 
                'school', 'student_number', 'course', 'gpa', 'year_level'
            ]);
        });
    }
};