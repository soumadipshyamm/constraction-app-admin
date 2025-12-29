<?php

namespace App\Models\Company;

use App\Models\Admin\CompanyManagment;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company_role extends Model
{
    use HasFactory;
    use Sluggable;
    public $timestamps = false;
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
        'slug',
        'company_id',
    ];

    public function permissions()
    {
        return $this->belongsToMany(Company_permission::class, 'company_role_permissions');
    }

    // public function companyRoleUser()
    // {
    //     return $this->belongsToMany(CompanyManagment::class, 'company_user_roles', 'company_role_id', 'company_user_id');
    // }

    public function companyRoleUser()
    {
        return $this->hasOne(CompanyUser::class, 'company_role_id');
    }
}
