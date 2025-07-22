<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    protected function middleware(): array
    {
        return [
            'authorize' => User::class,
        ];
    }

    public function index(): Response
    {
        return Inertia::render('admin/Users/Index', [
            'users' => User::with('role')->latest()->paginate(10),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('admin/Users/Create', [
            'roles' => Role::all(),
        ]);
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id',
        ]);

        User::create($request->all());

        return redirect()->route('admin.users.index');
    }

    public function show(User $user): Response
    {
        return Inertia::render('admin/Users/Show', [
            'user' => $user->load('role'),
        ]);
    }

    public function edit(User $user): Response
    {
        return Inertia::render('admin/Users/Edit', [
            'user' => $user,
            'roles' => Role::all(),
        ]);
    }

    public function update(Request $request, User $user): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id',
        ]);

        $user->update($request->except('password'));

        if ($request->filled('password')) {
            $user->update(['password' => $request->password]);
        }

        return redirect()->route('admin.users.index');
    }

    public function destroy(User $user): \Illuminate\Http\RedirectResponse
    {
        $user->delete();

        return redirect()->route('admin.users.index');
    }
}
