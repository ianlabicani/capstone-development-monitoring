<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if (app()->environment('production')) {
            // Production: Only seed roles, permissions, and admin account
            $this->call([
                RoleAndPermissionSeeder::class,
                AdminSeeder::class,
            ]);
        } else {
            // Development: Seed all demo data
            $this->call([
                RoleAndPermissionSeeder::class,
                AdminSeeder::class,
                CapstoneTeacherSeeder::class,
                TechnicalAdviserSeeder::class,
                TeamLeaderSeeder::class,
            ]);
        }
    }
}
