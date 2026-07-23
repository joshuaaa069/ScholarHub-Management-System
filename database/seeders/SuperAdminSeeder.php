<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@scholarhub.com'], // Prevents duplicates if run multiple times
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password123'), // Change this to a secure password!
                'role' => 'superadmin',
            ]
        );
    }
}