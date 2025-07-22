<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class OrderController extends Controller
{
    public function index()
    {
        $orders = auth()->user()->orders; // Fetch orders for the authenticated user

        return Inertia::render('customers/MyOrders', [
            'orders' => $orders,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $product = Product::findOrFail($request->product_id);

        DB::transaction(function () use ($request, $product) {
            $order = Order::create([
                'user_id' => auth()->id(),
                'order_number' => 'ORD-' . uniqid(), // Simple unique order number
                'total_amount' => $product->price * $request->quantity,
                'status' => 'pending',
            ]);

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'price' => $product->price,
            ]);
        });

        return redirect()->route('customer.orders.index')->with('success', 'Order placed successfully!');
    }
}
