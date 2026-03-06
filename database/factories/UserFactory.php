<?php

namespace Database\Factories;

use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Assign the admin role after creation.
     */
    public function admin(): static
    {
        return $this->afterCreating(fn ($user) => $user->assignRole(UserRole::Admin));
    }

    /**
     * Assign the capstone teacher role after creation.
     */
    public function capstoneTeacher(): static
    {
        return $this->afterCreating(fn ($user) => $user->assignRole(UserRole::CapstoneTeacher));
    }

    /**
     * Assign the technical adviser role after creation.
     */
    public function technicalAdviser(): static
    {
        return $this->afterCreating(fn ($user) => $user->assignRole(UserRole::TechnicalAdviser));
    }

    /**
     * Assign the team leader role after creation.
     */
    public function teamLeader(): static
    {
        return $this->afterCreating(fn ($user) => $user->assignRole(UserRole::TeamLeader));
    }
}
