<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Company\Assets;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BaseController;
use App\Http\Resources\API\Assets\AssetsResources;
use Illuminate\Support\Facades\Validator;

class AssetsController extends BaseController
{
    public function assetsList()
    {
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $datas = Assets::with('units')->where('company_id', $authCompany)->orderBy('id', 'desc')->get();

        if (count($datas) > 0) {
            return $this->responseJson(true, 200, 'Fetch Assets List Successfullsy', AssetsResources::collection($datas));
        } else {
            return $this->responseJson(true, 200, 'Assets List Data Not Found', []);
        }
    }
    public function assetsAdd(Request $request)
    {
        $authConpany = Auth::guard('company-api')->user()->company_id;
        // $validator = Validator::make($request->all(), [
        //     // 'project_id' => 'required',
        //     // 'store_warehouses_id' => 'required',
        //     'name' => 'required',
        //     'specification' => 'required',
        //     'unit_id' => 'required',
        // ]);
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                function ($attribute, $value, $fail) use ($request) {
                    $existingRecord = Assets::where('name', $value)
                        ->where(function ($query) use ($request) {
                            $query->where('specification', $request->specification)
                                ->orWhereNull('specification');
                        })
                        ->first();

                    if ($existingRecord) {
                        if ($existingRecord->specification === $request->specification || empty($request->specification)) {
                            $fail('The combination of name and specification already exists.');
                        }
                    }
                },
            ],
            'specification' => 'required',
            'unit_id' => 'required',
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
        try {
            $findId = Assets::find($request->updateId);
            if (isset($findId)) {
                $isUnittUpdate = Assets::where('id', $request->updateId)->update([
                    // 'project_id' => $request->project_id,
                    // 'store_warehouses_id' => $request->store_warehouses_id,
                    'name' => $request->name,
                    'specification' => $request->specification,
                    'unit_id' => $request->unit_id,
                ]);
                $message = 'Assets Updated Successfullsy';
            } else {
                $isAssetsCreated = Assets::create([
                    'uuid' => Str::uuid(),
                    // 'project_id' => $request->project_id,
                    // 'store_warehouses_id' => $request->store_warehouses_id,
                    'name' => $request->name,
                    // 'code' => uniqid(6),
                    'specification' => $request->specification,
                    'unit_id' => $request->unit_id,
                    'company_id' => $authConpany,
                ]);
                $message = 'Assets Created Successfullsy';
            }
            if (isset($isAssetsCreated) || isset($isUnittUpdate)) {
                DB::commit();
                return $this->responseJson(true, 201, $message, $isAssetsCreated ?? $isUnittUpdate);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage() . 'on' . $e->getFile() . 'in' . $e->getLine());
            return $this->responseJson(false, 500, $e->getMessage(), []);
        }
    }

    public function assetsSearch(Request $request)
    {
        // dd($request->all());
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $datas = Assets::where('company_id', $authCompany)
            ->where('is_active', 1);

        if ($request->has('search_keyword') && $request->search_keyword != "") {
            $datas->where(function ($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->search_keyword . '%')
                    ->orWhere('code', 'LIKE', '%' . $request->search_keyword . '%');
            });
        }
        $datas = $datas->get();
        return AssetsResources::collection($datas);
    }
    public function edit($uuid)
    {
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $data = Assets::where('id', $uuid)->where('company_id', $authCompany)->first();
        $message = $data ? 'Fetch Assets List Successfully' : 'Assets List Data Not Found';
        return $this->responseJson(true, 200, $message, new AssetsResources($data));
    }
    public function delete($uuid)
    {
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $data = Assets::where('id', $uuid)
            ->where('company_id', $authCompany)
            ->delete();
        $message = $data > 0 ? 'Assets Delete Successfully' : 'Assets Data Not Found';
        return $this->responseJson(true, 200, $message, $data);
    }
}
