<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;

class TechnicalAdviserSeeder extends Seeder
{
    /**
     * Seed the technical adviser user.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'Adviser User',
            'email' => 'adviser@example.com',
        ]);

        $user->assignSingleRole(UserRole::TechnicalAdviser);
    }
}
