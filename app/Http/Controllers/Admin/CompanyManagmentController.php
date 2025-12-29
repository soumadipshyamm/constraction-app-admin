<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Models\Admin\CompanyManagment;
use App\Models\Company\CompanyUser;
use App\Models\Company\CompanyuserRole;
use App\Models\Subscription\SubscriptionPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CompanyManagmentController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->setPageTitle('Company Managment');
        $datas = CompanyManagment::with('companyuser')->paginate(10);
        if (!empty($datas)) {
            return view('Admin.companyManagment.index', compact('datas'));
        }
        return view('Admin.companyManagment.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function add(Request $request)
    {
        if ($request->isMethod('post')) { {
                if ($request->isMethod('post')) {
                    // dd($request->all());
                    $validatedData = $request->validate([
                        'registration_name' => 'required',
                        'company_address' => 'required',
                        'phone' => 'required',
                        'user_name' => 'required',
                    ]);
                    DB::beginTransaction();
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
                                'password' => $request->password ? Hash::make($request->password) : $fechPassword->password,
                                'country' => $request->country,
                                'city' => $request->city,
                                'dob' => $request->dob,
                                'designation' => $request->designation,
                                'company_role_id' => 1,
                                // 'profile_images' => $request->profile_images ?? getImgUpload($request->profile_images, 'profile_image'),
                            ]);
                            if ($isCompanyUser) {
                                DB::commit();
                                return redirect()->route('admin.companyManagment.list')->with('success', 'Company Managment Created Successfully');
                            }
                        } catch (\Exception $e) {
                            DB::rollBack();
                            logger($e->getMessage() . '--' . $e->getFile() . '--' . $e->getLine());
                            return redirect()->route('admin.companyManagment.list')->with('success', 'Company Managment Created Successfully');
                        }
                    } else {
                        try {
                            // dd($request->all());
                            $isCompaniesCreated = CompanyManagment::create([
                                'uuid' => Str::uuid(),
                                'name' => $request->registration_name,
                                'registration_no' => $request->company_registration_no,
                                'address' => $request->company_address,
                                'phone' => $request->company_phone,
                                'website_link' => $request->website_link,
                            ]);
                            $isCompanyUser = CompanyUser::create([
                                'uuid' => Str::uuid(),
                                'name' => $request->user_name,
                                'phone' => $request->phone,
                                'email' => $request->email,
                                'password' => Hash::make($request->password),
                                'country' => $request->country,
                                'city' => $request->city,
                                'dob' => $request->dob,
                                'designation' => $request->designation,
                                'company_role_id' => 1,
                                'profile_images' => $request->profile_images ? getImgUpload($request->profile_images, 'profile_image') : '',
                            ]);
                            $isCompanyUserRole = CompanyuserRole::create([
                                'company_id' => $isCompaniesCreated->id,
                                'company_user_id' => $isCompanyUser->id,
                                'company_role_id' => 1,
                            ]);
                            if ($isCompanyUserRole) {
                                DB::commit();
                                return redirect()->route('admin.companyManagment.list')->with('success', 'Company Managment Created Successfully');
                            }
                        } catch (\Exception $e) {
                            DB::rollBack();
                            logger($e->getMessage() . '--' . $e->getFile() . '--' . $e->getLine());
                            return redirect()->route('admin.companyManagment.list')->with('success', 'Company Managment Created Successfully');
                        }
                    }
                }
                return view('Frontend.auth.registration');
            }
        }
        return view('Admin.companyManagment.add-edit');
    }

    public function edit(Request $request, $uuid)
    {
        $id = uuidtoid($uuid, 'company_managments');
        $data = CompanyManagment::with(['companyuser' => function ($q) {
            $q->where('company_users.company_role_id', 1);
        }])->where('company_managments.id', $id)->first();
        // dd($data->toArray());
        if ($data) {
            return view('Admin.companyManagment.add-edit', compact('data'));
        }
        return redirect()->route('Admin.companyManagment.list')->with('error', 'something want to be worng');
    }
    public function preview(Request $request, $uuid)
    {
        $id = uuidtoid($uuid, 'company_managments');
        $datas = CompanyManagment::with([
            'companyuser' => function ($q) {
                $q->where('company_users.company_role_id', 1);
            }
        ])->where('company_managments.id', $id)->first();
        // dd($datas->toArray());
// preview  "is_subscribed" => 2

$fetchSubscription = SubscriptionPackage::where('id', $datas->is_subscribed)->first();
        if (!empty($datas)) {
            return view('Admin.companyManagment.preview', compact('datas','fetchSubscription'));
        }
    }
}
