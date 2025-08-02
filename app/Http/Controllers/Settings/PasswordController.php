<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\PasswordHistory;
use App\Rules\NotContainUserData;
use App\Rules\NotInPasswordHistory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Inertia\Inertia;
use Illuminate\Validation\ValidationException;
use Inertia\Response;

class PasswordController extends Controller
{
    /**
     * Show the user's password settings page.
     */
    public function edit(Request $request): Response
    {
        $user = $request->user();
        if ($user->role->name === 'customer') {
            return Inertia::render('customers/Password', [
                'user' => [
                    'name' => $user->name,
                    'email' => $user->email,
                ],
            ]);
        }

        return Inertia::render('settings/Password', [
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
            ],
        ]);
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
            'password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols(2)
                    ->uncompromised(),
                new NotInPasswordHistory($user),
                new NotContainUserData(['name' => $user->name, 'email' => $user->email])
            ],
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
