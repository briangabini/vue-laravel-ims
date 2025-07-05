<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderItem>
 */
class OrderItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Get a random product to determine the price
        $product = Product::inRandomOrder()->first();
        $quantity = fake()->numberBetween(1, 5);

        return [
            'order_id' => Order::factory(),
            'product_id' => $product->id,
            'quantity' => $quantity,
            'price_per_unit' => $product->price, // Use the product's actual price
        ];
    }
}
