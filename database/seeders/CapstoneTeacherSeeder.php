<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;

class CapstoneTeacherSeeder extends Seeder
{
    /**
     * Seed the capstone teacher user.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'Teacher User',
            'email' => 'teacher@example.com',
        ]);

        $user->assignSingleRole(UserRole::CapstoneTeacher);
    }
}
