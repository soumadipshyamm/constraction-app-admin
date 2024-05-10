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
        $data = CompanyUser::where('company_id', $authCompany)->get();
        $message = $data->isNotEmpty() ? 'Fetch Teams List Successfully' : 'Teams List Data Not Found';
        return $this->responseJson(true, 200, $message, $data);
    }
    public function teamsAdd(Request $request)
    {
        $authCompany = Auth::guard('company-api')->user()->company_id;
        // dd($request->all());
        $validatedData = $request->validate([
            'company_user_role' => 'required',
            'updateId' => 'sometimes|required',
            'name' => 'required',
            'email' => 'required_if:updateId,!=,null|email',
            'password' => 'required_if:updateId,!=,null',
            'phone' => 'required',
            'address' => 'required',
            'designation' => 'required',
            'img' => 'mimes:jpeg,jpg,png',
        ]);
        DB::beginTransaction();
        try {
            if ($request->updateId) {
                $id = $request->updateId;
                $fetchUserId = CompanyUser::find($id);
                if ($request->hasFile('profile_images')) {
                    deleteFile($id, 'company_users', 'profile_images', 'profile_image');
                    $isUpdated = CompanyUser::where('id', $id)->update([
                        'name' => $request->name,
                        'phone' => $request->phone,
                        // 'email' => $request->email,
                        // 'password' => $request->password ? Hash::make($request->password) : $fetchUserId->password,
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
                        'profile_images' => getImgUpload($request->img, 'profile_image'),
                    ]);
                    $message = 'User Updaed Successfully';
                } else {
                    // dd($request->all());

                    // $id = uuidtoid($request->uuid, 'company_users');
                    $id = $request->updateId;
                    $isUpdated = CompanyUser::where('id', $id)->update([
                        'name' => $request->name,
                        'phone' => $request->phone,
                        // 'email' => $request->email,
                        // 'password' => $request->password ? Hash::make($request->password) : $fetchUserId->password,
                        'country' => $request->country,
                        'state' => $request->state,
                        'city' => $request->city,
                        'dob' => $request->dob,
                        'address' => $request->address,
                        'designation' => $request->designation,
                        'aadhar_no' => $request->aadhar_no,
                        'pan_no' => $request->pan_no,
                        'reporting_person' => $request->reporting_person,
                        'company_role_id' => $request->company_user_role,
                    ]);
                    $message = 'User Updaed Successfully';
                }
            } else {
                // dd($request->all());
                $isCompanyUser = CompanyUser::create([
                    'uuid' => Str::uuid(),
                    'name' => $request->name,
                    'phone' => $request->phone,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'country' => $request->country,
                    'state' => $request->state,
                    'city' => $request->city,
                    'dob' => $request->dob,
                    'address' => $request->address,
                    'designation' => $request->designation,
                    'aadhar_no' => $request->aadhar_no,
                    'pan_no' => $request->pan_no,
                    'company_id' => $authCompany,
                    'company_role_id' => $request->company_user_role,
                    'reporting_person' => $request->reporting_person,
                    'profile_images' => $request->img ? getImgUpload($request->img, 'profile_image') : '',
                ]);
                $message = 'User Created Successfully';
            }
            if (isset($isCompanyUser) || isset($isUpdated)) {
                // Commit the transaction on success
                DB::commit();
                return $this->responseJson(true, 201, $message, $isCompanyUser ?? $isUpdated);
            }
        } catch (\Exception $e) {
            // Rollback the transaction on error and log the exception
            DB::rollBack();
            logger($e->getMessage() . ' on ' . $e->getFile() . ' in ' . $e->getLine());
            // Return an error response in JSON
            return $this->responseJson(false, 500, $e->getMessage(), []);
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
        $data = CompanyUser::where('id', $uuid)->where('company_id', $authCompany)->first();
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
}
