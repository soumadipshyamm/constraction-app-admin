<?php

namespace App\Models\Company;

//
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use ProtoneMedia\LaravelFFMpeg\Filesystem\Media;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;

class Companies extends Model
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

    public function projects()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function projectCompanies()
    {
        return $this->belongsToMany(
            Project::class,
            'project_companies',
            'company_id',
            'project_id',
        );
    }

    // public function media(): MorphOne
    // {
    //     return $this->morphOne(Media::class, 'mediaable');
    // }

    public function getProfilePictureAttribute()
    {
        $file = $this->logo;
        if (!is_null($file)) {
            // $fileDisk = config('constants.SITE_FILE_STORAGE_DISK');
            // if ($fileDisk == 'public') {
            if (file_exists(public_path('logo/' . $file))) {
                return asset('logo/' . $file);
            }
            // }
        }
        return asset('assets/images/placeholder-no-image.png');
    }
}
