<?php

namespace App\Http\Controllers\API\inventory;

use App\Http\Controllers\BaseController;
use App\Http\Resources\API\Inventory\inventor\InventoryResources;
use App\Models\Inventory;
use App\Models\MaterialRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class MaterialRequestController extends BaseController
{
    public function add(Request $request)
    {
        $authCompany = Auth::guard('company-api')->user();
        DB::beginTransaction();
        $checkInventory = MaterialRequest::where(['date' => Carbon::now()->format('Y-m-d'), 'projects_id' => $request->projects_id, 'user_id' => $authCompany->id])->where('sub_projects_id', $request->sub_projects_id)->first();
        // dd($checkInventory);
        try {
            if ($request->id == null && $checkInventory == null) {
                $isInventoryDatas = new MaterialRequest();
                $isInventoryDatas->name = $request->name;
                $isInventoryDatas->date = Carbon::now()->format('Y-m-d');
                $isInventoryDatas->company_id = $authCompany->company_id;
                $isInventoryDatas->user_id = $authCompany->id;
                $isInventoryDatas->projects_id = $request->projects_id;
                $isInventoryDatas->sub_projects_id = $request->sub_projects_id;
            } else {
                $isInventoryDatas = MaterialRequest::find($checkInventory->id);
            }
            $isInventoryDatas->projects_id = $request->projects_id;
            $isInventoryDatas->sub_projects_id = $request->sub_projects_id;
            $isInventoryDatas->save();
            if ($request->id) {
                $message = 'Inventory Details Updated Successfullsy';
            } else {
                $message = 'Inventory Details Created Successfullsy';
            }
            if (isset($isInventoryDatas)) {
                DB::commit();
                return $this->responseJson(true, 201, $message, $isInventoryDatas);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage() . 'on' . $e->getFile() . 'in' . $e->getLine());
            return $this->responseJson(false, 500, $e->getMessage(), []);
        }
    }

    public function edit(Request $request)
    {
        $authCompany = Auth::guard('company-api')->user();
        $data = MaterialRequest::where('id', $request->id)->where('company_id', $authCompany->company_id)
            ->where('user_id', $authCompany->id)->get();
        $message = $data->isNotEmpty() ? 'Fetch Inventory List Successfully' : 'Inventory List Data Not Found';
        return $this->responseJson(true, 200, $message, InventoryResources::collection($data));
    }

    public function index(Request $request)
    {
        $authCompany = Auth::guard('company-api')->user();
        $this->setPageTitle('Inventory Management');
        $datas = MaterialRequest::where('company_id', $authCompany->company_id)
            ->where('user_id', $authCompany->id)->get();
        if (count($datas) > 0) {
            return $this->responseJson(true, 200, 'Fetch Inventory List Successfullsy', InventoryResources::collection($datas));
        } else {
            return $this->responseJson(true, 200, 'Inventory List Data Not Found', []);
        }
    }

    // public function projectToSubprojectList(Request $request)
    // {
    // }
}
