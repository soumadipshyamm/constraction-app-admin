<?php

namespace App\Models\Company;

use Carbon\Traits\Timestamp;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company_permission extends Model
{
    use HasFactory;

    public $timestamps = false;
    // public function sluggable(): array
    // {
    //     return [
    //         'slug' => [
    //             'source' => 'name',
    //         ],
    //     ];
    // }

    protected $fillable = [
        'name',

    ];
    public function roles()
    {
        return $this->belongsToMany(Company_role::class, 'company_role_permissions');
    }

    public function companyUser()
    {
        return $this->belongsToMany(CompanyManagment::class, 'company_roles');
    }
}
