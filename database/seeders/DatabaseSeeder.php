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
        // User::factory(10)->create();

        User::updateOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );

        // Create additional sample users
        User::updateOrCreate(
            ['email' => 'john.smith@example.com'],
            [
                'name' => 'John Smith',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'sarah.johnson@example.com'],
            [
                'name' => 'Sarah Johnson',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'mike.wilson@example.com'],
            [
                'name' => 'Mike Wilson',
                'password' => bcrypt('password'),
                // Not verified to show pending status
            ]
        );

        // Seed permission categories
        $this->call([
            PermissionCategorySeeder::class,
        ]);
    }
}
