<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BaseController;
use App\Http\Resources\API\Subscription\SubscriptionResources;
use App\Models\Subscription\SubscriptionPackage;

class SubscriptionController extends BaseController
{
    public function subscriptionList()
    {
        // $authConpany = Auth::guard('company-api')->user()->company_id;
        $data = SubscriptionPackage::with('subscriptionPackageOption')->get();
        $message = $data->isNotEmpty() ? 'Fetch Subscription Package List Successfully' : 'Subscription Package List Data Not Found';
        // dd($message);
        // return $this->responseJson(true, 200, $message, $data);
        return $this->responseJson(true, 200, $message, SubscriptionResources::collection($data));
    }
}
