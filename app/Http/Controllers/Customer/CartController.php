<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
}