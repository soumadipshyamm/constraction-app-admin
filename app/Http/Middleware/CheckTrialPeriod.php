<?php

namespace App\Http\Middleware;

use App\Models\SubscriptionCompany;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckTrialPeriod
{

    public function handle(Request $request, Closure $next)
    {
        $date = Carbon::now();
        $user = Auth::user();
        $authCompany = Auth::guard('company')->user()->id;
        $companyId = searchCompanyId($authCompany);
        // Get the authenticated user's subscription company
        $subscriptionCompany = SubscriptionCompany::with('subscriptionPackage')->where('company_id', $companyId)->first();
        // Check if subscription exists and trial is active
        if ($subscriptionCompany) {
            $isTrial = $subscriptionCompany->is_trial; // Check if trial is active
            $trialEndDate = $subscriptionCompany->trial_end;
            if (Carbon::now()->lt($trialEndDate)) {
                // The trial period is still active
                return $next($request);
            } elseif ( $subscriptionCompany->status == 1 && Carbon::now()->lt($subscriptionCompany->to_date)) {
                // The trial has ended or is not active
            // if ($isTrial == 1 && Carbon::now()->lt($trialEndDate)) {
            //     // The trial period is still active
            //     return $next($request);
            // } elseif ($isTrial == 0 && $subscriptionCompany->status == 1 && Carbon::now()->lt($subscriptionCompany->to_date)) {
            //     // The trial has ended or is not active
                return $next($request);
            } else {
                // Redirect to subscription add page with uuid
                return redirect()->route('company.subscription.scriptionlist');
                // return redirect()->route('company.subscription.add', ['uuid' => $subscriptionCompany->subscriptionPackage->uuid]);
            }
        }

        // If no subscription company is found, return a suitable response
        return redirect()->route('company.subscription.add', ['uuid' => $subscriptionCompany?->subscriptionPackage->uuid]);
    }
    // public function handle(Request $request, Closure $next)
    // {
    //     $date = Carbon::now();
    //     $user = Auth::user();
    //     $authCompany = Auth::guard('company')->user()->id;
    //     $companyId = searchCompanyId($authCompany);
    //     // Get the authenticated user's subscription company
    //     $subscriptionCompany = SubscriptionCompany::with('subscriptionPackage')->where('company_id', $companyId)->first();
    //     // Check if subscription exists and trial is active
    //     if ($subscriptionCompany) {
    //         $isTrial = $subscriptionCompany->is_trial; // Check if trial is active
    //         $trialEndDate = $subscriptionCompany->trial_end;
    //         if ($isTrial == 1 && Carbon::now()->lt($trialEndDate)) {
    //             // The trial period is still active
    //             return $next($request);
    //         } elseif ($isTrial == 0 && $subscriptionCompany->status == 1 && Carbon::now()->lt($subscriptionCompany->to_date)) {
    //             // The trial has ended or is not active
    //             return $next($request);
    //         } else {
    //             // Redirect to subscription add page with uuid
    //             return redirect()->route('company.subscription.add', ['uuid' => $subscriptionCompany->subscriptionPackage->uuid]);
    //         }
    //     }

    //     // If no subscription company is found, return a suitable response
    //     return redirect()->route('company.subscription.add', ['uuid' => $subscriptionCompany?->subscriptionPackage->uuid]);
    // }


}
