<?php

namespace Database\Factories;

use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TeamDocument>
 */
class TeamDocumentFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'team_id' => Team::factory(),
            'slot' => 1,
            'type' => 'file',
            'file_path' => 'team-documents/'.fake()->uuid().'.pdf',
            'original_name' => fake()->words(3, true).'.pdf',
            'file_size' => fake()->numberBetween(1024, 10 * 1024 * 1024),
        ];
    }

    public function slot(int $slot): self
    {
        return $this->state(fn () => ['slot' => $slot]);
    }

    public function text(): self
    {
        return $this->state(fn () => [
            'type' => 'text',
            'file_path' => null,
            'original_name' => null,
            'file_size' => null,
            'content' => fake()->paragraphs(3, true),
        ]);
    }
}
