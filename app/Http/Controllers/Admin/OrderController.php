<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
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

    public function create(): Response
    {
        return Inertia::render('admin/Orders/Create', [
            'users' => \App\Models\User::all(),
            'products' => \App\Models\Product::all(),
        ]);
    }

    public function store(StoreOrderRequest $request): \Illuminate\Http\RedirectResponse
    {
        $order = Order::create($request->validated());

        foreach ($request->validated('order_items') as $item) {
            $order->orderItems()->create($item);
        }

        return redirect()->route('admin.orders.index');
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
            'users' => \App\Models\User::all(),
            'products' => \App\Models\Product::all(),
        ]);
    }

    public function update(UpdateOrderRequest $request, Order $order): \Illuminate\Http\RedirectResponse
    {
        $order->update($request->validated());

        if ($request->has('order_items')) {
            $order->orderItems()->delete();
            foreach ($request->validated('order_items') as $item) {
                $order->orderItems()->create($item);
            }
        }

        return redirect()->route('admin.orders.index');
    }
}
