<?php

namespace App\Http\Controllers\API\inventory;

use App\Http\Controllers\BaseController;
use App\Http\Resources\API\Inventory\inventor\InventoryResources;
use App\Models\Company\InwardGoods;
use App\Models\Inventory;
use App\Models\InvIssueGood;
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
    public function index(Request $request)
    {
    }
    public function add(Request $request)
    {
    }
    public function edit(Request $request)
    {
    }
    public function generatePDF(Request $request)
    {
        $type = $request->type;
        // $requestId = 2;
        // $authCompany = 1;
        $requestId = $request->requestId;
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $pageLoc = '';
        $name = '';
        switch ($type) {
            case 'material_request':
                $datas = MaterialRequest::with(['materialRequestDetails'])
                    ->where('id', $requestId)
                    ->where('company_id', $authCompany)
                    ->first();
                // $datas = MaterialRequestDetails::with(['materialrequests'])->where('material_requests_id', $requestId)
                //     ->where('company_id', $authCompany)
                //     ->get();
                $pageLoc = 'common.pdf.material-request';
                $name = 'material_request_' . date('YmdHis');
                // dd($datas->materialrequests->projects->project_name);
                break;
            case 'inward':
                $datas = InwardGoods::select('id', 'grn_no as request_id', 'date')
                    ->where('inv_inwards_id', $requestId)
                    ->where('company_id', $authCompany)
                    ->first();
                $pageLoc = 'common.pdf.inward';
                $name = 'inward_' . date('YmdHis');
                break;
            case 'issue':
                $datas = InvIssueGood::select('id', 'issue_no as request_id', 'date')
                    ->where('inv_issues_id', $requestId)
                    ->where('company_id', $authCompany)
                    ->first();
                $pageLoc = 'common.pdf.issue';
                $name = 'issue_' . date('YmdHis');
                break;
            case 'return':
                $datas = InvReturnGood::select('id', 'return_no as request_id', 'date')
                    ->where('inv_returns_id', $requestId)
                    ->where('company_id', $authCompany)
                    ->first();
                $pageLoc = 'common.pdf.return';
                $name = 'return_' . date('YmdHis');
                break;
        }
        // dd($datas);
        // $data = new InventoryResources($datas);
        if (!$datas) {
            return response()->json([
                'error' => 'Data Not Found',
            ], 404);
        }
        // dd($pageLoc, $datas, $name);
        $pdfUrl = generatePdf($pageLoc, compact('datas'), $name . '.pdf');

        // dd($pdfUrl);

        // Return JSON response with success message and PDF URL
        return response()->json([
            'name' => $name,
            'data' => $datas,
            'message' => 'PDF generated successfully',
            'pdf_url' =>  $pdfUrl
        ], 200);
    }
}
