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
        Schema::table('scholarships', function (Blueprint $table) {
            if (! Schema::hasColumn('scholarships', 'description')) {
                $table->text('description')->nullable()->after('title');
            }
            if (! Schema::hasColumn('scholarships', 'eligibility')) {
                $table->text('eligibility')->nullable()->after('benefits');
            }
            if (! Schema::hasColumn('scholarships', 'requirements')) {
                $table->text('requirements')->nullable()->after('eligibility');
            }
            if (! Schema::hasColumn('scholarships', 'status')) {
                // 'Open' or 'Closed'
                $table->string('status')->default('Open')->after('deadline');
            }
            if (! Schema::hasColumn('scholarships', 'created_by')) {
                $table->foreignId('created_by')->nullable()->after('status')
                    ->constrained('users')->nullOnDelete();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('scholarships', function (Blueprint $table) {
            $table->dropConstrainedForeignId('created_by');
            $table->dropColumn(['description', 'eligibility', 'requirements', 'status']);
        });
    }
};
