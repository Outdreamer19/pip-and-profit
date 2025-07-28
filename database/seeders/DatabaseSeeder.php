<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed roles and permissions first
        $this->call([
            RolesAndPermissionsSeeder::class,
        ]);

        // Create admin user
        $adminUser = User::create([
            'name' => 'Admin User',
            'email' => 'admin@pipandprofit.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);
        $adminUser->assignRole('admin');

        // Create regular user
        $regularUser = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);
        $regularUser->assignRole('user');

        // Seed courses and lessons
        $this->call([
            CourseSeeder::class,
        ]);
    }
}
