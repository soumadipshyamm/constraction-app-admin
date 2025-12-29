<?php

namespace App\Http\Middleware;

use App\Models\Admin\CompanyManagment;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckSubscription
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // $date = Carbon::now();
        // $user = Auth::user();
        // $authConpany = Auth::guard('company')->user()->id;
        // $companyId = searchCompanyId($authConpany);

   
        
        // $company = CompanyManagment::where('id', $companyId)
        // ->whereHas('isSubscribed', function ($qwe) use ($date) {
        //     $qwe->whereDate('from_date', '<=', $date)
        //         ->whereDate('to_date', '>=', $date)
        //         ->where('status', 1)
        //         ->where(function ($query) {
        //             $query->whereHas('subscriptionPackage', function ($dsw) {
        //                 $dsw->where('free_subscription', 0); // paid
        //             })
        //             ->orWhereHas('subscriptionPackage', function ($dsw) {
        //                 $dsw->where('free_subscription', 1) // free
        //                     ->whereHas('subscriptionPackageOption', function ($optionQuery) {
        //                         $optionQuery->where('subscription_key', 'web_app');
        //                         $optionQuery->where('is_subscription', 'yes');
        //                     });
        //             });
        //         });
        // })
        // ->first();


        $date = Carbon::now();
        $user = Auth::user();
        $authCompanyId = Auth::guard('company')->user()->id;
        $companyId = searchCompanyId($authCompanyId);

        $company = CompanyManagment::where('id', $companyId)
            ->whereHas('isSubscribed', function ($query) use ($date) {
                // Check if the trial period is active
                $query->where(function ($q) use ($date) {
                    $q->where('is_trial', 1)
                    ->whereDate('trial_start', '<=', $date)
                    ->whereDate('trial_end', '>=', $date);
                })
                ->orWhere(function ($q) use ($date) {
                    // Check if the subscription is active
                    $q->where('status', 1)
                    ->whereDate('from_date', '<=', $date)
                    ->whereDate('to_date', '>=', $date);
                });

                // Check for subscription packages
                $query->where(function ($subQuery) {
                    $subQuery->whereHas('subscriptionPackage', function ($pkgQuery) {
                        $pkgQuery->where('free_subscription', 0); // Paid subscription
                    })
                    ->orWhere(function ($freeQuery) {
                        $freeQuery->whereHas('subscriptionPackage', function ($pkgQuery) {
                            $pkgQuery->where('free_subscription', 1) // Free subscription
                                ->whereHas('subscriptionPackageOption', function ($optionQuery) {
                                    $optionQuery->where('subscription_key', 'web_app')
                                                ->where('is_subscription', 'yes');
                                });
                        });
                    });
                });
            })
            ->first();

    
        // dd($company);
        // Check if user is authenticated and has an active subscription
        if ($company && $company->isSubscribed()) {
            return $next($request);
        }

        // Redirect or return an error response if subscription is inactive
        return redirect()->route('company.subscription.scriptionlist'); // Modify as per your application logic
    }
}
