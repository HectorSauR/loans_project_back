<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Investor>
 */
class InvestorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'available' => $this->faker->randomFloat(2, 1000, 5000),
            'engaged' => $this->faker->randomFloat(2, 1000, 5000),
            'profit' => $this->faker->randomFloat(2, 0, 1000),
            'user_id' => 1,
        ];
    }
}
