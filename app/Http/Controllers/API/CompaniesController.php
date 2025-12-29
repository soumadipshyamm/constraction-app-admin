<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Company\Companies;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\API\Companies\CompaniesResources;

class CompaniesController extends BaseController
{
    public function companiesList()
    {
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $data = Companies::where('company_id', $authCompany)->orderBy('id','desc')->get();
        if (count($data) > 0) {
            return $this->responseJson(true, 200, 'Fetch Companies List Successfullsy', CompaniesResources::collection($data));
        } else {
            return $this->responseJson(true, 200, 'Companies List Data Not Found', []);
        }
    }
    public function companiesAdd(Request $request)
    {
        $authConpany = Auth::guard('company-api')->user()->company_id;
        $validator = Validator::make($request->all(), [
            'registration_name' => 'required|string',
            'company_registration_no' => 'required|string',
            'registered_address' => 'required|string',
            'logo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        if ($validator->fails()) {
            $status = false;
            $code = 422;
            $response = [];
            $message = $validator->errors()->first();
            return $this->responseJson($status, $code, $message, $response);
        }
        $data = [
            'registration_name' => $request->registration_name,
            'company_registration_no' => $request->company_registration_no,
            'registered_address' => $request->registered_address,
            'logo' => $request->hasFile('logo') ? getImgUpload($request->file('logo'), 'logo') : null,
        ];
        DB::beginTransaction();
        try {
            if ($request->updateId) {
                $company = Companies::where('id', $request->updateId)->first();
                if ($company) {
                    $company->update($data);
                }
            } else {
                $data['uuid'] = Str::uuid();
                $data['company_id'] = $authConpany;
                $company = Companies::create($data);
            }
            DB::commit();
            if ($company) {
                return $this->responseJson(true, ($request->updateId) ? 200 : 201, ($request->updateId) ? 'Company Updated Successfully' : 'Company Created Successfully');
            } else {
                return $this->responseJson(true, 400, 'Company Update/Creation Failed');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage() . 'on' . $e->getFile() . 'in' . $e->getLine());
            return $this->responseJson(false, 500, $e->getMessage(), []);
        }
    }


    // {
    //     $authConpany = Auth::guard('company-api')->user()->company_id;
    //     $file = $request->file('img');
    //     $validator = Validator::make($request->all(), [
    //         'registration_name' => 'required',
    //     ]);
    // if ($validator->fails()) {
    //     $status = false;
    //     $code = 422;
    //     $response = [];
    //     $message = $validator->errors()->first();
    //     return $this->responseJson($status, $code, $message, $response);
    // }

    //     DB::beginTransaction();
    //     try {
    //         if ($request->id) {
    //             $isCompaniesCreated = Companies::where('id', $request->id)->update([
    //                 'registration_name' => $request->registration_name,
    //                 'company_registration_no' => $request->company_registration_no,
    //                 'registered_address' => $request->registered_address,
    //                 'logo' => getImgUpload($file, 'logo'),
    //             ]);
    //         } else {
    //             $isCompaniesCreated = Companies::create([
    //                 'uuid' => Str::uuid(),
    //                 'registration_name' => $request->registration_name,
    //                 'company_registration_no' => $request->company_registration_no,
    //                 'registered_address' => $request->registered_address,
    //                 'logo' => getImgUpload($file, 'logo'),
    //                 'company_id' => $authConpany,
    //             ]);
    //         }

    //         if (!empty($isCompaniesCreated) || count($isCompaniesCreated) > 0) {
    //             DB::commit();
    //             return $this->responseJson(true, 201, 'Companies  Created Successfullsy', $isCompaniesCreated);
    //         }
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         logger($e->getMessage() . 'on' . $e->getFile() . 'in' . $e->getLine());
    //         return $this->responseJson(false, 500, $e->getMessage(), []);
    //     }
    // }

    public function companiesSearch(Request $request)
    {
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $datas = Companies::where('company_id', $authCompany)
            ->where('is_active', 1);

        if ($request->has('search_keyword') && $request->search_keyword != "") {
            $datas->where(function ($q) use ($request) {
                $q->where('registration_name', 'LIKE', '%' . $request->search_keyword . '%');
            });
        }
        $datas = $datas->get();
        return CompaniesResources::collection($datas);
    }
    public function edit($uuid)
    {
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $data = Companies::where('id', $uuid)->where('company_id', $authCompany)->first();
        $message = 'Fetch Companies List Successfully';
        // dd($data);
        return $this->responseJson(true, 200, $message, new CompaniesResources($data));
    }
    public function delete($uuid)
    {
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $data = Companies::where('id', $uuid)
            ->where('company_id', $authCompany)
            ->delete();
        $message = $data > 0 ? 'Companies Delete Successfully' : 'Companies Data Not Found';
        return $this->responseJson(true, 200, $message, $data);
    }
}
