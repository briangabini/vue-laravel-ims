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
        }
        // Fallback for guests or any other roles
        return Inertia::render('Welcome');
    }
}

