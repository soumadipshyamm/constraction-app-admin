<?php

namespace App\Models;

use App\Models\Admin\CompanyManagment;
use App\Models\Subscription\SubscriptionPackage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionCompany extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function companysubscription()
    {
        return $this->hasMany(CompanyManagment::class, 'company_id', 'id');
    }
    public function subscriptionPackage()
    {
        return $this->belongsTo(SubscriptionPackage::class, 'is_subscribed', 'id');
    }
}
