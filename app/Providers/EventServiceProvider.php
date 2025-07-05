<?php

namespace App\Providers;

use App\Events\UserLoggedIn;
use App\Events\UserLoginFailed;
use App\Listeners\LogFailedLogin;
use App\Listeners\LogSuccessfulLogin;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        UserLoggedIn::class => [
            LogSuccessfulLogin::class,
        ],
        UserLoginFailed::class => [
            LogFailedLogin::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
