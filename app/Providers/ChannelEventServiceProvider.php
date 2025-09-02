<?php

namespace App\Providers;

use App\Listeners\HandleDisplaysChannelEvent;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class ChannelEventServiceProvider extends ServiceProvider
{
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
        // Listen for events on the displays channel
        $this->listenForChannelEvents();
    }

    /**
     * Listen for channel events
     */
    protected function listenForChannelEvents(): void
    {
        // Listen for all events on the displays channel
        Event::listen('displays.*', HandleDisplaysChannelEvent::class);

        // Also listen for specific client events
        Event::listen('displays.client-device-info', HandleDisplaysChannelEvent::class);
        Event::listen('displays.client-hello', HandleDisplaysChannelEvent::class);
    }
}
