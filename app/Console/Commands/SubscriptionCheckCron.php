<?php

namespace App\Console\Commands;

use App\Models\SubscriptionCompany;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SubscriptionCheckCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'log:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $companies = SubscriptionCompany::where('status', 1) // Only active subscriptions
            // ->whereDate('to_date', '<', now())
            ->get();

        // foreach ($companies as $company) {
        //     $company->update(['status' => 0]); // Set status to expired (0)
        // }
        Log::info("Subscription ID {$companies}");

        // $authConpany = Auth::guard('company')->user();
        // Log::info("Subscription ID" . $authConpany);
        // $sevenDaysAgo = now()->subDays(7);
        // $subscriptionsBeforeEndDate = SubscriptionCompany::where('status', 1) // Only active subscriptions
        //     ->whereDate('to_date', '<', $sevenDaysAgo)
        //     ->get();

        // foreach ($subscriptionsBeforeEndDate as $subscription) {
        //     Log::info("Subscription ID {$subscription->id} is expiring in less than 7 days.");
        // }
        // dd(Auth::guard('company')->user());
        // SubscriptionCompany::where('status', 1) // Only active subscriptions
        //     ->whereDate('to_date', '<', now())
        //     ->update(['status' => 0]); // Set status to expired (0)

        // // Set subscriptions to inactive where from_date is in the future
        // SubscriptionCompany::where('status', 1) // Only active subscriptions
        //     ->whereDate('from_date', '>', now())
        //     ->update(['status' => 0]); // Set status to inactive (0)

        // // Set subscriptions to active where from_date is in the past and to_date is in the future
        // SubscriptionCompany::where('status', 0) // Only inactive or expired subscriptions
        //     ->whereDate('from_date', '<=', now())
        //     ->whereDate('to_date', '>=', now())
        //     ->update(['status' => 1]); // Set status to active (1)
        // info("kjhgfdsa");
        // $authCompany = Auth::guard('company')->user();
        // $companyId = searchCompanyId($authCompany->id);
        // info($authCompany);
        // Log::info($authCompany);
    }
}
