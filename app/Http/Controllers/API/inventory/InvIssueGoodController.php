<?php

namespace App\Http\Controllers\API\inventory;

use App\Http\Controllers\BaseController;
use App\Http\Resources\API\Inventory\inventor\InventoryDtailsResources;
use App\Http\Resources\API\Inventory\InwardGoods\InwardGoodDetailsResources;
use App\Http\Resources\API\Inventory\IssueInward\InvIssuegoodDetailResource;
use App\Http\Resources\API\Inventory\IssueInward\InvIssueGoodResource;
use App\Models\Company\Assets;
use App\Models\Company\InwardGoods;
use App\Models\Company\Materials;
use App\Models\Inventory;
use App\Models\InvInwardEntryType;
use App\Models\InvIssue;
use App\Models\InvIssueGood;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class InvIssueGoodController extends BaseController
{

    public function add(Request $request)
    {
        log_daily('Issue', 'Inventory Issue Goods Add', 'add', 'info', json_encode($request->all()));
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $getMaterialsId = (array)$request->materials_id;
        $validator = Validator::make($request->all(), [
            'inv_issues_id' => 'required',
            'projects_id' => 'required',
            'store_warehouses_id' => 'required',
            // 'entry_type' => 'required',
            // 'issue_no' => 'required',
            'date' => 'required',
            'issue_to' => 'required',
            // 'remarkes' => 'required',
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
            $isActivityCreated = "";
            // Step 1: Update or create InvIssueGood
            if (!empty($request->id) || $request->id != null) {
                $isActivityCreated = InvIssueGood::where('id', $request->id)->first();
                InvIssueGood::where('id', $request->id)->update([
                    'inv_issues_id' => $request->inv_issues_id,
                    'type' => $request->goods_type,
                    'date' => $request->date,
                    'tag_id' => $request->entry_type ?? null,
                    'inv_issue_lists_id' => $request->issue_to,
                    'remarkes' => $request->remarkes ?? null,
                ]);

                $message = 'Inward Goods Details Updated Successfully';
            } else {
                $isActivityCreated = InvIssueGood::create([
                    'uuid' => Str::uuid(),
                    'inv_issues_id' => $request->inv_issues_id,
                    'type' => $request->goods_type,
                    'tag_id' => $request->entry_type ?? null,
                    'issue_no' => $request->issue_no,
                    'date' => $request->date,
                    'inv_issue_lists_id' => $request->issue_to,
                    'remarkes' => $request->remarkes ?? null,
                    'company_id' => $authCompany,
                ]);
                $message = 'Inward Goods Details create successfully';
            }

            // Step 2: Fetch relevant materials or assets

            $materialsQuery = $request->goods_type == 'materials'
                ? Materials::with(['inventorys'])
                : Assets::with(['inventorys']);

            // Step 3: Apply filters

            $requestMaterialsData = $materialsQuery
                // ->whereHas('invIssuesDetails', function ($query) use ($isActivityCreated) {
                //     // dd($isActivityCreated->id);
                //     $query
                //         // ->where('inv_issue_goods_id', $isActivityCreated->id)
                //         ->whereNotNull('inv_issue_goods_id');
                // })
                ->where('company_id', $authCompany)
                ->whereIn('id', $getMaterialsId)
                ->orderBy('id', 'DESC')
                ->get();

            // Step 4: Format data
            // dd($requestMaterialsData);
            $requestMaterialsData->each(function ($item) use ($isActivityCreated, $request, $authCompany) {
                // dd($item, $materialsQuery);
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
                $item->stockQty = $inventoryStockQty ? $inventoryStockQty->total_qty ?? 0 : 0;
                $item->type = $isActivityCreated->type;
                $item->issue_id = $isActivityCreated->id;
            });
            // dd($requestMaterialsData);
            if (isset($requestMaterialsData)) {
                $resule = InvIssueGoodDetailResource::collection($requestMaterialsData);
            }
            log_daily('Issue', 'Inventory Issue Goods Add Result ', 'add', 'info', json_encode($resule));

            DB::commit();
            // addNotifaction($message, $resule, $request->projects_id ?? null,$authCompany,null,null);
            return $this->responseJson(true, 200, $message, $resule ?? []);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->responseJson(false, 500, $e->getMessage(), []);
        }
    }
    // public function add(Request $request)
    // {
    //     log_daily('Issue', 'Inventory Issue Goods Add', 'add', 'info', json_encode($request->all()));
    //     $authCompany = Auth::guard('company-api')->user()->company_id;
    //     $getMaterialsId = (array)$request->materials_id;
    //     $getStoreWarehouses = (array)$request->store_warehouses_id;
    //     // dd($request->all());
    //     $resule = [];
    //     $validator = Validator::make($request->all(), [
    //         'inv_issues_id' => 'required',
    //         'projects_id' => 'required',
    //         'store_warehouses_id' => 'required',
    //         // 'entry_type' => 'required',
    //         // 'issue_no' => 'required',
    //         'date' => 'required',
    //         'issue_to' => 'required',
    //         // 'remarkes' => 'required',
    //     ]);
    //     if ($validator->fails()) {
    //         $status = false;
    //         $code = 422;
    //         $response = [];
    //         $message = $validator->errors()->first();
    //         return $this->responseJson($status, $code, $message, $response);
    //     }

    //     DB::beginTransaction();
    //     try {
    //         // Step 1: Update or create InvIssueGood
    //         if (!empty($request->id) || $request->id != null) {
    //             // dd($request->all());
    //             $isActivityCreated = InvIssueGood::where('id', $request->id)->first();
    //             InvIssueGood::where('id', $request->id)->update([
    //                 'inv_issues_id' => $request->inv_issues_id,
    //                 'type' => $request->goods_type,
    //                 'date' => $request->date,
    //                 'tag_id' => $request->entry_type ?? null,
    //                 'inv_issue_lists_id' => $request->issue_to,
    //                 'remarkes' => $request->remarkes ?? null,
    //             ]);

    //             $message = 'Inward Goods Details Updated Successfully';
    //         } else {
    //             // dd($request->all());
    //             $isActivityCreated = InvIssueGood::create([
    //                 'uuid' => Str::uuid(),
    //                 'inv_issues_id' => $request->inv_issues_id,
    //                 'type' => $request->goods_type,
    //                 'tag_id' => $request->entry_type ?? null,
    //                 'issue_no' => $request->issue_no,
    //                 'date' => $request->date,
    //                 'inv_issue_lists_id' => $request->issue_to,
    //                 'remarkes' => $request->remarkes ?? null,
    //                 'company_id' => $authCompany,
    //             ]);
    //             // dd($isActivityCreated);
    //             $message = 'Inward Goods Details create Successfully';
    //         }

    //         // dd($request->goods_type);
    //         // Step 2: Fetch relevant materials or assets

    //         // $materialsQuery = $request->goods_type == 'materials'
    //         //     ? Materials::with(['inventorys'])
    //         //     : Assets::with(['inventorys']);

    //         // Step 3: Apply filters

    //         // dd($materialsQuery->);
    //         if ($request->goods_type == 'materials') {
    //             $requestMaterialsData =  Materials::with('inventorys', 'invIssuesDetails.InvIssueGood')
    //                 // ->whereHas('invIssuesDetails', function ($query) use ($isActivityCreated) {
    //                 //     $query->where('inv_issue_goods_id', $isActivityCreated->id)
    //                 //         ->whereNotNull('inv_issue_goods_id');
    //                 // })
    //                 ->where('company_id', $authCompany)
    //                 ->whereIn('id', $getMaterialsId)
    //                 ->orderBy('id', 'DESC')
    //                 ->get();
    //         } else {
    //             $requestMaterialsData =  Assets::with('inventorys', 'invIssuesDetails.InvIssueGood')
    //                 // ->whereHas('invIssuesDetails', function ($query) use ($isActivityCreated) {
    //                 //     $query->whereHas('InvIssueGood', function ($qwer) use ($isActivityCreated) {
    //                 //         $qwer->where('inv_issue_goods_id', $isActivityCreated->id)
    //                 //             ->whereNotNull('inv_issue_goods_id');
    //                 //     });
    //                 // })
    //                 ->where('company_id', $authCompany)
    //                 ->whereIn('id', $getMaterialsId)
    //                 ->orderBy('id', 'DESC')
    //                 ->get();
    //         }

    //         // dd($requestMaterialsData);
    //         // Step 4: Format data
    //         $requestMaterialsData->each(function ($item) use ($isActivityCreated) {
    //             // dd($item->inventorys);
    //             $item->stockQty = $item?->inventorys ? $item->inventorys?->total_qty ?? null : 0;
    //             $item->type = $isActivityCreated->type;
    //             $item->issue_id = $isActivityCreated->id;
    //             // $item->invIssuesDetails = $item->invIssuesDetails->each(function ($detail) use ($isActivityCreated) {
    //             //     return $detail->inv_issue_goods_id = $isActivityCreated->id;
    //             // });
    //         });
    //         if (isset($requestMaterialsData)) {
    //             $resule = InvIssuegoodDetailResource::collection($requestMaterialsData);
    //             // return $this->responseJson(true, 200, $message, );
    //             // return $this->responseJson(true, 200, $message, InventoryDtailsResources::collection($requestMaterialsData->all()));
    //         }
    //         log_daily('Issue', 'Inventory Issue Goods Add Result ', 'add', 'info', json_encode($resule));

    //         // dd($requestMaterialsData->toArray());
    //         DB::commit();
    //         // addNotifaction($message, $resule, $request->projects_id ?? null,$authCompany,null,null);
    //         return $this->responseJson(true, 200, $message, $resule ?? []);
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         return $this->responseJson(false, 500, 'An error occurred', ['error' => $e->getMessage()]);
    //     }
    // }
    // ********************************************************************************
    public function entryType()
    {
        $datas = InvInwardEntryType::orderBy('id', 'desc')->get();
        if (!empty($datas) && ($datas) != null) {
            return $this->responseJson(true, 200, 'Fetch Entry Type List Successfullsy', $datas);
        } else {
            return $this->responseJson(true, 200, 'Entry Type List Data Not Found', []);
        }
    }
    // ********************************************************************************
    public function list() {}
    // ********************************************************************************
    public function edit(Request $request)
    {
        // dd($request->all());
        $data = InvIssueGood::with('InvIssue', 'invIssueDetails')->where(['inv_issues_id' => $request->inv_issues_id])->latest()->first();
        if (isset($data)) {
            return $this->responseJson(true, 200, 'Inward Goods Details Updated Successfullsy', $data ? new InvIssueGoodResource($data) : []);
        }
    }
}
