<?php

namespace App\Http\Controllers;

use App\Models\Display;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebSocketMessageController extends Controller
{
    /**
     * Handle WebSocket messages from displays
     */
    public function handleMessage(Request $request)
    {
        try {
            $message = $request->all();
            Log::info('WebSocket message received', $message);

            // Check if this is a template check request
            if (isset($message['event']) && $message['event'] === 'client-template-check') {
                return $this->handleTemplateCheck($message);
            }

            // Check if this is a status report
            if (isset($message['event']) && $message['event'] === 'client-status-report') {
                return $this->handleStatusReport($message);
            }

            return response()->json(['success' => false, 'message' => 'Unknown message type']);

        } catch (\Exception $e) {
            Log::error('WebSocket message handling error', [
                'error' => $e->getMessage(),
                'message' => $request->all(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json(['success' => false, 'message' => 'Message handling failed']);
        }
    }

    /**
     * Handle template check requests
     */
    private function handleTemplateCheck($message)
    {
        $data = $message['data'] ?? [];
        $displayId = $data['display_id'] ?? null;
        $connectionCode = $data['connection_code'] ?? null;

        Log::info('Processing template check request', [
            'display_id' => $displayId,
            'connection_code' => $connectionCode,
        ]);

        if (!$displayId && !$connectionCode) {
            Log::warning('Template check missing identifiers', ['data' => $data]);
            return response()->json(['success' => false, 'message' => 'Missing display ID or connection code']);
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
            return response()->json(['success' => false, 'message' => 'Display not found']);
        }

        // Update display's last seen timestamp
        $display->update(['last_seen_at' => now()]);

        // Check if display has an active template
        if (!$display->template_id) {
            $this->sendTemplateResponse($display, false, 'No active template for this display');
            return response()->json(['success' => true, 'has_template' => false]);
        }

        // Get the template with all necessary data
        $template = $display->template;
        
        if (!$template) {
            // Template was deleted, clear it from display
            $display->update(['template_id' => null]);
            $this->sendTemplateResponse($display, false, 'Template no longer exists, cleared from display');
            return response()->json(['success' => true, 'has_template' => false]);
        }

        // Check if template is published
        if ($template->status !== 'published') {
            $this->sendTemplateResponse($display, false, 'Template is not published');
            return response()->json(['success' => true, 'has_template' => false]);
        }

        // Send template data via WebSocket
        $this->sendTemplateResponse($display, true, 'Template found', $template);

        return response()->json(['success' => true, 'has_template' => true]);
    }

    /**
     * Handle status report requests
     */
    private function handleStatusReport($message)
    {
        $data = $message['data'] ?? [];
        $displayId = $data['display_id'] ?? null;
        $connectionCode = $data['connection_code'] ?? null;

        Log::info('Processing status report', [
            'display_id' => $displayId,
            'connection_code' => $connectionCode,
        ]);

        if (!$displayId && !$connectionCode) {
            return response()->json(['success' => false, 'message' => 'Missing display ID or connection code']);
        }

        // Find display by connection code or display ID
        $display = null;
        if ($connectionCode) {
            $display = Display::where('connection_code', $connectionCode)->first();
        } elseif ($displayId) {
            $display = Display::find($displayId);
        }

        if (!$display) {
            return response()->json(['success' => false, 'message' => 'Display not found']);
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
        ]);

        return response()->json(['success' => true, 'message' => 'Status updated']);
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
            // Get assets list
            $assets = $this->getTemplateAssets($template);
            
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
                'assets' => $assets,
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
     * Get template assets list
     */
    private function getTemplateAssets($template): array
    {
        try {
            $assetsPath = 'templates/' . $template->id . '/assets';
            $fullPath = storage_path('app/public/' . $assetsPath);
            
            if (!is_dir($fullPath)) {
                return [];
            }

            $assets = [];
            $iterator = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($fullPath, \RecursiveDirectoryIterator::SKIP_DOTS)
            );

            foreach ($iterator as $file) {
                if ($file->isFile()) {
                    $relativePath = str_replace($fullPath . DIRECTORY_SEPARATOR, '', $file->getPathname());
                    $relativePath = str_replace(DIRECTORY_SEPARATOR, '/', $relativePath);
                    $assets[] = $relativePath;
                }
            }

            return $assets;

        } catch (\Exception $e) {
            Log::error('Error getting template assets', [
                'template_id' => $template->id,
                'error' => $e->getMessage(),
            ]);
            return [];
        }
    }
}
