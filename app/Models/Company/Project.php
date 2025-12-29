<?php

namespace App\Models\Company;

use App\Models\InvInward;
use App\Models\InvIssue;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Webpatser\Uuid\Uuid;

class Project extends Model
{
    use HasFactory;
    // use SoftDeletes;
    // protected $deleted_at=false;
    protected $guarded = [];
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
        // self::deleting(function ($query) {
        //     $query->client()->delete();
        // });
    }

    public function client(): HasOne
    {
        return $this->hasOne(Client::class, 'project_id');
    }
    public function companys()
    {
        return $this->belongsTo(Companies::class, 'companies_id');
    }
    // public function subProject()
    // {
    //     return $this->hasMany(SubProject::class, 'projects_id');
    // }
    public function subProject()
    {
        return $this->belongsToMany(SubProject::class, 'project_subproject', 'project_id', 'subproject_id');
    }

    public function prMemeberManag()
    {
        return $this->hasMany(PrMemberManagment::class, 'project_id');
    }
    public function prApprovalMemebers()
    {
        return $this->hasMany(PrApprovalMember::class, 'project_id');
    }

    public function StoreWarehouse()
    {
        return $this->hasMany(StoreWarehouse::class, 'projects_id');
    }
    public function activites()
    {
        return $this->hasMany(Activities::class, 'project_id');
    }
    public function invInward()
    {
        return $this->hasMany(InvInward::class, 'projects_id', 'id');
    }
    public function invIssues()
    {
        return $this->hasMany(InvIssue::class, 'projects_id', 'id');
    }

    public function companiesProject()
    {
        return $this->belongsToMany(
            Companies::class,
            'project_companies',
            'project_id',
            'company_id'
        );
    }

    public function members()
    {
        return $this->belongsToMany(
            CompanyUser::class,
            'project_members',
            'project_id',
            'user_id'
        );
    }


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

    public function projectMemberAllocation()
    {
        return $this->hasMany(CompanyProjectPermission::class, 'project_id', 'id');
    }
}
