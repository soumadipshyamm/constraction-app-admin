<?php

namespace App\Http\Controllers\API\inventory;

use App\Http\Controllers\BaseController;
use App\Http\Resources\API\Inventory\inventor\InventoryResources;
use App\Http\Resources\API\Inventory\MaterialRequest\InvMaterialsRequestResources;
use App\Http\Resources\API\Inventory\MaterialRequest\MaterialRequestDetailsResources;
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
        $searchkey = $request->searchkey;
        $projectId = $request->projectId;

        $authCompany = Auth::guard('company-api')->user()->company_id;
        // Build the initial query
        $query = MaterialRequestDetails::with('materials', 'projects', 'stores')
            ->where('projects_id', $projectId)->where('company_id', $authCompany);
        // Apply search filters if searchkey is provided
        if (!empty($searchkey)) {
            $query->whereHas('materials', function ($q) use ($searchkey) {
                $q->where('name', 'like', '%' . $searchkey . '%')
                    ->orWhere('code', 'like', '%' . $searchkey . '%');
            });
        }
        // Get the filtered or unfiltered data
        $data = $query->orderBy('id', 'desc')->get();
        // dd($data->toArray());
        if ($data->isNotEmpty()) {
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
        log_daily(
            'MaterialRequestDetailsController',
            'Adding or updating material request details',
            'add',
            'info',
            json_encode($request->all()),
        );
        if (empty($request->all())) {
            return $this->responseJson(false, 422, "Unavailable To Update Data", []);
        }
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $validator = Validator::make($request->all(), [
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
        // dd($datas);
        ckeckPrApprovandmemberAllocation($datas[0]['projects_id'], $datas[0]['inventoryId']);

        DB::beginTransaction();
        try {
            foreach ($datas as $data) {

                $materials_id = $data['material_id'] ?? NULL;
                $activities_id = $data['activities_id'] ?? NULL;
                $projects_id = $data['projects_id'] ?? NULL;
                $sub_projects_id = $data['sub_projects_id'] ?? NULL;
                $qty = $data['qty'];
                $date = $data['date'] ?? NULL;
                $remarks = $data['remarks'] ?? NULL;
                $material_requests_id = $data['inventoryId'] ?? NULL;
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
            log_daily(
                'MaterialRequestDetailsController',
                'Adding or updating material request details after save',
                'add',
                'info',
                json_encode($result),
            );
            DB::commit();
            $message = 'Material Request Details Updated Successfully';
            // return $this->responseJson(true, 201, $message, new MaterialRequestDetailsResources($result));
            return $this->responseJson(true, 201, $message, $result);
        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage() . 'on' . $e->getFile() . 'in' . $e->getLine());
            return $this->responseJson(false, 500, $e->getMessage(), []);
        }
    }

    // ****************************************************************************************
    // public function edit(Request $request)
    // {
    //     $getMaterialsId = $request->get('materials');
    //     $inventoryId = $request->input('inventoryId');
    //     $authCompany = Auth::guard('company-api')->user()->company_id;
    //     $requestMaterialsData = Materials::whereIn('id', $getMaterialsId)->whereHas('materialsRequestDetails', function ($q) use ($inventoryId, $authCompany) {
    //         $q->where('material_requests_id', $inventoryId)
    //             ->where('company_id', $authCompany);
    //     });
    //     $requestMaterialsData = $requestMaterialsData->get();
    //     // $requestMaterialsData = $requestMaterialsData->map(function ($item) use ($inventoryId) {
    //     //     $item->material_requests_id = $inventoryId; // Add the material_requests_id to each item
    //     //     return $item; // Return the modified item
    //     // });

    //     dd($requestMaterialsData);
    //     $requestMaterials = InvMaterialsRequestResources::collection($requestMaterialsData);
    //     return response()->json(['success' => true, 'status' => 200, 'message' => 'Fetch Materials List Successfully', 'data' => $requestMaterials]);
    // }
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

        // $requestMaterials = InvMaterialsRequestResources::collection($requestMaterialsData);

        $item =  $requestMaterialsData->each(function ($item) use ($inventoryId) {
            $item->material_request_id = $inventoryId;;
            //     // dd($item->materialsRequestDetails);
            //     $item->materialsRequestDetails = $item->materialsRequestDetails->filter(function ($detail) use ($inventoryId) {
            //         dd($inventoryId);
            //         return $detail->material_request_id = $inventoryId;
            //     });
            //     // return $detail->inv_issue_goods_id = $isActivityCreated->id;
        });
        // dd($item->toArray());
        // dd($requestMaterialsData->toArray());

        $requestMaterials = InvMaterialsRequestResources::collection($item);
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
}
