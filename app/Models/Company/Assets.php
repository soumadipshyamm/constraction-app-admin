<?php

namespace App\Models\Company;

use App\Models\API\Dpr;
use App\Models\Inventory;
use App\Models\InvIssuesDetails;
use App\Models\InvReturnsDetails;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;

class Assets extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
        static::creating(function ($model) {
            $model->code = static::generateUniqueNumber(6);
        });
    }

    protected static function generateUniqueNumber($length)
    {
        $prefix = 'AEM'; // Define the prefix
        // Fetch the last generated code that matches the prefix
        $lastCode = static::where('code', 'like', "{$prefix}%")
            ->orderBy('code', 'desc')
            ->value('code');

        if ($lastCode) {
            // Extract the numeric part of the last code and increment it
            $lastNumber = intval(substr($lastCode, strlen($prefix)));
            $nextNumber = str_pad($lastNumber + 1, $length, '0', STR_PAD_LEFT);
        } else {
            // Start from 1 if no records exist
            $nextNumber = str_pad(1, $length, '0', STR_PAD_LEFT);
        }
        // Return the unique code
        return $prefix . $nextNumber;
    }
    // protected static function generateUniqueNumber($length)
    // {
    //     $number = str_pad(mt_rand(1, pow(10, $length) - 1), $length, '0', STR_PAD_LEFT);
    //     // Check if the generated number is unique in the database
    //     while (static::where('code', $number)->exists()) {
    //         $number = str_pad(mt_rand(1, pow(10, $length) - 1), $length, '0', STR_PAD_LEFT);
    //     }
    //     return $number;
    // }
    public function units()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
    public function store_warehouses()
    {
        return $this->belongsTo(StoreWarehouse::class, 'store_warehouses_id');
    }
    public function assetsHistory()
    {
        return $this->hasMany(AssetsHistory::class, 'assets_id', 'id');
    }
    public function InvInwardGoodDetails()
    {
        return $this->hasMany(InwardGoodsDetails::class, 'assets_id', 'id');
    }
    public function invIssuesDetails()
    {
        return $this->hasMany(InvIssuesDetails::class, 'assets_id', 'id');
    }
    public function inventorys()
    {
        return $this->hasOne(Inventory::class, 'assets_id', 'id');
        return $this->hasMany(Inventory::class, 'assets_id', 'id');
    }
    public function inventory()
    {
        return $this->hasOne(Inventory::class, 'assets_id', 'id');
    }
    public function invReturnDetails()
    {
        return $this->hasOne(InvReturnsDetails::class, 'assets_id', 'id');
        // return $this->hasMany(InvReturnsDetails::class, 'assets_id', 'id');
    }
}
