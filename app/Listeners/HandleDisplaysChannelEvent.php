<?php

namespace App\Listeners;

use App\Events\DisplayConnected;
use App\Models\Display;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class HandleDisplaysChannelEvent implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the channel event.
     */
    public function handle($event): void
    {
        try {
            Log::info('Handling displays channel event', [
                'event_type' => get_class($event),
                'event_data' => $event,
                'is_array' => is_array($event),
                'event_keys' => is_array($event) ? array_keys($event) : 'not_array',
            ]);

            // Check if this is a client-device-info event
            if (isset($event['event']) && $event['event'] === 'client-device-info') {
                $this->handleClientDeviceInfo($event);
            }
            // Also check for client-hello events that contain device info
            elseif (isset($event['event']) && $event['event'] === 'client-hello' && isset($event['data']['device_info'])) {
                $this->handleClientDeviceInfo($event);
            }
            // Check for client-template-check event
            elseif (isset($event['event']) && $event['event'] === 'client-template-check') {
                $this->handleClientTemplateCheck($event);
            }
            // Check for client-status-report event
            elseif (isset($event['event']) && $event['event'] === 'client-status-report') {
                $this->handleClientStatusReport($event);
            }

        } catch (\Exception $e) {
            Log::error('Error handling displays channel event', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
        }
    }

    /**
     * Handle client-device-info event
     */
    protected function handleClientDeviceInfo($event): void
    {
        try {
            Log::info('Processing client-device-info event', $event);

            // Extract device information from the event
            $deviceInfo = $event['data']['device_info'] ?? $event['data'] ?? [];

            if (empty($deviceInfo) || empty($deviceInfo['ip_address'])) {
                Log::warning('No valid device info provided in client-device-info event');

                return;
            }

            // Generate a unique 5-character alphanumeric connection code
            $connectionCode = $this->generateUniqueConnectionCode();

            // Create or update display record with device information
            $display = Display::updateOrCreate(
                ['ip_address' => $deviceInfo['ip_address']],
                [
                    'name' => $deviceInfo['name'] ?? 'Display '.$deviceInfo['ip_address'],
                    'ip_address' => $deviceInfo['ip_address'],
                    'mac_address' => $deviceInfo['mac_address'] ?? null,
                    'app_version' => $deviceInfo['app_version'] ?? null,
                    'os' => $deviceInfo['os'] ?? null,
                    'version' => $deviceInfo['version'] ?? null,
                    'firmware_version' => $deviceInfo['firmware_version'] ?? null,
                    'connection_code' => $connectionCode,
                    'online' => true,
                    'last_seen_at' => now(),
                    'status' => 'online',
                    'last_message' => 'Display connected via WebSocket with device info',
                ]
            );

            Log::info('Display connected via WebSocket', [
                'display_id' => $display->id,
                'connection_code' => $connectionCode,
                'ip_address' => $deviceInfo['ip_address'],
                'device_info' => $deviceInfo,
            ]);

            // Broadcast the connection code to the display
            broadcast(new DisplayConnected($display, $connectionCode));

        } catch (\Exception $e) {
            Log::error('Error processing client-device-info event', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
        }
    }

    /**
     * Generate a unique 5-character alphanumeric connection code
     */
    private function generateUniqueConnectionCode(): string
    {
        do {
            // Generate 5 random alphanumeric characters (0-9, A-Z)
            $code = '';
            for ($i = 0; $i < 5; $i++) {
                $code .= rand(0, 1) ? chr(rand(48, 57)) : chr(rand(65, 90)); // 0-9 or A-Z
            }
        } while (Display::where('connection_code', $code)->exists());

        return $code;
    }

    /**
     * Handle client-template-check event
     */
    protected function handleClientTemplateCheck($event): void
    {
        try {
            Log::info('Processing client-template-check event', $event);

            $data = $event['data'] ?? [];
            $displayId = $data['display_id'] ?? null;
            $connectionCode = $data['connection_code'] ?? null;

            if (!$displayId && !$connectionCode) {
                Log::warning('Template check missing identifiers', [
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
                Log::warning('Template check - display not found', [
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
            Log::error('Error processing client-template-check event', [
                'error' => $e->getMessage(),
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

        Log::info('Template check response sent', [
            'display_id' => $display->id,
            'has_template' => $hasTemplate,
            'template_id' => $template?->id,
        ]);
    }

    /**
     * Handle client-status-report event
     */
    protected function handleClientStatusReport($event): void
    {
        try {
            Log::info('Processing client-status-report event', $event);

            $data = $event['data'] ?? [];
            $displayId = $data['display_id'] ?? null;
            $connectionCode = $data['connection_code'] ?? null;

            if (!$displayId && !$connectionCode) {
                Log::warning('Status report missing identifiers', [
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
                Log::warning('Status report - display not found', [
                    'display_id' => $displayId,
                    'connection_code' => $connectionCode,
                ]);
                return;
            }

            // Update display's last seen timestamp and status
            $display->update([
                'last_seen_at' => now(),
                'online' => true,
                'status' => 'online',
                'last_message' => 'Status report received via WebSocket',
            ]);

            Log::info('Display status updated via WebSocket', [
                'display_id' => $display->id,
                'status' => $data['status'] ?? 'unknown',
                'capabilities' => $data['capabilities'] ?? [],
            ]);

        } catch (\Exception $e) {
            Log::error('Error processing client-status-report event', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
        }
    }
}
