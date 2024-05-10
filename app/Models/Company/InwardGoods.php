<?php

namespace App\Models\Company;

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
    public function InvInwardGoodDetails()
    {
        return $this->hasMany(InwardGoodsDetails::class, 'inward_goods_id', 'id');
    }
}
