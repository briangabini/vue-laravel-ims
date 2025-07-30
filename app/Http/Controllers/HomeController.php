<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;


class HomeController extends Controller
{
    public function index(Request $request): Response|RedirectResponse
    {
        if (auth()->check()) {
            $user = auth()->user();
            if ($user->role->name === 'admin' || $user->role->name === 'manager') {
                return redirect()->route('admin.dashboard');
            } elseif ($user->role->name === 'customer') {
                $products = Product::query()->with('category');

                if ($request->filled('category')) {
                    $products->where('category_id', $request->input('category'));
                }

                if ($request->filled('price_min')) {
                    $products->where('price', '>=', $request->input('price_min'));
                }

                if ($request->filled('price_max')) {
                    $products->where('price', '<=', $request->input('price_max'));
                }

                if ($request->filled('name')) {
                    $products->where('name', 'like', '%' . $request->input('name') . '%');
                }

                // Sorting
                $sortBy = $request->input('sort_by', 'name'); // Default sort by name
                $sortOrder = $request->input('sort_order', 'asc'); // Default sort order ascending

                $products->orderBy($sortBy, $sortOrder);

                $products = $products->paginate(12); // Paginate products, 12 per page
                $categories = Category::all();

                \Log::info('HomeController: last_login_attempt in session', (array) session('flash.last_login_attempt'));
                return Inertia::render('customers/Home', [
                    'products' => $products,
                    'categories' => $categories,
                    'filters' => $request->all(['category', 'price_min', 'price_max', 'name', 'sort_by', 'sort_order']),
                ]);
            }
        }
        // Fallback for guests or any other roles
        return Inertia::render('Welcome');
    }
}

