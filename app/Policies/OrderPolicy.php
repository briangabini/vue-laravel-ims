<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;

class OrderPolicy
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

    public function view(User $user, Order $order): bool
    {
        if (in_array($user->role->name, ['admin', 'manager'])) {
            return true;
        }
        return $user->id === $order->user_id;
    }

    public function create(User $user): bool
    {
        return $user->role->name === 'customer';
    }

    public function update(User $user, Order $order): bool
    {
        return in_array($user->role->name, ['admin', 'manager']);
    }
}
