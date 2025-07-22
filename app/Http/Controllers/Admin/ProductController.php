<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ProductController extends Controller
{
    protected function middleware(): array
    {
        return [
            'authorize' => Product::class,
        ];
    }

    public function index(): Response
    {
        return Inertia::render('admin/Products/Index', [
            'products' => Product::with('category')->latest()->paginate(10),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('admin/Products/Create', [
            'categories' => Category::all(),
        ]);
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
        ]);

        Product::create($request->all());

        return redirect()->route('admin.products.index');
    }

    public function show(Product $product): Response
    {
        return Inertia::render('admin/Products/Show', [
            'product' => $product->load('category'),
        ]);
    }

    public function edit(Product $product): Response
    {
        return Inertia::render('admin/Products/Edit', [
            'product' => $product,
            'categories' => Category::all(),
        ]);
    }

    public function update(Request $request, Product $product): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
        ]);

        $product->update($request->all());

        return redirect()->route('admin.products.index');
    }

    public function destroy(Product $product): \Illuminate\Http\RedirectResponse
    {
        $product->delete();

        return redirect()->route('admin.products.index');
    }
}
