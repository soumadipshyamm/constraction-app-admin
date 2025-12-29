<?php

namespace App\Models;

use App\Models\Company\StoreWarehouse;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class InvReturnGood extends Model
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
    // public function InvReturnStores()
    // {
    //     return $this->belongsToMany(StoreWarehouse::class, 'inv_return_stores', 'inv_returns_id', 'store_warehouses_id');
    // }
    public function invReturn()
    {
        return $this->belongsTo(InvReturn::class, 'inv_returns_id', 'id');
    }
    public function invIssueList()
    {
        return $this->belongsTo(InvIssueList::class, 'inv_issue_lists_id', 'id');
    }
    public function invReturnDetails()
    {
        return $this->hasMany(InvReturnsDetails::class, 'inv_return_goods_id', 'id');
    }
    // public function invReturn()
    // {
    //     return $this->belongsTo(InvReturn::class, 'inv_returns_id', 'id');
    // }
}
