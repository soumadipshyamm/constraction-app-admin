<?php

namespace App\Models\Company;

use App\Models\API\Dpr;
use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MaterialsHistory extends Model
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
    public function dpr()
    {
        return $this->belongsTo(Dpr::class, 'dpr_id');
    }
    public function vendors()
    {
        return $this->belongsTo(Vendor::class, 'vendors_id');
    }
    public function activities()
    {
        return $this->belongsTo(Activities::class, 'activities_id');
    }
    public function materials()
    {
        return $this->belongsTo(Materials::class, 'materials_id');
    }
}
