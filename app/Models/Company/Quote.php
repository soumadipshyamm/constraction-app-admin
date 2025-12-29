<?php

namespace App\Models\Company;

use App\Models\Admin\CompanyManagment;
use App\Models\QuotesDetails;
use App\Models\QuotesMaterialSendVendor;
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
    public function quotesdetails()
    {
        return $this->hasMany(QuotesDetails::class, 'quotes_id', 'id');
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
    public function materialrequestvendor()
    {
        return $this->hasMany(QuotesMaterialSendVendor::class, 'quotes_id', 'id');
    }
}
