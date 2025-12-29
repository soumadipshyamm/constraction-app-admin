<?php

namespace App\Models\Admin;

use App\Models\Admin\Cms\BannerPage;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class PageManagment extends Model
{
    use HasFactory, sluggable;
    protected $guarded = [];
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
    }
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'page_name',
            ],
        ];
    }

    // public function menu()
    // {
    //     return $this->hasMany(MenuManagment::class, 'page_id', 'id');
    // }
    public function banner()
    {
        return $this->hasOne(BannerPage::class, 'page_id', 'id');
    }

    // public function media(): MorphOne
    // {
    //     return $this->morphOne(Media::class, 'mediaable');
    // }
    // public function getProfilePictureAttribute()
    // {
    //     $file = $this->media()?->value('file');
    //     if (!is_null($file)) {
    //         // $fileDisk = config('constants.SITE_FILE_STORAGE_DISK');
    //         // if ($fileDisk == 'public') {
    //             if (file_exists(public_path('logo/' . $file))) {
    //                 return asset('logo/' . $file);
    //             }
    //         // }
    //     }
    //     return asset('assets/images/placeholder-no-image.png');
    // }

}
