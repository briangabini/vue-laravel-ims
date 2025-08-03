<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
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
            'products' => Product::with('category')->orderBy('id')->paginate(10),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('admin/Products/Create', [
            'categories' => Category::all(),
        ]);
    }

    public function store(StoreProductRequest $request): \Illuminate\Http\RedirectResponse
    {
        Product::create($request->validated());

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

    public function update(UpdateProductRequest $request, Product $product): \Illuminate\Http\RedirectResponse
    {
        $product->update($request->validated());

        return redirect()->route('admin.products.index');
    }

    public function destroy(Product $product): \Illuminate\Http\RedirectResponse
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();

        return redirect()->route('admin.products.index');
    }
}
