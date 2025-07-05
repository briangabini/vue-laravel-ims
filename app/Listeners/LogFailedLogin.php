<?php

namespace App\Listeners;

use App\Events\UserLoginFailed;
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
        Log::channel('security')->warning('User login failed.', [
            'email_attempted' => $event->email,
            'ip_address' => $event->ipAddress,
        ]);
    }
}
