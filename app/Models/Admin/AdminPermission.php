<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class AdminPermission extends Model
{
    use HasFactory, sluggable;

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
            ],
        ];
    }
    protected $fillable = [
        'name',
        'group_name',
    ];

    public function scopeNotDashboard($query)
    {
        return $query->whereNotIn('slug', ['view-dashboard', 'view-delivery', 'edit-delivery']);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'admin_user_role_permissions');
    }
    public function userPermission(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'admin_user_permissions');
    }
}
