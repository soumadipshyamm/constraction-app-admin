<?php

namespace App\Models\Admin;

use App\Models\User;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class AdminRole extends Model
{
    use Sluggable;
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
            ],
        ];
    }
    protected $fillable = [
        'name'
    ];


    public function adminUser()
    {
        return $this->belongsToMany(
            User::class,
            'admin_user_roles',
            'user_id',
            'admin_role_id'
        );
    }


    public function permissions()
    {
        return $this->belongsToMany(AdminPermission::class, 'admin_user_role_permissions');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'admin_user_roles');
    }

    public function getAllPermissions(array $permissions)
    {
        return AdminPermission::whereIn('slug', $permissions)->get();
    }

    public function hasPermission($permission)
    {
        return (bool) $this->permissions->where('slug', $permission)->count();
    }

    public function givePermissionsTo($permissions)
    {
        // dd($permissions);
        $permissions = $this->getAllPermissions($permissions);
        if ($permissions === null) {
            return $this;
        }
        $this->permissions()->saveMany($permissions);
        return $this;
    }
}
