<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * Get the roles that have this permission.
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * Get the users that have this permission directly.
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * Get the categories that this permission belongs to.
     */
    public function categories()
    {
        return $this->belongsToMany(PermissionCategory::class);
    }
}
