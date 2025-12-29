<?php

namespace App\Models;

use App\Models\Company\Vendor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class QuotesMaterialSendVendor extends Model
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
        return $this->belongsTo(QuotesDetails::class, 'quotes_details_id', 'id');
    }
    public function vendorlist()
    {
        return $this->belongsTo(Vendor::class, 'vendors_id', 'id');
    }
}
