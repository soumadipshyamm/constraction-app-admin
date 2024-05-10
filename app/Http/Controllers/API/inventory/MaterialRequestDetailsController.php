<?php

namespace App\Http\Controllers\API\inventory;

use App\Http\Controllers\BaseController;
use App\Http\Resources\API\Inventory\inventor\InventoryResources;
use App\Http\Resources\API\Inventory\MaterialRequest\InvMaterialsRequestResources;
use App\Http\Resources\API\Inventory\MaterialRequest\MaterialRequestResources;
use App\Models\Company\Materials;
use App\Models\Inventory;
use App\Models\MaterialRequest;
use App\Models\MaterialRequestDetails;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class MaterialRequestDetailsController extends BaseController
{
    public function index(Request $request)
    {
        $projectId = $request->projectId;
        $authConpany = Auth::guard('company-api')->user()->company_id;
        $data = MaterialRequestDetails::with('materials', 'projects', 'stores')->where('projects_id', $request->projectId)->get();
        if (isset($data)) {
            return $this->responseJson(
                true,
                200,
                'Fetch Inward Goods Details List Successfullsy',
                MaterialRequestResources::collection($data)
            );
        } else {
            return $this->responseJson(true, 200, 'Inward Goods Details List Data Not Found', []);
        }
    }
    public function add(Request $request)
    {
        // dd($request);
        if (empty($request->all())) {

            return $this->responseJson(false, 422, "Unavailable To Update Data", []);
        }
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $validator = Validator::make($request->all(), [

            '*.material_id' => 'required',
            '*.projects_id' => 'required',
            '*.qty' => 'required',
        ]);
        if ($validator->fails()) {
            $status = false;
            $code = 422;
            $response = [];
            $message = $validator->errors()->first();
            return $this->responseJson($status, $code, $message, $response);
        }
        $datas = $request->all();
        DB::beginTransaction();
        try {
            foreach ($datas as $data) {
                $materials_id = $data['material_id'];
                $activities_id = $data['activities_id'] ?? '';
                $projects_id = $data['projects_id'];
                $sub_projects_id = $data['sub_projects_id'] ?? NULL;
                $qty = $data['qty'];
                $date = $data['date'];
                $remarks = $data['remarks'];
                $material_requests_id = $data['inventoryId'];
                $company_id = $authCompany;

                $updateData = compact(
                    'activities_id',
                    'projects_id',
                    'sub_projects_id',
                    'qty',
                    'date',
                    'remarks',
                    'company_id',
                );
                $criteria = compact('materials_id', 'material_requests_id');
                $result = MaterialRequestDetails::updateOrCreate($criteria, $updateData);
            }
            DB::commit();
            $message = 'Material Request Details Updated Successfully';
            return $this->responseJson(true, 201, $message, $result);
        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage() . 'on' . $e->getFile() . 'in' . $e->getLine());
            return $this->responseJson(false, 500, $e->getMessage(), []);
        }
    }
    public function edit(Request $request)
    {
        $getMaterialsId = $request->get('materials');
        $inventoryId = $request->input('inventoryId');
        $authCompany = Auth::guard('company-api')->user();
        $requestMaterialsData = Materials::with(['materialsRequestDetails' => function ($q) use ($inventoryId) {
            $q->where('material_requests_id', $inventoryId);
        }])->where('company_id', $authCompany->company_id)
            ->whereIn('id', $getMaterialsId)
            ->get();
        // dd($requestMaterialsData->toArray());
        $requestMaterials = InvMaterialsRequestResources::collection($requestMaterialsData);
        $message = 'Fetch Materials List Successfully';
        return response()->json(['success' => true, 'status' => 200, 'message' => $message, 'data' => $requestMaterials]);
    }

    public function generatePDF(Request $request)
    {
        $requestId = $request->requestId;
        // Retrieve authenticated company user
        $authCompany = Auth::guard('company-api')->user();
        // Retrieve DPR data with related models
        $datas = MaterialRequestDetails::where('material_requests_id', $requestId)
            ->where('company_id', $authCompany->company_id)
            ->first();

        $data = new InventoryResources($datas);
        if (!$datas) {
            return response()->json([
                'error' => 'Data Not Found',
            ], 404);
        }
        $pdfUrl = generatePdf('common.pdf.material-request', compact('datas'), 'material-request_' . date('YmdHis') . '.pdf');

        // Return JSON response with success message and PDF URL
        return response()->json([
            'data' => $data,
            'message' => 'PDF generated successfully',
            'pdf_url' =>  $pdfUrl
        ], 200);
    }

    // projects
    // activities
    // materials
    // subprojects
    // stores
    // company
    // users



    // generatePDF


    // projects
    // activities
    // subprojects
    // stores
    //     public function company()

    // users

    // public function edit(Request $request)
    // {
    //     $getMaterialsId = $request->get('materials');
    //     $inventoryId = $request->input('inventoryId');
    //     $authCompany = Auth::guard('company-api')->user();
    //     $materials = [];
    //     foreach ($getMaterialsId as $materialsId) {
    //         $materialRequest = MaterialRequest::where('materials_id', $materialsId)
    //             ->where('inventories_id', $inventoryId)
    //             ->where('company_id', $authCompany->company_id)
    //             ->first();
    //         if ($materialRequest) {
    //             $material = Materials::where('id', $materialsId)
    //                 ->where('company_id', $authCompany->company_id)
    //                 ->first();
    //             // dd($material);
    //             if ($material) {
    //                 $materials[] = new InvMaterialsRequestResources([
    //                     'material' => $material,
    //                     'material_request' => $materialRequest
    //                 ]);
    //             }
    //         } else {
    //             $material = Materials::where('id', $materialsId)
    //                 ->where('company_id', $authCompany->company_id)
    //                 ->first();
    //                 // ->toRawSql();
    //                 // dd($material);
    //             if ($material) {
    //                 $materials[] = new InvMaterialsRequestResources([
    //                     'material' => $material
    //                 ]);
    //             }
    //         }
    //     }
    //     $message = 'Fetch Materials List Successfully';
    //     return response()->json(['success' => true, 'status' => 200, 'message' => $message, 'data' => $materials]);
    // }
    // public function index(Request $request)
    // {
    //     $authConpany = Auth::guard('company-api')->user()->company_id;
    //     $data = MaterialOpeningStock::with('materials', 'units', 'projects', 'stores')
    //         ->where('project_id', $request->projectId)
    //         ->orWhere('store_id', $request->storeId)
    //         ->get();
    //     if (isset($data)) {
    //         return $this->responseJson(true, 200, 'Fetch Inward Goods Details List Successfullsy', OpeningStockResource::collection($data));
    //     } else {
    //         return $this->responseJson(true, 200, 'Inward Goods Details List Data Not Found', []);
    //     }
    // }
    // public function add(Request $request)
    // {
    //     // dd($request->all());
    //     $authCompany = Auth::guard('company-api')->user()->company_id;
    //     $validator = Validator::make($request->all(), [
    //         '*.materialopening_id' => 'required',
    //         // '*.activities_id' => 'required',
    //         '*.projects_id' => 'required',
    //         // '*.sub_projects_id' => 'required',
    //         '*.qty' => 'required',
    //     ]);
    //     if ($validator->fails()) {
    //         $status = false;
    //         $code = 422;
    //         $response = [];
    //         $message = $validator->errors()->first();
    //         return $this->responseJson($status, $code, $message, $response);
    //     }
    //     $datas = $request->all();
    //     // dd( $datas);
    //     DB::beginTransaction();
    //     try {
    //         foreach ($datas as $data) {
    //             $materialopening_id = $data['materialopening_id'];
    //             $activities_id = $data['activities_id'];
    //             $projects_id = $data['projects_id'];
    //             $sub_projects_id = $data['sub_projects_id'];
    //             $qty = $data['qty'];
    //             $remarks = $data['remarks'];
    //             $inventories_id = $data['inventoryId'];
    //             $company_id = $authCompany;
    //             $updateData = compact(
    //                 'activities_id',
    //                 'projects_id',
    //                 'sub_projects_id',
    //                 'qty',
    //                 'remarks',
    //                 'company_id',
    //             );
    //             $criteria = compact('materialopening_id', 'inventories_id');
    //             // Update or create the record
    //             $result = MaterialRequest::updateOrCreate($criteria, $updateData);
    //         }
    //         DB::commit();
    //         $message = 'Material Request Details Updated Successfully';
    //         return $this->responseJson(true, 201, $message, $result);
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         logger($e->getMessage() . 'on' . $e->getFile() . 'in' . $e->getLine());
    //         return $this->responseJson(false, 500, $e->getMessage(), []);
    //     }
    // }
}
