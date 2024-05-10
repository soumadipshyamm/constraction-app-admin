<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\API\Dpr;
use App\Models\Company\Activities;
use App\Models\Company\LabourHistory;
use App\Models\InvReturnGood;
use App\Models\MaterialRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function reportGenerate(Request $request)
    {
        // dd($request->all());
        $type = $request->type;
        $projectId = $request->projectId;
        $subProjectId = $request->subProjectId;
        $fromDate = $request->dateForm;
        $toDate = $request->dateTo;
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $pageLoc = '';
        $name = '';
        switch ($type) {
            case 'pr':
                $indentNo = $request->indentNo;
                $preparedBy = $request->preparedBy;
                $datas = MaterialRequest::with(['materialRequestDetails']);

                if ($request->has('projectId')) {
                    $datas->Where('projects_id',  $request->projectId);
                }
                if ($request->has('subProjectId')) {
                    $datas->Where('sub_projects_id',  $request->subProjectId);
                }
                if ($request->has('projectId') || $request->has('subProjectId')) {
                    $datas = $datas->where(function ($q) use ($request) {
                        $q->Where('projects_id',  $request->projectId);
                        $q->Where('sub_projects_id',  $request->subProjectId);
                    });
                }

                $datas->where('company_id', $authCompany);
                $datas->when($indentNo, function ($q) use ($indentNo) {
                    return $q->where('request_id',  $indentNo);
                });
                // $datas->when($fromDate, function ($q) use ($fromDate) {
                //     return $q->whereDate('date', '>=', $fromDate);
                // });
                $datas->when($fromDate, function ($q) use ($fromDate) {
                    return $q->whereDate('date', '>=', $fromDate);
                });
                $datas->when($toDate, function ($q) use ($toDate) {
                    return $q->whereDate('date', '<=', $toDate);
                });

                $datas = $datas->first();
                $pageLoc = 'common.report.pr';
                $name = 'purches_request_' . date('YmdHis');
                break;

            case 'work-details':
                $datas = Activities::with('units', 'project', 'subproject', 'childrenActivites', 'parentActivites')
                    ->where('company_id', $authCompany);

                if ($request->has('projectId')) {
                    $datas->Where('project_id',  $request->projectId);
                }

                if ($request->has('subProjectId')) {
                    $datas->Where('subproject_id',  $request->subProjectId);
                }

                if ($request->has('projectId') || $request->has('subProjectId')) {
                    $datas = $datas->where(function ($q) use ($request) {
                        $q->Where('project_id',  $request->projectId);
                        $q->Where('subproject_id',  $request->subProjectId);
                    });
                }
                $datas->when($fromDate, function ($q) use ($fromDate) {
                    return $q->whereDate('start_date', '>=', $fromDate);
                });

                $datas->when($toDate, function ($q) use ($toDate) {
                    return $q->whereDate('end_date', '<=', $toDate);
                });
                $datas = $datas->first();
                $pageLoc = 'common.report.workdetails';
                $name = 'workdetails' . date('YmdHis');
                break;

            case 'dprs':
                $userId = $request->userId;
                $date = $request->date;
                $datas = Dpr::with('assets', 'activities', 'labour', 'material', 'historie', 'safetie')
                    ->where('projects_id', $projectId)
                    ->whereDate('date',  $date)
                    ->where('company_id', $authCompany)
                    ->when($userId, function ($q) use ($userId) {
                        return $q->where('user_id',  $userId);
                    })
                    ->get();
                $pageLoc = 'common.report.dpr';
                $name = 'dprs' . date('YmdHis');
                break;


            case 'labour-contractor':
                $datas = $this->labourcontractor($request);
                $pageLoc = 'common.report.labour-contractor';
                $name = 'labourcontractor_' . date('YmdHis');
                break;

            case 'work-contractor':
                $datas = $this->workcontractor($request);
                $pageLoc = 'common.report.work-contractor';
                $name = 'workcontractor_' . date('YmdHis');
                break;

            case 'rfq':
                $datas = $this->rfq($request);
                $pageLoc = 'common.report.quote';
                $name = 'rfq_' . date('YmdHis');
                break;

            case 'stock-tatement':
                $datas = $this->stockstatement($request);
                $pageLoc = 'common.report.stock-statement';
                $name = 'stockstatement_' . date('YmdHis');
                break;

            case 'issue-return':
                $datas = $this->issuereturn($request);
                $pageLoc = 'common.report.issue-return';
                $name = 'issuereturn_' . date('YmdHis');
                break;

            case 'issue-details':
                $datas = $this->issuedetails($request);
                $pageLoc = 'common.report.issue-details';
                $name = 'issuedetails_' . date('YmdHis');
                break;

            case 'issue-slip':
                $datas = $this->issueslip($request);
                $pageLoc = 'common.report.issue-slip';
                $name = 'issueslip_' . date('YmdHis');
                break;

            case 'grn-slip':
                $datas = $this->grnslip($request);
                $pageLoc = 'common.report.grn-slip';
                $name = 'grnslip_' . date('YmdHis');
                break;
        }
        if (!$datas) {
            return response()->json([
                'error' => 'Data Not Found',
            ], 404);
        }
        $pdfUrl = generatePdf($pageLoc, compact('datas'), $name . '.pdf');
        return response()->json([
            'name' => $name,
            'data' => $datas,
            'message' => 'PDF generated successfully',
            'pdf_url' =>  $pdfUrl
        ], 200);
        // }
    }

    function labourcontractor($request)
    {

        $labourContractorId = $request->labourContractor;
        $authCompany = Auth::guard('company-api')->user()->company_id;
        // $datas = [];

        $fetchData = LabourHistory::with(['labours', 'dpr'])
            ->where('company_id', $authCompany)
            ->whereHas('dpr', function ($query) use ($request) {
                $query->where('projects_id', $request->projectId);
            })
            ->whereHas('dpr', function ($q) use ($request) {
                $q->where('sub_projects_id', $request->subProjectId);
            })
            ->whereHas('dpr', function ($q) use ($request) {
                $q->whereNotNull('name');
                $q->where('name', '>=', $request->dateForm)
                    ->where('name', '<=', $request->dateTo);
            })
            ->get();
        // dd($fetchData->toArray());
        $datas = $fetchData;
        return $datas;
    }

    function workcontractor($request)
    {
        $labourContractorId = $request->labourContractor;
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $datas = Dpr::with('labour')->where('company_id', $authCompany)->where('projects_id',  $request->projectId)->orWhere('sub_projects_id',  $request->subProjectId)->first();
        return $datas;
    }
    function rfq($request)
    {
        $projectId = $request->projectId;
        $subProjectId = $request->subProjectId;
        $dateForm = $request->dateForm;
        $dateTo = $request->dateTo;
        $prepared = $request->prepared;
        $rfqno = $request->rfqno;
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $datas = Dpr::with('labour')->where('company_id', $authCompany)->where('projects_id',  $request->projectId)->orWhere('sub_projects_id',  $request->subProjectId)->first();
        return $datas;
    }
    function stockstatement($request)
    {
        $labourContractorId = $request->labourContractor;
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $datas = Dpr::with('labour')->where('company_id', $authCompany)->where('projects_id',  $request->projectId)->orWhere('sub_projects_id',  $request->subProjectId)->first();
        return $datas;
    }

    function issuereturn($request)
    {
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $datas = InvReturnGood::with(['invReturn.InvReturnStore'])
            ->where('company_id', $authCompany)
            ->whereHas('invReturn', function ($query) use ($request) {
                $query->where('projects_id', $request->projectId)
                    ->whereHas('InvReturnStore', function ($q) use ($request) {
                        $q->where('store_warehouses_id', $request->storeWarehousesId);
                    });
            })
            ->get();
        return $datas;
    }

    function issuedetails($request)
    {
        // dd($request->toArray());
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $datas = InvReturnGood::with(['invReturn.InvReturnStore'])
            ->where('company_id', $authCompany)
            ->whereHas('invReturn', function ($query) use ($request) {
                $query->where('projects_id', $request->projectId)
                    ->whereHas('InvReturnStore', function ($q) use ($request) {
                        $q->where('store_warehouses_id', $request->storeWarehousesId);
                    });
            })
            ->get();
        return $datas;
    }

    function issueslip($request)
    {
        // dd($request->toArray());
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $datas = InvReturnGood::with(['invReturn.InvReturnStore'])
            ->where('company_id', $authCompany)
            ->whereHas('invReturn', function ($query) use ($request) {
                $query->where('projects_id', $request->projectId)
                    ->whereHas('InvReturnStore', function ($q) use ($request) {
                        $q->where('store_warehouses_id', $request->storeWarehousesId);
                    });
            })
            ->get();
        return $datas;
    }

    function grnslip($request)
    {
        // dd($request->toArray());
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $datas = InvReturnGood::with(['invReturn.InvReturnStore'])
            ->where('company_id', $authCompany)
            ->whereHas('invReturn', function ($query) use ($request) {
                $query->where('projects_id', $request->projectId)
                    ->whereHas('InvReturnStore', function ($q) use ($request) {
                        $q->where('store_warehouses_id', $request->storeWarehousesId);
                    });
            })
            ->get();
        return $datas;
    }
}
