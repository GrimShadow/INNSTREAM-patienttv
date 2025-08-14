<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Template extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'category',
        'thumbnail_path',
        'html_file_path',
        'configuration',
        'components',
        'styles',
        'scripts',
        'status',
        'type',
        'version',
        'tags',
        'compatibility',
        'usage_count',
        'rating',
        'rating_count',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'configuration' => 'array',
        'components' => 'array',
        'styles' => 'array',
        'scripts' => 'array',
        'tags' => 'array',
        'compatibility' => 'array',
        'rating' => 'decimal:2',
    ];

    /**
     * Get the user who created this template.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who last updated this template.
     */
    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Get the deployments for this template.
     */
    public function deployments(): HasMany
    {
        return $this->hasMany(TemplateDeployment::class);
    }

    /**
     * Get the versions for this template.
     */
    public function versions(): HasMany
    {
        return $this->hasMany(TemplateVersion::class);
    }

    /**
     * Get the HTML content of the template.
     */
    public function getHtmlContent(): string
    {
        if (!Storage::exists($this->html_file_path)) {
            return '';
        }

        return Storage::get($this->html_file_path);
    }

    /**
     * Save the HTML content to a file.
     */
    public function saveHtmlContent(string $htmlContent): bool
    {
        $directory = 'templates/' . $this->id;
        $filename = 'template-' . $this->id . '-' . time() . '.html';
        $path = $directory . '/' . $filename;

        // Ensure directory exists
        Storage::makeDirectory($directory);

        // Save the HTML content
        if (Storage::put($path, $htmlContent)) {
            $this->update(['html_file_path' => $path]);
            return true;
        }

        return false;
    }

    /**
     * Generate a preview image for the template.
     */
    public function generateThumbnail(): bool
    {
        // This would typically use a headless browser like Puppeteer
        // For now, we'll create a placeholder
        $directory = 'templates/' . $this->id . '/thumbnails';
        $filename = 'thumbnail-' . $this->id . '.svg';
        $path = $directory . '/' . $filename;

        // Use public disk for web-accessible files
        Storage::disk('public')->makeDirectory($directory);

        // Create a simple placeholder image (in production, use a proper screenshot service)
        $placeholder = $this->createPlaceholderImage();
        
        if (Storage::disk('public')->put($path, $placeholder)) {
            $this->update(['thumbnail_path' => $path]);
            return true;
        }

        return false;
    }

    /**
     * Create a placeholder thumbnail image.
     */
    private function createPlaceholderImage(): string
    {
        // Create a more detailed SVG placeholder based on category
        $categoryIcons = [
            'healthcare' => '🏥',
            'welcome' => '🏨',
            'dining' => '🍽️',
            'weather' => '🌤️',
            'entertainment' => '🎬',
            'spa' => '💆',
            'info' => 'ℹ️',
            'events' => '📅',
            'general' => '📺'
        ];
        
        $icon = $categoryIcons[$this->category] ?? '📺';
        $bgColor = $this->getCategoryColor();
        
        $svg = '<svg width="300" height="200" xmlns="http://www.w3.org/2000/svg">
            <rect width="300" height="200" fill="' . $bgColor . '"/>
            <rect x="20" y="20" width="260" height="160" rx="8" fill="#1f2937" opacity="0.9"/>
            <text x="150" y="90" text-anchor="middle" fill="#ffffff" font-family="Arial, sans-serif" font-size="32">' . $icon . '</text>
            <text x="150" y="120" text-anchor="middle" fill="#ffffff" font-family="Arial, sans-serif" font-size="14" font-weight="bold">' . htmlspecialchars($this->name) . '</text>
            <text x="150" y="140" text-anchor="middle" fill="#9ca3af" font-family="Arial, sans-serif" font-size="12">' . htmlspecialchars($this->category_display_name) . '</text>
        </svg>';

        return $svg;
    }
    
    /**
     * Get category-specific background color for thumbnails.
     */
    private function getCategoryColor(): string
    {
        return match($this->category) {
            'healthcare' => '#1e40af', // Blue
            'welcome' => '#059669',    // Green
            'dining' => '#dc2626',     // Red
            'weather' => '#0891b2',    // Cyan
            'entertainment' => '#7c3aed', // Purple
            'spa' => '#ec4899',        // Pink
            'info' => '#f59e0b',       // Amber
            'events' => '#10b981',     // Emerald
            default => '#6b7280',      // Gray
        };
    }

    /**
     * Get the thumbnail URL.
     */
    public function getThumbnailUrl(): string
    {
        if ($this->thumbnail_path && Storage::disk('public')->exists($this->thumbnail_path)) {
            return Storage::url($this->thumbnail_path);
        }

        // Return a default placeholder
        return asset('images/template-placeholder.png');
    }

    /**
     * Create a new version of this template.
     */
    public function createVersion(string $version, string $changelog = null): TemplateVersion
    {
        return $this->versions()->create([
            'version' => $version,
            'html_file_path' => $this->html_file_path,
            'configuration' => $this->configuration,
            'components' => $this->components,
            'styles' => $this->styles,
            'scripts' => $this->scripts,
            'changelog' => $changelog,
            'created_by' => auth()->id(),
        ]);
    }

    /**
     * Deploy this template to a display.
     */
    public function deployToDisplay(string $displayId, array $config = []): TemplateDeployment
    {
        $deployment = $this->deployments()->create([
            'display_id' => $displayId,
            'status' => 'pending',
            'deployment_config' => $config,
            'deployed_by' => auth()->id(),
        ]);

        // Increment usage count
        $this->increment('usage_count');

        return $deployment;
    }

    /**
     * Scope to filter by category.
     */
    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope to filter by status.
     */
    public function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope to filter by type.
     */
    public function scopeByType($query, string $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope to filter by tags.
     */
    public function scopeByTags($query, array $tags)
    {
        return $query->whereJsonContains('tags', $tags);
    }

    /**
     * Scope to get published templates.
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    /**
     * Get the average rating as a percentage.
     */
    public function getRatingPercentageAttribute(): int
    {
        if (!$this->rating) {
            return 0;
        }

        return (int) ($this->rating * 20); // Convert 0-5 scale to 0-100
    }

    /**
     * Get the display name for the category.
     */
    public function getCategoryDisplayNameAttribute(): string
    {
        $categories = [
            'welcome' => 'Welcome Screens',
            'info' => 'Hotel Information',
            'events' => 'Events & Activities',
            'weather' => 'Weather & News',
            'dining' => 'Dining & Events',
            'entertainment' => 'Entertainment',
            'spa' => 'Spa & Wellness',
            'healthcare' => 'Healthcare',
            'general' => 'General',
        ];

        return $categories[$this->category] ?? ucfirst($this->category);
    }

    /**
     * Get the status badge color.
     */
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'draft' => 'gray',
            'published' => 'green',
            'archived' => 'red',
            default => 'gray',
        };
    }
} 