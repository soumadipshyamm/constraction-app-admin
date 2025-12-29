<?php

namespace App\Models;

use App\Models\Admin\CompanyManagment;
use App\Models\Company\Activities;
use App\Models\Company\CompanyUser;
use App\Models\Company\MaterialOpeningStock;
use App\Models\Company\Materials;
use App\Models\Company\PrMemberManagment;
use App\Models\Company\Project;
use App\Models\Company\StoreWarehouse;
use App\Models\Company\SubProject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class MaterialRequest extends Model
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
            $model->request_id = static::generateUniqueNumber(6);
        });
    }
    protected static function generateUniqueNumber($length)
    {
        $number = str_pad(mt_rand(1, pow(10, $length) - 1), $length, '0', STR_PAD_LEFT);
        // Check if the generated number is unique in the database
        while (static::where('request_id', $number)->exists()) {
            $number = str_pad(mt_rand(1, pow(10, $length) - 1), $length, '0', STR_PAD_LEFT);
        }
        return $number;
    }

    public function projects()
    {
        return $this->belongsTo(Project::class, 'projects_id');
    }
    public function activities()
    {
        return $this->belongsTo(Activities::class, 'activities_id');
    }
    public function materials()
    {
        return $this->belongsTo(Materials::class, 'materials_id');
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
    public function materialRequestDetails()
    {
        return $this->belongsTo(MaterialRequestDetails::class, 'material_requests_id', 'id');
    }

    public function quotesDetails()
    {
        return $this->belongsTo(QuotesDetails::class, 'material_requests_id', 'id');
    }
    public function hasquotesDetails()
    {
        return $this->hasMany(QuotesDetails::class, 'material_requests_id', 'id');
    }
    public function hasonequotesDetails()
    {
        return $this->hasOne(QuotesDetails::class, 'material_requests_id', 'id');
    }

    public function materialRequest()
    {
        return $this->hasMany(MaterialRequestDetails::class, 'material_requests_id', 'id');
    }

    public function PrMemberManagment(){
        return $this->hasMany(PrMemberManagment::class, 'material_request_id', 'id');
    }
}
