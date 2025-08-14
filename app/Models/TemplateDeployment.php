<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TemplateDeployment extends Model
{
    use HasFactory;

    protected $fillable = [
        'template_id',
        'display_id',
        'status',
        'deployed_at',
        'scheduled_at',
        'deployment_config',
        'error_message',
        'deployed_by',
    ];

    protected $casts = [
        'deployment_config' => 'array',
        'deployed_at' => 'datetime',
        'scheduled_at' => 'datetime',
    ];

    /**
     * Get the template for this deployment.
     */
    public function template(): BelongsTo
    {
        return $this->belongsTo(Template::class);
    }

    /**
     * Get the user who deployed this template.
     */
    public function deployer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'deployed_by');
    }

    /**
     * Scope to filter by status.
     */
    public function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope to filter by display.
     */
    public function scopeByDisplay($query, string $displayId)
    {
        return $query->where('display_id', $displayId);
    }

    /**
     * Scope to get active deployments.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope to get pending deployments.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Get the status badge color.
     */
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'pending' => 'yellow',
            'deploying' => 'blue',
            'active' => 'green',
            'failed' => 'red',
            'removed' => 'gray',
            default => 'gray',
        };
    }
} 