<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * Intentionally minimal: this system runs on real data end to end.
     * - Scholarship Admin accounts are created by the Super Admin
     *   (User Management page).
     * - Scholarship programs are created by Scholarship Admins
     *   (Scholarship Programs page).
     * - Students, applications, and notifications are created by real
     *   usage (registration, applying, approvals).
     *
     * The only thing seeded here is the initial Super Admin account,
     * since there is no other way to get into the system for the first time.
     * (You can also use `php artisan make:superadmin` interactively instead
     * of running this seeder, if you'd rather choose your own credentials.)
     */
    public function run(): void
    {
        if (! User::where('role', 'superadmin')->exists()) {
            User::create([
                'name' => 'Super Admin',
                'first_name' => 'Super',
                'last_name' => 'Admin',
                'email' => 'admin@scholarhub.com',
                'password' => Hash::make('password'),
                'role' => 'superadmin',
                'status' => 'Active',
            ]);

            $this->command->info('Super Admin created: admin@scholarhub.com / password');
            $this->command->warn('Change this password immediately after your first login.');
        } else {
            $this->command->info('A Super Admin account already exists — skipped.');
        }
    }
}
