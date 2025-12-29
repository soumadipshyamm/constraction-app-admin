<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Admin\CompanyManagment;
use App\Models\Subscription\SubscriptionPackage;
use App\Models\SubscriptionCompany;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Razorpay\Api\Api;

class SubscriptionCompanyController extends BaseController
{
    public function index(Request $request)
    {
        $isFetch = SubscriptionPackage::where('is_active', 1)->get();
        return view('Company.subscription.index', compact('isFetch'));
    }
    // *****************************************************************************************
    public function add(Request $request, $uuid)
    {
        // dd($request->all());
        $authCompany = Auth::guard('company')->user();
        $companyId = searchCompanyId($authCompany->id);
        $date = Carbon::now()->format('Y-m-d');
        $id = uuidtoid($uuid, 'subscription_packages'); 
        $fetchSubscription = SubscriptionPackage::where('id', $id)->first();
        $fetchSubscriptionCompany = SubscriptionCompany::where('company_id', $companyId)->first();
        
        if($fetchSubscription->free_subscription==1){
            // dd( $fetchSubscription,$fetchSubscriptionCompany);
            return view('Company.subscription.razorPay.razor-pay', compact('fetchSubscription','fetchSubscriptionCompany'));
        }
            // dd( $fetchSubscription,$fetchSubscriptionCompany);

        $inr = 0.18 * $fetchSubscription->amount_inr;
        $totalPriceinr = $fetchSubscription->amount_inr + $inr;

        $rpay=$this->createRazorpayOrder($totalPriceinr);

        return view('Company.subscription.razorPay.razor-pay', compact('fetchSubscription','rpay','fetchSubscriptionCompany'));
    }
    // *****************************************************************************************
     protected function createRazorpayOrder($amount)
    {
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
        // dd($api);
        $receipt_id = time();
        $orderData = [
            'receipt' => (string) $receipt_id,
            'amount' => ($amount*100),
            'currency' => 'INR',
            'payment_capture' => 1,
        ];
        // dd($api->order->create($orderData));
        return $api->order->create($orderData);
    }   
    // *****************************************************************************************
    public function subscriptionadd(Request $request)
    {
        // Get current date and authenticated company
        $date = Carbon::now();
        $authCompany = Auth::guard('company')->user();
        $companyId = searchCompanyId($authCompany->id);
        $id = uuidtoid($request->uuid, 'subscription_packages');

        // Fetch the subscription package
        $fetchSubscription = SubscriptionPackage::find($id);
        if (!$fetchSubscription) {
            return redirect()->route('company.subscription.subscriptionadd')->with('error', 'Subscription package not found.');
        }
        $subscriptionCompany = SubscriptionCompany::where('company_id', $companyId)->where('status', 1)->first();
        // Initialize payment information if not free subscription
        $paymentInfo = null;
        if ($fetchSubscription->free_subscription == 0 && $subscriptionCompany!=null) {
            // dd($fetchSubscription,$subscriptionCompany);
            $api = new Api('rzp_test_SkPV10mNu9JnN7', 'wZGHrXK08T0qMZamhIBAW4pl');
            $paymentId = $request->razorpay_payment_id;
            $paymentInfo = $api->payment->fetch($paymentId);
            
            // Calculate total price with tax
            $inrRate = 0.18;
            $totalPriceinr = $fetchSubscription->amount_inr * (1 + $inrRate);
            $totalPriceusd = $fetchSubscription->amount_usd * (1 + $inrRate);
        }

        // Set subscription dates
        $from_date = $date->toDateString();
        $trial_end = $date->copy()->addDays($fetchSubscription->trial_period)->toDateString();
        $to_date = $fetchSubscription->duration !== null ? 
                    $date->copy()->addMonths($fetchSubscription->duration)->toDateString() : 
                    $trial_end;

        DB::beginTransaction();
        try {
            // Check for existing subscription
// dd($subscriptionCompany);
            if($subscriptionCompany?->is_trial==1){
                // Prepare subscription data
                $data = [
                    'is_subscribed'    => $fetchSubscription->id,
                    'company_id'      => $companyId,
                    'user_id'         => $authCompany->id,
                    'from_date'       => $from_date,
                    'to_date'         => $to_date,
                    'type'            => $fetchSubscription->title,    
                    'is_trial'        => 0,    
                ];
            }else if($subscriptionCompany?->is_trial==null){
                // Prepare subscription data
                $data = [
                    'is_subscribed'    => $fetchSubscription->id,
                    'company_id'      => $companyId,
                    'user_id'         => $authCompany->id,
                   
                    'type'            => $fetchSubscription->title,
                    'trial_start'     => $from_date,
                    'trial_end'       => $trial_end,
                    'trial_day'       => $fetchSubscription->trial_period,
                    'is_trial'        => 1,
                ];
            }else{
                $data = [
                    'is_subscribed'    => $fetchSubscription->id,
                    'company_id'      => $companyId,
                    'user_id'         => $authCompany->id,
                    'from_date'       => $from_date,
                    'to_date'         => $to_date,
                    'type'            => $fetchSubscription->title,
                    'trial_start'     => $from_date,
                    'trial_end'       => $trial_end,
                    'trial_day'       => $fetchSubscription->trial_period,
                    'is_trial'        => 1,
                ];
            }
            // Update company management subscription status
            CompanyManagment::where('id', $companyId)->update(['is_subscribed' => $fetchSubscription->id]);

            // Create or update subscription company record
            $additionalData = ['additional_feature_id' => null];
            if ($fetchSubscription->free_subscription == 1) {
                $additionalData['is_use_free_subscription'] = 1;
            }

            SubscriptionCompany::updateOrCreate(
                ['company_id' => $companyId, 'status' => 1],
                array_merge($data, $additionalData)
            );

            // If not a free subscription, log transaction
            if ($fetchSubscription->free_subscription == 0) {
                $paymentData = array_merge($data, [
                    'payment_data' => $paymentInfo ?? null,
                    'subscriptionCompany' => $subscriptionCompany,
                    'fetchSubscription' => $fetchSubscription,
                ]);
                addSubscriptionTranction($paymentData);
            }

            // Log the subscription
            addSubscriptionLogs(array_merge($data, ['payment_data' => $paymentInfo ?? null]));

            DB::commit();
            // return redirect()->route('company.dashboard.home')->with('success', 'User Subscription Subscribe Successfully');
            return redirect()->route('company.subscription.thankU')->with('success', 'User Subscription Subscribe Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage() . ' -- ' . $e->getFile() . ' -- ' . $e->getLine());
            return redirect()->route('company.subscription.subscriptionadd')->with('error', 'An error occurred while processing your request.');
        }
    }
    // *****************************************************************************************

    // public function subscriptionadd(Request $request)
    // {

    //     $date = Carbon::now();
    //     $authCompany = Auth::guard('company')->user();
    //     $companyId = searchCompanyId($authCompany->id);
    //     $id = uuidtoid($request->uuid, 'subscription_packages');
    //     $fetchSubscription = SubscriptionPackage::find($id);
    //     if (!$fetchSubscription) {
    //         return redirect()->route('company.subscription.subscriptionadd')->with('error', 'Subscription package not found.');
    //     }

    //     // dd($request->all(),$fetchSubscription);

    //     if($fetchSubscription?->free_subscription==0){

    //     $api = new Api('rzp_test_SkPV10mNu9JnN7','wZGHrXK08T0qMZamhIBAW4pl');
    //     $paymentId = $request->razorpay_payment_id;        
    //     $paymentInfo = $api->payment->fetch($paymentId);
    //     // we get payment info
    //     // dd($paymentInfo);

    //     // if ($request->isMethod('post')) {
    //         $inrRate = 0.18;
    //         $totalPriceinr = $fetchSubscription->amount_inr * (1 + $inrRate);
    //         $totalPriceusd = $fetchSubscription->amount_usd * (1 + $inrRate);
    //     }
    //         $from_date = $date->toDateString();
    //         $trial_end = $date->copy()->addDays($fetchSubscription->trial_period)->toDateString();
    //         $to_date = $fetchSubscription->duration !== null ? $date->copy()->addMonths($fetchSubscription->duration)->toDateString() : $trial_end;

    //         DB::beginTransaction();
    //         try {
    //             $subscriptionCompany = SubscriptionCompany::where('company_id', $companyId)
    //             ->where('status', 1)
    //             ->first();
            
    //         $data = [
    //             'is_subscribed' => $fetchSubscription->id,
    //             'company_id' => $companyId,
    //             'user_id' => $authCompany->id,
    //             'from_date' => $from_date,
    //             'to_date' => $to_date,
    //             'type' => $fetchSubscription->title,
    //             'trial_start' => $from_date,
    //             'trial_end' => $trial_end,
    //             'trial_day' => $fetchSubscription->trial_period,
    //             'is_trial' => 1
    //         ];        

    //         CompanyManagment::where('id', $companyId)->update([
    //             'is_subscribed' => $fetchSubscription->id
    //         ]);

    //         if($fetchSubscription?->free_subscription==1){
    //             SubscriptionCompany::updateOrCreate(
    //                 ['company_id' => $companyId, 'status' => 1], // Conditions to find the record
    //                 array_merge($data, ['additional_feature_id' => null,'is_use_free_subscription'=>1]) // Data to update or create
    //             );
    //         }else{
    //         // Use updateOrCreate for a more concise approach
    //             SubscriptionCompany::updateOrCreate(
    //                 ['company_id' => $companyId, 'status' => 1], // Conditions to find the record
    //                 array_merge($data, ['additional_feature_id' => null]) // Data to update or create
    //             );
    //             $paymentData=array_merge($data,['payment_data'=>$paymentInfo??null,'subscriptionCompany'=>$subscriptionCompany,'fetchSubscription'=>$fetchSubscription]);
    //             addSubscriptionTranction($paymentData);
    //         }

    //             addSubscriptionLogs(array_merge($data,['payment_data'=>$paymentInfo??null]));
    //             // dd($data,$paymentInfo);
    //             // dd($paymentData);
               
    //             DB::commit();
    //             return redirect()->route('company.subscription.thankU')->with('success', 'User  Subscription Subscribe Successfully');
    //         } catch (\Exception $e) {
    //             DB::rollBack();
    //             logger($e->getMessage() . ' -- ' . $e->getFile() . ' -- ' . $e->getLine());
    //             return redirect()->route('company.subscription.subscriptionadd')->with('error', 'An error occurred while processing your request.');
    //         }
    //     // }
    // }

    // *****************************************************************************************
    public function thankU(Request $request)
    {
        return view('Company.subscription.thanku');
    }
}
