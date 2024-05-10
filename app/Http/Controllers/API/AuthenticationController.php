<?php

namespace App\Http\Controllers\API;

use App\Models\Cities;
use App\Models\States;
use App\Models\Countries;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Company\Project;
use Illuminate\Support\Facades\DB;
use App\Models\Company\CompanyUser;
use App\Models\Company\Company_role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin\CompanyManagment;
use App\Models\Company\CompanyuserRole;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\BaseController;
use App\Http\Resources\API\Profile\ProfileResources;
use Illuminate\Support\Facades\Validator;

class AuthenticationController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function signUp(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'company_name' => 'required',
            'company_address' => 'required',
            'company_phone' => 'required',
            'phone' => 'required|numeric',
            'name' => 'required',
            'email' => 'required|email|max:250',
            'password' => 'required',
            'profile_images' => 'mimes:jpeg,jpg,png',
        ]);
        // if ($validator->fails()) {
        //     return $this->responseJson(false, 400, $validator->errors()->all(), []);
        // }
        if ($validator->fails()) {
            $status = false;
            $code = 422;
            $response = [];
            $message = $validator->errors()->first();
            return $this->responseJson($status, $code, $message, $response);
        }
        $is_subscribed = getFreeSubscribeId('');
        DB::beginTransaction();
        $exitexEmail = CompanyUser::where('phone', $request->phone)
            ->where('email', $request->email)
            ->first();
        // dd($exitexEmail->id);
        try {
            if ($exitexEmail) {
                $isResendOtp = CompanyUser::where('id', $exitexEmail->id)->update([
                    'otp_no' => genrateOtp(),
                ]);
                if ($isResendOtp) {
                    $data = CompanyUser::where('id', $exitexEmail->id)->first();
                }
                // dd($data);
                if ($isResendOtp) {
                    DB::commit();
                    return $this->responseJson(true, 201, 'You Already Registrater. Re-Send OTP Check Your Phone', ['uuid' => $data->uuid, 'otp' => $data->otp_no, 'email' => $data->email, 'phone' => $data->phone]);
                }
            } else {
                $isCompaniesCreated = CompanyManagment::create([
                    'uuid' => Str::uuid(),
                    'name' => $request->company_name,
                    'registration_no' => $request->company_registration_no,
                    'address' => $request->company_address,
                    'phone' => $request->company_phone,
                    'is_subscribed' => $is_subscribed->id,
                    'website_link' => $request->website_link,
                ]);
                $isRoleCreated = Company_role::create([
                    'name' => 'Super Admin',
                    'slug' => createSlug('Super Admin'),
                    'company_id' => $isCompaniesCreated->id,
                ]);
                $isCompanyUser = CompanyUser::create([
                    'uuid' => Str::uuid(),
                    'name' => $request->name,
                    'phone' => $request->phone,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'country' => $request->country,
                    'city' => $request->city,
                    'dob' => $request->dob,
                    'otp_no' => genrateOtp(),
                    'designation' => $request->designation,
                    'company_id' => $isCompaniesCreated->id,
                    'company_role_id' => $isRoleCreated->id,
                    'profile_images' => getImgUpload($request->profile_images, 'profile_image'),
                ]);
                if ($isCompanyUser) {
                    DB::commit();
                    return $this->responseJson(true, 201, 'Registration Successfully', ['uuid' => $isCompanyUser->uuid, 'otp' => $isCompanyUser->otp_no, 'email' => $isCompanyUser->email, 'phone' => $isCompanyUser->phone]);
                }
            }
        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage() . 'on' . $e->getFile() . 'in' . $e->getLine());
            return $this->responseJson(false, 500, $e->getMessage(), []);
        }
    }
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            $status = false;
            $code = 422;
            $response = [];
            $message = $validator->errors()->first();
            return $this->responseJson($status, $code, $message, $response);
        }
        DB::beginTransaction();
        try {
            if (Auth::guard('company')->attempt($request->only(['email', 'password']))) {
                $user = Auth::guard('company')->user();
                $data['token'] = $user->createToken('MyApp', ['company'])->accessToken;
                $data['user'] = $user;
                DB::commit();
                return $this->responseJson(true, 200, 'User Login Successfully', $data);
            } else {
                return $this->responseJson(false, 200, 'Incorrect User Type Please try again', []);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage() . 'on' . $e->getFile() . 'in' . $e->getLine());
            return $this->responseJson(false, 500, $e->getMessage(), []);
        }
    }
    public function logout(Request $request)
    {
        $request
            ->user()
            ->token()
            ->revoke();
        return response()->json(['message' => 'You have been successfully logged out.'], 200);
    }
    // **************************OTP Verification************************************************************
    public function otpVerification(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'uuid' => 'required',
            'otp' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
        ]);
        if ($validator->fails()) {
            $status = false;
            $code = 422;
            $response = [];
            $message = $validator->errors()->first();
            return $this->responseJson($status, $code, $message, $response);
        }
        // dd($request->all());
        try {
            $id = uuidtoid($request->uuid, 'company_users');
            $fetchOtp = CompanyUser::where([
                'email' => $request->email,
                'id' => $id,
                'otp_no' => $request->otp,
                // 'company_id' => $authCompany->id,
            ])->first();
            if ($fetchOtp) {
                $fetchOtp->update([
                    'otp_no' => null,
                    'otp_verify' => 'yes',
                ]);
                DB::commit();
                return $this->responseJson(true, 200, 'Otp Verification Successfully');
            } else {
                return $this->responseJson(false, 200, 'Incorrect OTP Number Please Try Again', []);
            }
        } catch (\Exception $e) {
            logger($e->getMessage() . ' on ' . $e->getFile() . ' in ' . $e->getLine());
            return $this->responseJson(false, 500, $e->getMessage(), []);
        }
    }
    public function resendOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'uuid' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
        ]);
        if ($validator->fails()) {
            $status = false;
            $code = 422;
            $response = [];
            $message = $validator->errors()->first();
            return $this->responseJson($status, $code, $message, $response);
        }
        try {
            $id = uuidtoid($request->uuid, 'company_users');
            // dd(genrateOtp());
            $fetchOtp = CompanyUser::where('id', $id)->update([
                'otp_no' => genrateOtp(),
            ]);
            if ($fetchOtp) {
                DB::commit();
                return $this->responseJson(true, 200, 'Resend Otp Verification Successfully', []);
            } else {
                return $this->responseJson(false, 200, ' Please Try Again', []);
            }
        } catch (\Exception $e) {
            logger($e->getMessage() . ' on ' . $e->getFile() . ' in ' . $e->getLine());
            return $this->responseJson(false, 500, $e->getMessage(), []);
        }
    }
    // **************************User Profile************************************************************
    public function profileList(Request $request)
    {
        $authCompany = Auth::guard('company-api')->user()->id;
        // dd($authCompany);
        $data = CompanyUser::where('id', $authCompany)->first();
        $message = $data ? 'Fetch User List Successfully' : 'User List Data Not Found';
        return $this->responseJson(true, 200, $message,new ProfileResources($data));
    }

    public function profileUpdate(Request $request)
    {
        $authUserId = Auth::guard('company-api')->user()->id;
        $data =  CompanyUser::where('id', $authUserId)->update([
            'name' => $request->name
        ]);
        $message = 'User Details Updated Successfully';
        // $message = $data->isNotEmpty() ? 'Fetch User List Successfully' : 'User List Data Not Found';
        return $this->responseJson(true, 200, $message, $data);
    }

    // **************************User Password Update************************************************************
    public function passwordUpdate(Request $request)
    {
        $authUserId = Auth::guard('company-api')->user()->id;
        // dd($request->all());
        if (Hash::check($request->oldPassword, auth()->guard('company-api')->user()->password)) {
            $data =  CompanyUser::where('id', $authUserId)->update([
                'password' => Hash::make($request->newPassword),
            ]);
            $message = 'Password Updated Successfully';
        } else {
            $data = [];
            $message = 'Do not matched the password';
        }
        return $this->responseJson(true, 200, $message, $data);
    }
}
