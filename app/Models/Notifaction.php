<?php

namespace App\Models;

use App\Models\Admin\CompanyManagment;
use App\Models\Company\CompanyUser;
use App\Models\Company\Project;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifaction extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(CompanyUser::class, 'user_id', 'id');
    }

    public function sender()
    {
        return $this->belongsTo(CompanyUser::class, 'sender_id', 'id');
    }

    public function company()
    {
        return $this->belongsTo(CompanyManagment::class, 'company_id', 'id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }
}
