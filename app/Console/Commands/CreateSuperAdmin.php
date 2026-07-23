<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateSuperAdmin extends Command
{
    // The terminal command signature
    protected $signature = 'make:superadmin';

    // Description of the command
    protected $description = 'Create a new Super Admin account interactively';

    public function handle()
    {
        $name = $this->ask('Enter the Admin Name');
        $email = $this->ask('Enter the Admin Email Address');
        $password = $this->secret('Enter a Secure Password');

        // Basic validation
        if (User::where('email', $email)->exists()) {
            $this->error('A user with this email already exists!');
            return Command::FAILURE;
        }

        // Create user
        User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'role' => 'superadmin',
        ]);

        $this->info("Super Admin account successfully created for {$name} ({$email})!");
        return Command::SUCCESS;
    }
}