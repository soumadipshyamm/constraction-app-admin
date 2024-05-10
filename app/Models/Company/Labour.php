<?php

namespace App\Models\Company;

use App\Models\API\Dpr;
use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Labour extends Model
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
    public function companys()
    {
        return $this->belongsTo(Companies::class, 'companies_id');
    }

    public function labourHistory()
    {
        return $this->hasMany(LabourHistory::class, 'labours_id', 'id');
    }
}
