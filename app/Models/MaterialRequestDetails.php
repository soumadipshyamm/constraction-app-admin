<?php

namespace App\Models;

use App\Models\Company\Activities;
use App\Models\Company\MaterialOpeningStock;
use App\Models\Company\Materials;
use App\Models\Company\Project;
use App\Models\Company\StoreWarehouse;
use App\Models\Company\SubProject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class MaterialRequestDetails extends Model
{
    use HasFactory;
    protected $guarded = [];
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
        static::creating(function ($model) {
            $model->request_id = static::generateUniqueNumber(6);
        });
    }
    protected static function generateUniqueNumber($length)
    {
        $number = str_pad(mt_rand(1, pow(10, $length) - 1), $length, 0, STR_PAD_LEFT);
        // Check if the generated number is unique in the database
        while (static::where('request_id', $number)->exists()) {
            $number = str_pad(mt_rand(1, pow(10, $length) - 1), $length, 0, STR_PAD_LEFT);
        }
        return $number;
    }
    public function projects()
    {
        return $this->belongsTo(Project::class, 'projects_id');
    }
    public function subprojects()
    {
        return $this->belongsTo(SubProject::class, 'sub_projects_id', 'id');
    }
    public function subProject()
    {
        return $this->belongsToMany(SubProject::class, 'project_subproject', 'projects_id', 'sub_projects_id');
    }
    public function stores()
    {
        return $this->belongsTo(StoreWarehouse::class, 'store_id');
    }
    public function openingMaterials()
    {
        return $this->belongsTo(MaterialOpeningStock::class, 'material_id', 'id');
    }
    public function materials()
    {
        return $this->belongsTo(Materials::class, 'materials_id', 'id');
    }
    public function inventory()
    {
        return $this->belongsTo(Inventory::class, 'inventories_id', 'id');
    }
    public function activites()
    {
        return $this->belongsTo(Activities::class, 'activities_id', 'id');
    }
    public function materialrequests()
    {
        return $this->belongsTo(MaterialRequest::class, 'material_requests_id', 'id');
        // return $this->hasMany(MaterialRequest::class, 'material_requests_id', 'id');
    }
    public function materialrequest()
    {
        return $this->belongsTo(MaterialRequest::class, 'material_requests_id', 'id');
        // return $this->hasOne(MaterialRequest::class, 'material_requests_id', 'id');
    }
}
