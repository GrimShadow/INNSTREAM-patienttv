<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Display;
use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class DisplayTemplateController extends Controller
{
    /**
     * Check for active template for a specific display.
     * This endpoint is called by displays to see if they have an active template to display.
     */
    public function checkTemplate(Request $request): JsonResponse
    {
        try {
            // Get display identifier from request
            $displayId = $request->input('display_id');
            $connectionCode = $request->input('connection_code');
            $macAddress = $request->input('mac_address');
            
            if (!$displayId && !$connectionCode && !$macAddress) {
                return response()->json([
                    'success' => false,
                    'message' => 'Display identifier required (display_id, connection_code, or mac_address)',
                ], 400);
            }

            // Find the display
            $display = null;
            if ($displayId) {
                $display = Display::find($displayId);
            } elseif ($connectionCode) {
                $display = Display::where('connection_code', $connectionCode)->first();
            } elseif ($macAddress) {
                $display = Display::where('mac_address', $macAddress)->first();
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
            $template = Template::find($display->template_id);
            
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

            // Get assets list
            $assets = $this->getTemplateAssets($template);

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
                    'assets' => $assets,
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
            Log::error('Display template check failed', [
                'error' => $e->getMessage(),
                'request' => $request->all(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Internal server error',
            ], 500);
        }
    }

    /**
     * Get template content for a specific display.
     * This endpoint returns the actual HTML, CSS, and JS content.
     */
    public function getTemplateContent(Request $request): JsonResponse
    {
        try {
            $templateId = $request->input('template_id');
            $displayId = $request->input('display_id');
            
            if (!$templateId || !$displayId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Template ID and Display ID required',
                ], 400);
            }

            // Verify the display has this template
            $display = Display::find($displayId);
            if (!$display || $display->template_id != $templateId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Display does not have access to this template',
                ], 403);
            }

            $template = Template::find($templateId);
            if (!$template) {
                return response()->json([
                    'success' => false,
                    'message' => 'Template not found',
                ], 404);
            }

            // Get template content
            $htmlContent = $template->getHtmlContent();
            $cssContent = $template->getCssContent();
            $jsContent = $template->getJsContent();

            // Get assets list
            $assets = $this->getTemplateAssets($template);

            return response()->json([
                'success' => true,
                'template' => [
                    'id' => $template->id,
                    'name' => $template->name,
                    'html_content' => $htmlContent,
                    'css_content' => $cssContent,
                    'js_content' => $jsContent,
                    'configuration' => $template->configuration,
                    'assets_url' => route('template.assets', $template->id),
                    'assets' => $assets,
                ],
            ]);

        } catch (\Exception $e) {
            Log::error('Template content retrieval failed', [
                'error' => $e->getMessage(),
                'request' => $request->all(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Internal server error',
            ], 500);
        }
    }

    /**
     * Report display status and capabilities.
     * This endpoint allows displays to report their status and capabilities.
     */
    public function reportStatus(Request $request): JsonResponse
    {
        try {
            $displayId = $request->input('display_id');
            $connectionCode = $request->input('connection_code');
            $macAddress = $request->input('mac_address');
            
            if (!$displayId && !$connectionCode && !$macAddress) {
                return response()->json([
                    'success' => false,
                    'message' => 'Display identifier required',
                ], 400);
            }

            // Find the display
            $display = null;
            if ($displayId) {
                $display = Display::find($displayId);
            } elseif ($connectionCode) {
                $display = Display::where('connection_code', $connectionCode)->first();
            } elseif ($macAddress) {
                $display = Display::where('mac_address', $macAddress)->first();
            }

            if (!$display) {
                return response()->json([
                    'success' => false,
                    'message' => 'Display not found',
                ], 404);
            }

            // Update display status
            $display->update([
                'online' => true,
                'last_seen_at' => now(),
                'last_message' => $request->input('message', 'Status update'),
                'ip_address' => $request->ip(),
                'app_version' => $request->input('app_version'),
                'os' => $request->input('os'),
                'version' => $request->input('version'),
                'firmware_version' => $request->input('firmware_version'),
                'capabilities' => $request->input('capabilities', []),
                'configuration' => $request->input('configuration', []),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully',
                'display' => [
                    'id' => $display->id,
                    'name' => $display->name,
                    'connection_code' => $display->connection_code,
                    'online' => $display->online,
                    'last_seen_at' => $display->last_seen_at->toISOString(),
                ],
            ]);

        } catch (\Exception $e) {
            Log::error('Display status report failed', [
                'error' => $e->getMessage(),
                'request' => $request->all(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Internal server error',
            ], 500);
        }
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