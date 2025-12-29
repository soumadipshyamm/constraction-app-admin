<?php

namespace App\Http\Controllers\API\inventory;

use App\Http\Controllers\BaseController;
use App\Http\Resources\API\Inventory\inventor\InventoryDtailsResources;
use App\Http\Resources\API\Inventory\InwardGoods\InwardGoodDetailsResources;
use App\Http\Resources\API\Inventory\InwardGoods\InwardGoodsResource;
use App\Models\Company\Assets;
use App\Models\Company\InwardGoods;
use App\Models\Company\InwardGoodsDetails;
use App\Models\Company\Materials;
use App\Models\Company\Project;
use App\Models\Company\StoreWarehouse;
use App\Models\Company\Vendor;
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
        log_daily('Inward', 'Inventory inwardGoodsController Add', 'add', 'info', json_encode($request->all()));
        // dd($request->all());
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
        // dd($request->all());

        if ($validator->fails()) {
            $status = false;
            $code = 422;
            $response = [];
            $message = $validator->errors()->first();
            return $this->responseJson($status, $code, $message, $response);
        }
        // dd($request->all());
        $isActivityCreated = "";
        $img = $request->img ? getImgUpload($request->img, 'upload') : null;
        $fetchDate = $request->date;
        DB::beginTransaction();
        try {
            // dd($request->all());
            if (($request->id == "null") || empty($request->id)) {
                // dd($request->all());
                $isActivityCreated = InwardGoods::create([
                    'uuid' => Str::uuid(),
                    'inv_inwards_id' => $request->inv_inwards_id,
                    'vendor_id' => $request->vendors_id,
                    'grn_no' => $request->grn_no,
                    'date' => $request->date,
                    'inv_inward_entry_types_id' => $request->entry_type,
                    'delivery_ref_copy_no' => $request->delivery_ref_copy_no ?? '',
                    'delivery_ref_copy_date' => $request->delivery_ref_copy_date ?? '',
                    'remarkes' => $request->remarkes,
                    'img' => $img ?? null,
                    'company_id' => $authCompany,
                    'type' => $request->type
                ]);
                // dd($isActivityCreated);
                $message = 'Inward Goods Details Created Successfullsy';
            } else {
                // dd($request->all());
                $isActivityCreated = InwardGoods::where('id', $request->id)->first();
                $isActivityCreated->update([
                    'inv_inwards_id' => $request->inv_inwards_id,
                    'vendor_id' => $request->vendors_id,
                    'date' => $request->date,
                    'inv_inward_entry_types_id' => $request->entry_type,
                    'delivery_ref_copy_no' => $request->delivery_ref_copy_no ?? '',
                    'delivery_ref_copy_date' => $request->delivery_ref_copy_date ?? '',
                    'remarkes' => $request->remarkes,
                    'img' => $img ?? null,
                    'type' => $request->type
                ]);
                $message = 'Inward Goods Details Updated Successfullsy';
            }
            // $isActivityCreated->id
            // dd($isActivityCreated);
            // dd($getMaterialsId);
            if ($request->type == 'materials') {
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
            // dd($requestMaterialsData);
            $requestMaterialsData = collect($requestMaterialsData)->each(function ($value, $key) use ($isActivityCreated) {
                $value->inward_id = $isActivityCreated->id;
            });
            $resultt = [];
            // dd($requestMaterialsData->toArray());
            if (isset($requestMaterialsData)) {
                $resultt = InwardGoodDetailsResources::collection($requestMaterialsData->all());
            } else {
                $resultt = [];
            }
            log_daily('Inward', 'Inventory inwardGoodsController Add Result', 'add', 'info', json_encode($resultt));
            DB::commit();
            // dd($resultt);
            // addNotifaction($message, $resultt, $request->projects_id ?? null,$authCompany);
            return $this->responseJson(true, 200, 'Inward Goods Details Updated Successfullsy', $resultt);
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
        $data = InwardGoods::with('InvInward', 'InvInwardGoodDetails')->where(['inv_inwards_id' => $request->inv_inwards_id])->first();
        // dd(collect($data->InvInwardGoodDetails));
        if (isset($data)) {
            // dd($data);
            DB::commit();
            return $this->responseJson(true, 200, 'Inward Goods Details Updated Successfullsy', new InwardGoodsResource($data));
        } else {
            return $this->responseJson(true, 200, 'Inward Goods Details Updated Successfullsy', []);
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
    public function invFetchentryType(Request $request)
    {
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $type = $request->type;
        $project_id = $request->project_id;
        $store_id = $request->store_id;
        // $data = "";
        switch ($type) {
            case 'direct':
                $data = Vendor::where('company_id', $authCompany)->whereIn('type', ['supplier', 'both'])->orderBy('id', 'desc')->get();
                $message = 'Vendor Fetch Successfull';
                break;
            case 'from-po':
                $data = Vendor::where('company_id', $authCompany)->whereIn('type', ['supplier', 'both'])->orderBy('id', 'desc')->get();
                $message = 'Vendor Fetch Successfull';
                break;
            case 'from-pr':
                $data = Vendor::where('company_id', $authCompany)->whereIn('type', ['supplier', 'both'])->orderBy('id', 'desc')->get();
                $message = 'Vendor Fetch Successfull';
                break;
            case 'from-other-project':
                $data = Project::where('company_id', $authCompany)->whereNot('id', $project_id)->orderBy('id', 'desc')->get();
                $message = 'Project Fetch Successfull';
                break;
            case 'same-project-other-stores':
                $data = StoreWarehouse::where('company_id', $authCompany)->where('projects_id', $project_id)->whereNotIn('id', $store_id)->orderBy('id', 'desc')->get();
                // dd($data);
                $message = 'Store/Warehouse Fetch Successfull';
                break;
            case 'from-client':
                $data = Vendor::where('company_id', $authCompany)->whereIn('type', ['supplier', 'both'])->orderBy('id', 'desc')->get();
                $message = 'Vendor Fetch Successfull';
                break;
            case 'cash-purchase':
                $data = Vendor::where('company_id', $authCompany)->whereIn('type', ['supplier', 'both'])->orderBy('id', 'desc')->get();
                $message = 'Vendor Fetch Successfull';
                break;
            default:
                return $this->responseJson(false, 200, 'Something Wrong Happened');
        }
        // dd($data);
        if ($data) {
            // dd($data);
            return $this->responseJson(true, 200, $message, $data);
        } else {
            return $this->responseJson(false, 200, 'Something Wrong Happened');
        }
    }
    // ********************************************************************************
}
