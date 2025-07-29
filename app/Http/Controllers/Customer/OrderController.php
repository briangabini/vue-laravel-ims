<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class OrderController extends Controller
{
    public function index(): Response
    {
        $orders = Auth::user()->orders()->orderByDesc('created_at')->get();

        return Inertia::render('customers/Orders', [
            'orders' => $orders,
        ]);
    }

    public function show(Order $order): Response
    {
        // Ensure the order belongs to the authenticated user
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $order->load('orderItems.product');

        return Inertia::render('customers/OrderDetails', [
            'order' => $order,
        ]);
    }

    public function checkStatus(Request $request): Response
    {
        $request->validate([
            'order_number' => 'required|string|max:255',
        ]);

        $order = Order::where('order_number', $request->order_number)
                      ->with('orderItems.product')
                      ->first();

        return Inertia::render('customers/OrderStatus', [
            'order' => $order,
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
                'total_price' => ($product->price * $request->quantity) * 100,
                'status' => 'pending',
            ]);

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'price_per_unit' => $product->price,
            ]);
        });

        return redirect()->route('customer.orders.index')->with('success', 'Order placed successfully!');
    }
}