<?php

namespace App\Providers;

// use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Listeners\SendNotificationWhenEventCreated;class EventServiceProvider extends ServiceProvider

{
    protected $listen = [
        'App\Events\EventCreated' => [
            'App\Listeners\SendNotificationWhenEventCreated',
        ],
    ];
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
