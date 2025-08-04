<?php

namespace Database\Seeders;

use App\Models\PermissionCategory;
use Illuminate\Database\Seeder;

class PermissionCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'User Management',
                'description' => 'Permissions related to managing users, roles, and permissions',
                'color' => '#3B82F6', // Blue
            ],
            [
                'name' => 'Content Management',
                'description' => 'Permissions for managing TV content, channels, and playlists',
                'color' => '#10B981', // Green
            ],
            [
                'name' => 'Display Management',
                'description' => 'Permissions for managing TV displays and devices',
                'color' => '#F59E0B', // Amber
            ],
            [
                'name' => 'Analytics & Reporting',
                'description' => 'Permissions for viewing analytics, reports, and system statistics',
                'color' => '#8B5CF6', // Purple
            ],
            [
                'name' => 'System Administration',
                'description' => 'Permissions for system configuration and maintenance',
                'color' => '#EF4444', // Red
            ],
            [
                'name' => 'Patient Interaction',
                'description' => 'Permissions for patient-facing features and interactions',
                'color' => '#06B6D4', // Cyan
            ],
        ];

        foreach ($categories as $category) {
            PermissionCategory::create($category);
        }
    }
}
