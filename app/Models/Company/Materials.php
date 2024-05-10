<?php

namespace App\Models\Company;

use App\Models\API\Dpr;
use App\Models\Inventory;
use App\Models\InvIssuesDetails;
use App\Models\MaterialRequest;
use App\Models\MaterialRequestDetails;
use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Materials extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
    }
    public function units()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }
    public function projects()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
    public function stores()
    {
        return $this->belongsTo(StoreWarehouse::class, 'store_id');
    }

    public function materialsOpenStock()
    {
        return $this->hasMany(MaterialOpeningStock::class, 'material_id', 'id');
    }
    public function materialsHistory()
    {
        return $this->hasMany(MaterialsHistory::class, 'materials_id', 'id');
    }
    public function materialsRequest()
    {
        return $this->hasMany(MaterialRequest::class, 'materials_id', 'id');
    }
    public function invInwardGoodDetails()
    {
        return $this->hasMany(InwardGoodsDetails::class, 'materials_id', 'id');
    }
    public function inventorys()
    {
        return $this->hasOne(Inventory::class, 'materials_id', 'id');
        // return $this->hasMany(Inventory::class, 'materials_id', 'id');
    }

    public function materialsRequestDetails()
    {
        return $this->hasMany(MaterialRequestDetails::class, 'materials_id', 'id');
    }

    public function InvIssueGoodDetails()
    {
        return $this->hasMany(InvIssuesDetails::class, 'materials_id', 'id');
    }
}
