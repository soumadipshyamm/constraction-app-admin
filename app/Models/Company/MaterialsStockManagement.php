<?php

namespace App\Models\Company;

use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MaterialsStockManagement extends Model
{
    use HasFactory;
    protected $guarded = [];
    public static function boot()
    {
        parent::boot();
        // self::creating(function ($model) {
        //     $model->uuid = (string) Uuid::generate(4);
        // });
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
}
