<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_number' => 'ORD-' . fake()->unique()->randomNumber(8),
            'status' => fake()->randomElement(['pending', 'processing', 'shipped', 'delivered']),
            'total_price' => fake()->randomFloat(2, 50, 2000),
        ];
    }
}
