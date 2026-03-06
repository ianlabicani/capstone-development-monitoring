<?php

namespace Database\Factories;

use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Repository>
 */
class RepositoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $owner = fake()->userName();
        $repo = fake()->unique()->slug(2);

        return [
            'team_id' => Team::factory(),
            'github_owner' => $owner,
            'github_repo' => $repo,
            'full_name' => $owner.'/'.$repo,
            'default_branch' => 'main',
            'description' => fake()->optional()->sentence(),
            'is_active' => true,
        ];
    }
}
