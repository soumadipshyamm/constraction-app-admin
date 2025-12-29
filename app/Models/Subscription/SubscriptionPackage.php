<?php

namespace App\Models\Subscription;

use Carbon\Carbon;
use Webpatser\Uuid\Uuid;
use App\Models\Admin\CompanyManagment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Subscription\SubscriptionPackageOptions;
use App\Models\SubscriptionCompany;

class SubscriptionPackage extends Model
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

    //json column details   
    protected $casts = [
        'details' => 'json',
    ];
    public function subscriptionPackageOption()
    {
        return $this->hasMany(SubscriptionPackageOptions::class, 'subscription_packages_id','id');
    }

    public function getCreatedAtAttribute($created_at)
    {
        return Carbon::parse($created_at)->format('Y-m-d'); // Format as date (YYYY-MM-DD)
    }

    public function company()
    {
        return $this->hasOne(CompanyManagment::class, 'is_subscribed', 'id');
    }
    public function subscriptionCompany()
    {
        return $this->hasOne(SubscriptionCompany::class, 'is_subscribed', 'id');
    }

    // public function getFreeSubscriptionAttribute($free_subscription)
    // {
    //     return $free_subscription  == 1 ? 'Free' : 'Paid';;
    // }
}
