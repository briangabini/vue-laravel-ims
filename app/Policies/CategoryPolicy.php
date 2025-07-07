<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;

class CategoryPolicy
{
    public function before(User $user, string $ability): bool|null
    {
        if ($user->role->name === 'admin') {
            return true;
        }
        return null;
    }

    public function viewAny(User $user): bool
    {
        return in_array($user->role->name, ['admin', 'manager']);
    }

    public function view(User $user, Category $category): bool
    {
        return in_array($user->role->name, ['admin', 'manager']);
    }

    public function create(User $user): bool
    {
        return in_array($user->role->name, ['admin', 'manager']);
    }

    public function update(User $user, Category $category): bool
    {
        return in_array($user->role->name, ['admin', 'manager']);
    }

    public function delete(User $user, Category $category): bool
    {
        return $user->role->name === 'admin';
    }
}
