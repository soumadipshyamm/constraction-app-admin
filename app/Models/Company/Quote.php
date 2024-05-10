<?php

namespace App\Models\Company;

use App\Models\Admin\CompanyManagment;
use App\Models\QuotesDetails;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class Quote extends Model
{
    use HasFactory;
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
    public function quotesdetails()
    {
        return $this->hasMany(QuotesDetails::class, 'quotes_id');
    }
    public function projects()
    {
        return $this->belongsTo(Project::class, 'projects_id');
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
}
