<?php

namespace App\Listeners;

use App\Models\LoginAttempt;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Log;

class LogSuccessfulLogin
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \Illuminate\Auth\Events\Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        // Check if a similar login attempt has already been logged very recently
        $existingAttempt = LoginAttempt::where('user_id', $event->user->id)
            ->where('ip_address', request()->ip())
            ->where('successful', true)
            ->where('logged_in_at', '>=', now()->subSeconds(5))
            ->first();

        if ($existingAttempt) {
            return;
        }

        LoginAttempt::create([
            'user_id' => $event->user->id,
            'ip_address' => request()->ip(),
            'successful' => true,
            'logged_in_at' => now(),
        ]);

        Log::channel('security')->info('User logged in successfully.', [
            'user_id' => $event->user->id,
            'email' => $event->user->email,
            'ip_address' => request()->ip(),
        ]);
    }
}
