<?php

namespace App\Http\Controllers;

use App\Models\Template;
use App\Services\TemplateService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;

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
    public function preview(Template $template): View
    {
        $htmlContent = $template->getHtmlContent();
        
        // Check if this is a card preview request (smaller size)
        $isCardPreview = request()->has('card') || request()->header('X-Preview-Type') === 'card';
        
        return view('template-preview', compact('template', 'htmlContent', 'isCardPreview'));
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
     * Deploy a template to displays.
     */
    public function deploy(Request $request, Template $template): JsonResponse
    {
        $request->validate([
            'display_ids' => 'required|array',
            'display_ids.*' => 'string',
            'deployment_config' => 'nullable|array',
        ]);

        try {
            $deployments = $this->templateService->deployTemplate(
                $template,
                $request->display_ids,
                $request->deployment_config ?? []
            );
            
            return response()->json([
                'success' => true,
                'message' => 'Template deployed successfully to ' . count($deployments) . ' displays',
                'deployments' => $deployments,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to deploy template: ' . $e->getMessage(),
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
} 