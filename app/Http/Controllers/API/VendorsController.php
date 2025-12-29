<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Company\Vendor;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\API\Vendor\VendorResources;

class VendorsController extends BaseController
{
    public function vendorList()
    {
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $datas = Vendor::where('company_id', $authCompany)->orderBy('id', 'desc')->get();
        if (count($datas) > 0) {
            return $this->responseJson(true, 200, 'Fetch Vendor List Successfullsy', VendorResources::collection($datas));
        } else {
            return $this->responseJson(true, 200, 'Vendor List Data Not Found', []);
        }

    }
    //*************************************************************************************
    public function supplierContractorList(Request $request)
    {
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $type = $request->type;
        $datas = Vendor::where('company_id', $authCompany)->whereIn('type', ['both', $type])->orderBy('id', 'desc')->get();
        if (count($datas) > 0) {
            return $this->responseJson(true, 200, 'Fetch Vendor List Successfullsy', VendorResources::collection($datas));
        } else {
            return $this->responseJson(true, 200, 'Vendor List Data Not Found', []);
        }
    }
    //*************************************************************************************
    public function vendorAdd(Request $request)
    {
        $authConpany = Auth::guard('company-api')->user()->company_id;
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'address' => 'required',
            'type' => 'required|in:both,supplier,contractor',
            'contact_person_name' => 'required',
            'country_code' => 'required|in:91,971',
            'phone' => 'required',
            'email' => 'required|email',
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
            $findId = Vendor::find($request->updateId);
            if (isset($findId)) {
                $isVendorUpdate = Vendor::where('id', $request->updateId)->update([
                    'name' => $request->name,
                    'gst_no' => $request->gst_no,
                    'address' => $request->address,
                    'type' => $request->type,
                    'contact_person_name' => $request->contact_person_name,
                    'country_code' => $request->country_code,
                    'phone' => $request->phone,
                    'email' => $request->email,
                    'additional_fields' => json_encode($request->f),
                ]);
                $message = 'Vendor Updated Successfullsy';
            } else {
                $isVendorCreated = Vendor::create([
                    'uuid' => Str::uuid(),
                    'name' => $request->name,
                    'gst_no' => $request->gst_no,
                    'address' => $request->address,
                    'type' => $request->type,
                    'contact_person_name' => $request->contact_person_name,
                    'country_code' => $request->country_code,
                    'phone' => $request->phone,
                    'email' => $request->email,
                    'company_id' => $authConpany,
                    'additional_fields' => json_encode($request->f),
                ]);
                $message = 'Vendor Created Successfullsy';
            }
            if (isset($isVendorCreated) || isset($isVendorUpdate)) {
                DB::commit();
                return $this->responseJson(true, 201, $message, $isVendorCreated ?? $isVendorUpdate);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage() . 'on' . $e->getFile() . 'in' . $e->getLine());
            return $this->responseJson(false, 500, $e->getMessage(), []);
        }
    }
    //*************************************************************************************
    public function vendorSearch(Request $request)
    {
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $datas = Vendor::where('company_id', $authCompany)
            ->where('is_active', 1);
        if ($request->has('search_keyword') && $request->search_keyword != "") {
            $datas->where(function ($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->search_keyword . '%')
                    ->orWhere('gst_no', 'LIKE', '%' . $request->search_keyword . '%')
                    ->orWhere('type', 'LIKE', '%' . $request->search_keyword . '%')
                    ->orWhere('contact_person_name', 'LIKE', '%' . $request->search_keyword . '%')
                    ->orWhere('email', 'LIKE', '%' . $request->search_keyword . '%')
                    ->orWhere('phone', 'LIKE', '%' . $request->search_keyword . '%');
            });
        }
        $datas = $datas->get();
        if (count($datas) > 0) {
            return $this->responseJson(true, 200, 'Fetch Search List Successfullsy', VendorResources::collection($datas));
        } else {
            return $this->responseJson(true, 200, 'Vendor Search Data Not Found', []);
        }
    }
    //*************************************************************************************
    public function edit($uuid)
    {
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $data = Vendor::where('id', $uuid)->where('company_id', $authCompany)->first();
        $message = 'Fetch Vendor List Successfully';
        return $this->responseJson(true, 200, $message, new VendorResources($data));
    }
    //*************************************************************************************
    public function delete($uuid)
    {
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $data = Vendor::where('id', $uuid)
            ->where('company_id', $authCompany)
            ->delete();
        $message = $data > 0 ? 'Vendor Delete Successfully' : 'Vendor Data Not Found';
        return $this->responseJson(true, 200, $message, $data);
    }
}
