<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserLoginFailed
{
    use Dispatchable, SerializesModels;

    public $email;
    public $ipAddress;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(string $email, string $ipAddress)
    {
        $this->email = $email;
        $this->ipAddress = $ipAddress;
    }
}
