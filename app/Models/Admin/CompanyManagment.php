<?php

namespace App\Models\Admin;

use App\Models\Company\Company_role;
use App\Models\Company\CompanyUser;
use App\Models\Subscription\SubscriptionPackage;
use App\Traits\HasRolesAndPermissions;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Webpatser\Uuid\Uuid;

class CompanyManagment extends Authenticatable
{
    // use SoftDeletes;
    // use HasPermissionsTrait;
    use HasRolesAndPermissions;
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

    // public function companyUserRole()
    // {
    //     return $this->belongsToMany(Company_role::class, 'company_user_roles', 'company_user_id', 'company_role_id');
    // }

    public function companyUserRole()
    {
        return $this->belongsTo(Company_role::class, 'company_role_id');
    }
    public function companyuser()
    {
        return $this->belongsToMany(CompanyUser::class, 'companyuser_roles', 'company_id', 'company_user_id');
    }
}
