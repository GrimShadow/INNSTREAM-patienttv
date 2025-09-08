<?php

namespace App\Http\Controllers;

use App\Models\Display;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebSocketController extends Controller
{
    /**
     * Handle display connection and generate connection code
     */
    public function connect(Request $request)
    {
        try {
            Log::info('Display connection attempt', $request->all());

            // Extract device information from the request
            $deviceInfo = $request->input('device_info', []);
            $displayId = $request->input('display_id'); // For reconnections

            $display = null;
            $connectionCode = null;
            $isReconnection = false;

            // Check if this is a reconnection with existing display_id
            if ($displayId) {
                $display = Display::find($displayId);
                if ($display) {
                    $isReconnection = true;
                    $connectionCode = $display->connection_code;
                    Log::info('Display reconnection detected', [
                        'display_id' => $displayId,
                        'connection_code' => $connectionCode,
                    ]);
                }
            }

            // If not a reconnection or display not found, create/update normally
            if (! $isReconnection) {
                // Generate a unique 5-character alphanumeric connection code
                $connectionCode = $this->generateUniqueConnectionCode();

                // Create or update display record with device information
                // Use MAC address as primary identifier, fallback to IP address
                $uniqueIdentifier = $deviceInfo['mac_address'] ?? $request->ip();
                $identifierField = $deviceInfo['mac_address'] ? 'mac_address' : 'ip_address';

                $display = Display::updateOrCreate(
                    [$identifierField => $uniqueIdentifier],
                    [
                        'name' => $deviceInfo['name'] ?? 'Display '.$uniqueIdentifier,
                        'ip_address' => $deviceInfo['ip_address'] ?? $request->ip(),
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
            } else {
                // Update existing display for reconnection
                $display->update([
                    'online' => true,
                    'last_seen_at' => now(),
                    'status' => 'online',
                    'last_message' => 'Display reconnected via WebSocket',
                ]);
            }

            Log::info($isReconnection ? 'Display reconnected' : 'Display connected', [
                'display_id' => $display->id,
                'connection_code' => $connectionCode,
                'ip_address' => $request->ip(),
                'device_info' => $deviceInfo,
                'is_reconnection' => $isReconnection,
            ]);

            // Broadcast the connection code to the display
            Log::info('Broadcasting DisplayConnected event', [
                'display_id' => $display->id,
                'connection_code' => $connectionCode,
                'is_reconnection' => $isReconnection,
            ]);
            broadcast(new \App\Events\DisplayConnected($display, $connectionCode));

            return response()->json([
                'success' => true,
                'message' => $isReconnection ? 'Display reconnected successfully' : 'Display connected successfully',
                'data' => [
                    'display_id' => $display->id,
                    'connection_code' => $connectionCode,
                    'is_reconnection' => $isReconnection,
                ],
            ]);

        } catch (\Exception $e) {
            Log::error('Display connection error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Connection failed',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Handle display disconnection
     */
    public function disconnect(Request $request)
    {
        try {
            $connectionCode = $request->input('connection_code');

            if (! $connectionCode) {
                return response()->json([
                    'success' => false,
                    'message' => 'Connection code is required',
                ], 400);
            }

            $display = Display::where('connection_code', $connectionCode)->first();

            if (! $display) {
                return response()->json([
                    'success' => false,
                    'message' => 'Display not found',
                ], 404);
            }

            $display->update([
                'online' => false,
                'status' => 'offline',
                'last_message' => 'Display disconnected via WebSocket',
                'last_seen_at' => now(),
            ]);

            Log::info('Display disconnected', [
                'display_id' => $display->id,
                'connection_code' => $connectionCode,
            ]);

            // Broadcast the disconnection
            broadcast(new \App\Events\DisplayDisconnected($display));

            return response()->json([
                'success' => true,
                'message' => 'Display disconnected successfully',
            ]);

        } catch (\Exception $e) {
            Log::error('Display disconnection error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Disconnection failed',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Handle display heartbeat
     */
    public function heartbeat(Request $request)
    {
        try {
            $connectionCode = $request->input('connection_code');
            $displayId = $request->input('display_id'); // Alternative identifier

            if (! $connectionCode && ! $displayId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Connection code or display ID is required',
                ], 400);
            }

            // Find display by connection code or display ID
            $display = null;
            if ($connectionCode) {
                $display = Display::where('connection_code', $connectionCode)->first();
            } elseif ($displayId) {
                $display = Display::find($displayId);
            }

            if (! $display) {
                return response()->json([
                    'success' => false,
                    'message' => 'Display not found',
                ], 404);
            }

            $wasOffline = ! $display->online;

            $display->update([
                'last_seen_at' => now(),
                'online' => true,
                'status' => 'online',
                'last_message' => 'Heartbeat received',
            ]);

            // If display was offline and now came back online, broadcast reconnection
            if ($wasOffline) {
                Log::info('Display came back online via heartbeat', [
                    'display_id' => $display->id,
                    'connection_code' => $display->connection_code,
                ]);

                broadcast(new \App\Events\DisplayConnected($display, $display->connection_code));
            }

            return response()->json([
                'success' => true,
                'message' => 'Heartbeat received',
                'data' => [
                    'display_id' => $display->id,
                    'was_offline' => $wasOffline,
                ],
            ]);

        } catch (\Exception $e) {
            Log::error('Display heartbeat error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Heartbeat failed',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get all displays with their current status
     */
    public function getDisplays()
    {
        try {
            $displays = Display::orderBy('last_seen_at', 'desc')->get()->map(function ($display) {
                return [
                    'id' => $display->id,
                    'name' => $display->name,
                    'connection_code' => $display->connection_code,
                    'ip_address' => $display->ip_address,
                    'mac_address' => $display->mac_address,
                    'online' => $display->online,
                    'status' => $display->status,
                    'last_seen_at' => $display->last_seen_at,
                    'last_message' => $display->last_message,
                    'app_version' => $display->app_version,
                    'os' => $display->os,
                    'version' => $display->version,
                    'firmware_version' => $display->firmware_version,
                    'created_at' => $display->created_at,
                    'updated_at' => $display->updated_at,
                ];
            });

            return response()->json([
                'success' => true,
                'data' => $displays,
            ]);

        } catch (\Exception $e) {
            Log::error('Error getting displays', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to get displays',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Handle template check request from display
     */
    public function checkTemplate(Request $request)
    {
        try {
            $connectionCode = $request->input('connection_code');
            $displayId = $request->input('display_id');

            if (!$connectionCode && !$displayId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Connection code or display ID is required',
                ], 400);
            }

            // Find display by connection code or display ID
            $display = null;
            if ($connectionCode) {
                $display = Display::where('connection_code', $connectionCode)->first();
            } elseif ($displayId) {
                $display = Display::find($displayId);
            }

            if (!$display) {
                return response()->json([
                    'success' => false,
                    'message' => 'Display not found',
                ], 404);
            }

            // Update display's last seen timestamp
            $display->update(['last_seen_at' => now()]);

            // Check if display has an active template
            if (!$display->template_id) {
                return response()->json([
                    'success' => true,
                    'has_template' => false,
                    'message' => 'No active template for this display',
                    'display' => [
                        'id' => $display->id,
                        'name' => $display->name,
                        'connection_code' => $display->connection_code,
                        'online' => $display->online,
                    ],
                ]);
            }

            // Get the template with all necessary data
            $template = $display->template;
            
            if (!$template) {
                // Template was deleted, clear it from display
                $display->update(['template_id' => null]);
                
                return response()->json([
                    'success' => true,
                    'has_template' => false,
                    'message' => 'Template no longer exists, cleared from display',
                    'display' => [
                        'id' => $display->id,
                        'name' => $display->name,
                        'connection_code' => $display->connection_code,
                        'online' => $display->online,
                    ],
                ]);
            }

            // Check if template is published
            if ($template->status !== 'published') {
                return response()->json([
                    'success' => true,
                    'has_template' => false,
                    'message' => 'Template is not published',
                    'display' => [
                        'id' => $display->id,
                        'name' => $display->name,
                        'connection_code' => $display->connection_code,
                        'online' => $display->online,
                    ],
                ]);
            }

            // Return template data
            return response()->json([
                'success' => true,
                'has_template' => true,
                'template' => [
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
                ],
                'display' => [
                    'id' => $display->id,
                    'name' => $display->name,
                    'connection_code' => $display->connection_code,
                    'online' => $display->online,
                    'template_id' => $display->template_id,
                ],
                'deployment' => [
                    'deployed_at' => $display->updated_at->toISOString(),
                    'last_checked' => now()->toISOString(),
                ],
            ]);

        } catch (\Exception $e) {
            Log::error('WebSocket template check failed', [
                'error' => $e->getMessage(),
                'request' => $request->all(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Template check failed',
                'error' => $e->getMessage(),
            ], 500);
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
