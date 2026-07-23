<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('scholarships', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('provider'); // e.g., 'All Universities', 'Partner Universities', 'NCR Universities'
            $table->string('type'); // 'STEM', 'Merit-Based', 'Need-Based', 'Government', 'Corporate'
            $table->string('benefits'); // e.g., '₱40,000/sem + monthly allowance'
            $table->integer('slots_total');
            $table->integer('slots_left');
            $table->decimal('min_gpa', 5, 2); // e.g., 90.00
            $table->date('deadline');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('scholarships');
    }
};