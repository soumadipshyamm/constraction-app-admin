<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Str;
use App\Models\Company\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\API\Unit\UnitResources;

class UnitController extends BaseController
{
    public function unitList(Request $request)
    {
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $data = Unit::where('company_id', $authCompany)->orderBy('id','desc')->get();
        $message = $data->isNotEmpty() ? 'Fetch Units List Successfully' : 'Units List Data Not Found';
        return $this->responseJson(true, 200, $message, UnitResources::collection($data));
    }
    public function unitAdd(Request $request)
    {
        $authConpany = Auth::guard('company-api')->user()->company_id;
        $validator = Validator::make($request->all(), [
            'unit' => 'required',
            'unit_coversion' => 'sometimes',
            'unit_coversion_factor' => 'required_with:unit_coversion|nullable',
        ]);
        // $validator = Validator::make($request->all(), [
        //     'f' => 'required|array',
        //     'f.*.unit' => 'required',
        //     'f.*.unit_coversion' => 'sometimes',
        //     'f.*.unit_coversion_factor' => 'required_with:f.*.unit_coversion|nullable',
        // ]);
        if ($validator->fails()) {
            $status = false;
            $code = 422;
            $response = [];
            $message = $validator->errors()->first();
            return $this->responseJson($status, $code, $message, $response);
        }
        // dd($request->all());
        DB::beginTransaction();
        try {
            $findId = Unit::find($request->updateId);
            if (isset($findId)) {
                $isUnittUpdate = Unit::where('id', $request->updateId)->update([
                    'unit' => $request->unit,
                    'unit_coversion' => $request->unit_coversion,
                    'unit_coversion_factor' => $request->unit_coversion_factor,
                ]);
                $message = 'Unit Updaed Successfullsy';
            } else {
                $isUnittCreated = Unit::create([
                    'uuid' => Str::uuid(),
                    'unit' => $request->unit,
                    'unit_coversion' => $request->unit_coversion,
                    'unit_coversion_factor' => $request->unit_coversion_factor,
                    'company_id' => $authConpany
                ]);
                $message = 'Unit Create Successfullsy';
            }
            if (isset($isUnittCreated) || isset($isUnittUpdate)) {
                // dd($isLabourCreated);
                DB::commit();
                return $this->responseJson(true, 201, $message, $isUnittCreated ?? $isUnittUpdate);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage() . 'on' . $e->getFile() . 'in' . $e->getLine());
            return $this->responseJson(false, 500, $e->getMessage(), []);
        }
    }

    public function unitSearch(Request $request)
    {
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $datas = Unit::where('company_id', $authCompany)
            ->where('is_active', 1);

        if ($request->has('search_keyword') && $request->search_keyword != "") {
            $datas->where(function ($q) use ($request) {
                $q->where('unit', 'LIKE', '%' . $request->search_keyword . '%');
            });
        }
        $datas = $datas->get();
        return UnitResources::collection($datas);
    }

    public function edit($uuid)
    {
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $data = Unit::where('id', $uuid)->where('company_id', $authCompany)->first();
        $message =  'Fetch Unit List Successfully';
        return $this->responseJson(true, 200, $message, new UnitResources($data));
    }
    public function delete($uuid)
    {
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $data = Unit::where('id', $uuid)
            ->where('company_id', $authCompany)
            ->delete();
        $message = $data > 0 ? 'Unit Delete Successfully' : 'Unit Data Not Found';
        return $this->responseJson(true, 200, $message, $data);
    }
}
