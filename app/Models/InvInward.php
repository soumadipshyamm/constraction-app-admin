<?php

namespace App\Models;

use App\Models\Admin\CompanyManagment;
use App\Models\Company\CompanyUser;
use App\Models\Company\InwardGoods;
use App\Models\Company\Project;
use App\Models\Company\StoreWarehouse;
use App\Models\Company\SubProject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class InvInward extends Model
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
        return $this->belongsTo(Project::class, 'projects_id');
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
    public function users()
    {
        return $this->belongsTo(CompanyUser::class, 'user_id', 'id');
    }
    public function InvInwardStore()
    {
        return $this->belongsToMany(StoreWarehouse::class, 'inward_stores', 'inv_inwards_id', 'store_warehouses_id');
    }

    public function invInwardGood()
    {
        return $this->hasMany(InwardGoods::class, 'inv_inwards_id', 'id');
    }
    public function invInwardGoods()
    {
        return $this->belongsTo(InwardGoods::class, 'inv_inwards_id', 'id');
    }
}
