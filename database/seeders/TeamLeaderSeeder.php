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
        $user = User::factory()->create([
            'name' => 'Team Leader User',
            'email' => 'teamleader@example.com',
        ]);

        $user->assignRole(UserRole::TeamLeader);
    }
}
