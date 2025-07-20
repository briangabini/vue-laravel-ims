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
        return Inertia::render('settings/Password');
    }

    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();
        $user->load('passwordHistories');

        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed', new NotInPasswordHistory($user)],
        ]);

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        PasswordHistory::create([
            'user_id' => $user->id,
            'password_hash' => $user->password,
        ]);

        return back();
    }
}
