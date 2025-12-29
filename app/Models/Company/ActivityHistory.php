<?php

namespace App\Models\Company;

use App\Models\Admin\CompanyManagment;
use App\Models\API\Dpr;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;
use Webpatser\Uuid\Uuid;

class ActivityHistory extends Model
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
    public function dpr()
    {
        return $this->belongsTo(Dpr::class, 'dpr_id');
    }
    public function activities()
    {
        return $this->belongsTo(Activities::class, 'activities_id', 'id');
    }
    public function vendors()
    {
        return $this->belongsTo(Vendor::class, 'vendors_id', 'id');
    }
    public function companys()
    {
        return $this->belongsTo(CompanyManagment::class, 'company_id', 'id');
    }
    // public function getTotalQty(Request $request)
    // {
    // return $request->all();
    // return $this->where('dpr_id', $request->input('dpr_id'))
    //     ->where('activities_id', $this->attributes['activities_id'])
    //     ->sum('qty');
    // }
}
