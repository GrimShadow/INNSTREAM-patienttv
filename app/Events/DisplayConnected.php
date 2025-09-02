<?php

namespace App\Events;

use App\Models\Display;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DisplayConnected implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $display;

    public $connectionCode;

    /**
     * Create a new event instance.
     */
    public function __construct(Display $display, string $connectionCode)
    {
        $this->display = $display;
        $this->connectionCode = $connectionCode;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('displays'),
        ];
    }

    /**
     * Get the data to broadcast.
     */
    public function broadcastWith(): array
    {
        return [
            'type' => 'good_day',
            'code' => $this->connectionCode,
            'display_id' => $this->display->id,
            'message' => 'Display connected successfully',
        ];
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'display.code';
    }
}
