<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\BaseController;
use App\Models\Admin\CompanyManagment;
use App\Models\Company\CompanyUser;
use App\Models\Company\Dashboard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use vitopedro\chartjs\PieChart;

class DashboardController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Session::put('navbar', 'dashboard');
        $projectWiseDpr = projectwisedpr(1);
        $estimatedCost = estimatedcost(1);
        $estimatedCostForExecutedQty = estimatedcostforexecutedqty($estimatedCost, 1);

        // dd($projectWiseDpr->toArray());
        dd($projectWiseDpr,$estimatedCost,$estimatedCostForExecutedQty);
        // dd($estimatedCostForExecutedQty);

        return view('Company.dashboard.index');
    }
    /**
     * Show the form for creating a new resource.
     */
    public function UpdatePassword(Request $request)
    {
        if ($request->isMethod('post')) {
            //  dd(auth()->guard('company')->user()->password);
            $request->validate([
                'old_password' => 'required',
                'new_password' => 'required',
                // 'new_password' => 'required',
                'confirm_password' => ['same:new_password'],
            ]);
            DB::beginTransaction();
            try {
                if (Hash::check($request->old_password, auth()->guard('company')->user()->password)) {
                    $passwordUpdate = CompanyUser::find(auth()->guard('company')->user()->id)->update([
                        'password' => Hash::make($request->new_password),
                    ]);
                    // dd($passwordUpdate);
                    DB::commit();
                    return redirect()->route('company.home')->with('success', 'Password Updated Successfully');
                } else {
                    // return $this->responseRedirectBack('do not matched the password ', 'info', true, true);
                    return redirect()->route('company.dashboard.password-update')->with('error', 'Do not matched the password');
                }
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->route('company.dashboard.password-update')->with('error', 'something want to be worng');
            }
        }
        return view('Company.dashboard.password-update');
    }

    public function profile(Request $request, $uuid)
    {
        $authConpany = uuidtoid($uuid, 'company_users');
        $companyId = searchCompanyId($authConpany);
        $data = CompanyManagment::with([
            'companyuser' => function ($q) {
                $q->where('company_users.company_role_id', 1);
            }
        ])->where('company_managments.id', $companyId)->first();
        // dd($data->toArray());
        return view('Company.profile.index', compact('data'));
    }

    public function updateProfile(Request $request)
    {
        if ($request->uuid) {
            try {
                // dd($request->all());
                $cid = uuidtoid($request->uuid, 'company_managments');
                $isCompaniesCreated = CompanyManagment::where('id', $cid)->update([
                    'name' => $request->registration_name,
                    'registration_no' => $request->company_registration_no,
                    'address' => $request->company_address,
                    'phone' => $request->company_phone,
                    'website_link' => $request->website_link,
                ]);

                $uid = uuidtoid($request->cid, 'company_users');
                $fechPassword = CompanyUser::find($uid);
                // dd($fechPassword->password);
                $isCompanyUser = CompanyUser::where('id', $uid)->update([
                    'name' => $request->user_name,
                    'phone' => $request->phone,
                    'email' => $request->email,
                    // 'password' =>$request->password?Hash::make($request->password):$fechPassword->password,
                    'country' => $request->country,
                    'city' => $request->city,
                    'dob' => $request->dob,
                    'designation' => $request->designation,
                    // 'profile_images' => $request->profile_images ?? getImgUpload($request->profile_images, 'profile_image'),
                ]);
                if ($isCompanyUser) {
                    DB::commit();
                    return redirect()->route('company.home')->with('success', 'Profile Update Successfully');
                }
            } catch (\Exception $e) {
                DB::rollBack();
                logger($e->getMessage() . '--' . $e->getFile() . '--' . $e->getLine());
                return redirect()->route('company.profile')->with('error', 'something want to be worng');
            }
        }
    }
}
