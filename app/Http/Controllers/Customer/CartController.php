<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class CartController extends Controller
{
    public function index(): Response
    {
        $cartItems = Auth::user()->carts()->with('product')->get();

        return Inertia::render('customers/Cart', [
            'cartItems' => $cartItems,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $user = Auth::user();
        $productId = $request->input('product_id');

        $cartItem = Cart::where('user_id', $user->id)
                        ->where('product_id', $productId)
                        ->first();

        if ($cartItem) {
            $cartItem->quantity++;
            $cartItem->save();
        } else {
            Cart::create([
                'user_id' => $user->id,
                'product_id' => $productId,
                'quantity' => 1,
            ]);
        }

        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }

    public function update(Request $request)
    {
        $request->validate([
            'cart_item_id' => 'required|exists:carts,id',
            'quantity' => 'required|integer|min:0',
        ]);

        $cartItem = Cart::where('id', $request->cart_item_id)
                        ->where('user_id', Auth::id())
                        ->firstOrFail();

        if ($request->quantity === 0) {
            $cartItem->delete();
            return redirect()->back()->with('success', 'Item removed from cart.');
        }

        // Check against product stock
        if ($request->quantity > $cartItem->product->stock) {
            return redirect()->back()->withErrors(['quantity' => 'Quantity exceeds available stock.']);
        }

        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        return redirect()->back()->with('success', 'Cart updated successfully!');
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'cart_item_id' => 'required|exists:carts,id',
        ]);

        Cart::where('id', $request->cart_item_id)
            ->where('user_id', Auth::id())
            ->firstOrFail()
            ->delete();

        return redirect()->back()->with('success', 'Item removed from cart.');
    }

    public function checkout(Request $request)
    {
        $user = Auth::user();
        $cartItems = $user->carts()->with('product')->get();

        if ($cartItems->isEmpty()) {
            throw ValidationException::withMessages([
                'cart' => 'Your cart is empty.',
            ]);
        }

        DB::transaction(function () use ($user, $cartItems) {
            $totalPrice = 0;
            $orderItemsData = [];

            foreach ($cartItems as $cartItem) {
                $product = $cartItem->product;

                // Check stock
                if ($cartItem->quantity > $product->stock) {
                    throw ValidationException::withMessages([
                        'stock' => "Not enough stock for {$product->name}. Available: {$product->stock}",
                    ]);
                }

                $totalPrice += $product->price * $cartItem->quantity;

                $orderItemsData[] = [
                    'product_id' => $product->id,
                    'quantity' => $cartItem->quantity,
                    'price_per_unit' => $product->price,
                ];

                // Update product stock
                $product->stock -= $cartItem->quantity;
                $product->save();
            }

            // Create the order
            $orderNumber = 'ORD-' . strtoupper(uniqid());
            $order = Order::create([
                'user_id' => $user->id,
                'order_number' => $orderNumber,
                'status' => 'pending',
                'total_price' => $totalPrice,
            ]);

            // Create order items
            foreach ($orderItemsData as $itemData) {
                $order->orderItems()->create($itemData);
            }

            // Clear the cart
            $user->carts()->delete();
        });

        return redirect()->route('customers.orders')->with('success', 'Order placed successfully!');
    }
}
