<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CategoryController extends Controller
{
    protected function middleware(): array
    {
        return [
            'authorize' => Category::class,
        ];
    }

    public function index(): Response
    {
        return Inertia::render('admin/Categories/Index', [
            'categories' => Category::latest()->paginate(10),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('admin/Categories/Create');
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories',
            'description' => 'nullable|string',
        ]);

        Category::create($request->all());

        return redirect()->route('admin.categories.index');
    }

    public function show(Category $category): Response
    {
        return Inertia::render('admin/Categories/Show', [
            'category' => $category,
        ]);
    }

    public function edit(Category $category): Response
    {
        return Inertia::render('admin/Categories/Edit', [
            'category' => $category,
        ]);
    }

    public function update(Request $request, Category $category): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string',
        ]);

        $category->update($request->all());

        return redirect()->route('admin.categories.index');
    }

    public function destroy(Category $category): \Illuminate\Http\RedirectResponse
    {
        $category->delete();

        return redirect()->route('admin.categories.index');
    }
}
