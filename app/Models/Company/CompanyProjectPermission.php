<?php

namespace App\Models\Company;

use App\Models\Admin\CompanyManagment;
use Faker\Provider\ar_EG\Company;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class CompanyProjectPermission extends Model
{
    use HasFactory;
    // use HasFactory, SoftDeletes;
    protected $guarded = [];

    public function company()
    {
        return $this->belongsTo(CompanyManagment::class, 'company_id', 'id');
    }
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }
    public function subProject()
    {
        return $this->belongsTo(SubProject::class, 'sub_project_id', 'id');
    }
    // user
    public function user()
    {
        return $this->belongsTo(CompanyUser::class, 'company_user_id', 'id');
    }
}
