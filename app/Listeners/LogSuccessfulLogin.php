<?php

namespace App\Listeners;

use App\Events\UserLoggedIn;
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
     * @param  \App\Events\UserLoggedIn  $event
     * @return void
     */
    public function handle(UserLoggedIn $event)
    {
        Log::channel('security')->info('User logged in successfully.', [
            'user_id' => $event->user->id,
            'email' => $event->user->email,
            'ip_address' => $event->ipAddress,
        ]);
    }
}
