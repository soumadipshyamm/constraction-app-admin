<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\BaseController;
use App\Http\Resources\API\DPR\DprMaterialsResources;
use App\Http\Resources\API\Materials\MaterialsResources;
use App\Http\Resources\MaterialsResource;
use App\Http\Resources\OpeningStockResource;
use App\Models\Company\MaterialOpeningStock;
use App\Models\Company\Materials;
use App\Models\Company\MaterialsHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class MaterialsHistoryController extends BaseController
{
    public function index()
    {
        $authConpany = Auth::guard('company-api')->user()->company_id;
        $data = MaterialsHistory::where('company_id', $authConpany)->orderBy('id', 'asc')->get();
        // dd($data);
        if (isset($data)) {
            return $this->responseJson(true, 200, 'Fetch Materials List Successfullsy', $data);
        } else {
            return $this->responseJson(true, 200, 'Materials List Data Not Found', []);
        }
    }
    public function add(Request $request)
    {
        log_daily(
            'MaterialsHistory',
            'Materials History Add/Update request received with data.',
            'add',
            'info',
            json_encode($request->all())
        );
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $validator = Validator::make($request->all(), [
            '*.qty' => 'required|integer',
            // '*.materials_id' => 'required|integer|exists:materials,id', // Check if materials_id exists in the 'materials' table
            // '*.activities_id' => 'required|integer|exists:activities,id', // Check if activities_id exists in the 'activities' table
            // '*.vendors_id' => 'required|integer|exists:vendors,id', // Check if vendors_id exists in the 'vendors' table
            // '*.remarkes' => 'required|string',
            // '*.dpr_id' => 'required',
        ]);
        if ($validator->fails()) {
            $status = false;
            $code = 422;
            $message = $validator->errors()->first();
            $response = [];
            return $this->responseJson($status, $code, $message, $response);
        }
        $datas = $request->all();
        DB::beginTransaction();
        try {
            $MaterialsHistory = [];
            // if ($request[0]['type'] == "previous") {
            //     $materialData = Materials::with(['materialsOpenStock', 'units', 'projects', 'stores'])
            //         ->whereHas('materialsHistory', function ($query) use ($request) {
            //             $query->where('dpr_id', $request[0]['dpr_id']);
            //         })
            //         ->where('company_id', $authCompany)
            //         // ->whereIn('id', $getMaterialsId)
            //         ->get();
            //     $MaterialsHistory = DprMaterialsResources::collection($materialData);
            //     $message = 'Fetch Materials List Successfully';
            // } else {
            foreach ($datas as $data) {
                $materials_id = $data['materials_id'];
                $dpr_id = $data['dpr_id'];
                $activities_id = $data['activities_id'] ?? null;
                $qty = $data['qty'] ?? '';
                $remarkes = $data['remarkes'] ?? '';
                $company_id = $authCompany;
                $MaterialsHistory[] = MaterialsHistory::updateOrCreate(
                    compact('materials_id', 'dpr_id', 'activities_id'),
                    compact('qty', 'remarkes', 'company_id')
                );
                $message = $data['materials_id'] ? 'Materials Details Updated Successfully' : 'Materials Details Added Successfully';
            }
            // }
            DB::commit();
            return $this->responseJson(true, 200, $message, $MaterialsHistory);
            // return $this->responseJson(true, 201, $message, MaterialsResources::collection($MaterialsHistory));
        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage() . ' on ' . $e->getFile() . ' in ' . $e->getLine());
            return $this->responseJson(false, 500, $e->getMessage(), []);
        }
    }
    // public function edit(Request $request)
    // {
    //     $getMaterialsId = $request->get('getMaterials');
    //     $dprId = $request->input('dprId');
    //     $authCompany = Auth::guard('company-api')->user();
    //     $materials = [];
    //     foreach ($getMaterialsId as $materialsId) {
    //         $materialHistory = MaterialsHistory::where('materials_id', $materialsId)
    //             ->where('dpr_id', $dprId)
    //             ->where('company_id', $authCompany->company_id)
    //             ->first();
    //         // dd($materialHistory);
    //         if ($materialHistory) {
    //             $material = Materials::where('id', $materialsId)
    //                 ->where('company_id', $authCompany->company_id)
    //                 ->first();
    //             if ($material) {
    //                 $materials[] = new DprMaterialsResources([
    //                     'material' => $material,
    //                     'material_history' => $materialHistory
    //                 ]);
    //             }
    //         } else {
    //             $material = Materials::where('id', $materialsId)
    //                 ->where('company_id', $authCompany->company_id)
    //                 ->first();
    //             if ($material) {
    //                 $materials[] = new DprMaterialsResources([
    //                     'material' => $material
    //                 ]);
    //             }
    //         }
    //     }
    //     // dd($materials);
    //     $message = 'Fetch Materials List Successfully';
    //     return response()->json(['success' => true, 'status' => 200, 'message' => $message, 'data' => $materials]);
    // }
    public function edit(Request $request)
    {
        $getMaterialsId = $request->getMaterials;
        $dprId = $request->dprId;
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $materialData = Materials::with(['materialsOpenStock', 'units', 'projects', 'stores', 'materialsHistory' => function ($query) use ($dprId) {
            $query->where('dpr_id', $dprId);
        }])
            ->where('company_id', $authCompany)
            ->whereIn('id', $getMaterialsId)
            ->get();
        $materials = DprMaterialsResources::collection($materialData);
        $message = 'Fetch Materials List Successfully';
        return response()->json(['success' => true, 'status' => 200, 'message' => $message, 'data' => $materials]);
    }
    // ************************************************************************************
    public function materialsOpening(Request $request)
    {
        log_daily(
            'MaterialsHistory',
            'Materials Opening Stock request received with data.',
            'opening_stock',
            'info',
            json_encode($request->all())
        );
        $authConpany = Auth::guard('company-api')->user()->company_id;
        $data = MaterialOpeningStock::with('materials', 'units', 'projects', 'stores')
            ->where('project_id', $request->projectId)
            ->orWhere('store_id', $request->storeId)
            ->get();
        if (isset($data)) {
            return $this->responseJson(true, 200, 'Fetch Materials List Successfullsy',  OpeningStockResource::collection($data));
        } else {
            return $this->responseJson(true, 200, 'Materials List Data Not Found', []);
        }
    }
    // public function edit(Request $request)
    // {
    //     $ids = $request->all();
    //     // dd($ids);
    //     $findId = [];
    //     foreach ($ids as $key => $data) {
    //         foreach ($data as $k => $dataValue) {
    //             // dd($k, $data);
    //             $i = 0;
    //             $authCompany = Auth::guard('company-api')->user()->company_id;
    //             $findId[] = MaterialOpeningStock::with('materials', 'materials.units', 'projects', 'stores')
    //                 ->where('company_id', $authCompany)
    //                 ->where('id', $dataValue)
    //                 ->get();
    //             $i++;
    //         }
    //     }
    //     // dd($findId);
    //     $object = json_decode(json_encode((object) $findId), FALSE);
    //     $flattenedData = [];
    //     $finalData = $this->flattenNestedData($object, $flattenedData);
    //     // dd($finalData);
    //     $message = 'Fetch Materials List Successfullsy';
    //     return $this->responseJson(true, 200, $message,  OpeningStockResource::collection($finalData));
    // }
    // public function edit(Request $request)
    // {
    //     $ids = $request->all();
    //     // dd($ids);
    //     $findId = [];
    //     $material = [];
    //     foreach ($ids as $key => $data) {
    //         foreach ($data as $k => $dataValue) {
    //             // dd($k, $data);
    //             $i = 0;
    //             $authCompany = Auth::guard('company-api')->user()->company_id;
    //             $findId[] = Materials::with('materialsOpenStock', 'units', 'projects', 'stores','materialsHistory')->where('company_id', $authCompany)
    //                 ->where('id', $dataValue)
    //                 ->get();
    //             $i++;
    //         }
    //     }
    //     // dd($findId);
    //     $object = json_decode(json_encode((object) $findId), FALSE);
    //     $flattenedData = [];
    //     $finalData = $this->flattenNestedData($object, $flattenedData);
    //     $material[] = $this->arrayToObject($finalData);
    //     // dd($finalData);
    //     $message = 'Fetch Materials List Successfullsy';
    //     return $this->responseJson(true, 200, $message,  DprMaterialsResources::collection($material));
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
    // function arrayToObject($array)
    // {
    //     // dd($array);
    //     $materials = [];
    //     foreach ($array as $key => $data) {
    //         // foreach ($arrayData as $key => $data) {
    //             // dd($data);
    //             $materials['id'] = $data->id;
    //             $materials['uuid'] = $data->uuid;
    //             $materials['code'] = $data->code;
    //             $materials['unit_id'] = $data->unit_id;
    //             $materials['class'] = $data->class;
    //             $materials['name'] = $data->name;
    //             $materials['specification'] = $data->specification;
    //             if (isset($data->materials_history) && $data->materials_history != null) {
    //                 foreach ($data->materials_history as $k => $materialsHistory) {
    //                     // dd($materialsHistory);
    //                     $materials['materials_history_id'] = $materialsHistory->id ?? '';
    //                     $materials['materials_history_uuid'] = $materialsHistory->uuid ?? '';
    //                     $materials['materials_history_materials_id'] = $materialsHistory->materials_id ?? '';
    //                     $materials['materials_history_activities_id'] = $materialsHistory->activities_id ?? '';
    //                     $materials['materials_history_qty'] = $materialsHistory->qty ?? '';
    //                     $materials['materials_history_date'] = $materialsHistory->date ?? '';
    //                     $materials['materials_history_vendors_id'] = $materialsHistory->vendors_id ?? '';
    //                     $materials['materials_history_remarkes'] = $materialsHistory->remarkes ?? '';
    //                     $materials['materials_history_dpr_id'] = $materialsHistory->dpr_id ?? '';
    //                 }
    //             }
    //         // }
    //     }
    //     // dd($materials);
    //     return $materials;
    // }
    // public function edit(Request $request)
    // {
    //     $ids = $request->all();
    //     $authCompany = Auth::guard('company-api')->user()->company_id;
    //     $materials = [];
    //     foreach ($ids as $key => $data) {
    //         foreach ($data as $k => $dataValue) {
    //             $materialData = Materials::with('materialsOpenStock', 'units', 'projects', 'stores', 'materialsHistory')
    //                 ->where('company_id', $authCompany)
    //                 ->where('id', $dataValue)
    //                 ->first();
    //             if ($materialData) {
    //                 $materials[] = new DprMaterialsResources($materialData);
    //             }
    //         }
    //     }
    //     $message = 'Fetch Materials List Successfully';
    //     return response()->json(['success' => true, 'status' => 200, 'message' => $message, 'data' => $materials]);
    // }
}
