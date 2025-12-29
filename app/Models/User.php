<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Admin\AdminRole;
use Laravel\Passport\HasApiTokens;
use App\Models\Company\CompanyUser;
use App\Models\Admin\CompanyManagment;
use Illuminate\Notifications\Notifiable;
use App\Models\Admin\AdminUserPermission;
use App\Models\Company\Project;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'uuid',
        'app_id',
        'email',
        'mobile_number',
        'password',
        'username',
        'admin_role_id',
        'verification_code',
        'email_verified_at',
        'mobile_number_verified_at',
        'is_online',
        'is_active',
        'is_subscribed',
        'is_blocked',
        'last_login_at',
        'last_logout_at',
        'last_login_ip',
        'address',
        'state',
        'city',
        // 'profile_image',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function adminUserRole()
    {
        return $this->belongsToMany(
            AdminRole::class,
            'admin_user_roles',
            'user_id',
            'admin_role_id',
        );
    }


    public function role()
    {
        return $this->belongsTo(AdminRole::class, 'admin_role_id');
    }
    // public function userPermission()
    // {
    //    return \DB::select('SELECT `admin_user_permissions`.*, `admin_menus`.* FROM `admin_user_permissions` INNER JOIN `admin_menus` ON `admin_menus`.`id` = `admin_user_permissions`.`menu_id` WHERE `admin_user_permissions`.`user_id` ='.auth()->user()->id);
    // }

    public function userPermission()
    {
        return $this->hasMany(AdminUserPermission::class, 'user_id');
    }

    // public function menus()
    // {
    //     return $this->hasMany(AdminMenu::class,'id');
    // }

    // public function menu()
    // {
    //     return $this->belongsToMany(
    //         AdminUserPermission::class,
    //         'admin_menus',
    //         'user_id',
    //         'menu_id',
    //     );
    // }

    public function projectmembers()
    {
        return $this->belongsToMany(Project::class,'project_assings','user_id', 'project_id');
    }
}
