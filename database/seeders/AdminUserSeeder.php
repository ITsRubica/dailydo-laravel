<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if admin user already exists
        $adminExists = User::where('email', 'admin@dailydo.com')->exists();
        
        if (!$adminExists) {
            User::create([
                'username' => 'admin',
                'email' => 'admin@dailydo.com',
                'password' => Hash::make('admin123'),
                'first_name' => 'Admin',
                'last_name' => 'User',
                'role' => 'admin',
                'bio' => 'System Administrator',
                'interests' => 'System Management',
            ]);
            
            $this->command->info('Admin user created successfully!');
            $this->command->info('Email: admin@dailydo.com');
            $this->command->info('Password: admin123');
        } else {
            $this->command->info('Admin user already exists.');
        }
    }
}
