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
            // Defensive: some environments' users table predates the "role" column
            // being added to the base migration, which breaks all role-based
            // logic (login redirects, Scholarship Admin checks, etc.).
            if (! Schema::hasColumn('users', 'role')) {
                $table->string('role')->default('student')->after('email');
            }

            // The scholarship a "Scholarship Admin" account is assigned to manage
            if (! Schema::hasColumn('users', 'scholarship_name')) {
                $table->string('scholarship_name')->nullable()->after('role');
            }

            // Account status shown in the User Management table (Active / Inactive)
            if (! Schema::hasColumn('users', 'status')) {
                $table->string('status')->default('Active')->after('scholarship_name');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['scholarship_name', 'status']);
        });
    }
};
