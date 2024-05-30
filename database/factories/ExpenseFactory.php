<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Expense>
 */
class ExpenseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        
        return [
            'title' => fake()->unique()->words(3, true),
            'description' => fake()->sentence(2, true),
            'quantity' => fake()->randomDigitNotZero(),
            'unit_price' =>fake()->numberBetween(50, 1000),
            'category' => fake()->randomElements(['food', 'transportation', 'utilities', 'leisure', 'others'])[0],
            'receipt' => fake()->imageUrl(),
            'user_id' =>1,
        ];
    }
}
