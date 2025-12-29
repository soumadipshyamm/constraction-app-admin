<?php

namespace App\Models\Admin;

use App\Models\Company\Company_role;
use App\Models\Company\CompanyUser;
use App\Models\Subscription\SubscriptionPackage;
use App\Models\SubscriptionCompany;
use App\Traits\HasRolesAndPermissions;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Webpatser\Uuid\Uuid;

class CompanyManagment extends Authenticatable
{
    // use SoftDeletes;
    // use HasPermissionsTrait;
    use HasRolesAndPermissions,SoftDeletes;
    protected $guarded = [];
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
    }
    public function subscription()
    {
        return $this->belongsTo(SubscriptionPackage::class, 'is_subscribed', 'id');
    }
    public function isSubscribed()
    {
        return $this->hasMany(SubscriptionCompany::class, 'company_id', 'id');
    }

    // public function companyUserRole()
    // {
    //     return $this->belongsToMany(Company_role::class, 'company_user_roles', 'company_user_id', 'company_role_id');
    // }

    public function companyUsers()
    {
        return $this->hasOne(CompanyUser::class, 'company_id', 'id');
    }
    public function companyTeams()
    {
        return $this->hasMany(CompanyUser::class, 'company_id', 'id');
    }
    public function companyUserRole()
    {
        return $this->belongsTo(Company_role::class, 'company_role_id');
    }
    public function companyuser()
    {
        return $this->belongsToMany(CompanyUser::class, 'companyuser_roles', 'company_id', 'company_user_id');
    }
}
