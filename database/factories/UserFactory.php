<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user' => $this->faker->unique()->userName,
            'password' => bcrypt('password'),
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'available_balance' => $this->faker->randomFloat(2, 0, 10000),
            'balance_receivable' => $this->faker->randomFloat(2, 0, 10000),
            'email_verified_at' => now(),
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
}
