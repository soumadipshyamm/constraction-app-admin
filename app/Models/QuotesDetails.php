<?php

namespace App\Models;

use App\Models\Admin\CompanyManagment;
use App\Models\Company\CompanyUser;
use App\Models\Company\Materials;
use App\Models\Company\Project;
use App\Models\Company\Quote;
use App\Models\Company\StoreWarehouse;
use App\Models\Company\SubProject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Webpatser\Uuid\Uuid;

class QuotesDetails extends Model
{
    use HasFactory;
    protected $guarded = [];
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });

        static::creating(function ($model) {
            $model->request_no = static::generateUniqueNumber(6);
        });
    }
    protected static function generateUniqueNumber($length)
    {
        $number = str_pad(mt_rand(1, pow(10, $length) - 1), $length, '0', STR_PAD_LEFT);
        // Check if the generated number is unique in the database
        while (static::where('request_no', $number)->exists()) {
            $number = str_pad(mt_rand(1, pow(10, $length) - 1), $length, '0', STR_PAD_LEFT);
        }
        return $number;
    }
    public function projects()
    {
        return $this->belongsTo(Project::class, 'projects_id');
    }
    public function subprojects()
    {
        return $this->belongsTo(SubProject::class, 'sub_projects_id');
    }
    public function stores()
    {
        return $this->belongsTo(StoreWarehouse::class, 'store_id');
    }
    public function company()
    {
        return $this->belongsTo(CompanyManagment::class, 'company_id', 'id');
    }
    public function users()
    {
        return $this->belongsTo(CompanyUser::class, 'user_id', 'id');
    }
    public function materialsRequest()
    {
        return $this->belongsTo(MaterialRequest::class, 'material_requests_id', 'id');
    }
    public function materialsRequestDetails()
    {
        return $this->belongsTo(MaterialRequestDetails::class, 'material_request_details_id', 'id');
    }
    public function materialsRequestDetail()
    {
        return $this->hasMany(MaterialRequestDetails::class, 'material_request_details_id', 'id');
    }
    public function materials()
    {
        return $this->belongsTo(Materials::class, 'materials_id', 'id');
    }
    public function quotes()
    {
        return $this->belongsTo(Quote::class, 'quotes_id');
    }

    public function materialrequestvendor()
    {
        return $this->hasMany(QuotesMaterialSendVendor::class, 'quotes_details_id', 'id');
    }

    public function image(): MorphMany
    {
        return $this->morphMany(Media::class, 'mediaable');
    }

    // public function getVehicleImageAttribute()
    // {
    //     $vehicles = $this->media()->where('media_type', 'vehicle-image')->get();
    //     if (!is_null($vehicles)) {
    //         $data = [];
    //         foreach ($vehicles as $value) {
    //             // $fileDisk = config('constants.SITE_FILE_STORAGE_DISK');
    //             // if ($fileDisk == 'public') {
    //             if (file_exists(public_path('storage/images/quotes/' . $value->file))) {
    //                 $data[] = asset('storage/images/quotes/' . $value->file);
    //             }
    //             // }
    //         }
    //         return $data;
    //     }
    //     return [asset('assets/img/avatars/no-image.png')];
    // }
}
