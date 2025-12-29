<?php

namespace App\Models\Company;

use App\Models\InvInward;
use App\Models\InvIssue;
use App\Models\InvReturn;
use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StoreWarehouse extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
        static::creating(function ($model) {
            $model->code = static::generateUniqueNumber(6);
        });
    }

    protected static function generateUniqueNumber($length)
    {
        $number = str_pad(mt_rand(1, pow(10, $length) - 1), $length, '0', STR_PAD_LEFT);
        // Check if the generated number is unique in the database
        while (static::where('code', $number)->exists()) {
            $number = str_pad(mt_rand(1, pow(10, $length) - 1), $length, '0', STR_PAD_LEFT);
        }
    }
    // ************************************************************************************************
    public function project()
    {
        return $this->belongsTo(Project::class, 'projects_id');
    }
    // ************************************************************************************************
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
    // ************************************************************************************************
    public function InvReturnStore()
    {
        return $this->belongsToMany(InvReturn::class, 'inv_return_stores', 'inv_returns_id', 'store_warehouses_id');
    }
    // ************************************************************************************************
    public function InvIssueStore()
    {
        return $this->belongsToMany(InvIssue::class, 'inv_issue_stores', 'inv_issues_id', 'store_warehouses_id');
    }
    // ************************************************************************************************
    public function InvInwardStore()
    {
        return $this->belongsToMany(InvInward::class, 'inward_stores', 'inv_inwards_id', 'store_warehouses_id');
    }
}
