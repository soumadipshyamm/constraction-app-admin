<?php

namespace App\Http\Controllers\API\inventory;

use App\Http\Controllers\BaseController;
use App\Http\Resources\API\Inventory\inventor\InventoryDtailsResources;
use App\Http\Resources\API\Inventory\InwardGoods\InwardGoodDetailsResources;
use App\Models\Company\Assets;
use App\Models\Company\InwardGoods;
use App\Models\Company\Materials;
use App\Models\InvInwardEntryType;
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
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $getMaterialsId = (array)$request->materials_id;
        $getStoreWarehouses = (array)$request->store_warehouses_id;
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'inv_issues_id' => 'required',
            'projects_id' => 'required',
            'store_warehouses_id' => 'required',
            'entry_type' => 'required',
            'issue_no' => 'required',
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
        // $fetchDate = $request->date;
        // materials_id
        DB::beginTransaction();
        try {
            // dd($request->all());
            $isActivityCreated = InvIssueGood::create([
                'uuid' => Str::uuid(),
                'inv_issues_id' => $request->inv_issues_id,
                'type' => $request->entry_type, //tag id
                'issue_no' => $request->issue_no,
                'date' => $request->date,
                'type' => $request->entry_type,
                'inv_issue_lists_id' => $request->issue_to,
                'remarkes' => $request->remarkes ?? null,
                'company_id' => $authCompany,
            ]);

            // fetch multiple materials

            if ($request->goods_type == 'materials') {
                $requestMaterialsData = Materials::with(['inventorys' => function ($q) use ($getMaterialsId) {
                    $q->whereIn('materials_id', $getMaterialsId);
                }])->where('company_id', $authCompany)
                    ->orderBy('id', 'DESC')
                    ->whereIn('id', $getMaterialsId)
                    ->get();
            } else {
                $requestMaterialsData = Assets::with(['inventorys' => function ($q) use ($getMaterialsId) {
                    $q->whereIn('assets_id', $getMaterialsId);
                }])->where('company_id', $authCompany)
                    ->orderBy('id', 'DESC')
                    ->whereIn('id', $getMaterialsId)
                    ->get();
                // dd( $requestMaterialsData->toArray());
            }
            $requestMaterialsData = collect($requestMaterialsData)->each(function ($value, $key) use ($isActivityCreated) {
                $value->inward_id = $isActivityCreated->id;
            });
            $message = 'Inward Goods Details Updated Successfullsy';
            if (isset($isActivityCreated)) {
                DB::commit();
                return $this->responseJson(true, 201, $message, InventoryDtailsResources::collection($requestMaterialsData));
                // return $this->responseJson(true, 201, $message, $requestMaterialsData);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage() . 'on' . $e->getFile() . 'in' . $e->getLine());
            return $this->responseJson(false, 500, $e->getMessage(), []);
        }
    }
    // ********************************************************************************
    public function entryType()
    {
        $datas = InvInwardEntryType::all();
        if (!empty($datas) && ($datas) != null) {
            return $this->responseJson(true, 200, 'Fetch Entry Type List Successfullsy', $datas);
        } else {
            return $this->responseJson(true, 200, 'Entry Type List Data Not Found', []);
        }
    }
    // ********************************************************************************


    public function list()
    {

    }
}
