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
use Carbon\Carbon;

class InwardGoodsDetailsController extends BaseController
{
    public function index()
    {
        $authConpany = Auth::guard('company-api')->user()->company_id;
        $data = InwardGoodsDetails::where('company_id', $authConpany)->get();
        if (isset($data)) {
            return $this->responseJson(true, 200, 'Fetch Inward Goods Details List Successfullsy', $data);
        } else {
            return $this->responseJson(true, 200, 'Inward Goods Details List Data Not Found', []);
        }
    }
    public function add(Request $request)
    {
        $authCompany = Auth::guard('company-api')->user();
        $datas = $request->all();
        // dd($datas);
        DB::beginTransaction();
        try {
            foreach ($datas as $data) {
                InwardGoodsDetails::create([
                    'uuid' => Str::uuid(),
                    'inward_goods_id' => $data['inward_goods_id'] ?? null,
                    'materials_id' => $data['materials_id'],
                    'recipt_qty' => $data['recipt_qty'],
                    'reject_qty' => $data['reject_qty'],
                    'accept_qty' => $data['recipt_qty'] - $data['reject_qty'],
                    'price' => $data['price'],
                    'remarkes' => $data['remarkes'],
                    'company_id' => $authCompany->company_id,
                ]);
            }
            foreach ($datas as $data) {
                $isDataExites = inventoryDataChecking($data);
                if ($data['type'] == 'materials') {
                    $materialsId = $data['materials_id'];
                } else {
                    $assetsId = $data['materials_id'];
                }
                $totalQty = $data['recipt_qty'] - $data['reject_qty'];
                if (isset($isDataExites) && $isDataExites != NULL) {
                    $inventory = Inventory::where('id', $isDataExites->id)->update([
                        'total_qty' => $isDataExites->total_qty + $totalQty,
                        'price' => $data['price'],
                    ]);
                } else {
                    $inventory = Inventory::create([
                        'uuid' => Str::uuid(),
                        'projects_id' => $data['projects_id'],
                        'materials_id' => $materialsId ?? null,
                        'assets_id' => $assetsId ?? null,
                        'user_id' => $authCompany->id,
                        'date' => $date = Carbon::now(),
                        'type' => $data['type'],
                        'recipt_qty' => $data['recipt_qty'],
                        'reject_qty' => $data['reject_qty'],
                        'total_qty' => $data['recipt_qty'] - $data['reject_qty'],
                        'price' => $data['price'],
                        'remarks' => $data['remarkes'],
                        'company_id' => $authCompany->company_id,
                    ]);
                    $inventory->inventoryStore()->sync($data['store_warehouses_id']);
                }
            }
            DB::commit();
            $message = 'Inward Goods Details Details Updated Successfully';
            return $this->responseJson(true, 201, $message, $datas);
        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage() . ' on ' . $e->getFile() . ' in ' . $e->getLine());
            return $this->responseJson(false, 500, $e->getMessage(), []);
        }
    }
    public function edit(Request $request)
    {
        $getMaterialsId = $request->get('materials_id');
        $inventoryId = $request->input('inward_goods_id');
        $authCompany = Auth::guard('company-api')->user();
        $requestMaterialsData = InwardGoods::with(['InvInwardGoodDetails' => function ($q) use ($getMaterialsId) {
            $q->whereIn('materials_id', $getMaterialsId);
        }])->where('company_id', $authCompany->company_id)
            // ->where('id', $inventoryId)
            ->get();
        // dd($requestMaterialsData->toArray());
        $requestMaterials = InwardGoodDetailsResources::collection($requestMaterialsData);
        $message = 'Fetch Inward Good Details List Successfully';
        return response()->json(['success' => true, 'status' => 200, 'message' => $message, 'data' => $requestMaterials]);
    }
}
// projects_id
// store_warehouses_id
// materials_id
// activities_id
// user_id
// date
// type
// qty
// remarks
// company_id
