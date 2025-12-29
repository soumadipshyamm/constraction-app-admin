<?php

namespace App\Http\Controllers\API\inventory;

use App\Http\Controllers\BaseController;
use App\Http\Resources\API\Inventory\inventor\InventoryResources;
use App\Http\Resources\API\Materials\MaterialsResources;
use App\Http\Resources\AssetsResource;
use App\Models\Company\Assets;
use App\Models\Company\InwardGoods;
use App\Models\Company\Materials;
use App\Models\Company\Quote;
use App\Models\Inventory;
use App\Models\InvInward;
use App\Models\InvIssue;
use App\Models\InvIssueGood;
use App\Models\InvReturn;
use App\Models\InvReturnGood;
use App\Models\MaterialRequest;
use App\Models\MaterialRequestDetails;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class InventoryController extends BaseController
{
    public function index(Request $request) {}
    // **************************************************************************************
    public function add(Request $request) {}
    // **************************************************************************************
    public function edit(Request $request) {}
    // **************************************************************************************
    public function generatePDF(Request $request)
    {
        $type = $request->type;
        // $requestId = 2;
        // $authCompany = 1;
        $requestId = $request->requestId;
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $pageLoc = '';
        $name = '';
        $fetcDatas = '';
        switch ($type) {
            case 'material_request':
                // $datas = MaterialRequestDetails::with(['materialrequests', 'materials'])->where('material_requests_id', $requestId)
                //     ->where('company_id', $authCompany)
                //     ->get();
                // $fetcDatas = $datas->first();

                $datas = MaterialRequest::with(['materialRequest', 'materialRequest.materials'])->where('id', $requestId)
                    ->where('company_id', $authCompany)
                    ->first();
                // dd($datas);
                $fetcDatas = $datas;
                $pageLoc = 'common.pdf.material-request';
                $name = 'material_request_' . date('YmdHis');
                break;
            case 'inward':
                $datas = InvInward::with('invInwardGood', 'invInwardGood.InvInwardGoodDetails', 'invInwardGood.InvInwardGoodDetails.assets', 'invInwardGood.InvInwardGoodDetails.materials', 'invInwardGood.vendores', 'invInwardGood.invInwardEntryTypes', 'InvInwardStore')
                    ->where('id', $requestId)
                    ->where('company_id', $authCompany)->first();
                // dd($datas);
                $fetcDatas = $datas;
                $pageLoc = 'common.pdf.inward';
                $name = 'inward_' . date('YmdHis');
                break;
            case 'issue':
                $datas = InvIssue::with('InvIssueStore', 'invIssueGoods.invIssueDetails', 'invIssueGoods.invIssueList', 'invIssueGoods.invIssueDetails.assets', 'invIssueGoods.invIssueDetails.materials')
                    ->where('id', $requestId)
                    ->where('company_id', $authCompany)->first();
                $fetcDatas = $datas;
                // dd($datas);
                $pageLoc = 'common.pdf.issue';
                $name = 'issue_' . date('YmdHis');
                break;
            case 'return':
                $datas = InvReturn::with('InvReturnStore', 'invReturnsGoods.invIssueList', 'invReturnsGoods.invReturnDetails.assets', 'invReturnsGoods.invReturnDetails.materials')
                    ->where('id', $requestId)
                    ->where('company_id', $authCompany)
                    ->first();
                // dd($datas);
                $fetcDatas = $datas;
                $pageLoc = 'common.pdf.return';
                $name = 'return_' . date('YmdHis');
                break;
            case 'quotes':
                $datas = Quote::with('quotesdetails.materialsRequestDetails.materialrequests')
                    ->where('id', $requestId)
                    ->where('company_id', $authCompany)
                    ->first();
                    $datas->type=$datas->quotesdetails[0]->type;
                // dd($datas);
                $fetcDatas = $datas;
                $pageLoc = 'common.pdf.quote';
                $name = 'quotes_' . date('YmdHis');
                break;
        }
        if (!$datas) {
            return response()->json([
                'error' => 'Data Not Found',
            ], 404);
        }
        $pdfUrl = generatePdf($pageLoc, compact('datas'), $name . '.pdf');
        // Return JSON response with success message and PDF URL
        return response()->json([
            'name' => $name,
            'data' => $fetcDatas,
            'message' => 'PDF generated successfully',
            'pdf_url' =>  $pdfUrl
        ], 200);
    }
    // **************************************************************************************
    function listMaterials(Request $request)
    {
        $authCompany = Auth::guard('company-api')->user()->company_id;

        $materialList = Materials::where('company_id', $authCompany)
            ->whereHas('invInwardGoodDetails', function ($query) {
                $query->whereNotNull('materials_id');
            })
            ->get();
            $filteredMaterials=$materialList->map(function ($material) {
                $totalQty = $material->inventorys->total_qty ?? 0; // Use null coalescing to handle potential null
                $material->total_stk_qty = $totalQty > 0 ? $totalQty : null;
                return $material;
            })->filter(fn($material) => !is_null($material->total_stk_qty));

        $message = 'Fetch Materials List Successfully';

        return $this->responseJson(true, 200, $message, $filteredMaterials);
    }
    // **************************************************************************************
    function listMachine(Request $request)
    {
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $materialList = Assets::where('company_id', $authCompany)
            ->whereHas('invInwardGoodDetails', function ($quer) {
                $quer->whereNotNull('assets_id');
            })->get();
            $filteredMachines = $materialList->map(function ($machine) {
                $totalQty =  $machine->inventory->total_qty ?? 0; // Use null coalescing to handle potential null
                $machine->total_stk_qty = $totalQty > 0 ? $totalQty : null;
                return $machine;
            })->filter(fn($machine) => !is_null($machine->total_stk_qty));

        $message =  'Fetch Machine List Successfully';
        return $this->responseJson(true, 200, $message,  $filteredMachines);
    }
    // **************************************************************************************

    function issuelistMaterials(Request $request)
{
    $authCompany = Auth::guard('company-api')->user()->company_id;

    $materials = Materials::where('company_id', $authCompany)
        ->whereHas('invIssuesDetails', fn($query) => $query->whereNotNull('materials_id'))
        ->with('inventorys') // Eager load to reduce queries
        ->get();

    $filteredMaterials = $materials->map(function ($material) {
        $totalQty = $material->inventorys->total_qty ?? 0;
        $material->total_stk_qty = $totalQty > 0 ? $totalQty : null;
        return $material;
    })->filter(fn($material) => !is_null($material->total_stk_qty));

    return $this->responseJson(true, 200, 'Fetch Materials List Successfully', $filteredMaterials);
}

function issuelistMachine(Request $request)
{
    $authCompany = Auth::guard('company-api')->user()->company_id;

    $machines = Assets::where('company_id', $authCompany)
        ->whereHas('invIssuesDetails', fn($query) => $query->whereNotNull('assets_id'))
        ->with('inventory') // Eager load to reduce queries
        ->get();

    $filteredMachines = $machines->map(function ($machine) {
        $totalQty = $machine->inventory->total_qty ?? 0;
        $machine->total_stk_qty = $totalQty > 0 ? $totalQty : null;
        return $machine;
    })->filter(fn($machine) => !is_null($machine->total_stk_qty));

    return $this->responseJson(true, 200, 'Fetch Machine List Successfully', $filteredMachines);
}

}