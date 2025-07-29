<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function index(Request $request): Response
    {
        if (auth()->user()->role->name === 'admin' || auth()->user()->role->name === 'manager') {
            return Inertia::render('admin/Home');
        } else if (auth()->user()->role->name === 'customer') {
            $products = Product::with('category');

            if ($request->filled('search')) {
                $searchTerm = $request->search;
                $products->where(function ($query) use ($searchTerm) {
                    $query->where('name', 'like', '%' . $searchTerm . '%')
                          ->orWhere('description', 'like', '%' . $searchTerm . '%');
                });
            }

            if ($request->has('category_id') && $request->category_id !== '') {
                $products->where('category_id', (int)$request->category_id);
            }

            $products = $products->get();
            $categories = Category::all();

            \Log::info('HomeController: last_login_attempt in session', (array) session('flash.last_login_attempt'));
            return Inertia::render('customers/Home', [
                'products' => $products,
                'categories' => $categories,
                'filters' => $request->only(['search', 'category_id']),
            ]);
        }
        // Fallback for any other roles or if role is not set
        return Inertia::render('Welcome');
    }
}
