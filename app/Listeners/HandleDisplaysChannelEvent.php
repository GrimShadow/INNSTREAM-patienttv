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
            Log::info('Handling displays channel event', $event);

            // Check if this is a client-device-info event
            if (isset($event['event']) && $event['event'] === 'client-device-info') {
                $this->handleClientDeviceInfo($event);
            }
            // Also check for client-hello events that contain device info
            elseif (isset($event['event']) && $event['event'] === 'client-hello' && isset($event['data']['device_info'])) {
                $this->handleClientDeviceInfo($event);
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
}
