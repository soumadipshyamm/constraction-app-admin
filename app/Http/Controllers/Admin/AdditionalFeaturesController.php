<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Models\Subscription\AdditionalFeatures;
use App\Models\Subscription\SubscriptionPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class AdditionalFeaturesController extends BaseController
{
    public function index(Request $request)
    {
        $datas = AdditionalFeatures::first();
        // dd($datas);
        return view('Admin.subscription.additionalPurchase.index', compact('datas'));
    }
    public function add(Request $request)
    {
        // dd('adssssssss');
        if ($request->isMethod('post')) {
            // dd($request->all());
            $validatedData = $request->validate([
                'aditional_project_inr' => 'required',
                'aditional_project_usd' => 'required',
                'additional_users_inr' => 'required',
                'additional_users_usd' => 'required',
            ]);
            DB::beginTransaction();
            try {
                $fetchData = AdditionalFeatures::first();

                if ($fetchData) {
                    $isCompanyUser = AdditionalFeatures::where('id', $fetchData->id)->update([
                        'aditional_project_inr' => $request->aditional_project_inr,
                        'aditional_project_usd' => $request->aditional_project_usd,
                        'additional_users_inr' => $request->additional_users_inr,
                        'additional_users_usd' => $request->additional_users_usd,
                    ]);
                    if ($isCompanyUser) {
                        DB::commit();
                        return redirect()
                            ->route('admin.additionalFeatures.list')
                            ->with('success', 'Additional Features Managment Update Successfully');
                    }
                } else {
                    $isCompanyUser = AdditionalFeatures::create([
                        'uuid' => Str::uuid(),
                        'aditional_project_inr' => $request->aditional_project_inr,
                        'aditional_project_usd' => $request->aditional_project_usd,
                        'additional_users_inr' => $request->additional_users_inr,
                        'additional_users_usd' => $request->additional_users_usd,
                    ]);
                    // dd($isCompanyUser);

                    if ($isCompanyUser) {
                        DB::commit();
                        return redirect()
                            ->route('admin.subscription.list')
                            ->with('success', 'Additional Features Managment Created Successfully');
                    }
                }
            } catch (\Exception $e) {
                DB::rollBack();
                logger($e->getMessage() . '--' . $e->getFile() . '--' . $e->getLine());
            }
        }
        $data = AdditionalFeatures::first();
        return view('Admin.subscription.additionalPurchase.additional-purchase', compact('data'));
    }
}
