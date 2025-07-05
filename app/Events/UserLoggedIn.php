<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class UserLoggedIn
{
    use Dispatchable, SerializesModels;

    public $user;
    public $ipAddress;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, string $ipAddress)
    {
        $this->user = $user;
        $this->ipAddress = $ipAddress;
    }
}
