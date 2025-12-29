<?php

namespace App\Models\Company;

use App\Models\API\Dpr;
use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Labour extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
        // static::creating(function ($model) {
        //     $model->code = static::generateUniqueNumber(6);
        // });
        static::creating(function ($model) {
            $model->code = static::generateUniqueNumber(6);
        });
    }

    protected static function generateUniqueNumber($length)
    {
        $prefix = 'L';
        $number = str_pad(mt_rand(1, pow(10, $length) - 1), $length, '0', STR_PAD_LEFT);
        // Check if the generated number is unique in the database
        while (static::where('code', $number)->exists()) {
            $number = str_pad(mt_rand(1, pow(10, $length) - 1), $length, '0', STR_PAD_LEFT);
        }
        return $prefix . $number; // {{ edit_1 }} Return the unique number
    }

    public function units()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }
    public function companys()
    {
        return $this->belongsTo(Companies::class, 'companies_id');
    }

    public function labourHistory()
    {
        return $this->hasMany(LabourHistory::class, 'labours_id', 'id');
    }
}
