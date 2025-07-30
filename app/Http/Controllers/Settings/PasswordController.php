<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\PasswordHistory;
use App\Rules\NotInPasswordHistory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Inertia\Inertia;
use Inertia\Response;

class PasswordController extends Controller
{
    /**
     * Show the user's password settings page.
     */
    public function edit(): Response
    {
        if (auth()->user()->role->name === 'customer') {
            return Inertia::render('customers/Password');
        }

        return Inertia::render('settings/Password');
    }

    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();
        $user->load('passwordHistories');

        // Enforce password aging (2.1.11)
        if ($user->password_change_at && $user->password_change_at->diffInHours(now()) < 24) {
            throw ValidationException::withMessages([
                'password' => __('You can only change your password once every 24 hours.'),
            ]);
        }

        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed', new NotInPasswordHistory($user)],
        ]);

        $user->forceFill([
            'password' => Hash::make($validated['password']),
            'password_change_at' => now(),
        ])->save();

        PasswordHistory::create([
            'user_id' => $user->id,
            'password_hash' => $user->password,
        ]);

        if (auth()->user()->role->name === 'customer') {
            return to_route('customers.settings.password');
        }

        return back();
    }
}