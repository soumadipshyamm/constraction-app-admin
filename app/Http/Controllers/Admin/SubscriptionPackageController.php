<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Models\Subscription\AdditionalFeatures;
use App\Models\Subscription\SubscriptionPackage;
use App\Models\Subscription\SubscriptionPackageOptions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SubscriptionPackageController extends BaseController
{
    public function index(Request $request)
    {
        $datas = SubscriptionPackage::with('subscriptionPackageOption')->get();
        // dd($datas);
        return view('Admin.subscription.index', compact('datas'));
    }

    public function add(Request $request)
    {
        if ($request->isMethod('post')) {
            // dd($request->all());
            $validatedData = $request->validate([
                'title' => 'required',
                'free_subscription' => 'in:1,0,null',
                'payment_mode' => 'required_unless:free_subscription,1',
                'amount_inr' => 'required_unless:free_subscription,1',
                'amount_usd' => 'required_unless:free_subscription,1',
                'trial_period' => 'required_unless:free_subscription,1',
                'duration' => 'required_unless:free_subscription,1',
            ]);

            // dd($request->all());
            DB::beginTransaction();
            try {
                if ($request->uuid) {
                    $isCompanyUser = SubscriptionPackage::where('uuid', $request->uuid)->update([
                        'title' => $request->title,
                        'free_subscription' => $request->free_subscription === null ? 0 : 1,
                        'payment_mode' => $request->payment_mode,
                        'amount_inr' => $request->amount_inr,
                        'amount_usd' => $request->amount_usd,
                        'duration' => $request->duration,
                        'trial_period' => $request->trial_period,
                        'details'=> $request->details
                    ]);
                } else {
                    $isCompanyUser = SubscriptionPackage::create([
                        'uuid' => Str::uuid(),
                        'title' => $request->title,
                        'free_subscription' => $request->free_subscription === null ? 0 : 1,
                        'payment_mode' => $request->payment_mode,
                        'amount_inr' => $request->amount_inr,
                        'amount_usd' => $request->amount_usd,
                        'duration' => $request->duration,
                        'trial_period' => $request->trial_period,
                        'details'=> $request->details
                    ]);
                }
                // dd($isCompanyUser);
                if ($isCompanyUser) {
                    DB::commit();
                    return redirect()
                        ->route('admin.subscription.list')
                        ->with('success', 'Subscription Managment Created Successfully');
                }
            } catch (\Exception $e) {
                DB::rollBack();
                logger($e->getMessage() . '--' . $e->getFile() . '--' . $e->getLine());
            }
            // return view('Frontend.auth.registration');
        }
        return view('Admin.subscription.add-subscription');
    }

    public function edit($id)
    {
        $data = SubscriptionPackage::where('uuid', $id)->first();
        return view('Admin.subscription.add-subscription', compact('data'));
    }

    // *****************************Edit Option Subscription****************************************************************
    public function editSubscriptionOption(Request $request, $uuid)
    {
        $id = uuidtoid($uuid, 'subscription_packages');
        $exitesOrNot = SubscriptionPackageOptions::where('subscription_packages_id', $id)->get();
        if (count($exitesOrNot) > 0) {
            $datas = $exitesOrNot;
        } else {
            $datas = $id;
        }
        return view('Admin.subscription.add-on-features', compact('datas'));
    }

    // *****************************Add & Update Option Subscription****************************
    public function addSubscriptionOption(Request $request)
    {
        if ($request->isMethod('post')) {
            DB::beginTransaction();
            try {
                $opionData = $request->except(['id', 'uuid', '_token']);
                // dd($opionData);
                if ($request->uuid) {
                    $subscription_packages_id=$request->uuid;
                    foreach ($opionData as $key => $value) {
                        $convertedText = str_replace('_', ' ', $key);
                        // Convert to sentence case
                        $convertedText = ucwords($convertedText);
                // dd($convertedText);
                // dd($request->uuid);
                        SubscriptionPackageOptions::where('subscription_packages_id',$subscription_packages_id )
                            ->where('subscription_key', $key)                            
                            ->update(['is_subscription' => $value['free'],
                            'value'=> $convertedText
                        ]);
                    }
                    DB::commit();
                } else {
                    $subscription_id = $request->id;
                    foreach ($opionData as $key => $value) {
                        $convertedText = str_replace('_', ' ', $key);
                        // Convert to sentence case
                        $convertedText = ucwords($convertedText);
                // dd($convertedText);
                        $created = SubscriptionPackageOptions::create([
                            'uuid' => Str::uuid(),
                            'subscription_packages_id' => $subscription_id,
                            'subscription_key' => $key,
                            'value' => $convertedText,
                            'is_subscription' => $value['free'],
                        ]);
                    }
                }
                DB::commit();
                $message = $request->uuid ? 'Subscription Features Updated Successfully' : 'Subscription Features Created Successfully';
                return redirect()->route('admin.subscription.list')->with('success', $message);
            } catch (\Exception $e) {
                // dd('$created no');
                DB::rollBack();
                logger($e->getMessage() . '--' . $e->getFile() . '--' . $e->getLine());
            }
        }
        return view('Admin.subscription.add-on-features');
    }
}
