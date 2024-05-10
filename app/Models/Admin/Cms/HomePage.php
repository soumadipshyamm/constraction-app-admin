<?php

namespace App\Models\Admin\Cms;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class HomePage extends Model
{
    use HasFactory, sluggable;
    protected $guarded = [];
    protected $table = 'home_pages';

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

    public function banner()
    {
        return $this->hasOne(BannerPage::class, 'page_id', 'id');
    }

}
