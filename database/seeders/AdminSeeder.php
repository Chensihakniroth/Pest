<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeders\Seed;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if admin already exists to avoid duplicates
        $admin = User::where('email', 'admin@example.com')->first();

        if (!$admin) {
            User::create([
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => Hash::make('admin123'), // Default password: admin123
                'role' => 'admin',
                'is_active' => true,
            ]);

            $this->command->info('Admin account created successfully!');
            $this->command->info('Email: admin@example.com');
            $this->command->info('Password: admin123');
        } else {
            $this->command->info('Admin account already exists.');
        }
    }
}
