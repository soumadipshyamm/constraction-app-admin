<?php

namespace App\Models\Company;

use App\Mail\MaterialRequest;
use App\Models\Admin\CompanyManagment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class PrApprovalMember extends Model
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
    public function user()
    {
        return $this->belongsTo(CompanyUser::class, 'user_id');
    }

    public function materialRequest()
    {
        return $this->belongsTo(MaterialRequest::class, 'material_request_id');
    }

    public function company()
    {
        return $this->belongsTo(CompanyManagment::class, 'company_id');
    }
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
}
