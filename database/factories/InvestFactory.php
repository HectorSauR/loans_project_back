<?php

namespace Database\Factories;

use App\Models\Investor;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvestFactory extends Factory
{
    public function definition(): array
    {
        return [
            'total' => $this->faker->randomFloat(2, 100, 1000),
            'investor_id' => function () {
                return Investor::factory()->create()->id;
            },
            'kind' => $this->faker->randomElement(['in', 'out']),
        ];
    }
}
