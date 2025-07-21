<?php

namespace App\Listeners;

use App\Models\LoginAttempt;
use App\Models\User;
use Illuminate\Auth\Events\Failed;
use Illuminate\Support\Facades\Log;

class LogFailedLogin
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
     * @param  \Illuminate\Auth\Events\Failed  $event
     * @return void
     */
    public function handle(Failed $event)
    {
        $user = User::where('email', $event->credentials['email'])->first();

        // Check if a similar failed login attempt has already been logged very recently
        $existingAttempt = LoginAttempt::where('user_id', $user ? $user->id : null)
            ->where('ip_address', request()->ip())
            ->where('successful', false)
            ->where('logged_in_at', '>=', now()->subSeconds(5))
            ->first();

        if ($existingAttempt) {
            return;
        }

        LoginAttempt::create([
            'user_id' => $user ? $user->id : null,
            'ip_address' => request()->ip(),
            'successful' => false,
            'logged_in_at' => now(),
        ]);

        Log::channel('security')->warning('User login failed.', [
            'email_attempted' => $event->credentials['email'],
            'ip_address' => request()->ip(),
        ]);
    }
}
