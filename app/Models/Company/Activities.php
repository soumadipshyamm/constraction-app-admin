<?php

namespace App\Models\Company;

use App\Models\API\Dpr;
use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

class Activities extends Model
{
    use HasFactory, HasRecursiveRelationships, SoftDeletes;
    protected $guarded = [];
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
    }

    public function units()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function subproject()
    {
        return $this->belongsTo(SubProject::class, 'subproject_id');
    }

    public function childrenActivites(): HasMany
    {
        return $this->hasMany(Activities::class, 'parent_id');
    }
    public function parentActivites()
    {
        return $this->hasMany(Activities::class, 'parent_id');
    }
    public function headingActivites(): HasOne
    {
        return $this->hasOne(Activities::class, 'parent_id');
    }
    // public function activitiesHistory()
    // {
    //     return $this->belongsTo(ActivityHistory::class, 'activities_id', 'id');
    // }
    public function activitiesHistory()
    {
        return $this->hasMany(ActivityHistory::class, 'activities_id', 'id');
    }
}
