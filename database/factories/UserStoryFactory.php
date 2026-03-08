<?php

namespace Database\Factories;

use App\Enums\UserStoryStatus;
use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserStory>
 */
class UserStoryFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'team_id' => Team::factory(),
            'title' => fake()->sentence(6),
            'description' => fake()->paragraph(),
            'keywords' => fake()->words(5),
            'status' => UserStoryStatus::Draft,
            'is_covered' => false,
            'is_achieved' => false,
            'sort_order' => fake()->numberBetween(0, 10),
            'version' => 'v1',
            'manually_created' => false,
            'manually_achieved_at' => null,
        ];
    }

    public function approved(): self
    {
        return $this->state(fn () => ['status' => UserStoryStatus::Approved]);
    }

    public function outdated(): self
    {
        return $this->state(fn () => ['status' => UserStoryStatus::Outdated]);
    }

    public function covered(): self
    {
        return $this->state(fn () => [
            'status' => UserStoryStatus::Approved,
            'is_covered' => true,
        ]);
    }
}
