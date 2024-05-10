<?php

namespace App\Models\Company;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialsStockReport extends Model
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
    public function materials()
    {
        return $this->belongsTo(Materials::class, 'material_id');
    }
}
