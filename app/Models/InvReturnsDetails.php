<?php

namespace App\Models;

use App\Models\Admin\CompanyManagment;
use App\Models\Company\Activities;
use App\Models\Company\Assets;
use App\Models\Company\CompanyUser;
use App\Models\Company\Materials;
use App\Models\Company\Project;
use App\Models\Company\StoreWarehouse;
use App\Models\Company\SubProject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class InvReturnsDetails extends Model
{
    use HasFactory;
    protected $guarded = [];
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
    }
    public function projects()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
    public function subprojects()
    {
        return $this->belongsTo(SubProject::class, 'sub_projects_id');
    }
    public function stores()
    {
        return $this->belongsTo(StoreWarehouse::class, 'store_id');
    }
    public function company()
    {
        return $this->belongsTo(CompanyManagment::class, 'company_id', 'id');
    }
    public function invReturnGood()
    {
        return $this->belongsTo(InvReturnGood::class, 'inv_return_goods_id', 'id');
    }
    public function users()
    {
        return $this->belongsTo(CompanyUser::class, 'user_id', 'id');
    }

    public function materials()
    {
        return $this->belongsTo(Materials::class, 'materials_id', 'id');
    }
    public function assets()
    {
        return $this->belongsTo(Assets::class, 'assets_id', 'id');
    }
    public function activites()
    {
        return $this->belongsTo(Activities::class, 'activities_id', 'id');
    }
}
