<?php

namespace App\Models\Company;

use App\Models\API\Dpr;
use App\Models\Inventory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;

class Assets extends Model
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
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
    public function store_warehouses()
    {
        return $this->belongsTo(StoreWarehouse::class, 'store_warehouses_id');
    }
    public function assetsHistory()
    {
        return $this->hasMany(AssetsHistory::class, 'assets_id', 'id');
    }
    public function InvInwardGoodDetails()
    {
        return $this->hasMany(InwardGoodsDetails::class, 'assets_id', 'id');
    }
    public function inventorys()
    {
        return $this->hasMany(Inventory::class, 'assets_id', 'id');
    }

}
