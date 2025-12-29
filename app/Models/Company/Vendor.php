<?php

namespace App\Models\Company;

use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vendor extends Model
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
    protected $casts = [
        'additional_fields' => 'array',
    ];
    // DPR

    public function activitiesHistory(): HasMany
    {
        return $this->hasMany(ActivityHistory::class, 'vendors_id');
    }
    public function laboursHistory(): HasMany
    {
        return $this->hasMany(LabourHistory::class, 'vendors_id');
    }
}
