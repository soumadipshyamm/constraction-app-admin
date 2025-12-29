<?php

namespace App\Models\Company;

use App\Models\Cities;
use App\Models\Countries;
use App\Models\States;
use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Teams extends Model
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

    public function profileRole()
    {
        return $this->belongsTo(profileDesignation::class, 'profile_role');
    }
    public function teams()
    {
        return $this->belongsTo(Teams::class, 'reporting_person');
    }
    public function country()
    {
        return $this->belongsTo(Countries::class, 'country');
    }
    public function state()
    {
        return $this->belongsTo(States::class, 'state');
    }
    public function city()
    {
        return $this->belongsTo(Cities::class, 'city');
    }
    //     country
    // state
    // city
}
