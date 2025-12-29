<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Company\Teams;
use Illuminate\Support\Facades\DB;
use App\Models\Company\CompanyUser;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Company\CompanyuserRole;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\API\Teams\TeamsResources;
use App\Http\Resources\Common\CountryResources;

class TeamsController extends BaseController
{
    public function teamsList(Request $request)
    {
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $data = CompanyUser::where('company_id', $authCompany)->whereNotNull('company_role_id')->orderBy('id', 'desc')->get();
        $message = $data->isNotEmpty() ? 'Fetch Teams List Successfully' : 'Teams List Data Not Found';
        return $this->responseJson(true, 200, $message, $data);
    }

    public function teamsAdd(Request $request)
    {
        $authCompany = Auth::guard('company-api')->user()->company_id;

        // Common validation rules
        $rules = [
            'company_user_role' => 'required',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:company_users,email',
            'country_code' => 'required|in:91,971',
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:255',
            'designation' => 'nullable|string|max:255',
            'profile_images' => 'nullable|mimes:jpeg,jpg,png|max:2048',
            'dob' => 'nullable|date',
            'aadhar_no' => 'nullable|string|max:12',
            'pan_no' => 'nullable|string|max:10',
            // 'reporting_person' => 'nullable|integer',
        ];

        if ($request->updateId) {
            $rules['email'] = 'required|email|unique:company_users,email,' . $request->updateId; // Keep unique check for update
            // $rules['phone'] = 'required|string|max:15|unique:company_users,phone,' . $request->updateId; // Keep unique check for update
        } else {
            $rules['password'] = 'required|min:8';
        }

        $validatedData = $request->validate($rules);

        DB::beginTransaction();
        try {
            if ($request->updateId) {
                // Update user logic
                $id = $request->updateId;
                $fetchUser = CompanyUser::findOrFail($id);

                // Handle image upload
                $profileImage = $fetchUser->profile_images;
                if ($request->hasFile('profile_images')) {
                    // Delete existing image
                    deleteFile($id, 'company_users', 'profile_images', 'profile_image');
                    $profileImage = getImgUpload($request->file('profile_images'), 'profile_image');
                }

                $fetchUser->update([
                    'name' => $request->name,
                    'country_code' => $request->country_code,
                    'phone' => $request->phone,
                    'email' => $request->email,
                    'country' => $request->country,
                    'state' => $request->state,
                    'city' => $request->city,
                    'dob' => $request->dob,
                    'address' => $request->address,
                    'designation' => $request->designation,
                    'aadhar_no' => $request->aadhar_no,
                    'pan_no' => $request->pan_no,
                    'company_role_id' => $request->company_user_role,
                    'reporting_person' => $request->reporting_person,
                    'profile_images' => $profileImage,
                ]);

                $message = 'User Updated Successfully';
            } else {
                // Create user logic
                $isCompanyUser = CompanyUser::create([
                    'uuid' => Str::uuid(),
                    'name' => $request->name,
                    'country_code' => $request->country_code,
                    'phone' => $request->phone,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'dob' => $request->dob,
                    'address' => $request->address,
                    'designation' => $request->designation,
                    'aadhar_no' => $request->aadhar_no,
                    'pan_no' => $request->pan_no,
                    'country' => $request->country ?? null,
                    'state' => $request->state ?? null,
                    'city' => $request->city ?? null,
                    'company_id' => $authCompany,
                    'company_role_id' => $request->company_user_role,
                    'reporting_person' => $request->reporting_person,
                    'profile_images' => $request->file('profile_images') ? getImgUpload($request->file('profile_images'), 'profile_image') : null,
                ]);
                $message = 'User Created Successfully';

                $to =$request->email;
                $subject = 'Create New Account';
                $template = "emails.user_account";
                $data = [
                    'name' => $request->name,
                    'email'=>$request->email,
                    'password'=>$request->password,
                    'message' => 'Created New Account '
                ];
                sendEmail($to,$subject,$template,$data);
            }
            // Commit the transaction
            DB::commit();
            return $this->responseJson(true, 200, $message, $isCompanyUser ?? $fetchUser);
        } catch (\Exception $e) {
            // Rollback the transaction on error
            DB::rollBack();
            logger($e->getMessage() . ' on ' . $e->getFile() . ' in ' . $e->getLine());
            return $this->responseJson(false, 500, 'An error occurred. Please try again.', []);
        }
    }

    public function search(Request $request)
    {
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $datas = CompanyUser::where('company_id', $authCompany)
            ->where('is_active', 1);

        if ($request->has('search_keyword') && $request->search_keyword != "") {
            $datas->where(function ($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->search_keyword . '%')
                    ->orWhere('email', 'LIKE', '%' . $request->search_keyword . '%');
            });
        }
        $datas = $datas->get();
        return $datas;
        // return TeamsResources::collection($datas);
    }

    public function edit($uuid)
    {
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $data = CompanyUser::with('countries', 'states', 'cities', 'reportingPerson')->where('id', $uuid)->where('company_id', $authCompany)->first();
        $message = 'Fetch User List Successfully';
        // $data=$data->country;
        // dd($data);
        return $this->responseJson(true, 200, $message, new TeamsResources($data));
        // return $this->responseJson(true, 200, $message, new CountryResources($data));
    }

    public function details(Request $request)
    {
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $data = CompanyUser::where('id', $request->details_search_id)->where('company_id', $authCompany)->first();
        // dd($data);
        $message =  'Fetch User List Successfully' ?? 'User List Data Not Found';
        return $this->responseJson(true, 200, $message, $data);
    }

    public function delete($uuid)
    {
        DB::beginTransaction();
        try {
            $authCompany = Auth::guard('company-api')->user()->company_id;
            $data = CompanyUser::where('id', $uuid)
                ->where('company_id', $authCompany)
                ->delete();
            $message = $data > 0 ? 'User Delete Successfully' : 'User Data Not Found';
            DB::commit();
            return $this->responseJson(true, 200, $message, $data);
        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage() . ' on ' . $e->getFile() . ' in ' . $e->getLine());
            return $this->responseJson(false, 500, $e->getMessage(), []);
        }
    }

    public function teamsPasswordUpdate($uuid)
    {
        return $uuid;
    }

    // public function teamsChat(Request $request)
    // {
    //     // dd("lkjhgfd");
    //     // dd(setup_client_create());
    //     // dd(getFirestoreData());
    // }
}
