<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Display extends Model
{
    protected $fillable = [
        'connection_code',
        'name',
        'make',
        'model',
        'online',
        'ip_address',
        'mac_address',
        'app_version',
        'os',
        'version',
        'firmware_version',
        'last_message',
        'template_id',
        'location',
        'floor',
        'room',
        'status',
        'last_seen_at',
        'configuration',
        'capabilities',
    ];

    protected $casts = [
        'online' => 'boolean',
        'last_seen_at' => 'datetime',
        'configuration' => 'array',
        'capabilities' => 'array',
    ];

    public function template(): BelongsTo
    {
        return $this->belongsTo(Template::class);
    }
}
