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
use App\Http\Resources\API\User\UserResource;
use App\Mail\OTPNotification;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

Validator::extend('valid_tld', function ($attribute, $value, $parameters, $validator) {
    $validTlds = ['com', 'org', 'net', 'edu', 'gov', 'mil']; // Add more valid TLDs as needed
    $domain = substr(strrchr($value, '.'), 1); // Get the domain part after the last dot
    return in_array($domain, $validTlds);
});

class AuthenticationController extends BaseController
{
    public function signUp(Request $request)
    {
        log_daily(
            'registration',
            'Registration request received with data.',
            'registration',
            'info',
            json_encode($request->all())
        );
        $validator = Validator::make($request->all(), [
            'company_name'          => 'required|string|max:255',
            'company_address'       => 'required|string',
            'company_country_code'  => 'required|in:91,971',
            'company_phone'         => 'required|numeric',
            'country_code'          => 'required|in:91,971',
            'phone'                 => 'required|numeric|digits_between:10,15',
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|email|max:250|valid_tld|regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
            'password'              => 'required|string|min:6',
            'profile_images'        => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        ], [
            'company_name.required'         => 'Company Name is required.',
            'company_address.required'      => 'Company Address is required.',
            'company_country_code.in'       => 'Company Country Code must be 91 or 971.',
            'company_phone.required'        => 'Company Phone is required.',
            'country_code.in'               => 'Country Code must be 91 or 971.',
            'phone.required'                => 'Phone Number is required.',
            'name.required'                 => 'Name is required.',
            'email.required'                => 'Email is required.',
            'email.email'                   => 'Enter a valid email address.',
            'password.required'             => 'Password is required.',
            'profile_images.image'          => 'Profile image must be an image (jpeg, jpg, png).',
        ]);

        if ($validator->fails()) {
            return $this->responseJson(false, 422, $validator->errors()->first(), []);
        }
        $generateOtp = genrateOtp(); // Make sure this function exists
        DB::beginTransaction();

        try {
            // Check if user exists by phone OR email
            $existingUser = CompanyUser::Where('email', $request->email)
                ->first();

            if ($existingUser) {
                // Case 1: OTP already verified → User is registered
                if (($existingUser->email === $request->email && $existingUser->otp_verify === 'yes' && $existingUser->is_active === 1)) {
                    DB::commit(); // Not necessary here, but safe
                    return $this->responseJson(false, 422, 'You are already registered. Please login.', [
                        'uuid' => $existingUser->uuid,
                        'email' => $existingUser->email,
                        'phone' => $existingUser->phone,
                    ]);
                }

                // Case 2: OTP not verified → Update profile and resend OTP
                $updated = $existingUser->update([
                    'name'              => $request->name,
                    'country_code'      => $request->country_code,
                    'email'             => $request->email,
                    'company_id'        => $existingUser->company_id, // assuming company exists
                    'designation'       => $request->designation,
                    'dob'               => $request->dob,
                    'city'              => $request->city,
                    'country'           => $request->country,
                    'otp_no'            => $generateOtp,
                    // 'fcm_token'          => $request->fcm_token ?? '',
                    'password'          => $request->password ? Hash::make($request->password) : $existingUser->password,
                    'profile_images'    => $request->hasFile('profile_images')
                        ? getImgUpload($request->profile_images, 'profile_image')
                        : $existingUser->profile_images,
                ]);

                if ($updated) {
                    DB::commit();
                    Mail::to($request->email)->send(new OTPNotification($generateOtp));
                    // sendSms($generateOtp, $existingUser->phone);
                    return $this->responseJson(true, 200, 'Registration successful. OTP sent Please verify your account.', [
                        'uuid' => $existingUser->uuid,
                        'otp' => $generateOtp,
                        'email' => $existingUser->email,
                        'phone' => $existingUser->phone,
                    ]);
                }
            } else {
                // Case 3: New user → Create company, role, and user
                $isSubscribed = getFreeSubscribeId(''); // Make sure this returns valid subscription

                $company = CompanyManagment::create([
                    'uuid'               => Str::uuid(),
                    'name'               => $request->company_name,
                    'registration_no'    => $request->company_registration_no ?? null,
                    'address'            => $request->company_address,
                    'country_code'       => $request->company_country_code,
                    'phone'              => $request->company_phone,
                    'is_subscribed'      => $isSubscribed->id,
                    'website_link'       => $request->website_link ?? null,
                ]);

                $role = Company_role::create([
                    'name'        => 'Super Admin',
                    'slug'        => Str::slug('Super Admin'),
                    'company_id'  => $company->id,
                ]);

                $user = CompanyUser::create([
                    'uuid'               => Str::uuid(),
                    'name'               => $request->name,
                    'country_code'       => $request->country_code,
                    'phone'              => $request->phone,
                    'email'              => $request->email,
                    'password'           => Hash::make($request->password),
                    'designation'        => $request->designation ?? '',
                    'dob'                => $request->dob ?? '',
                    'city'               => $request->city ?? '',
                    'country'            => $request->country ?? '',
                    'company_id'         => $company->id,
                    'company_role_id'    => $role->id,
                    'profile_images'     => getImgUpload($request->profile_images, 'profile_image'),
                    'otp_no'             => $generateOtp,
                    // 'fcm_token'          => $request->fcm_token ?? '',
                ]);

                // Optional: Seed data
                $domeData = domeData($company?->id);
                log_daily(
                    'registration',
                    'dome Data add ' . $company?->id,
                    'domeData',
                    'info',
                    json_encode($domeData)
                );
                DB::commit();
                Mail::to($request->email)->send(new OTPNotification($generateOtp));
                // sendSms($generateOtp, $user->phone);

                return $this->responseJson(true, 201, 'Registration successful. OTP sent.', [
                    'uuid'  => $user->uuid,
                    'otp'   => $generateOtp,
                    'email' => $user->email,
                    'phone' => $user->phone,
                ]);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage() . ' in ' . $e->getFile() . ' on line ' . $e->getLine());
            return $this->responseJson(false, 500, 'Something went wrong. Please try again.', []);
        }
    }
    public function login(Request $request)
    {
        log_daily(
            'login',
            'Login request received with data.',
            'loginPost',
            'info',
            json_encode($request->all())
        );
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
        // dd($request->all());
        DB::beginTransaction();
        // try {
        //     if (Auth::guard('company')->attempt($request->only(['email', 'password']))) {
        //         $user = Auth::guard('company')->user();
        //         if (isset($request->fcm_token)) {
        //             CompanyUser::where('id', auth()->user()->id)->update(['fcm_token' => $request->fcm_token]);
        //         }
        //         $data['token'] = $user->createToken('MyApp', ['company'])->accessToken;
        //         $data['user'] = $user;
        //         DB::commit();
        //         return $this->responseJson(true, 200, 'User Login Successfully', new UserResource($data));
        //     } else {
        //         return $this->responseJson(false, 200, 'Incorrect User Type Please try again', []);
        //     }
        // } catch (\Exception $e) {
        //     DB::rollBack();
        //     logger($e->getMessage() . 'on' . $e->getFile() . 'in' . $e->getLine());
        //     return $this->responseJson(false, 500, $e->getMessage(), []);
        // }

        try {
            $exites = CompanyUser::where('email', $request->email)
                ->where('is_active', 1)
                ->first();
            // dd($exites);
            if (!$exites) {
                return $this->responseJson(false, 404, 'Email Not Found or Account is not verified', []);
            } elseif ($exites->is_active == 0) {
                return $this->responseJson(false, 423, 'Your Account is not active. Please contact support.', []);
            } elseif ($exites->is_active == 1) {
                // Case 3: OTP verified and user is active
                if (Auth::guard('company')->attempt($request->only(['email', 'password']))) {
                    $user = Auth::guard('company')->user();
                    if ($exites->otp_verify == 'no') {
                        // return $this->responseJson(false, 422, 'You are not registered!', [
                        return $this->responseJson(false, 300, 'Your Email Id is not verified. Please verify your Email Id.', [
                            "otp_verify" => $exites->otp_verify == 'no' ? false : true,
                            "uuid" => $exites->uuid,
                            "email" => $exites->email,
                            "phone" => $exites->phone,
                        ]);
                    }
                    if (isset($request->fcm_token)) {
                        CompanyUser::where('id', $user->id)->update(['fcm_token' => $request->fcm_token]);
                    }
                    $data['token'] = $user?->createToken('MyApp', ['company'])->accessToken;
                    $data['user'] = $user;
                    log_daily(
                        'login_fcm',
                        'login request received with data.' . Auth::guard('company')->user()->id,
                        'login',
                        'info',
                        json_encode([$data['user'], $request->all()])
                    );
                    DB::commit();
                    return $this->responseJson(true, 200, 'User Login Successfully', new UserResource($data));
                } else {
                    return $this->responseJson(false, 422, 'Incorrect Credencial. Please try again', []);
                }
            }
            // }
        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage() . 'on' . $e->getFile() . 'in' . $e->getLine());
            return $this->responseJson(false, 500, $e->getMessage(), []);
        }
    }
    public function logout(Request $request)
    {
        log_daily(
            'logout',
            'logout request received with data.' . Auth::guard('api')->user()->id,
            'logout',
            'info',
            json_encode(Auth::guard('api')->user())
        );
        $request
            ->user()
            ->token()
            ->revoke();
        return response()->json(['message' => 'You have been successfully logged out.'], 200);
    }
    // **************************OTP Verification************************************************************
    public function otpVerification(Request $request)
    {
        log_daily(
            'registration',
            'OTP Verification request received with data.',
            'otpVerification',
            'info',
            json_encode($request->all())
        );
        $validator = Validator::make($request->all(), [
            // 'uuid' => 'required',
            'otp' => 'required',
            'email' => 'required|email',
            // 'phone' => 'required',
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
            // $id = uuidtoid($request->uuid, 'company_users');
            $fetchOtp = CompanyUser::where([
                'email' => $request->email,
                // 'id' => $id,
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
        log_daily(
            'registration',
            'Resend OTP request received with data.',
            'resendOtp',
            'info',
            json_encode($request->all())
        );
        $validator = Validator::make($request->all(), [
            // 'uuid' => 'required',
            'email' => 'required|email',
            // 'phone' => 'required',
        ]);
        // dd($request->all());
        if ($validator->fails()) {
            $status = false;
            $code = 422;
            $response = [];
            $message = $validator->errors()->first();
            return $this->responseJson($status, $code, $message, $response);
        }
        try {
            // $id = uuidtoid($request->uuid, 'company_users');
            // dd(genrateOtp());
            $genrateOtp = genrateOtp();
            $fetchOtp = CompanyUser::where('email', $request->email)->where('otp_verify', 'no')->update([
                'otp_no' => $genrateOtp,
            ]);

            $result = (object) [
                'otp_no' => $genrateOtp,
                'email' => $request->email,
            ];
            if ($fetchOtp) {
                // dd($genrateOtp);
                // sendSms($genrateOtp, $request?->phone);
                Mail::to($request->email)->send(new OTPNotification($genrateOtp));
                DB::commit();
                return $this->responseJson(true, 200, 'Otp Send Successfully', $result);
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
        $data = CompanyUser::where('id', $authCompany)->orderBy('id', 'desc')->first();
        $message = $data ? 'Fetch User List Successfully' : 'User List Data Not Found';
        return $this->responseJson(true, 200, $message, new ProfileResources($data));
    }

    public function profileUpdate(Request $request)
    {
        log_daily(
            'profile',
            'Profile request received with data.',
            'profileList',
            'info',
            json_encode($request->all())
        );
        $authUserId = Auth::guard('company-api')->user()->id;
        $companyId = Auth::guard('company-api')->user()->company_id;
        $data =  CompanyUser::where('id', $authUserId)->update([
            'name' => $request->name,
            'country_code' => $request->country_code,
            'phone' => $request->phone,
            'country' => $request->country,
            'state' => $request->state,
            'city' => $request->city,
            'dob' => $request->dob,
            'designation' => $request->designation,
        ]);

        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('profile_image'), $imageName);
            $data = CompanyUser::where('id', $authUserId)->update([
                'profile_image' => $imageName,
            ]);
        }
        $updateCompanyDetails = CompanyManagment::where('id', $companyId)->update([
            'address' => $request->company_address,
            'country_code' => $request->company_country_code,
            'phone' => $request->company_phone,
            'website_link' => $request->website_link,
        ]);
        $message = 'User Details Updated Successfully';

        // $message = $data->isNotEmpty() ? 'Fetch User List Successfully' : 'User List Data Not Found';
        return $this->responseJson(true, 200, $message, $data);
    }

    // **************************User Password Update************************************************************
    public function passwordUpdate(Request $request)
    {
        log_daily(
            'password',
            'Password request received with data.',
            'passwordUpdate',
            'info',
            json_encode($request->all())
        );
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
    public function forgotPasswordUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:company_users,email',
            'newPassword' => 'required|min:6',
        ]);
        if ($validator->fails()) {
            $status = false;
            $code = 422;
            $response = [];
            $message = $validator->errors()->first();
            return $this->responseJson($status, $code, $message, $response);
        }
        try {
            $user = CompanyUser::where('email', $request->email)
                ->first();
            if (!$user) {
                return $this->responseJson(false, 404, 'User Not Found', []);
            }
            if ($user) {
                $user->update(['password' => Hash::make($request->newPassword)]);
                return $this->responseJson(true, 200, 'Password Updated Successfully', []);
            } else {
                return $this->responseJson(false, 404, 'User Not Found', []);
            }
        } catch (\Exception $e) {
            logger($e->getMessage() . ' on ' . $e->getFile() . ' in ' . $e->getLine());
            return $this->responseJson(false, 500, $e->getMessage(), []);
        }
    }
    public function getEmailforgotePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:company_users,email',
        ]);
        if ($validator->fails()) {
            $status = false;
            $code = 422;
            $response = [];
            $message = $validator->errors()->first();
            return $this->responseJson($status, $code, $message, $response);
        }
        try {
            $user = CompanyUser::where('email', $request->email)->first();
            if ($user) {
                $genrateOtp = genrateOtp();
                $user->update([
                    'otp_no' => $genrateOtp,
                ]);
                Mail::to($request->email)->send(new OTPNotification($genrateOtp));

                return $this->responseJson(true, 200, 'OTP Send Successfully', $user);
            } else {
                return $this->responseJson(false, 404, 'Email Not Found', []);
            }
        } catch (\Exception $e) {
            logger($e->getMessage() . ' on ' . $e->getFile() . ' in ' . $e->getLine());
            return $this->responseJson(false, 500, $e->getMessage(), []);
        }
    }

    public function getOtpverification(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'otp' => 'required',
        ]);
        if ($validator->fails()) {
            $status = false;
            $code = 422;
            $response = [];
            $message = $validator->errors()->first();
            return $this->responseJson($status, $code, $message, $response);
        }
        try {
            $user = CompanyUser::where('email', $request->email)
                ->where('otp_no', $request->otp)
                ->first();
            if (!$user) {
                return $this->responseJson(false, 404, 'Invalid OTP or Email', []);
            }
            return $this->responseJson(true, 200, 'OTP Verified Successfully', []);
        } catch (\Exception $e) {
            logger($e->getMessage() . ' on ' . $e->getFile() . ' in ' . $e->getLine());
            return $this->responseJson(false, 500, $e->getMessage(), []);
        }
    }
}
