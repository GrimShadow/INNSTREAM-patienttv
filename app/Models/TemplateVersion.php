<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TemplateVersion extends Model
{
    use HasFactory;

    protected $fillable = [
        'template_id',
        'version',
        'html_file_path',
        'configuration',
        'components',
        'styles',
        'scripts',
        'changelog',
        'created_by',
    ];

    protected $casts = [
        'configuration' => 'array',
        'components' => 'array',
        'styles' => 'array',
        'scripts' => 'array',
    ];

    /**
     * Get the template for this version.
     */
    public function template(): BelongsTo
    {
        return $this->belongsTo(Template::class);
    }

    /**
     * Get the user who created this version.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Scope to filter by version.
     */
    public function scopeByVersion($query, string $version)
    {
        return $query->where('version', $version);
    }

    /**
     * Scope to get latest versions.
     */
    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }
} 