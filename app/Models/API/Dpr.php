<?php

namespace App\Models\API;

use App\Models\Company\Activities;
use App\Models\Company\ActivityHistory;
use App\Models\Company\Assets;
use App\Models\Company\AssetsHistory;
use App\Models\Company\CompanyUser;
use App\Models\Company\Labour;
use App\Models\Company\LabourHistory;
use App\Models\Company\Materials;
use App\Models\Company\MaterialsHistory;
use App\Models\Company\Project;
use App\Models\Company\SubProject;
use App\Models\Company\Vendor;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;
use Webpatser\Uuid\Uuid;

class Dpr extends Model
{
    use HasFactory;
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
        return $this->belongsTo(Project::class, 'projects_id');
    }
    public function subProjects()
    {
        return $this->belongsTo(SubProject::class, 'sub_projects_id');
    }
    public function assets()
    {
        return $this->hasMany(AssetsHistory::class, 'dpr_id');
    }

    public function activities()
    {
        return $this->hasMany(ActivityHistory::class, 'dpr_id');
    }
    public function labour()
    {
        return $this->hasMany(LabourHistory::class, 'dpr_id');
    }
    public function labours()
    {
        return $this->belongsTo(LabourHistory::class, 'dpr_id');
    }
    public function material()
    {
        return $this->hasMany(MaterialsHistory::class, 'dpr_id');
    }
    public function historie()
    {
        return $this->hasMany(Hinderance::class, 'dpr_id');
    }
    public function safetie()
    {
        return $this->hasMany(Safety::class, 'dpr_id');
    }
    public function users()
    {
        return $this->belongsTo(CompanyUser::class, 'user_id', 'id');
        // return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function vendors()
    {
        return $this->belongsTo(Vendor::class, 'vendors_id', 'id');
    }

    // public function getProjectId(Request $request)
    // {
    //     return $request;
    // }
}
