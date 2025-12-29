<?php

namespace App\Http\Controllers\API\inventory;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BaseController;
use App\Http\Resources\API\Inventory\InwardGoods\InwardGoodDetailsResources;
use App\Models\Company\InwardGoods;
use Illuminate\Support\Facades\Validator;
use App\Models\Company\InwardGoodsDetails;
use App\Models\Company\Materials;
use App\Models\Inventory;
use App\Models\InventoryLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class InwardGoodsDetailsController extends BaseController
{
    public function index()
    {
        $authConpany = Auth::guard('company-api')->user()->company_id;
        $data = InwardGoodsDetails::where('company_id', $authConpany)->orderBy('id', 'desc')->get();
        if (isset($data)) {
            return $this->responseJson(true, 200, 'Fetch Inward Goods Details List Successfullsy', $data);
        } else {
            return $this->responseJson(true, 200, 'Inward Goods Details List Data Not Found', []);
        }
    }

    // *************************************************************************
    // public function add(Request $request)
    // {
    //     $authCompany = Auth::guard('company-api')->user();
    //     $datas = $request->all();

    //     DB::beginTransaction();
    //     try {
    //         $store_warehouses_id = null;
    //         // Get store warehouse ID once before the loop
    //         if (!empty($datas[0]['inward_goods_id'])) {
    //             $store_warehouses_id = findDatacustomflied('id', $datas[0]['inward_goods_id'])
    //                 ->with(['InvInward.InvInwardStore'])
    //                 ->first();
    //         }
    //         $storeWarehousesId = $store_warehouses_id?->InvInward?->InvInwardStore?->first()?->id;

    //         foreach ($datas as $data) {
    //             // Determine the type and set the corresponding ID
    //             $materialsId = null;
    //             $assetsId = null;
    //             if ($data['type'] == 'materials') {
    //                 $materialsId = $data['materials_id'];
    //             } else {
    //                 $assetsId = $data['materials_id'];
    //             }

    //             // Calculate total quantity
    //             $totalQty = ($data['recipt_qty'] ?? 0) - ($data['reject_qty'] ?? 0);

    //             // Prepare the data to be updated or created
    //             $attributes = [
    //                 'uuid' => Str::uuid(),
    //                 'inward_goods_id' => $data['inward_goods_id'] ?? null,
    //                 'materials_id' => $materialsId,
    //                 'recipt_qty' => $data['recipt_qty'] ?? 0,
    //                 'reject_qty' => $data['reject_qty'] ?? 0,
    //                 'accept_qty' => $totalQty,
    //                 'po_qty' => $data['po_qty'] ?? null,
    //                 'price' => $data['price'] ?? 0,
    //                 'remarkes' => $data['remarkes'] ?? '',
    //                 'company_id' => $authCompany->company_id,
    //                 'type' => $data['type'],
    //                 'assets_id' => $assetsId
    //             ];

    //             if (empty($data['id']) || $data['id'] === "null") {
    //                 InwardGoodsDetails::create($attributes);
    //             } else {
    //                 InwardGoodsDetails::where('id', $data['id'])->update($attributes);
    //             }

    //             // Handle inventory updates
    //             $isDataExites = inventoryDataChecking($data);

    //             if ($isDataExites) {
    //                 Inventory::where('id', $isDataExites->id)->update([
    //                     'total_qty' => $isDataExites->total_qty + $totalQty,
    //                     'price' => $data['price'] ?? 0,
    //                 ]);
    //                 $inventoryData = Inventory::where('id', $isDataExites->id)->first();
    //                 inventoryLog($inventoryData, "Update inventory", $isDataExites->id);
    //             } else {

    //                 $inventoryData = [
    //                     'projects_id' => $data['projects_id'] ?? null,
    //                     'materials_id' => $materialsId,
    //                     'assets_id' => $assetsId,
    //                     'user_id' => $authCompany->id,
    //                     'date' => Carbon::now(),
    //                     'type' => $data['type'],
    //                     'recipt_qty' => $data['recipt_qty'] ?? 0,
    //                     'reject_qty' => $data['reject_qty'] ?? 0,
    //                     'total_qty' => $totalQty,
    //                     'po_qty' => $data['po_qty'] ?? null,
    //                     'price' => $data['price'] ?? 0,
    //                     'remarks' => $data['remarkes'] ?? '',
    //                     'company_id' => $authCompany->company_id,
    //                 ];
    //                 $inventory = Inventory::create($inventoryData);
    //                 if ($storeWarehousesId) {
    //                     $inventory->inventoryStore()->sync($storeWarehousesId);
    //                 }
    //                 inventoryLog($inventory, "add data in inventory", $inventory->id);
    //             }
    //         }

    //         DB::commit();
    //         $message = 'Inward Goods Details Updated Successfully';
    //         return $this->responseJson(true, 200, $message, $datas);
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         Log::error($e->getMessage() . ' on ' . $e->getFile() . ' in ' . $e->getLine());
    //         return $this->responseJson(false, 500, $e->getMessage(), []);
    //     }
    // }


    public function add(Request $request)
    {
        log_daily('Inward', 'Inventory Inward Goods Details Add', 'add', 'info', json_encode($request->all()));
        $authCompany = Auth::guard('company-api')->user();
        $datas = $request->all();
        // dd($datas);
        DB::beginTransaction();
        try {
            // Get store warehouse ID once before the loop
            $storeWarehousesId = null;
            if (!empty($datas[0]['inward_goods_id'])) {
                // dd($datas[0]['inward_goods_id']);
                $storeWarehousesId = findDatacustomflied('id', $datas[0]['inward_goods_id'])
                    ->with(['InvInward.InvInwardStore'])
                    ->first()?->InvInward?->InvInwardStore;
                // ->first()?->InvInward?->InvInwardStore?->first()?->id;
            }
            // dd($storeWarehousesId->toArray() );

            foreach ($datas as $data) {
                // Determine the type and set the corresponding ID
                $materialsId = $data['type'] === 'materials' ? $data['materials_id'] : null;
                $assetsId = $data['type'] !== 'materials' ? $data['materials_id'] : null;

                // Calculate total quantity
                // Calculate total quantity
                $recipt_qty = (float)($data['recipt_qty'] ?? 0);
                $totalQty = (float)($data['recipt_qty'] ?? 0) - (float)($data['reject_qty'] ?? 0);

                // Prepare the data to be updated or created
                $attributes = [
                    'uuid' => Str::uuid(),
                    'inward_goods_id' => $data['inward_goods_id'] ?? null,
                    'materials_id' => $materialsId,
                    'recipt_qty' => number_format((float)$data['recipt_qty'] ?? 0, 2, '.', ''),
                    'reject_qty' => number_format((float)$data['reject_qty'] ?? 0, 2, '.', ''),
                    'accept_qty' => number_format((float)$totalQty, 2, '.', ''),
                    'po_qty' => $data['po_qty'] ?? null,
                    'price' => number_format((float)$data['price'] ?? 0, 2, '.', ''),
                    'remarkes' => $data['remarkes'] ?? '',
                    'company_id' => $authCompany->company_id,
                    'type' => $data['type'],
                    'assets_id' => $assetsId
                ];

                // Create or update InwardGoodsDetails
                if (empty($data['id']) || $data['id'] === "null") {
                    InwardGoodsDetails::create($attributes);
                } else {
                    InwardGoodsDetails::where('id', $data['id'])->update($attributes);
                }
                // Handle inventory updates
                $isDataExites = inventoryDataChecking($data);
                if ($isDataExites) {
                    // dd($storeWarehousesId);
                    Inventory::where('id', $isDataExites->id)->update([
                        'recipt_qty' => number_format((float)$isDataExites->recipt_qty + (float)$recipt_qty, 2, '.', ''),
                        'total_inward' => number_format((float)$isDataExites->total_inward + (float)$totalQty, 2, '.', ''),
                        'total_qty' => number_format((float)$isDataExites->total_qty + (float)$totalQty, 2, '.', ''),
                        'price' => $data['price'] ?? 0,
                    ]);
                    $inventoryData = Inventory::find($isDataExites->id);
                    inventoryLog($inventoryData, "Update inventory", $isDataExites->id, $storeWarehousesId, number_format((float)$data["recipt_qty"] ?? 0, 2, '.', ''), 'INWARD');
                } else {
                    // Create new inventory entry
                    $inventoryData = [
                        'projects_id' => $data['projects_id'] ?? null,
                        'materials_id' => $materialsId,
                        'assets_id' => $assetsId,
                        'user_id' => $authCompany->id,
                        'date' => Carbon::now(),
                        'type' => $data['type'],
                        'recipt_qty' => number_format((float)$recipt_qty ?? 0, 2, '.', ''),
                        'reject_qty' => number_format((float)$data['reject_qty'] ?? 0, 2, '.', ''),
                        'total_qty' => number_format((float)$totalQty, 2, '.', ''),
                        'total_inward' => number_format((float)$totalQty, 2, '.', ''),
                        'po_qty' => $data['po_qty'] ?? null,
                        'price' => number_format((float)$data['price'] ?? 0, 2, '.', ''),
                        'remarks' => $data['remarkes'] ?? '',
                        'company_id' => $authCompany->company_id,
                    ];
                    $inventory = Inventory::create($inventoryData);
                    if ($storeWarehousesId) {
                        $inventory->inventoryStore()->sync($storeWarehousesId);
                    }
                    InventoryLog::create([
                        'inventory_id' => $inventory->id,
                        'message' => 'add data in inventory',
                        'qty' => number_format((float)$data["recipt_qty"] ?? 0, 2, '.', ''),
                        'type' => 'INWARD',
                        'company_id' => $authCompany->company_id

                    ]);
                }
            }

            log_daily('Inward', 'Inventory Inward Goods Details Add Result', 'add', 'info', json_encode($datas));

            DB::commit();
            $message = 'Inward Goods Details Updated Successfully';
            return $this->responseJson(true, 200, $message, $datas);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage() . ' on ' . $e->getFile() . ' in ' . $e->getLine());
            return $this->responseJson(false, 500, $e->getMessage(), []);
        }
    }

    // *************************************************************************
    public function edit(Request $request)
    {
        $getMaterialsId = $request->get('materials_id');
        $inventoryId = $request->input('inward_goods_id');
        $authCompany = Auth::guard('company-api')->user();
        $requestMaterialsData = InwardGoods::with([
            'InvInwardGoodDetails' => function ($q) use ($getMaterialsId) {
                $q->whereIn('materials_id', $getMaterialsId);
            }
        ])->where('company_id', $authCompany->company_id)
            // ->where('id', $inventoryId)
            ->get();
        // dd($requestMaterialsData->toArray());
        $requestMaterials = InwardGoodDetailsResources::collection($requestMaterialsData);
        $message = 'Fetch Inward Good Details List Successfully';
        return response()->json(['success' => true, 'status' => 200, 'message' => $message, 'data' => $requestMaterials]);
    }
}
