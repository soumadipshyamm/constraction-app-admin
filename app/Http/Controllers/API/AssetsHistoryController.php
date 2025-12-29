<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\Company\Assets;
use Illuminate\Support\Facades\Auth;
use App\Models\Company\AssetsHistory;
use App\Http\Controllers\BaseController;
use App\Http\Resources\API\Assets\AssetsHistoryResources;
use App\Http\Resources\API\Assets\AssetsResources;
use App\Http\Resources\AssetsResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AssetsHistoryController extends BaseController
{
    public function index($id)
    {
        $authConpany = Auth::guard('company-api')->user()->company_id;
        $data = AssetsHistory::where('company_id', $authConpany)->where('dpr_id', $id)->get();
        if (isset($data)) {
            return $this->responseJson(true, 200, 'Fetch Assets List Successfullsy', $data);
        } else {
            return $this->responseJson(true, 200, 'Assets List Data Not Found', []);
        }
    }

    public function add(Request $request)
    {
        log_daily(
            'AssetsHistory',
            'Assets History Add/Update request received with data.',
            'add',
            'info',
            json_encode($request->all())
        );
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $validator = Validator::make($request->all(), [
            // '*.assets_id' => 'required',
            '*.qty' => 'required',
            // '*.activities_id' => 'required',
            // '*.vendors_id' => 'required',
            '*.rate_per_unit' => 'required',
            // '*.dpr_id' => 'required',
        ]);
        if ($validator->fails()) {
            $status = false;
            $code = 422;
            $response = [];
            $message = $validator->errors()->first();
            return $this->responseJson($status, $code, $message, $response);
        }
        $datas = $request->all();
        // dd( $datas);
        DB::beginTransaction();
        try {
            // if ($request[0]['type'] == "previous") {
            //     $assets = Assets::with(['units', 'project', 'store_warehouses'])
            //         ->whereHas('assetsHistory', function ($query) use ($request) {
            //             $query->where('dpr_id', $request[0]['dpr_id']);
            //         })
            //         ->where('company_id', $authCompany)
            //         // ->whereIn('id', $getAssetsId)
            //         ->get();
            //     $result = AssetsHistoryResources::collection($assets);

            //     $message = 'Fetch Assets List Successfully';
            // } else {
            foreach ($datas as $data) {

                $assets_id = $data['assets_id'];
                $dpr_id = $data['dpr_id'];
                $uuid = Str::uuid();

                $qty = $data['qty'];
                $activities_id = $data['activities_id'] ?? null;
                $vendors_id = $data['vendors_id'] ?? null;
                $rate_per_unit = $data['rate_per_unit'];
                $remarkes = $data['remarkes'];
                $company_id = $authCompany;

                $updateData = compact(
                    'qty',
                    'activities_id',
                    'vendors_id',
                    'rate_per_unit',
                    'remarkes',
                    'company_id'
                );

                $criteria = compact('assets_id', 'dpr_id');
                log_daily(
                    'AssetsHistory',
                    'Assets History Update/Insert criteria and data.',
                    'update_or_create',
                    'info',
                    json_encode(['criteria' => $criteria, 'data' => $updateData])
                );
                // Update or create the record
                $result = AssetsHistory::updateOrCreate($criteria, $updateData);
            }
            $message = 'Activity Details Updated Successfully';
            // }
            DB::commit();
            return $this->responseJson(true, 201, $message, $result);
        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage() . 'on' . $e->getFile() . 'in' . $e->getLine());
            return $this->responseJson(false, 500, $e->getMessage(), []);
        }
    }

    // public function edit(Request $request)
    // {
    //     $getAssetsId = $request->get('getAssets');
    //     $dprId = $request->input('dprId');
    //     $authCompany = Auth::guard('company-api')->user();
    //     $assets = [];
    //     foreach ($getAssetsId as $assetsId) {
    //         $assetsHistory = AssetsHistory::where('assets_id', $assetsId)
    //             ->where('dpr_id', $dprId)
    //             ->where('company_id', $authCompany->company_id)
    //             ->first();

    //         if ($assetsHistory) {
    //             $asset = Assets::where('id', $assetsId)
    //                 ->where('company_id', $authCompany->company_id)
    //                 ->first();

    //             if ($asset) {
    //                 $assets[] = new AssetsHistoryResources([
    //                     'asset' => $asset,
    //                     'asset_history' => $assetsHistory
    //                 ]);
    //             }
    //         } else {
    //             $asset = Assets::where('id', $assetsId)
    //                 ->where('company_id', $authCompany->company_id)
    //                 ->first();

    //             if ($asset) {
    //                 $assets[] = new AssetsHistoryResources([
    //                     'asset' => $asset
    //                 ]);
    //             }
    //         }
    //     }
    //     $message = 'Fetch Assets List Successfully';
    //     return response()->json(['success' => true, 'status' => 200, 'message' => $message, 'data' => $assets]);
    // }



    public function edit(Request $request)
    {
        $getAssetsId = $request->getAssets;
        $dprId = $request->dprId;
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $assets = Assets::with(['units', 'project', 'store_warehouses', 'assetsHistory' => function ($query) use ($dprId) {
            $query->where('dpr_id', $dprId);
        }])
            ->where('company_id', $authCompany)
            ->whereIn('id', $getAssetsId)
            ->get();
        $assetsResources = AssetsHistoryResources::collection($assets);

        $message = 'Fetch Assets List Successfully';
        return response()->json(['success' => true, 'status' => 200, 'message' => $message, 'data' => $assetsResources]);
    }

    // public function edit($id)
    // {
    //     $findId = Assets::find($id);
    //     if ($findId) {
    //         $authCompany = Auth::guard('company-api')->user()->company_id;
    //         $data = Assets::where('company_id', $authCompany)
    //             ->where('assets_id', $id)
    //             ->latest('id')
    //             ->first();
    //         $message = 'Fetch Assets List Successfullsy';
    //     } else {
    //         $data = [];
    //         $message = 'ID Do Not Found';
    //     }
    //     return $this->responseJson(true, 200, $message, $data);
    // }


    // public function edit(Request $request)
    // {
    //     $getAssetsId = $request->getAssets;
    //     $dprId = $request->dprId;
    //     $authCompany = Auth::guard('company-api')->user()->company_id;
    //     $assets = [];
    //     // dd($dprId);
    //     // $assets['dpr']=$dprId;
    //     foreach ($getAssetsId as $key => $dataValue) {
    //         // foreach ($data as $k => $dataValue) {
    //             $assetsData = Assets::with('units', 'project', 'store_warehouses', 'assetsHistory',function($q) use($dprId){
    //                 $q->where('dpr_id',$dprId);
    //             })->where('company_id', $authCompany)
    //                 ->where('id', $dataValue)
    //                 ->first();
    //             if ($assetsData) {
    //                 dd($assetsData);
    //                 $assets[] = new AssetsHistoryResources($assetsData);
    //             }
    //         // }
    //     }
    //     // dd($assets);
    //     $message = 'Fetch Assets List Successfully';
    //     return response()->json(['success' => true, 'status' => 200, 'message' => $message, 'data' => $assets]);
    // }

    // function flattenNestedData($data, &$result = [])
    // {
    //     foreach ($data as $item) {
    //         if (is_array($item)) {
    //             $this->flattenNestedData($item, $result);
    //         } else {
    //             $result[] = $item;
    //         }
    //     }
    //     return $result;
    // }
}
