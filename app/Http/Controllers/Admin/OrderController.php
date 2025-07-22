<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class OrderController extends Controller
{
    protected function middleware(): array
    {
        return [
            'authorize' => Order::class,
        ];
    }

    public function index(): Response
    {
        return Inertia::render('admin/Orders/Index', [
            'orders' => Order::with('user')->latest()->paginate(10),
        ]);
    }

    public function show(Order $order): Response
    {
        return Inertia::render('admin/Orders/Show', [
            'order' => $order->load('orderItems.product', 'user'),
        ]);
    }

    public function edit(Order $order): Response
    {
        return Inertia::render('admin/Orders/Edit', [
            'order' => $order,
        ]);
    }

    public function update(Request $request, Order $order): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'status' => 'required|string|in:pending,processing,shipped,delivered,cancelled',
        ]);

        $order->update($request->only('status'));

        return redirect()->route('admin.orders.index');
    }
}
