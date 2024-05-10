<?php

namespace App\Models;

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
    public function InvReturnStore()
    {
        return $this->belongsToMany(InvReturn::class, 'inv_return_stores', 'inv_returns_id', 'store_warehouses_id');
    }
    public function invReturn()
    {
        return $this->belongsTo(InvReturn::class, 'inv_returns_id', 'id');
    }
}
