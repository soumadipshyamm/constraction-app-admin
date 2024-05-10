<?php

namespace App\Http\Controllers;

use App\Http\Resources\API\Inventory\inventor\InventoryDtailsResources;
use App\Models\Company\Assets;
use App\Models\Company\Materials;
use App\Models\InvReturnGood;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class InvReturnGoodController extends BaseController
{

    public function add(Request $request)
    { {
            $authCompany = Auth::guard('company-api')->user()->company_id;
            $getMaterialsId = (array)$request->materials_id;
            $validator = Validator::make($request->all(), [
                'inv_return_id' => 'required',
                'projects_id' => 'required',
                'store_warehouses_id' => 'required',
                'type' => 'required',
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
            try {

                $isActivityCreated = InvReturnGood::create([
                    'uuid' => Str::uuid(),
                    'inv_returns_id' => $request->inv_return_id,
                    'type' => $request->type,
                    'return_no' => $request->return_no,
                    'date' => $request->date,
                    'inv_issue_lists_id' => $request->return_from,
                    // 'remarkes' => $request->remarkes,
                    'company_id' => $authCompany,
                ]);

                // dd($isActivityCreated);
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
    }
}


// array:9 [ // app\Http\Controllers\InvReturnGoodController.php:13
//     "inv_return_id" => 1
//     "projects_id" => 2
//     "store_warehouses_id" => 3
//     "type" => 1
//     "return_no" => "wdetgh876"
//     "date" => "2024-03-07"
//     "return_from" => 7
//     "remarkes" => "eeeeeeeeeeeeeeeeeeeeeeeeeeeeee"
//     "materials_id" => array:2 [
//       0 => 1
//       1 => 3
//     ]
//   ]
