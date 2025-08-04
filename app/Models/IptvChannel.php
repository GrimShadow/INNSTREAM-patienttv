<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IptvChannel extends Model
{
    /**
     * The table associated with the model.
     */
    protected $table = 'iptv_channels';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'channel_number',
        'channel_name',
        'channel_logo',
        'protocol',
        'stream_address',
        'username',
        'password',
        'head_end_assignment',
        'status',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'channel_number' => 'integer',
        'status' => 'string',
        'protocol' => 'string',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Scope a query to only include active channels.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include inactive channels.
     */
    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }

    /**
     * Get the channel logo URL.
     */
    public function getLogoUrlAttribute()
    {
        return $this->channel_logo ? asset('storage/' . $this->channel_logo) : null;
    }

    /**
     * Get the status as a formatted string.
     */
    public function getStatusBadgeAttribute()
    {
        return $this->status === 'active' ? 'Active' : 'Inactive';
    }
}
