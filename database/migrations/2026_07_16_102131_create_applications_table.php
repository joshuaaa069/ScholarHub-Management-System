<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->string('application_code'); // e.g., 'APP-2026-001'
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // The applicant student
            $table->foreignId('scholarship_id')->constrained()->onDelete('cascade'); // The chosen scholarship
            
            // The officer assigned to review (nullable initially)
            $table->foreignId('officer_id')->nullable()->constrained('users')->onDelete('set null'); 
            
            // Status states: 'Under Review', 'Approved', 'Needs Revision', 'Pending'
            $table->string('status')->default('Pending'); 
            $table->text('remarks')->nullable(); // Officer feedback remarks
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};