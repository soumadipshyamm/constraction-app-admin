<?php

namespace App\Models\Company;

use App\Models\InvInward;
use App\Models\InvInwardEntryType;
use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InwardGoods extends Model
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

    public function users()
    {
        return $this->belongsTo(CompanyUser::class, 'user_id', 'id');
    }
    public function vendores()
    {
        return $this->belongsTo(Vendor::class, 'vendors_id', 'id');
    }
    public function vendors()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id', 'id');
    }

    public function InvInwardGoodDetails()
    {
        return $this->hasMany(InwardGoodsDetails::class, 'inward_goods_id', 'id');
    }
    public function InvInwardGoodDetail()
    {
        return $this->belongsTo(InwardGoodsDetails::class, 'inward_goods_id', 'id');
    }
    public function InvInward()
    {
        return $this->belongsTo(InvInward::class, 'inv_inwards_id', 'id');
    }
    public function invInwards()
    {
        return $this->hasMany(InvInward::class, 'inv_inwards_id', 'id');
    }
    public function entryType()
    {
        return $this->belongsTo(InvInwardEntryType::class, 'inv_inward_entry_types_id', 'id');
    }
    public function invInwardEntryTypes()
    {
        return $this->belongsTo(InvInwardEntryType::class, 'inv_inward_entry_types_id', 'id');
    }
}
