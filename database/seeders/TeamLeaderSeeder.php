<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;

class TeamLeaderSeeder extends Seeder
{
    /**
     * Seed the team leader user.
     */
    public function run(): void
    {
        $adviser = User::where('email', 'adviser@example.com')->first();

        $user = User::factory()->create([
            'name' => 'Team Leader User',
            'email' => 'teamleader@example.com',
            'created_by' => $adviser?->id,
        ]);

        $user->assignRole(UserRole::TeamLeader);
    }
}
