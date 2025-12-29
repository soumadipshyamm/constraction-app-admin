<?php

namespace App\Models\Company;

use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Unit extends Model
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
    public function labour()
    {
        return $this->belongsTo(Labour::class, 'unit_id');
    }
    public function assets()
    {
        return $this->belongsTo(Assets::class, 'unit_id');
    }
    public function openingStock()
    {
        return $this->belongsTo(OpeningStock::class, 'unit_id');
    }
    public function activities()
    {
        return $this->belongsTo(Activities::class, 'unit_id');
    }

}
