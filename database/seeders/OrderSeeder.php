<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::whereHas('role', function ($query) {
            $query->where('name', 'customer');
        })->get();

        $products = Product::all();

        if ($users->isNotEmpty() && $products->isNotEmpty()) {

            Order::factory(25)->make(['total_price' => 0])->each(function ($order) use ($users, $products) {
                $order->user_id = $users->random()->id;
                $order->save();

                $totalPrice = 0;
                $itemCount = rand(1, 5);

                for ($i = 0; $i < $itemCount; $i++) {
                    $product = $products->random();
                    $quantity = rand(1, 5);
                    $item = OrderItem::factory()->create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'price_per_unit' => $product->price,
                        'quantity' => $quantity,
                    ]);
                    $totalPrice += $item->price_per_unit * $item->quantity;
                }

                $order->total_price = $totalPrice * 100;
                $order->save();
            });
        }
    }
}
