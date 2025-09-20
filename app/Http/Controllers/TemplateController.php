<?php

namespace App\Http\Controllers;

use App\Models\Template;
use App\Services\TemplateService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class TemplateController extends Controller
{
    public function __construct(
        private TemplateService $templateService
    ) {}

    /**
     * Display the template gallery.
     */
    public function index(Request $request): View
    {
        $query = Template::with(['creator', 'deployments'])
            ->published()
            ->orderBy('usage_count', 'desc');

        // Filter by category
        if ($request->filled('category') && $request->category !== 'all') {
            $query->byCategory($request->category);
        }

        // Filter by type
        if ($request->filled('type')) {
            $query->byType($request->type);
        }

        // Search by name or description
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereJsonContains('tags', $search);
            });
        }

        $templates = $query->paginate(12);

        return view('templates', compact('templates'));
    }

    /**
     * Display the template management dashboard.
     */
    public function management()
    {
        // Get active deployments with their templates and displays (exclude removed)
        $deployments = \App\Models\TemplateDeployment::with(['template', 'deployer'])
            ->where('status', 'active')
            ->orderBy('deployed_at', 'desc')
            ->get();

        // Get template statistics
        $activeTemplates = Template::where('status', 'published')->count();
        $deployedDisplays = \App\Models\Display::whereNotNull('template_id')->count();
        $pendingUpdates = \App\Models\TemplateDeployment::where('status', 'pending')->count();
        $failedDeployments = \App\Models\TemplateDeployment::where('status', 'failed')->count();

        // Get recent activity
        $recentActivity = \App\Models\TemplateDeployment::with(['template', 'deployer'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Get template performance data
        $templatePerformance = Template::withCount('deployments')
            ->orderBy('deployments_count', 'desc')
            ->limit(5)
            ->get();

        return view('template-management', compact(
            'deployments',
            'activeTemplates',
            'deployedDisplays',
            'pendingUpdates',
            'failedDeployments',
            'recentActivity',
            'templatePerformance'
        ));
    }

    /**
     * Show a specific template.
     */
    public function show(Template $template): View
    {
        $template->load(['creator', 'deployments', 'versions']);
        
        return view('template-detail', compact('template'));
    }

    /**
     * Preview a template.
     */
    public function preview(Template $template): Response
    {
        // Disable debug bar for template previews
        if (class_exists(\Barryvdh\Debugbar\LaravelDebugbar::class)) {
            app(\Barryvdh\Debugbar\LaravelDebugbar::class)->disable();
        }
        
        $htmlContent = $template->getHtmlContent();
        
        if (empty($htmlContent)) {
            abort(404, 'Template HTML not found');
        }
        
        // Remove browser logger script from template content
        $htmlContent = preg_replace('/<script id="browser-logger-active">.*?<\/script>/s', '', $htmlContent);
        
        return response($htmlContent)
            ->header('Content-Type', 'text/html; charset=utf-8')
            ->header('X-Frame-Options', 'SAMEORIGIN');
    }

    /**
     * Get template HTML content for editing.
     */
    public function getHtml(Template $template): Response
    {
        $htmlContent = $template->getHtmlContent();
        
        return response($htmlContent)
            ->header('Content-Type', 'text/html');
    }

    /**
     * Get template CSS content.
     */
    public function getCss(Template $template): Response
    {
        $cssContent = $template->getCssContent();
        
        if (empty($cssContent)) {
            abort(404, 'Template CSS not found');
        }
        
        return response($cssContent)
            ->header('Content-Type', 'text/css; charset=utf-8');
    }

    /**
     * Get template JS content.
     */
    public function getJs(Template $template): Response
    {
        $jsContent = $template->getJsContent();
        
        if (empty($jsContent)) {
            abort(404, 'Template JS not found');
        }
        
        return response($jsContent)
            ->header('Content-Type', 'application/javascript; charset=utf-8');
    }

    /**
     * Update a template.
     */
    public function update(Request $request, Template $template): JsonResponse
    {
        Log::info('Updating template', ['template_id' => $template->id, 'data' => $request->all()]);
        
        try {
            // Update basic template data
            $template->update([
                'name' => $request->input('name', $template->name),
                'description' => $request->input('description', $template->description),
            ]);
            
            // Store custom template data in the configuration JSON field
            $config = $template->configuration ?? [];
            
            // Update configuration with new data
            $config = array_merge($config, [
                'headerText' => $request->input('headerText'),
                'temperature' => $request->input('temperature'),
                'headerBgColor' => $request->input('headerBgColor'),
                'wellnessTitle' => $request->input('wellnessTitle'),
                'wellnessSubtitle' => $request->input('wellnessSubtitle'),
                'wellnessProgress' => $request->input('wellnessProgress'),
                'caringTitle' => $request->input('caringTitle'),
                'caringDoctor' => $request->input('caringDoctor'),
                'comingUpTitle' => $request->input('comingUpTitle'),
                'comingUpTime' => $request->input('comingUpTime'),
                'myCareText' => $request->input('myCareText'),
                'myCareColor' => $request->input('myCareColor'),
                'myCareAction' => $request->input('myCareAction'),
                'welcomeTitle' => $request->input('welcomeTitle'),
                'welcomeSubtitle' => $request->input('welcomeSubtitle'),
                'welcomeBgColor' => $request->input('welcomeBgColor'),
                'weatherTitle' => $request->input('weatherTitle'),
                'weatherLocation' => $request->input('weatherLocation'),
                'weatherTemp' => $request->input('weatherTemp'),
                'weatherCondition' => $request->input('weatherCondition'),
                'weatherBgColor' => $request->input('weatherBgColor'),
            ]);
            
            $template->update(['configuration' => $config]);
            
            return response()->json([
                'success' => true,
                'message' => 'Template updated successfully',
                'template' => $template->fresh()
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error updating template', ['error' => $e->getMessage()]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error updating template: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get template data for AJAX requests.
     */
    public function getTemplateData(Template $template): JsonResponse
    {
        // Get configuration data
        $config = $template->configuration ?? [];
        
        return response()->json([
            'template' => array_merge([
                'id' => $template->id,
                'name' => $template->name,
                'description' => $template->description,
                'category' => $template->category,
                'category_display_name' => $template->category_display_name,
                'type' => $template->type,
                'status' => $template->status,
                'usage_count' => $template->usage_count,
                'rating' => $template->rating,
                'rating_count' => $template->rating_count,
                'tags' => $template->tags,
                'compatibility' => $template->compatibility,
                'thumbnail_url' => $template->getThumbnailUrl(),
                'preview_url' => route('template.preview', $template),
                'created_at' => $template->created_at->format('M j, Y'),
                'creator' => [
                    'name' => $template->creator->name,
                    'initials' => $template->creator->initials(),
                ],
            ], $config),
            'features' => $this->getTemplateFeatures($template),
        ]);
    }

    /**
     * Store a new template.
     */
    public function store(Request $request): JsonResponse
    {
        Log::info('Template creation request received', [
            'request_data' => $request->except(['html_content']),
            'html_content_length' => strlen($request->html_content ?? ''),
        ]);
        
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'category' => 'required|string|in:welcome,info,events,weather,dining,entertainment,spa,healthcare,general',
                'type' => 'required|string|in:spa,component,layout',
                'html_content' => 'required|string',
                'tags' => 'nullable|array',
                'compatibility' => 'nullable|array',
            ]);

            // Add created_by to the request data
            $data = $request->all();
            $data['created_by'] = $request->user()->id;

            $template = $this->templateService->createTemplate($data, $request->html_content);
            
            return response()->json([
                'success' => true,
                'message' => 'Template created successfully',
                'template' => [
                    'id' => $template->id,
                    'name' => $template->name,
                    'preview_url' => route('template.preview', $template),
                ],
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            Log::error('Template creation failed: ' . $e->getMessage(), [
                'exception' => $e,
                'request_data' => $request->except(['html_content']),
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to create template: ' . $e->getMessage(),
            ], 500);
        }
    }



    /**
     * Get template categories for filtering.
     */
    public function getCategories(): JsonResponse
    {
        $categories = [
            'all' => 'All Categories',
            'welcome' => 'Welcome Screens',
            'info' => 'Hotel Information',
            'events' => 'Events & Activities',
            'weather' => 'Weather & News',
            'dining' => 'Dining & Events',
            'entertainment' => 'Entertainment',
            'spa' => 'Spa & Wellness',
            'general' => 'General',
        ];

        return response()->json($categories);
    }

    /**
     * Upload a template from files.
     */
    public function upload(Request $request): JsonResponse
    {
        Log::info('Template upload started', [
            'request_data' => $request->except(['html_file', 'css_file', 'js_file', 'assets']),
            'files' => array_keys($request->allFiles()),
            'user_id' => $request->user()?->id,
            'user_authenticated' => $request->user() !== null,
        ]);
        
        // Check if user is authenticated
        if (!$request->user()) {
            Log::error('Template upload failed: User not authenticated');
            return response()->json([
                'success' => false,
                'message' => 'User not authenticated',
            ], 401);
        }
        
        Log::info('Starting validation');
        Log::info('Uploaded files:', $request->allFiles());
        Log::info('Request data:', $request->except(['html_file', 'css_file', 'js_file', 'assets']));
        
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'category' => 'required|string|in:welcome,info,events,weather,dining,entertainment,spa,healthcare,general',
                'type' => 'required|string|in:spa,component,layout',
                'html_file' => 'required|file|max:51200', // 50MB - removed MIME validation
                'css_file' => 'nullable|file|max:51200', // 50MB - removed MIME validation
                'js_file' => 'nullable|file|max:51200', // 50MB - removed MIME validation
                'thumbnail' => 'nullable|file|mimes:png,jpg,jpeg,gif,svg|max:10240', // 10MB
                'assets' => 'nullable|array',
                'assets.*' => 'file',
                'tags' => 'nullable|array',
                'compatibility' => 'nullable|array',
            ]);
            Log::info('Validation passed successfully');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed:', [
                'errors' => $e->errors(),
                'request_data' => $request->except(['html_file', 'css_file', 'js_file', 'assets']),
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        }

        try {
            Log::info('Entering try block');
            // Create template data
            $data = [
                'name' => $request->name,
                'description' => $request->description,
                'category' => $request->category,
                'type' => $request->type,
                'tags' => $request->tags ?? [],
                'compatibility' => $request->compatibility ?? ['tv', 'tablet'],
                'status' => 'published',
                'created_by' => $request->user()->id,
                'html_file_path' => 'templates/temp-' . time() . '.html',
            ];

            // Create the template
            Log::info('Creating template', ['data' => $data]);
            $template = Template::create($data);
            Log::info('Template created successfully', ['template_id' => $template->id]);

            // Process HTML file
            $htmlContent = $request->file('html_file')->getContent();
            
            // Update HTML to reference separate CSS and JS files
            $htmlContent = $this->updateFileReferences($htmlContent, $template);
            
            // Process CSS file if provided
            if ($request->hasFile('css_file')) {
                $cssFile = $request->file('css_file');
                $cssContent = $cssFile->getContent();
                $cssFilename = $cssFile->getClientOriginalName();
                Log::info('Saving CSS content', ['css_length' => strlen($cssContent), 'filename' => $cssFilename]);
                $template->saveCssContent($cssContent, $cssFilename);
                Log::info('CSS content saved successfully');
            }

            // Process JS file if provided
            if ($request->hasFile('js_file')) {
                $jsFile = $request->file('js_file');
                $jsContent = $jsFile->getContent();
                $jsFilename = $jsFile->getClientOriginalName();
                Log::info('Saving JS content', ['js_length' => strlen($jsContent), 'filename' => $jsFilename]);
                $template->saveJsContent($jsContent, $jsFilename);
                Log::info('JS content saved successfully');
            }

            // Process assets if provided
            if ($request->hasFile('assets')) {
                $assetsPath = $this->processAssets($template, $request->file('assets'));
                // Update HTML to use correct asset paths
                $htmlContent = $this->updateAssetPaths($htmlContent, $assetsPath);
            }

            // Save the HTML content
            Log::info('Saving HTML content', ['html_length' => strlen($htmlContent)]);
            $template->saveHtmlContent($htmlContent);
            Log::info('HTML content saved successfully');

            // Process thumbnail if provided
            if ($request->hasFile('thumbnail')) {
                Log::info('Processing uploaded thumbnail');
                $thumbnailPath = $this->processThumbnail($template, $request->file('thumbnail'));
                $template->update(['thumbnail_path' => $thumbnailPath]);
                Log::info('Thumbnail processed successfully', ['path' => $thumbnailPath]);
            } else {
                // Generate default thumbnail
                Log::info('Generating default thumbnail');
                $template->generateThumbnail();
                Log::info('Default thumbnail generated successfully');
            }

            Log::info('Template upload completed successfully', [
                'template_id' => $template->id,
                'template_name' => $template->name,
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Template uploaded successfully',
                'template' => [
                    'id' => $template->id,
                    'name' => $template->name,
                    'preview_url' => route('template.preview', $template),
                ],
            ]);

        } catch (\Exception $e) {
            Log::error('Template upload failed: ' . $e->getMessage(), [
                'exception' => $e,
                'request_data' => $request->except(['html_file', 'css_file', 'js_file', 'assets']),
                'trace' => $e->getTraceAsString(),
            ]);
            Log::error('Exception caught in upload method');
            
        return response()->json([
            'success' => false,
            'message' => 'Failed to upload template: ' . $e->getMessage(),
        ], 500);
        }
    }

    /**
     * Delete a template and all its associated files.
     */
    public function destroy(Template $template): JsonResponse
    {
        try {
            Log::info('Template deletion started', ['template_id' => $template->id, 'template_name' => $template->name]);
            
            // Delete all associated files
            $this->deleteTemplateFiles($template);
            
            // Delete the template from database
            $template->delete();
            
            Log::info('Template deleted successfully', ['template_id' => $template->id]);
            
            return response()->json([
                'success' => true,
                'message' => 'Template deleted successfully',
            ]);
            
        } catch (\Exception $e) {
            Log::error('Template deletion failed: ' . $e->getMessage(), [
                'template_id' => $template->id,
                'exception' => $e,
                'trace' => $e->getTraceAsString(),
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete template: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Delete all files associated with a template.
     */
    private function deleteTemplateFiles(Template $template): void
    {
        $templateId = $template->id;
        
        // Delete HTML content file
        if ($template->html_file_path && Storage::disk('local')->exists($template->html_file_path)) {
            Storage::disk('local')->delete($template->html_file_path);
            Log::info('Deleted HTML file', ['path' => $template->html_file_path]);
        }
        
        // Delete CSS file
        if ($template->css_file_path && Storage::disk('local')->exists($template->css_file_path)) {
            Storage::disk('local')->delete($template->css_file_path);
            Log::info('Deleted CSS file', ['path' => $template->css_file_path]);
        }
        
        // Delete JS file
        if ($template->js_file_path && Storage::disk('local')->exists($template->js_file_path)) {
            Storage::disk('local')->delete($template->js_file_path);
            Log::info('Deleted JS file', ['path' => $template->js_file_path]);
        }
        
        // Delete thumbnail
        if ($template->thumbnail_path && Storage::disk('public')->exists($template->thumbnail_path)) {
            Storage::disk('public')->delete($template->thumbnail_path);
            Log::info('Deleted thumbnail', ['path' => $template->thumbnail_path]);
        }
        
        // Delete assets directory
        $assetsPath = 'templates/' . $templateId . '/assets';
        if (Storage::disk('public')->exists($assetsPath)) {
            Storage::disk('public')->deleteDirectory($assetsPath);
            Log::info('Deleted assets directory', ['path' => $assetsPath]);
        }
        
        // Delete thumbnail directory
        $thumbnailDir = 'templates/' . $templateId . '/thumbnail';
        if (Storage::disk('public')->exists($thumbnailDir)) {
            Storage::disk('public')->deleteDirectory($thumbnailDir);
            Log::info('Deleted thumbnail directory', ['path' => $thumbnailDir]);
        }
        
        // Force delete the entire template directory from local storage
        $templateDir = 'templates/' . $templateId;
        if (Storage::disk('local')->exists($templateDir)) {
            Storage::disk('local')->deleteDirectory($templateDir);
            Log::info('Deleted template directory from local storage', ['path' => $templateDir]);
        }
        
        // Also try to delete from public storage if it exists there
        if (Storage::disk('public')->exists($templateDir)) {
            Storage::disk('public')->deleteDirectory($templateDir);
            Log::info('Deleted template directory from public storage', ['path' => $templateDir]);
        }
    }

    /**
     * Update HTML to reference separate CSS and JS files.
     */
    private function updateFileReferences(string $html, Template $template): string
    {
        // Update CSS link to point to the separate CSS file
        $cssUrl = route('template.css', $template);
        $html = preg_replace('/<link[^>]*rel=["\']stylesheet["\'][^>]*>/i', '<link rel="stylesheet" href="' . $cssUrl . '">', $html);
        
        // Update JS script to point to the separate JS file
        $jsUrl = route('template.js', $template);
        $html = preg_replace('/<script[^>]*src=["\'][^"\']*\.js["\'][^>]*><\/script>/i', '<script src="' . $jsUrl . '"></script>', $html);
        
        return $html;
    }


    /**
     * Process uploaded assets.
     */
    private function processAssets(Template $template, array $assets): string
    {
        $baseAssetsPath = 'templates/' . $template->id . '/assets';
        Storage::disk('public')->makeDirectory($baseAssetsPath);

        foreach ($assets as $asset) {
            $originalPath = $asset->getClientOriginalName();
            
            // For now, store all assets directly in the assets directory
            // TODO: Implement smart directory structure detection based on CSS references
            $asset->storeAs($baseAssetsPath, $originalPath, 'public');
        }

        return $baseAssetsPath;
    }

    /**
     * Deploy a template to selected displays.
     */
    public function deploy(Request $request)
    {
        try {
            Log::info('Template deployment started', [
                'user_id' => auth()->user()?->id,
                'request_data' => $request->all(),
            ]);

            $request->validate([
                'template_id' => 'required|exists:templates,id',
                'display_ids' => 'required|array|min:1',
                'display_ids.*' => 'exists:displays,id',
                'deployment_config' => 'nullable|json',
                'scheduled_at' => 'nullable|date|after:now',
            ]);

            $template = Template::findOrFail($request->template_id);
            $displayIds = $request->display_ids;
            $deploymentConfig = $request->deployment_config ? json_decode($request->deployment_config, true) : [];
            $scheduledAt = $request->scheduled_at ? \Carbon\Carbon::parse($request->scheduled_at) : null;

            $deployments = [];
            $errors = [];

            foreach ($displayIds as $displayId) {
                try {
                    // Check if display is online
                    $display = \App\Models\Display::findOrFail($displayId);
                    if (!$display->online) {
                        $errors[] = "Display {$display->name} is offline and cannot receive deployments.";
                        continue;
                    }

                    // Create deployment record
                    $deployment = $template->deployToDisplay($displayId, $deploymentConfig);
                    
                    // Set scheduled time if provided
                    if ($scheduledAt) {
                        $deployment->update(['scheduled_at' => $scheduledAt]);
                        
                        // If scheduled for immediate deployment (within 1 minute), process it now
                        if ($scheduledAt->diffInMinutes(now()) <= 1) {
                            $deployment->update([
                                'status' => 'deploying',
                                'deployed_at' => now(),
                            ]);
                            
                            // Update display's current template
                            $display->update(['template_id' => $template->id]);
                            
                            // Mark deployment as active
                            $deployment->update(['status' => 'active']);

                            // Broadcast template update to display
                            Log::info('Broadcasting immediate scheduled template update', [
                                'display_id' => $display->id,
                                'template_id' => $template->id,
                                'action' => 'deploy',
                            ]);
                            
                            $event = new \App\Events\TemplateUpdate($display, $template, 'deploy');
                            broadcast($event);
                            
                            Log::info('Immediate scheduled template update broadcast sent', [
                                'display_id' => $display->id,
                                'template_id' => $template->id,
                            ]);
                        }
                    } else {
                        // Deploy immediately
                        $deployment->update([
                            'status' => 'deploying',
                            'deployed_at' => now(),
                        ]);
                        
                        // Update display's current template
                        $display->update(['template_id' => $template->id]);
                        
                        // Mark deployment as active
                        $deployment->update(['status' => 'active']);

                        // Broadcast template update to display
                        Log::info('Broadcasting template update', [
                            'display_id' => $display->id,
                            'template_id' => $template->id,
                            'action' => 'deploy',
                        ]);
                        
                        $event = new \App\Events\TemplateUpdate($display, $template, 'deploy');
                        broadcast($event);
                        
                        Log::info('Template update broadcast sent', [
                            'display_id' => $display->id,
                            'template_id' => $template->id,
                            'action' => 'deploy',
                            'event_class' => get_class($event),
                        ]);
                    }

                    $deployments[] = $deployment;

                } catch (\Exception $e) {
                    Log::error('Deployment failed for display', [
                        'display_id' => $displayId,
                        'template_id' => $template->id,
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString(),
                    ]);
                    $errors[] = "Failed to deploy to display {$displayId}: " . $e->getMessage();
                }
            }

            if (empty($deployments)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No deployments were successful. ' . implode(' ', $errors)
                ], 400);
            }

            $message = "Successfully deployed '{$template->name}' to " . count($deployments) . " display(s).";
            if (!empty($errors)) {
                $message .= " Errors: " . implode(' ', $errors);
            }

            Log::info('Template deployment completed', [
                'template_id' => $template->id,
                'template_name' => $template->name,
                'deployments_count' => count($deployments),
                'errors_count' => count($errors),
                'deployments' => collect($deployments)->pluck('id')->toArray(),
            ]);

            return response()->json([
                'success' => true,
                'message' => $message,
                'deployments' => $deployments
            ]);

        } catch (\Exception $e) {
            Log::error('Template deployment failed', [
                'error' => $e->getMessage(),
                'request' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Deployment failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove a template from a display.
     */
    public function remove(\App\Models\TemplateDeployment $deployment)
    {
        try {
            // Update the deployment status to 'removed'
            $deployment->update([
                'status' => 'removed',
                'deployed_at' => null,
            ]);

            // Clear the template from the display
                $display = \App\Models\Display::find($deployment->display_id);
                if ($display) {
                    $display->update(['template_id' => null]);
                    
                    // Broadcast template removal to display
                    broadcast(new \App\Events\TemplateUpdate($display, null, 'remove'));
                }

            Log::info('Template removed from display', [
                'deployment_id' => $deployment->id,
                'template_id' => $deployment->template_id,
                'display_id' => $deployment->display_id,
                'removed_by' => auth()->user()?->id,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Template removed successfully from display.',
            ]);

        } catch (\Exception $e) {
            Log::error('Template removal failed', [
                'deployment_id' => $deployment->id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to remove template: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update asset paths in HTML content.
     */
    private function updateAssetPaths(string $html, string $assetsPath): string
    {
        // Update relative asset paths to use the stored assets
        $baseUrl = Storage::url($assetsPath);
        
        // Update image sources in HTML - handle both direct files and subdirectory files
        $html = preg_replace('/src="([^"]*\.(?:png|jpg|jpeg|gif|svg|ico))"/', 'src="' . $baseUrl . '/$1"', $html);
        
        // Update CSS/JS links in HTML - handle both direct files and subdirectory files  
        $html = preg_replace('/href="([^"]*\.(?:css|js))"/', 'href="' . $baseUrl . '/$1"', $html);
        
        // Update background images in CSS - handle both direct files and subdirectory files
        $html = preg_replace('/url\([\'"]?([^)]*\.(?:png|jpg|jpeg|gif|svg|ico))[\'"]?\)/', 'url("' . $baseUrl . '/$1")', $html);
        
        return $html;
    }

    /**
     * Process uploaded thumbnail.
     */
    private function processThumbnail(Template $template, $thumbnail): string
    {
        $thumbnailPath = 'templates/' . $template->id . '/thumbnail';
        Storage::disk('public')->makeDirectory($thumbnailPath);

        $filename = 'thumbnail-' . time() . '.' . $thumbnail->getClientOriginalExtension();
        $thumbnail->storeAs($thumbnailPath, $filename, 'public');

        return $thumbnailPath . '/' . $filename;
    }

    /**
     * Get template features for display.
     */
    private function getTemplateFeatures(Template $template): array
    {
        $features = [];

        // Add features based on template type and components
        if ($template->type === 'spa') {
            $features[] = 'Single Page Application';
            $features[] = 'Interactive Navigation';
        }

        if ($template->components) {
            $features[] = 'Modular Components';
        }

        if ($template->scripts) {
            $features[] = 'JavaScript Functionality';
        }

        if (in_array('tv', $template->compatibility ?? [])) {
            $features[] = 'TV Optimized';
        }

        if (in_array('tablet', $template->compatibility ?? [])) {
            $features[] = 'Tablet Compatible';
        }

        if (in_array('mobile', $template->compatibility ?? [])) {
            $features[] = 'Mobile Responsive';
        }

        // Add category-specific features
        switch ($template->category) {
            case 'welcome':
                $features[] = 'Guest Greeting';
                $features[] = 'Room Information';
                break;
            case 'info':
                $features[] = 'Hotel Services';
                $features[] = 'Local Information';
                break;
            case 'weather':
                $features[] = 'Live Weather Data';
                $features[] = 'Forecast Display';
                break;
            case 'entertainment':
                $features[] = 'Media Integration';
                $features[] = 'Streaming Services';
                break;
        }

        return array_unique($features);
    }

    /**
     * Serve template assets (images, fonts, etc.)
     */
    public function assets(Template $template, $path = '')
    {
        try {
            $assetsPath = 'templates/' . $template->id . '/assets';
            
            if ($path) {
                $fullPath = $assetsPath . '/' . $path;
            } else {
                $fullPath = $assetsPath;
            }

            // Check if the asset exists in public storage
            if (Storage::disk('public')->exists($fullPath)) {
                $filePath = Storage::disk('public')->path($fullPath);
                $mimeType = mime_content_type($filePath);
                
                return response()->file($filePath, [
                    'Content-Type' => $mimeType,
                    'Cache-Control' => 'public, max-age=3600', // Cache for 1 hour
                ]);
            }

            // If it's a directory, return a 403
            if (Storage::disk('public')->exists($fullPath) && is_dir(Storage::disk('public')->path($fullPath))) {
                return response()->json(['error' => 'Directory listing not allowed'], 403);
            }

            return response()->json(['error' => 'Asset not found'], 404);

        } catch (\Exception $e) {
            Log::error('Template asset serving failed', [
                'template_id' => $template->id,
                'path' => $path,
                'error' => $e->getMessage(),
            ]);

            return response()->json(['error' => 'Internal server error'], 500);
        }
    }

    /**
     * Serve the Tizen widget package and configuration files for displays to download.
     */
    public function tizenApp()
    {
        $tizenDir = public_path('tizen');
        
        // Check if tizen directory exists
        if (!is_dir($tizenDir)) {
            return response()->json([
                'error' => 'Tizen directory not found',
                'message' => 'Please ensure the tizen directory exists in the public folder with INNSTREAM.wgt and sssp_config.xml files'
            ], 404);
        }

        $viewerWgtPath = $tizenDir . '/INNSTREAM.wgt';
        $configXmlPath = $tizenDir . '/sssp_config.xml';
        
        // Check if both required files exist
        if (!file_exists($viewerWgtPath) || !file_exists($configXmlPath)) {
            return response()->json([
                'error' => 'Required Tizen files not found',
                'message' => 'Please ensure both INNSTREAM.wgt and sssp_config.xml are in the public/tizen directory',
                'missing_files' => [
                    'INNSTREAM.wgt' => !file_exists($viewerWgtPath),
                    'sssp_config.xml' => !file_exists($configXmlPath)
                ]
            ], 404);
        }

        // Return directory listing with both files
        $files = [
            [
                'name' => 'INNSTREAM.wgt',
                'size' => filesize($viewerWgtPath),
                'last_modified' => date('d/m/Y H:i:s', filemtime($viewerWgtPath)),
                'url' => url('apps/tizen/INNSTREAM.wgt')
            ],
            [
                'name' => 'sssp_config.xml',
                'size' => filesize($configXmlPath),
                'last_modified' => date('d/m/Y H:i:s', filemtime($configXmlPath)),
                'url' => url('apps/tizen/sssp_config.xml')
            ]
        ];

        return response()->view('tizen-directory', compact('files'))
            ->header('Content-Type', 'text/html')
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
            ->header('Access-Control-Allow-Headers', 'Content-Type, Accept, Authorization, X-Requested-With');
    }

    /**
     * Serve the Tizen INNSTREAM.wgt file.
     */
    public function tizenViewer()
    {
        $viewerPath = public_path('tizen/INNSTREAM.wgt');
        
        if (!file_exists($viewerPath)) {
            return response()->json([
                'error' => 'INNSTREAM.wgt not found',
                'message' => 'Please ensure INNSTREAM.wgt is placed in the public/tizen directory'
            ], 404);
        }

        $fileContent = file_get_contents($viewerPath);
        
        return response($fileContent, 200, [
            'Content-Type' => 'application/vnd.tizen.widget',
            'Content-Disposition' => 'attachment; filename="INNSTREAM.wgt"',
            'Content-Length' => strlen($fileContent),
            'Cache-Control' => 'public, max-age=3600',
            'Access-Control-Allow-Origin' => '*',
            'Access-Control-Allow-Methods' => 'GET, POST, PUT, DELETE, OPTIONS',
            'Access-Control-Allow-Headers' => 'Content-Type, Accept, Authorization, X-Requested-With',
        ]);
    }

    /**
     * Serve the Tizen sssp_config.xml file.
     */
    public function tizenConfig()
    {
        $configPath = public_path('tizen/sssp_config.xml');
        
        if (!file_exists($configPath)) {
            return response()->json([
                'error' => 'sssp_config.xml not found',
                'message' => 'Please ensure sssp_config.xml is placed in the public/tizen directory'
            ], 404);
        }

        $response = response()->file($configPath);
        
        $response->headers->set('Content-Type', 'application/xml');
        $response->headers->set('Cache-Control', 'public, max-age=3600');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Accept, Authorization, X-Requested-With');
        
        return $response;
    }
} 