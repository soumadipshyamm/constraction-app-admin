<?php

namespace App\Models\Company;

use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InwardGoodsDetails extends Model
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

    public function InvInwardGoodDetails()
    {
        return $this->hasMany(InwardGoods::class, 'inward_goods_id', 'id');
    }
    public function InvInwardGood()
    {
        return $this->belongsTo(InwardGoods::class, 'inward_goods_id', 'id');
    }
    // public function InvInwardGoodMaterials()
    public function materials()
    {
        return $this->belongsTo(Materials::class, 'materials_id', 'id');
    }
    public function material()
    {
        return $this->hasMany(Materials::class, 'materials_id', 'id');
    }
    public function assets()
    {
        return $this->belongsTo(Assets::class, 'assets_id', 'id');
    }
    public function asset()
    {
        return $this->hasMany(Assets::class, 'assets_id', 'id');
    }


}
