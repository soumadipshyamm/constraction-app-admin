<?php

namespace App\Http\Controllers\API\inventory;

use App\Http\Controllers\BaseController;
use App\Http\Resources\API\Inventory\inventor\InventoryDtailsResources;
use App\Http\Resources\API\Inventory\InwardGoods\InwardGoodDetailsResources;
use App\Models\Company\Assets;
use App\Models\Company\InwardGoods;
use App\Models\Company\InwardGoodsDetails;
use App\Models\Company\Materials;
use App\Models\InvInwardEntryType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class InwardGoodsController extends BaseController
{
    public function add(Request $request)
    {
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $getMaterialsId = (array)$request->get('materials_id');

        $validator = Validator::make($request->all(), [
            'inv_inwards_id' => 'required',
            'projects_id' => 'required',
            // 'store_id' => 'required',
            'vendors_id' => 'required',
            'grn_no' => 'required',
            'entry_type' => 'required',
            'date' => 'required',
            'delivery_ref_copy_no' => 'required',
            'delivery_ref_copy_date' => 'required',
        ]);
        if ($validator->fails()) {
            $status = false;
            $code = 422;
            $response = [];
            $message = $validator->errors()->first();
            return $this->responseJson($status, $code, $message, $response);
        }
        // dd($request->all());

        $img = getImgUpload($request->img, 'upload');
        $fetchDate = $request->date;
        DB::beginTransaction();
        try {
            $isActivityCreated = InwardGoods::create([
                'uuid' => Str::uuid(),
                'inv_inwards_id' => $request->inv_inwards_id,
                'vendors_id' => $request->vendors_id,
                'grn_no' => $request->grn_no,
                'date' => $request->date,
                'inv_inward_entry_types_id' => $request->entry_type,
                'delivery_ref_copy_no' => $request->delivery_ref_copy_no,
                'delivery_ref_copy_date' => $request->delivery_ref_copy_date,
                'remarkes' => $request->remarkes,
                'img' => $img ?? "",
                'company_id' => $authCompany,
            ]);
            // $isActivityCreated->id
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
            }
            $requestMaterialsData = collect($requestMaterialsData)->each(function ($value, $key) use ($isActivityCreated) {
                $value->inward_id = $isActivityCreated->id;
            });
            $message = 'Inward Goods Details Updated Successfullsy';
            if (isset($isActivityCreated)) {
                DB::commit();
                return $this->responseJson(true, 201, $message, InventoryDtailsResources::collection($requestMaterialsData->all()));
            }
        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage() . 'on' . $e->getFile() . 'in' . $e->getLine());
            return $this->responseJson(false, 500, $e->getMessage(), []);
        }
    }
    // ********************************************************************************
    public function inwardGoodSearch(Request $request)
    {
        // dd($request->all());
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $type = $request->type;
        $name = $request->name;
        // if ($request->type == 'materials') {
        //     $requestMaterialsData = Materials::with(['InvInwardGoodDetails' => function ($q) use ($name) {
        //         $q->name('name', $name);
        //     }])->where('company_id', $authCompany)
        //         ->orderBy('id', 'DESC')
        //         ->whereIn('id', $getMaterialsId)
        //         ->get();
        // } else {
        //     $requestMaterialsData = Assets::with(['InvInwardGoodDetails' => function ($q) use ($getMaterialsId) {
        //         $q->whereIn('assets_id', $getMaterialsId);
        //     }])->where('company_id', $authCompany)
        //         ->orderBy('id', 'DESC')
        //         ->whereIn('id', $getMaterialsId)
        //         ->get();
        // }
    }
    // ********************************************************************************

    public function edit(Request $request)
    {
        $data = InwardGoods::with('InvInwardGoodDetails')->where('inv_inwards_id', $request->inv_inwards_id)->get();
        // $data = $data->with('InvInwardGoodDetails');

        dd($data->toArray());
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
}
