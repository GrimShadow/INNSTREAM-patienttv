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
        $data = [
            'type' => 'good_day',
            'code' => $this->connectionCode,
            'display_id' => $this->display->id,
            'message' => 'Display connected successfully',
        ];

        // Include template information if display has an active template
        if ($this->display->template_id) {
            $template = $this->display->template;
            if ($template && $template->status === 'published') {
                $data['template'] = [
                    'id' => $template->id,
                    'name' => $template->name,
                    'description' => $template->description,
                    'category' => $template->category,
                    'type' => $template->type,
                    'version' => $template->version,
                    'configuration' => $template->configuration,
                    'tags' => $template->tags,
                    'compatibility' => $template->compatibility,
                    'preview_url' => route('template.preview', $template->id),
                    'css_url' => route('template.css', $template->id),
                    'js_url' => route('template.js', $template->id),
                    'assets_url' => route('template.assets', $template->id),
                    'thumbnail_url' => $template->thumbnail_url,
                ];
                $data['has_template'] = true;
            } else {
                $data['has_template'] = false;
                $data['message'] = 'Display connected - no active template';
            }
        } else {
            $data['has_template'] = false;
            $data['message'] = 'Display connected - no template assigned';
        }

        return $data;
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'display.code';
    }
}
