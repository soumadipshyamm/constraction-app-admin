<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\BaseController;
use App\Models\Admin\CompanyManagment;
use App\Models\Company\CompanyUser;
use App\Models\Company\CompanyuserRole;
use App\Models\Company\Company_permission;
use App\Models\Company\Company_user_permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CompanyUserController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->setPageTitle('User');
        $authConpany = Auth::guard('company')->user()->id;
        // $employees = CompanyUser::findOrFail($authConpany);
        // $absvvd = $employees->userCompany;
        // $companyId = $absvvd[0]->id;
        $companyId = searchCompanyId($authConpany);

        $datas = CompanyUser::where('company_id', $companyId)->get();
        // dd($datas->toArray());
        if (!empty($datas)) {
            return view('Company.userManagment.index', compact('datas'));
        }
        return view('Company.userManagment.index');
    }
    protected function getEmailValidationRule(Request $request)
    {
        $uuid = $request->uuid;
        if ($uuid === 'false') {
            return 'required|';
        } else {
            return 'nullable|';
        }
    }
    /**
     * Show the form for creating a new resource.
     */

    public function add(Request $request)
    {
        $authConpany = Auth::guard('company')->user()->id;
        $companyId = searchCompanyId($authConpany);
        $checkAdditionalFeatures = fetchData($companyId, 'company_users');
        $isSubscription = checkSubscriptionPermission($companyId, 'no_of_users');
        if (count($checkAdditionalFeatures) <= $isSubscription->is_subscription) {
            // dd($checkAdditionalFeatures);
            if ($request->isMethod('post')) {
                // dd($request->all());
                $validatedData = $request->validate([
                    'company_user_role' => 'required',
                    'name' => 'required',
                    // 'email' => 'required_if|unique:company_users,email',
                    'email' => 'required',
                    // 'password' => 'required|confirmed',
                    'phone' => 'required',
                    'address' => 'required',
                    'designation' => 'required',
                    // 'reporting_person' => 'required',
                    'img' => 'mimes:jpeg,jpg,png',
                ]);
                DB::beginTransaction();
                if ($request->uuid) {
                    // dd($request->all());
                    try {
                        $id = uuidtoid($request->uuid, 'company_users');
                        $fetchUserId = CompanyUser::find($id);
                        if ($request->hasFile('img')) {
                            deleteFile($id, 'company_users', 'profile_images', 'profile_image');

                            $isUpdated = CompanyUser::where('id', $id)->update([
                                'name' => $request->name,
                                'phone' => $request->phone,
                                // 'email' => $request->email,
                                // 'password' => $request->password ? Hash::make($request->password) : $fetchUserId->password,
                                'country' => $request->country,
                                'city' => $request->city,
                                'dob' => $request->dob,
                                'address' => $request->address,
                                'designation' => $request->designation,
                                'aadhar_no' => $request->aadhar_no,
                                'pan_no' => $request->pan_no,
                                'company_role_id' => $request->company_user_role,
                                'reporting_person' => $request->reporting_person,
                                'profile_images' => getImgUpload($request->img, 'profile_image'),
                            ]);
                        } else {
                            $id = uuidtoid($request->uuid, 'company_users');
                            $isUpdated = CompanyUser::where('id', $id)->update([
                                'name' => $request->name,
                                'phone' => $request->phone,
                                // 'email' => $request->email,
                                // 'password' => $request->password ? Hash::make($request->password) : $fetchUserId->password,
                                'country' => $request->country,
                                'city' => $request->city,
                                'dob' => $request->dob,
                                'address' => $request->address,
                                'designation' => $request->designation,
                                'aadhar_no' => $request->aadhar_no,
                                'pan_no' => $request->pan_no,
                                'reporting_person' => $request->reporting_person,
                                'company_role_id' => $request->company_user_role,
                            ]);
                        }

                        // $isUpdated = CompanyUser::where('id', $id)->update([
                        //     'name' => $request->name,
                        //     'phone' => $request->phone,
                        //     'email' => $request->email,
                        //     'password' => $request->password ? Hash::make($request->password) : $fetchUserId,
                        //     'country' => $request->country,
                        //     'city' => $request->city,
                        //     'dob' => $request->dob,
                        //     'address' => $request->address,
                        //     'designation' => $request->designation,
                        //     'aadhar_no' => $request->aadhar_no,
                        //     'pan_no' => $request->pan_no,
                        //     'company_role_id' => $request->company_user_role,
                        //     'reporting_person' => $request->reporting_person,
                        //     // 'profile_images' => $img,
                        // ]);
                        // } else {
                        //     $id = uuidtoid($request->uuid, 'company_users');
                        //     $isUpdated = CompanyUser::where('id', $id)->update([
                        //         'name' => $request->name,
                        //         'phone' => $request->phone,
                        //         'email' => $request->email,
                        //         'password' => $request->password ? Hash::make($request->password) : $fetchUserId,
                        //         'country' => $request->country,
                        //         'city' => $request->city,
                        //         'dob' => $request->dob,
                        //         'address' => $request->address,
                        //         'designation' => $request->designation,
                        //         'aadhar_no' => $request->aadhar_no,
                        //         'pan_no' => $request->pan_no,
                        //         'reporting_person' => $request->reporting_person,
                        //         'company_role_id' => $request->company_user_role,
                        //     ]);
                        // }
                        if ($isUpdated) {
                            DB::commit();
                            // dd($isUpdated);
                            return redirect()->route('company.userManagment.list')->with('success', 'User Updated Successfully');
                        } else {
                            return redirect()->route('company.userManagment.list')->with('error', 'something want to be worng');
                        }
                    } catch (\Exception $e) {
                        DB::rollBack();
                        logger($e->getMessage() . '--' . $e->getFile() . '--' . $e->getLine());
                        return redirect()->route('company.userManagment.list')->with('false', $e->getMessage());
                    }
                } else {
                    try {
                        // $checkexist = CompanyUser::where('email', $request->email)->first();
                        // if (!empty($checkexist)) {
                        //     return redirect()->route('company.userManagment.add')->with('message', 'Email id already exist!');
                        // }
                        $isCompanyUser = CompanyUser::create([
                            'uuid' => Str::uuid(),
                            'name' => $request->name,
                            'phone' => $request->phone,
                            'email' => $request->email,
                            'password' => Hash::make($request->password),
                            'country' => $request->country,
                            'city' => $request->city,
                            'dob' => $request->dob,
                            'address' => $request->address,
                            'designation' => $request->designation,
                            'aadhar_no' => $request->aadhar_no,
                            'pan_no' => $request->pan_no,
                            'company_id' => $companyId,
                            'company_role_id' => $request->company_user_role,
                            'reporting_person' => $request->reporting_person,
                            'profile_images' => $request->img ? getImgUpload($request->img, 'profile_image') : '',
                        ]);

                        $isCompanyUserRole = CompanyuserRole::create([
                            'company_id' => $companyId,
                            'company_user_id' => $isCompanyUser->id,
                            'company_role_id' => $request->company_user_role,
                        ]);

                        if ($isCompanyUser) {
                            DB::commit();
                            return redirect()->route('company.userManagment.list')->with('success', 'User Created Successfully');
                        }
                    } catch (\Exception $e) {
                        DB::rollBack();
                        logger($e->getMessage() . '--' . $e->getFile() . '--' . $e->getLine());
                        return redirect()->route('company.userManagment.list')->with('error', $e->getMessage());
                    }
                }
            }
            return view('Company.userManagment.add-user');
        } else {
            return redirect()
                ->back()
                // ->route('company.subscription.list')
                ->with('expired', true);
        }
    }
    public function edit(Request $request, $uuid)
    {
        $id = uuidtoid($uuid, 'company_users');
        $data = CompanyUser::with('companyUserRole')->where('id', $id)->first();
        if ($data) {
            return view('Company.userManagment.add-user', compact('data'));
        }
        return redirect()->route('company.userManagment.list')->with('error', 'something want to be worng');
    }

    // **************************************************************************************************************
    public function userPermission(Request $request, $uuid)
    {
        $id = uuidtoid($uuid, 'company_users');
        $menus = Company_permission::all();
        $permissionInfo = Company_user_permission::where('company_user_id', $id)->get();
        $permissionInfo = $permissionInfo->toArray();
        $tempArr = [];
        if (!empty($permissionInfo)) :
            foreach ($permissionInfo as $key => $value) :
                $tempArr[$value['company_permission_id']][] = $value['action'];
            endforeach;
        endif;
        return view('Company.userManagment.add-userWisePermission', compact('menus', 'tempArr', 'id'));
    }
    public function addUserPermission(Request $request)
    {
        // dd($request->input('permission'));
        $updateId = $request->input('updateId');
        $inputPermissions = $request->input('permission');
        if ($updateId) {
            if ($inputPermissions) {
                $tempArr = [];
                foreach ($inputPermissions as $menu => $actions) {
                    foreach ($actions as $action) {
                        $tempArr[] = [
                            'company_user_id' => $updateId,
                            'company_permission_id' => $menu,
                            'action' => $action,
                        ];
                    }
                }
                Company_user_permission::where('company_user_id', $updateId)->delete();
                Company_user_permission::insert($tempArr);
            } else {
                Company_user_permission::where('company_user_id', $updateId)->delete();
            }
        }
        return redirect()->back()->with('success', 'User permissions updated successfully.');
    }
}

// "uuid" => null
// "name" => "labour2"
// "designation" => "ssssssssssssssss"
// "aadhar_no" => "222222222222222222222"
// "pan_no" => "ss33333333333"
// "email" => "cap@abc.com"
// "phone" => "1234567890"
// "password" => "12345678"
// "password_confirmation" => "12345678"
// "address" => "kolkata"
// "country" => "yyyyyy"
// "city" => "ttttttttttttt"
// "dob" => "2023-08-10"
// "company_user_role" => "4"
// "reporting_person" => "1"
// "img" => Illuminate\Http\UploadedFile {#1298 ▶}
