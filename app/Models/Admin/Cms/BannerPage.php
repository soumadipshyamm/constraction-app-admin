<?php

namespace App\Models\Admin\Cms;

use App\Models\Admin\PageManagment;
use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BannerPage extends Model
{
    use HasFactory, sluggable;
    protected $guarded = [];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
            ],
        ];
    }

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
    }

    public function pageManagment()
    {
        return $this->belongsTo(PageManagment::class, 'page_id', 'id');
    }
    // public function homePageManagment()
    // {
    //     return $this->belongsTo(HomePage::class, 'page_id', 'id');
    // }

}
