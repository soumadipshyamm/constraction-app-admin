<?php

namespace App\Http\Controllers;

use App\Http\Resources\API\Inventory\inventor\InventoryDtailsResources;
use App\Http\Resources\API\Inventory\ReturnGoods\InvReturnGoodsDetailsResources;
use App\Models\Company\Assets;
use App\Models\Company\Materials;
use App\Models\Inventory;
use App\Models\InvReturnGood;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class InvReturnGoodController extends BaseController
{

    public function add(Request $request)
    {
        log_daily('Return', 'Inventory Return Goods Add', 'add', 'info', json_encode($request->all()));
        $result = [];
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $getMaterialsId = (array)$request->materials_id;
        $validator = Validator::make($request->all(), [
            'inv_return_id' => 'required',
            'projects_id' => 'required',
            'goods_type' => 'required',
            'return_no' => 'required',
            'date' => 'required',
            'return_from' => 'required',
            // 'remarkes' => 'required',
        ]);
        if ($validator->fails()) {
            $status = false;
            $code = 422;
            $response = [];
            $message = $validator->errors()->first();
            return $this->responseJson($status, $code, $message, $response);
        }
        // $fetchDate = $request->date;
        // materials_id
        DB::beginTransaction();
        // try {
        if (!empty($request->id) || $request->id != null) {
            $isActivityCreated = InvReturnGood::where('id', $request->id)->first();
            // dd($isActivityCreated, $request->all());
            $isUpdated = InvReturnGood::where('id', $request->id)->update([
                'type' => $request->goods_type,
                'tag_id' => $request->type,
                'return_no' => $request->return_no,
                'date' => $request->date,
                'inv_issue_lists_id' => $request->return_from
            ]);
            // dd($isUpdated);
            $message = 'Return Goods Details Updated Successfullsy';
        } else {
            $isActivityCreated = InvReturnGood::create([
                'uuid' => Str::uuid(),
                'inv_returns_id' => $request->inv_return_id,
                'type' => $request->goods_type,
                'tag_id' => $request->type,
                'return_no' => $request->return_no,
                'date' => $request->date,
                'inv_issue_lists_id' => $request->return_from,
                'remarkes' => $request->remarkes,
                'company_id' => $authCompany,
            ]);
            $message = 'Return Goods Details Created Successfullsy';
        }


        // dd($isActivityCreated);
        // fetch multiple materials
        // if ($request->goods_type == 'materials') {
        //     $requestMaterialsData = Materials::with(['inventorys' => function ($q) use ($getMaterialsId) {
        //         $q->whereIn('materials_id', $getMaterialsId);
        //     }])->where('company_id', $authCompany)
        //         ->orderBy('id', 'DESC')
        //         ->whereIn('id', $getMaterialsId)
        //         ->get();
        // } else {
        //     $requestMaterialsData = Assets::with(['inventorys' => function ($q) use ($getMaterialsId) {
        //         $q->whereIn('assets_id', $getMaterialsId);
        //     }])->where('company_id', $authCompany)
        //         ->orderBy('id', 'DESC')
        //         ->whereIn('id', $getMaterialsId)
        //         ->get();
        //     // dd( $requestMaterialsData->toArray());
        // }
        // $message = 'Return Goods Details Updated Successfullsy';
        // $materialsQuery = $request->goods_type == 'materials'
        //     ? Materials::with(['inventorys'])
        //     : Assets::with(['inventorys']);
        // dd($authCompany);
        // Step 3: Apply filters
        // if (!empty($request->id) || $request->id != null) {
        // ->whereHas('invReturnDetails', function ($query) use ($isActivityCreated) {
        //     $query->where('inv_return_goods_id', $isActivityCreated->id)
        //         ->whereNotNull('inv_return_goods_id');
        // })
        if ($request->goods_type == 'materials') {
            $requestMaterialsData = Materials::with(['inventorys'])
                ->whereIn('id', $getMaterialsId)
                ->orderBy('id', 'DESC')
                ->get();
        } else {
            $requestMaterialsData = Assets::with(['inventorys'])->where('company_id', $authCompany)
                ->whereIn('id', $getMaterialsId)
                ->orderBy('id', 'DESC')
                ->get();
        }
        // dd($requestMaterialsData);
        // dd($isActivityCreated);
        // Step 4: Format data
        $requestMaterialsData->each(function ($item) use ($isActivityCreated, $request, $authCompany) {
            $inventoryStockQty = Inventory::where('materials_id', $item->id)
                ->where(function ($query) use ($request, $authCompany) {
                    $query->where('projects_id', $request->projects_id)
                        ->where('company_id', $authCompany)
                        ->where('user_id', Auth::guard('company-api')->user()->id);
                })
                ->orWhere(function ($query) use ($item) {
                    $query->where('company_id', $item->company_id)
                        ->where('projects_id', '0');
                })
                ->first() ?? null;
            $item->stockQty = $inventoryStockQty ? $inventoryStockQty->total_qty : 0;
            $item->type = $isActivityCreated->type;
            $item->return_id = $isActivityCreated->id;
            // $item->stockQty = $item?->inventorys ? $item?->inventorys?->total_qty ?? 0 : 0;
            // dd($item);
            // $item->invReturnDetails = $item->invReturnDetails->filter(function ($detail) use ($isActivityCreated) {
            //     dd($detail);
            //     return $detail->inv_return_goods_id = $isActivityCreated->id;
            // });
        });


        // if($requestMaterialsData) {
        // dd($requestMaterialsData);
        $result = InvReturnGoodsDetailsResources::collection($requestMaterialsData);
        // dd( $result);
        // }
        log_daily('Return', 'Inventory Return Goods Add Result', 'add', 'info', json_encode($result));

        DB::commit();
        // addNotifaction($message, $result, $request->projects_id ?? null,$authCompany,null,null);
        return $this->responseJson(true, 200, $message, $result);
        // return $this->responseJson(true, 201, $message, InventoryDtailsResources::collection($requestMaterialsData));
        // return $this->responseJson(true, 201, $message, $requestMaterialsData);
        // } catch (\Exception $e) {
        //     DB::rollBack();
        //     logger($e->getMessage() . 'on' . $e->getFile() . 'in' . $e->getLine());
        //     return $this->responseJson(false, 500, $e->getMessage(), []);
        // }
    }
}
