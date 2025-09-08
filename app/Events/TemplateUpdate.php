<?php

namespace App\Events;

use App\Models\Display;
use App\Models\Template;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TemplateUpdate implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $display;
    public $template;
    public $action; // 'deploy', 'remove', 'update'

    /**
     * Create a new event instance.
     */
    public function __construct(Display $display, ?Template $template = null, string $action = 'update')
    {
        $this->display = $display;
        $this->template = $template;
        $this->action = $action;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        $channels = [
            new Channel('display.'.$this->display->id), // Specific channel for the display
            new Channel('displays'), // General channel for all displays
        ];

        // Log the channels being used
        \Log::info('TemplateUpdate broadcast channels', [
            'display_id' => $this->display->id,
            'channels' => [
                'display.'.$this->display->id,
                'displays'
            ],
            'action' => $this->action,
        ]);

        return $channels;
    }

    /**
     * Get the data to broadcast.
     */
    public function broadcastWith(): array
    {
        $data = [
            'type' => 'template_update',
            'display_id' => $this->display->id,
            'connection_code' => $this->display->connection_code,
            'action' => $this->action,
            'timestamp' => now()->toISOString(),
        ];

        if ($this->action === 'remove') {
            $data['has_template'] = false;
            $data['message'] = 'Template removed from display';
        } elseif ($this->template && $this->template->status === 'published') {
            $data['has_template'] = true;
            $data['template'] = [
                'id' => $this->template->id,
                'name' => $this->template->name,
                'description' => $this->template->description,
                'category' => $this->template->category,
                'type' => $this->template->type,
                'version' => $this->template->version,
                'configuration' => $this->template->configuration,
                'tags' => $this->template->tags,
                'compatibility' => $this->template->compatibility,
                'preview_url' => route('template.preview', $this->template->id),
                'css_url' => route('template.css', $this->template->id),
                'js_url' => route('template.js', $this->template->id),
                'assets_url' => route('template.assets', $this->template->id),
                'thumbnail_url' => $this->template->thumbnail_url,
            ];
            $data['message'] = 'Template ' . $this->action . 'd successfully';
        } else {
            $data['has_template'] = false;
            $data['message'] = 'No active template available';
        }

        // Log the complete broadcast data
        \Log::info('TemplateUpdate broadcast data', [
            'event_name' => $this->broadcastAs(),
            'channels' => $this->broadcastOn(),
            'data' => $data,
            'display_id' => $this->display->id,
            'template_id' => $this->template?->id,
            'action' => $this->action,
        ]);

        return $data;
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'template.update';
    }
}