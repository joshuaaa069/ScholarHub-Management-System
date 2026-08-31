<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('application_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained()->onDelete('cascade');
            $table->foreignId('document_requirement_id')->constrained('document_requirements')->onDelete('cascade');

            // Student upload
            $table->string('student_file_path')->nullable();
            $table->string('student_original_name')->nullable();
            $table->timestamp('student_uploaded_at')->nullable();

            // Registrar upload (if registrar needs to add additional files like
            // certified true copies, signature pages, etc.)
            $table->string('registrar_file_path')->nullable();
            $table->string('registrar_original_name')->nullable();
            $table->timestamp('registrar_uploaded_at')->nullable();
            $table->foreignId('registrar_uploader_id')->nullable()->constrained('users')->onDelete('set null');

            $table->boolean('is_complete')->default(false); // true when at least student_file_path is set
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('application_documents');
    }
};
