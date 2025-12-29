<?php

namespace App\Models\Company;

use App\Models\Admin\CompanyManagment;
use App\Models\Cities;
use App\Models\Countries;
use App\Models\States;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class CompanyUser extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;
    protected $guarded = [];

    public function userCompany()
    {
        return $this->belongsToMany(CompanyManagment::class, 'companyuser_roles', 'company_user_id', 'company_id');
    }

    public function companyUserRole()
    {
        return $this->belongsTo(Company_role::class, 'company_role_id');
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(CompanyManagment::class, 'company_id');
    }
    public function countries()
    {
        return $this->belongsTo(Countries::class, 'country');
    }
    public function states()
    {
        return $this->belongsTo(States::class, 'state');
    }
    public function cities()
    {
        return $this->belongsTo(Cities::class, 'city');
    }
    public function reportingPerson()
    {
        return $this->belongsTo(CompanyUser::class, 'reporting_person');
    }
    public function projectMembers()
    {
        return $this->belongsToMany(
            Project::class,
            'project_members',
            'user_id',
            'project_id'
        );
    }
}
