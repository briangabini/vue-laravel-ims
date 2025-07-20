<?php

namespace App\Listeners;

use App\Events\UserLoginFailed;
use App\Models\LoginAttempt;
use App\Models\User;
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
     * @param  \App\Events\UserLoginFailed  $event
     * @return void
     */
    public function handle(UserLoginFailed $event)
    {
        $user = User::where('email', $event->email)->first();

        LoginAttempt::create([
            'user_id' => $user ? $user->id : null,
            'ip_address' => $event->ipAddress,
            'successful' => false,
            'logged_in_at' => now(),
        ]);

        Log::channel('security')->warning('User login failed.', [
            'email_attempted' => $event->email,
            'ip_address' => $event->ipAddress,
        ]);
    }
}
