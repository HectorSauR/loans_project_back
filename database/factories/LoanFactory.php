<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Loan>
 */
class LoanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'total' => $this->faker->randomFloat(2, 100, 1000),
            'remaining' => $this->faker->randomFloat(2, 0, 1000),
            'interest' => 10.00,
            'interest_generated' => $this->faker->randomFloat(2, 0, 100),
            'deadline' => $this->faker->randomElement(['week', 'month']),
            'ended_date' => $this->faker->dateTimeBetween('now', '+1 year'),
            'guarantee' => $this->faker->text,
            'kind' => $this->faker->randomElement(['cash', 'card']),
            'investor_id' => function () {
                return \App\Models\Investor::inRandomOrder()->first()->id;
            },
            'debtor_id' => function () {
                return \App\Models\Debtor::inRandomOrder()->first()->id;
            },
        ];
    }
}
