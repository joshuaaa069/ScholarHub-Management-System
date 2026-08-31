<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            // The registrar that reviewed/endorsed/rejected the application
            $table->foreignId('registrar_id')->nullable()->after('officer_id')
                ->constrained('users')->onDelete('set null');

            // Two-stage remarks so each reviewer can leave their own feedback
            $table->text('registrar_remarks')->nullable()->after('remarks');
            $table->text('admin_remarks')->nullable()->after('registrar_remarks');
        });
    }

    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->dropForeign(['registrar_id']);
            $table->dropColumn(['registrar_id', 'registrar_remarks', 'admin_remarks']);
        });
    }
};
