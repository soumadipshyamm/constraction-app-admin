<?php

namespace App\Models;

use App\Models\Admin\CompanyManagment;
use App\Models\Company\Assets;
use App\Models\Company\CompanyUser;
use App\Models\Company\Materials;
use App\Models\Company\Project;
use App\Models\Company\StoreWarehouse;
use App\Models\Company\SubProject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Webpatser\Uuid\Uuid;

class Inventory extends Model
{
    use HasFactory, HasApiTokens, Notifiable, SoftDeletes;
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
    public function materials()
    {
        return $this->belongsTo(Materials::class, 'materials_id', 'id');
    }
    public function assets()
    {
        return $this->belongsTo(Assets::class, 'assets_id', 'id');
    }
    public function users()
    {
        return $this->belongsTo(CompanyUser::class, 'user_id', 'id');
    }
    public function inventoryStore()
    {
        return $this->belongsToMany(StoreWarehouse::class, 'inventory_stores', 'inventories_id', 'store_warehouses_id')->withPivot('store_warehouses_id', 'inventories_id');
        // return $this->belongsToMany(StoreWarehouse::class, 'inventory_stores', 'inventories_id', 'store_warehouses_id');
    }
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
