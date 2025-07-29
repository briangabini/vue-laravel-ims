<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class AuthenticatedSessionController extends Controller
{
    /**
     * Show the login page.
     */
    public function create(Request $request): Response
    {
        return Inertia::render('auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => $request->session()->get('status'),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $user = User::where('email', $request->email)->first();
        $lastLogin = null;

        if ($user) {
            $lastLogin = $user->loginAttempts()->latest()->first();
        }

        try {
            $request->authenticate();

            $request->session()->regenerate();

            $authenticatedUser = $request->user();

            if ($lastLogin) {
                $request->session()->flash('last_login_attempt', [
                    'successful' => $lastLogin->successful,
                    'ip_address' => $lastLogin->ip_address,
                    'logged_in_at' => $lastLogin->logged_in_at->toDayDateTimeString(),
                ]);
                \Log::info('AuthenticatedSessionController: last_login_attempt set in session', $request->session()->get('last_login_attempt'));
            }

            if ($user && in_array($user->role->name, ['admin', 'manager'])) {
                return redirect()->intended(route('admin.dashboard', absolute: false));
            } else if ($user && $user->role->name === 'customer') {
                return redirect()->route('customers.home');
            }

            return redirect()->intended(route('home', absolute: false));
        } catch (ValidationException $e) {
            throw $e;
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
