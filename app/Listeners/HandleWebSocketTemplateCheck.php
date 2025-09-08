<?php

namespace App\Listeners;

use App\Models\Display;
use Illuminate\Support\Facades\Log;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;

class HandleWebSocketTemplateCheck
{
    /**
     * Handle the WebSocket template check event.
     */
    public function handle($event): void
    {
        try {
            Log::info('HandleWebSocketTemplateCheck triggered', [
                'event_class' => get_class($event),
                'event_data' => $event->data ?? null,
                'raw_event' => $event,
            ]);

            $data = $event->data ?? [];
            $displayId = $data['display_id'] ?? null;
            $connectionCode = $data['connection_code'] ?? null;

            Log::info('WebSocket template check received', [
                'display_id' => $displayId,
                'connection_code' => $connectionCode,
                'data' => $data,
            ]);

            if (!$displayId && !$connectionCode) {
                Log::warning('WebSocket template check missing identifiers', [
                    'data' => $data,
                ]);
                return;
            }

            // Find display by connection code or display ID
            $display = null;
            if ($connectionCode) {
                $display = Display::where('connection_code', $connectionCode)->first();
            } elseif ($displayId) {
                $display = Display::find($displayId);
            }

            if (!$display) {
                Log::warning('WebSocket template check - display not found', [
                    'display_id' => $displayId,
                    'connection_code' => $connectionCode,
                ]);
                return;
            }

            // Update display's last seen timestamp
            $display->update(['last_seen_at' => now()]);

            // Check if display has an active template
            if (!$display->template_id) {
                $this->sendTemplateResponse($display, false, 'No active template for this display');
                return;
            }

            // Get the template with all necessary data
            $template = $display->template;
            
            if (!$template) {
                // Template was deleted, clear it from display
                $display->update(['template_id' => null]);
                $this->sendTemplateResponse($display, false, 'Template no longer exists, cleared from display');
                return;
            }

            // Check if template is published
            if ($template->status !== 'published') {
                $this->sendTemplateResponse($display, false, 'Template is not published');
                return;
            }

            // Send template data via WebSocket
            $this->sendTemplateResponse($display, true, 'Template found', $template);

        } catch (\Exception $e) {
            Log::error('WebSocket template check failed', [
                'error' => $e->getMessage(),
                'data' => $event->data ?? [],
                'trace' => $e->getTraceAsString(),
            ]);
        }
    }

    /**
     * Send template response via WebSocket
     */
    private function sendTemplateResponse($display, $hasTemplate, $message, $template = null)
    {
        $responseData = [
            'type' => 'template_check_response',
            'display_id' => $display->id,
            'connection_code' => $display->connection_code,
            'has_template' => $hasTemplate,
            'message' => $message,
            'timestamp' => now()->toISOString(),
        ];

        if ($hasTemplate && $template) {
            $responseData['template'] = [
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
        }

        // Broadcast the response to the specific display
        broadcast(new \App\Events\TemplateCheckResponse($display, $responseData));

        Log::info('WebSocket template check response sent', [
            'display_id' => $display->id,
            'has_template' => $hasTemplate,
            'template_id' => $template?->id,
        ]);
    }
}
