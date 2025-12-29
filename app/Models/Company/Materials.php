<?php

namespace App\Models\Company;

use App\Models\API\Dpr;
use App\Models\Inventory;
use App\Models\InvIssuesDetails;
use App\Models\InvReturnsDetails;
use App\Models\MaterialRequest;
use App\Models\MaterialRequestDetails;
use App\Models\QuotesDetails;
use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Materials extends Model
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
        $prefix = 'M';
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
    public function projects()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
    public function stores()
    {
        return $this->belongsTo(StoreWarehouse::class, 'store_id');
    }

    public function materialsOpenStock()
    {
        return $this->hasMany(MaterialOpeningStock::class, 'material_id', 'id');
    }
    public function materialsHistory()
    {
        return $this->hasMany(MaterialsHistory::class, 'materials_id', 'id');
    }
    public function materialsRequest()
    {
        return $this->hasMany(MaterialRequest::class, 'materials_id', 'id');
    }
    public function invInwardGoodDetails()
    {
        // return $this->belongsTo(InwardGoodsDetails::class, 'materials_id', 'id');
        return $this->hasMany(InwardGoodsDetails::class, 'materials_id', 'id');
    }
    public function invIssuesDetails()
    {
        return $this->hasMany(InvIssuesDetails::class, 'materials_id', 'id');
    }
    public function inventorys()
    {
        return $this->hasOne(Inventory::class, 'materials_id', 'id');
        // return $this->hasMany(Inventory::class, 'materials_id', 'id');
    }
    public function inventorystock()
    {
        return $this->belongsTo(Inventory::class, 'materials_id', 'id');
        // return $this->hasMany(Inventory::class, 'materials_id', 'id');
    }

    // public function inventorystock()
    // {
    //     return $this->belongsTo(Inventory::class, 'materials_id', 'id');
    //     // return $this->hasMany(Inventory::class, 'materials_id', 'id');
    // }
    public function materialsRequestDetails()
    {
        return $this->hasMany(MaterialRequestDetails::class, 'materials_id', 'id');
    }
    public function materialsRequestDetail()
    {
        return $this->hasOne(MaterialRequestDetails::class, 'materials_id', 'id');
    }

    public function InvIssueGoodDetails()
    {
        return $this->hasMany(InvIssuesDetails::class, 'materials_id', 'id');
    }
    public function invReturnDetails()
    {
        return $this->hasMany(InvReturnsDetails::class, 'materials_id', 'id');
    }
    public function invQurtsDetail()
    {
        return $this->hasMany(QuotesDetails::class, 'materials_id', 'id');
    }
}
