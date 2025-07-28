<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create super admin user if it doesn't exist
        $superAdmin = User::firstOrCreate(
            ['email' => 'admin@pipandprofit.com'],
            [
                'name' => 'Admin User',
                'password' => bcrypt('password'),
                'role' => 'admin',
            ]
        );

        // Ensure the user has the admin role
        if (!$superAdmin->hasRole('admin')) {
            $superAdmin->assignRole('admin');
        }

        // Create a test user if it doesn't exist
        $testUser = User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => bcrypt('password'),
                'role' => 'user',
            ]
        );

        // Ensure the user has the user role
        if (!$testUser->hasRole('user')) {
            $testUser->assignRole('user');
        }

        $this->command->info('Super admin and test user created/updated successfully!');
    }
} 