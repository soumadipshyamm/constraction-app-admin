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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(SubscriptionPackageOptions $subscriptionPackageOptions)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SubscriptionPackageOptions $subscriptionPackageOptions)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SubscriptionPackageOptions $subscriptionPackageOptions)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubscriptionPackageOptions $subscriptionPackageOptions)
    {
        //
    }
}
