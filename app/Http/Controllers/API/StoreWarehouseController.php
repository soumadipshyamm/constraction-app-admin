<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Company\StoreWarehouse;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\API\Store\StoreResources;
use App\Models\Company\Project;

class StoreWarehouseController extends BaseController
{
    public function list(Request $request)
    {
        $authCompany = Auth::guard('company-api')->user();
        $data = StoreWarehouse::with('project')->where('company_id', $authCompany?->company_id)->orderBy('id','desc')->get();
        $message = $data->isNotEmpty() ? 'Fetch Store List Successfully' : 'Store List Data Not Found';
        return $this->responseJson(true, 200, $message, StoreResources::collection($data));
    }

    public function projectWiseStoreList(Request $request)
    {
        // dd($request->project_id);
        $authCompany = Auth::guard('company-api')->user();
        $data = StoreWarehouse::with('project')->where('projects_id', $request->project_id)->where('company_id', $authCompany->company_id)->get();
        // dd($data);
        // $data = Project::with('project')->where('company_id', $authCompany?->company_id)->get();
        $message = $data->isNotEmpty() ? 'Fetch Store List Successfully' : 'Store List Data Not Found';
        return $this->responseJson(true, 200, $message, StoreResources::collection($data));
    }

    public function add(Request $request)
    {
        // dd($request->all());
        $authCompany = Auth::guard('company-api')->user();
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'location' => 'required',
            'tag_project' => 'required',
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
            $findId = StoreWarehouse::find($request->upadteId);
            if (isset($findId)) {
                // dd($request->all());
                $isStoreUpdated = StoreWarehouse::where('id', $request->upadteId)->update([
                    'name' => $request->name,
                    'location' => $request->location,
                    'projects_id' => $request->tag_project,
                ]);
                $message = 'Stores Updated Successfullsy';
            } else {
                $isStoreCreated = StoreWarehouse::create([
                    'uuid' => Str::uuid(),
                    'name' => $request->name,
                    'location' => $request->location,
                    'projects_id' => $request->tag_project,
                    'company_id' => $authCompany->company_id,
                ]);
                $message = 'Stores Create Successfullsy';
            }

            if (isset($isStoreCreated) || isset($isStoreUpdated)) {
                DB::commit();
                return $this->responseJson(true, 201,  $message, $isStoreCreated ?? $isStoreUpdated);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage() . 'on' . $e->getFile() . 'in' . $e->getLine());
            return $this->responseJson(false, 500, $e->getMessage(), []);
        }
    }
    public function search(Request $request)
    {
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $datas = StoreWarehouse::where('company_id', $authCompany)
            ->where('is_active', 1);

        if ($request->has('search_keyword') && $request->search_keyword != "") {
            $datas->where(function ($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->search_keyword . '%');
            });
        }
        $datas = $datas->get();
        return StoreResources::collection($datas);
    }
    public function edit($uuid)
    {
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $data = StoreWarehouse::where('id', $uuid)->where('company_id', $authCompany)->first();
        $message = $data ? 'Fetch Store/Warehouse List Successfully' : 'Store/Warehouse List Data Not Found';
        return $this->responseJson(true, 200, $message, new StoreResources($data));
    }
    public function delete($uuid)
    {
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $data = StoreWarehouse::where('id', $uuid)
            ->where('company_id', $authCompany)
            ->delete();
        $message = $data > 0 ? 'Store/Warehouse Delete Successfully' : 'Store/Warehouse Data Not Found';
        return $this->responseJson(true, 200, $message, $data);
    }
}
