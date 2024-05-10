<?php

namespace App\Models\Company;

use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class profileDesignation extends Model
{
    use HasFactory;
    use Sluggable;
    protected $guarded = [];


    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
    }
    public function teams()
    {
        return $this->hasMany(Teams::class,'profile_role');
    }

}
