<?php

namespace Database\Factories;

use App\Models\Repository;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Commit>
 */
class CommitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $sha = fake()->sha1();

        return [
            'repository_id' => Repository::factory(),
            'sha' => $sha,
            'message' => fake()->sentence(),
            'author_name' => fake()->name(),
            'author_email' => fake()->safeEmail(),
            'author_login' => fake()->optional(0.8)->userName(),
            'committed_at' => fake()->dateTimeBetween('-3 months'),
            'url' => 'https://github.com/owner/repo/commit/'.$sha,
        ];
    }
}
