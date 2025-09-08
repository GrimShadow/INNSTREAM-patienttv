<?php

namespace App\Providers;

use App\Listeners\HandleDisplaysChannelEvent;
use App\Listeners\HandleWebSocketTemplateCheck;
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
        \Log::info('ChannelEventServiceProvider: Setting up event listeners');

        // Listen for all events on the displays channel
        Event::listen('displays.*', HandleDisplaysChannelEvent::class);

        // Also listen for specific client events
        Event::listen('displays.client-device-info', HandleDisplaysChannelEvent::class);
        Event::listen('displays.client-hello', HandleDisplaysChannelEvent::class);
        Event::listen('displays.client-template-check', HandleWebSocketTemplateCheck::class);

        \Log::info('ChannelEventServiceProvider: Event listeners registered', [
            'listeners' => [
                'displays.*' => HandleDisplaysChannelEvent::class,
                'displays.client-device-info' => HandleDisplaysChannelEvent::class,
                'displays.client-hello' => HandleDisplaysChannelEvent::class,
                'displays.client-template-check' => HandleWebSocketTemplateCheck::class,
            ]
        ]);
    }
}
