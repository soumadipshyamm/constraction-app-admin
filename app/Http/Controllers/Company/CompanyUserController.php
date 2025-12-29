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

        $datas = CompanyUser::where('company_id', $companyId)->whereNotNull('company_role_id')->get();
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
        // if (count($checkAdditionalFeatures) <= $isSubscription->is_subscription) {
        // dd($request->all());
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
                // 'img' => 'mimes:jpeg,jpg,png',
            ]);

            // dd($request->all());
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
                            'country' => $request->country ?? null,
                            'city' => $request->city ?? null,
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
                        // dd($request->all());
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
                // dd($request->all());
                try {
                    // dd($request->all(), $companyId);
                    $isCompanyUser = CompanyUser::create([
                        'uuid' => Str::uuid() ?? " ",
                        'name' => $request->name ?? " ",
                        'phone' => $request->phone ?? " ",
                        'email' => $request->email ?? " ",
                        'password' => Hash::make($request->password) ?? " ",
                        'country' => $request->country ?? " ",
                        'state' => $request->state ?? " ",
                        'city' => $request->city ?? " ",
                        'dob' => $request->dob ?? " ",
                        'address' => $request->address ?? " ",
                        'designation' => $request->designation ?? " ",
                        'aadhar_no' => $request->aadhar_no ?? " ",
                        'pan_no' => $request->pan_no ?? " ",
                        'company_id' => $companyId ?? " ",
                        'company_role_id' => $request->company_user_role ?? " ",
                        'reporting_person' => $request->reporting_person ?? " ",
                        'profile_images' => $request->img ? getImgUpload($request->img, 'profile_image') : " ",
                    ]);
                    // dd($isCompanyUser);
                    $isCompanyUserRole = CompanyuserRole::create([
                        'company_id' => $companyId,
                        'company_user_id' => $isCompanyUser->id,
                        'company_role_id' => $request->company_user_role,
                    ]);

                    if ($isCompanyUser) {
                        $to = $request->email;
                        $subject = 'Create New Account';
                        $template = "emails.user_account";
                        $data = [
                            'name' => $request->name,
                            'username/email' => $request->email,
                            'password' => $request->password,
                            'message' => 'Created New Account '
                        ];
                        DB::commit();
                        sendEmail($to, $subject, $template, $data);
                        return redirect()->route('company.userManagment.list')->with('success', 'User Created Successfully');
                    }
                    // dd($request->all());
                } catch (\Exception $e) {
                    DB::rollBack();
                    logger($e->getMessage() . '--' . $e->getFile() . '--' . $e->getLine());
                    return redirect()->route('company.userManagment.list')->with('error', $e->getMessage());
                }
            }
        }
        return view('Company.userManagment.add-user');
        // } else {
        //     return redirect()
        //         ->back()
        //         // ->route('company.subscription.list')
        //         ->with('expired', true);
        // }
    }


    // public function add(Request $request)
    // {
    //     // Check subscription status

    //     $authConpany = Auth::guard('company')->user()->id;
    //         $companyId = searchCompanyId($authConpany);
    //         $checkAdditionalFeatures = fetchData($companyId, 'company_users');
    //         $isSubscription = checkSubscriptionPermission($companyId, 'no_of_users');

    //     // // if (!auth()->user()->subscriptionIsActive()) {
    //     //     return redirect()->back()->with('expired', true);
    //     // }

    //     try {
    //         DB::beginTransaction();
    //         if (count($checkAdditionalFeatures) <= $isSubscription->is_subscription) {
    //             // Validation rules
    //             $validationRules = [
    //                 'name' => 'required|string|max:255',
    //                 'phone' => 'required|string|max:15',
    //                 'email' => 'required|email|unique:company_users,email,' . $request->id,
    //                 'password' => $request->id ? 'nullable|string|min:8|confirmed' : 'required|string|min:8|confirmed',
    //                 'country' => 'nullable|string|max:255',
    //                 'state' => 'nullable|string|max:255',
    //                 'city' => 'nullable|string|max:255',
    //                 'dob' => 'nullable|date',
    //                 'address' => 'nullable|string|max:500',
    //                 'designation' => 'nullable|string|max:255',
    //                 'aadhar_no' => 'nullable|string|max:20',
    //                 'pan_no' => 'nullable|string|max:20',
    //                 'company_user_role' => 'required|exists:company_roles,id',
    //                 'reporting_person' => 'nullable|exists:company_users,id',
    //                 'img' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    //             ];

    //             // Validate request data
    //             $validatedData = $request->validate($validationRules);

    //             // Get company ID
    //             $companyId = auth()->user()->company_id;

    //             // Handle profile image
    //             $profileImage = $request->hasFile('img')
    //                 ? getImgUpload($validatedData['img'], 'profile_image')
    //                 : null;

    //             // Determine if updating or creating
    //             if ($request->id) {
    //                 // Update existing company user
    //                 $isCompanyUser = CompanyUser::findOrFail($request->id);
    //                 $isCompanyUser->update([
    //                     'name' => $validatedData['name'],
    //                     'phone' => $validatedData['phone'],
    //                     'email' => $validatedData['email'],
    //                     'password' => $request->password ? Hash::make($validatedData['password']) : $isCompanyUser->password,
    //                     'country' => $validatedData['country'],
    //                     'state' => $validatedData['state'],
    //                     'city' => $validatedData['city'],
    //                     'dob' => $validatedData['dob'],
    //                     'address' => $validatedData['address'],
    //                     'designation' => $validatedData['designation'],
    //                     'aadhar_no' => $validatedData['aadhar_no'],
    //                     'pan_no' => $validatedData['pan_no'],
    //                     'company_role_id' => $validatedData['company_user_role'],
    //                     'reporting_person' => $validatedData['reporting_person'],
    //                     'profile_images' => $profileImage ?? $isCompanyUser->profile_images,
    //                 ]);

    //                 // Update user role if needed
    //                 CompanyUserRole::updateOrCreate(
    //                     ['company_user_id' => $isCompanyUser->id],
    //                     [
    //                         'company_id' => $companyId,
    //                         'company_role_id' => $validatedData['company_user_role'],
    //                     ]
    //                 );

    //                 $message = 'User updated successfully.';
    //             } else {
    //                 // Create a new company user
    //                 $isCompanyUser = CompanyUser::create([
    //                     'uuid' => Str::uuid(),
    //                     'name' => $validatedData['name'],
    //                     'phone' => $validatedData['phone'],
    //                     'email' => $validatedData['email'],
    //                     'password' => Hash::make($validatedData['password']),
    //                     'country' => $validatedData['country'],
    //                     'state' => $validatedData['state'],
    //                     'city' => $validatedData['city'],
    //                     'dob' => $validatedData['dob'],
    //                     'address' => $validatedData['address'],
    //                     'designation' => $validatedData['designation'],
    //                     'aadhar_no' => $validatedData['aadhar_no'],
    //                     'pan_no' => $validatedData['pan_no'],
    //                     'company_id' => $companyId,
    //                     'company_role_id' => $validatedData['company_user_role'],
    //                     'reporting_person' => $validatedData['reporting_person'],
    //                     'profile_images' => $profileImage,
    //                 ]);

    //                 // Create user role
    //                 CompanyUserRole::create([
    //                     'company_id' => $companyId,
    //                     'company_user_id' => $isCompanyUser->id,
    //                     'company_role_id' => $validatedData['company_user_role'],
    //                 ]);

    //                 $message = 'User created successfully.';
    //             }

    //             // Commit transaction
    //             DB::commit();

    //             return redirect()->route('company.userManagment.list')->with('success', $message);
    //     }else{

    //         return redirect()->back()->with('expired', true);
    //     }
    //     } catch (\Exception $e) {
    //         // Rollback transaction and log error
    //         DB::rollBack();
    //         logger()->error("Error saving company user: {$e->getMessage()}", [
    //             'file' => $e->getFile(),
    //             'line' => $e->getLine(),
    //         ]);

    //         return redirect()->route('company.userManagment.list')->with('error', 'An error occurred while saving the user.');
    //     }

    // }



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
