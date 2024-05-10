<?php

namespace App\Http\Controllers\API\inventory;

use App\Http\Controllers\BaseController;
use App\Http\Resources\API\Inventory\inventor\InventoryResources;
use App\Models\InvReturn;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InvReturnController extends BaseController
{
    public function add(Request $request)
    {
        $store_warehouses_id = $request->store_warehouses_id;
        $authCompany = Auth::guard('company-api')->user();
        $record = InvReturn::updateOrCreate(
            [
                'projects_id' => $request->projects_id,
                'company_id' => $authCompany->company_id,
                'user_id' => $authCompany->id,
                'date' => Carbon::now()->format('Y-m-d'),
            ],
            [
                'name' => $request->name
            ]
        );

        $record->InvReturnStore()->sync($store_warehouses_id);
        $message = 'Inward Details Updated Successfullsy';
        return $this->responseJson(true, 201, $message, $record);
    }
    // public function add(Request $request)
    // {
    //     $authCompany = Auth::guard('company-api')->user();
    //     DB::beginTransaction();
    //     $checkInventory = InvReturn::where(['date' => Carbon::now()->format('Y-m-d'), 'projects_id' => $request->projects_id, 'user_id' => $authCompany->id])->where('store_id', $request->store_id)->first();
    //     try {
    //         if ($request->id == null && $checkInventory == null) {
    //             $isInventoryDatas = new InvReturn();
    //             $isInventoryDatas->name = $request->name;
    //             $isInventoryDatas->date = Carbon::now()->format('Y-m-d');
    //             $isInventoryDatas->company_id = $authCompany->company_id;
    //             $isInventoryDatas->user_id = $authCompany->id;
    //             $isInventoryDatas->projects_id = $request->projects_id;
    //             $isInventoryDatas->store_id = $request->store_id;
    //         } else {
    //             $isInventoryDatas = InvReturn::find($checkInventory->id);
    //         }
    //         $isInventoryDatas->projects_id = $request->projects_id;
    //         $isInventoryDatas->store_id = $request->store_id;
    //         $isInventoryDatas->save();
    //         if ($request->id) {
    //             $message = 'Inventory Return Details Updated Successfullsy';
    //         } else {
    //             $message = 'Inventory Return Details Created Successfullsy';
    //         }
    //         if (isset($isInventoryDatas)) {
    //             DB::commit();
    //             return $this->responseJson(true, 201, $message, $isInventoryDatas);
    //         }
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         logger($e->getMessage() . 'on' . $e->getFile() . 'in' . $e->getLine());
    //         return $this->responseJson(false, 500, $e->getMessage(), []);
    //     }
    // }
    public function index(Request $request)
    {
        $data = InvReturn::all();
        $message = 'Return List Fetch Successfullsy';
        // return $this->responseJson(true, 201, $message, $data);
        return $this->responseJson(true, 201, $message, InventoryResources::collection($data));
    }
}
