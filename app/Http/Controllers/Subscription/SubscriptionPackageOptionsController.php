<?php

namespace App\Http\Controllers\Subscription;

use App\Http\Controllers\BaseController;
use App\Models\Subscription\SubscriptionPackageOptions;
use Illuminate\Http\Request;

class SubscriptionPackageOptionsController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('subscription.index');
    }


}
