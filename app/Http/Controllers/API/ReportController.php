<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\API\Dpr;
use App\Models\Company\Activities;
use App\Models\Company\ActivityHistory;
use App\Models\Company\InwardGoods;
use App\Models\Company\InwardGoodsDetails;
use App\Models\Company\LabourHistory;
use App\Models\Company\Quote;
use App\Models\Inventory;
use App\Models\InvInward;
use App\Models\InvIssueGood;
use App\Models\InvIssuesDetails;
use App\Models\InvReturn;
use App\Models\InvReturnGood;
use App\Models\InvReturnsDetails;
use App\Models\InwardStore;
use App\Models\MaterialRequest;
use App\Models\QuotesDetails;
use Faker\Provider\Base;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class ReportController extends BaseController
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
        $datas = '';

        log_daily('invReportGenerate', 'reportGenerate', 'reportGenerate', 'info', json_encode([
            'all' => $request->all(),
            'authCompany' => $authCompany,
            'type' => $type,
            'projects_id' => $projectId,
            'sub_projects_id' => $subProjectId,
            'dateForm' => $fromDate,
            'dateTo' => $toDate,
        ]));
        switch ($type) {
            case 'pr':
                $indentNo = $request->indentNo;
                $preparedBy = $request->preparedBy;
                $datas = MaterialRequest::with(['materialRequestDetails', 'materialRequest']);

                if ($request->has('projectId')) {
                    $datas->Where('projects_id',  $request->projectId);
                }
                if ($request->has('subProjectId')) {
                    $datas->Where('sub_projects_id',  $request->subProjectId);
                }

                $datas->where('company_id', $authCompany);
                $datas->when($indentNo, function ($q) use ($indentNo) {
                    return $q->where('request_id',  $indentNo);
                });

                $datas->when($fromDate, function ($q) use ($fromDate) {
                    return $q->whereDate('date', '>=', $fromDate);
                });
                $datas->when($toDate, function ($q) use ($toDate) {
                    return $q->whereDate('date', '<=', $toDate);
                });
                $datas = $datas->get();
                // $datas = $datas->first();
                // dd($datas);
                $pageLoc = 'common.report.pr';
                $name = 'purches_request_' . date('YmdHis');
                break;

            case 'work-details':
                $activites = [];
                $headerDetails = [];
                $result = Activities::with('units', 'project', 'subproject', 'activitiesHistory')
                    ->where('company_id', $authCompany)
                    ->where(function ($query) {
                        $query->whereNotNull('project_id')->orWhereNotNull('subproject_id');
                    })
                    ->where(function ($query) use ($projectId, $subProjectId) {
                        $query->where('project_id', $projectId)
                            ->orWhere('subproject_id', $subProjectId);
                    })
                    ->whereHas('activitiesHistory', function ($q) use ($request) {
                        $q->whereHas('dpr', function ($qq) use ($request) {
                            $qq->where('projects_id', $request->projectId)
                                ->Where('sub_projects_id', $request->subProjectId)
                                ->whereBetween('date', [$request->dateForm, $request->dateTo]);
                        });
                    })
                    ->get();

                $result->each(function ($activity) {
                    $totalQty = $activity->activitiesHistory->sum('qty');
                    $activity['totalQtyInHistory'] = $totalQty;
                });
                $headerDetails = [
                    'projectId' => $result->first()?->project?->project_name ?? '',
                    'subProjectId' => $result->first()?->subproject?->project_name ?? '',
                    'fromDate' => $fromDate ?? '',
                    'toDate' => $toDate ?? '',
                    'logo' => $result->first()?->project?->logo ?? ''
                ];
                foreach ($result as $key => $val) {
                    // dd($val);
                    $activites[$key]['sl_no'] = $key + 1;
                    $activites[$key]['activities'] = $val->activities;
                    $activites[$key]['unit'] = $val?->units?->unit ?? '';
                    $activites[$key]['est_qty'] = $val?->qty ?? '';
                    $activites[$key]['est_rate'] = $val?->rate ?? '';
                    $activites[$key]['est_amount'] = ($val?->qty * $val?->rate) ?? '';
                    $activites[$key]['completed_qty'] = $val?->totalQtyInHistory ?? '';
                    $activites[$key]['est_amount_completion'] = ($val?->totalQtyInHistory * $val?->rate) ?? '';
                    $activites[$key]['completion'] = round(
                        (int)$val->qty !== 0 && (int)$val->totalQtyInHistory !== 0
                            ? ((int)$val->totalQtyInHistory / (int)$val->qty) * 100
                            : 0
                    );
                    $activites[$key]['balance_qty'] = $val?->totalQtyInHistory ? abs((int)$val?->qty - $val?->totalQtyInHistory) : 0;
                }
                $datas = compact('activites', 'headerDetails');
                // dd($datas);
                $pageLoc = 'common.pdf.workdetails';
                $name = 'workdetails' . date('YmdHis');
                break;

            case 'dprs':
                // dd($request->all());
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

                // dd($datas->toArray());
                $pageLoc = 'common.report.dpr';
                // $pageLoc = 'common.pdf.dprs';
                $name = 'dprs' . date('YmdHis');
                // dd($pageLoc);
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

            case 'stock-statement':
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
                // dd($request);
                $datas = $this->issueslip($request);
                // dd($datas);
                $pageLoc = 'common.report.issue-slip';
                $name = 'issueslip_' . date('YmdHis');
                break;

            case 'grn-slip':
                $datas = $this->grnslip($request);
                $pageLoc = 'common.pdf.grn-slip';
                $name = 'grnslip_' . date('YmdHis');
                break;

            case 'in_progress':
                $datas = $this->inProgess($request);
                $pageLoc = 'common.pdf.in_progress';
                $name = 'in_progress_' . date('YmdHis');
                break;
            case 'work_complete':
                $datas = $this->workComplete($request);
                $pageLoc = 'common.pdf.work_complete';
                $name = 'work_complete_' . date('YmdHis');
                break;
            case 'not_stated':
                $datas = $this->notStatus($request);
                $pageLoc = 'common.pdf.not_stated';
                $name = 'not_stated_' . date('YmdHis');
                break;
        }
        // dd($datas);
        if (isset($datas)) {
            //     return response()->json([
            //         'message' => 'Data Not Found',
            //     ], 200);
            //     // return response()->json([
            //     //     'error' => 'Data Not Found',
            //     // ], 404);
            // }

            $pdfUrl = generatePdf($pageLoc, compact('datas'), $name . '.pdf');
            log_daily('invReportGenerate', 'after reportGenerate result--', 'reportGenerate', 'info', json_encode([
                'pageLoc' => $pageLoc,
                'datas' => $datas,
                'pdfUrl' => $pdfUrl
            ]));
            return response()->json([
                'name' => $name,
                'data' => $datas,
                'message' => 'PDF generated successfully',
                'pdf_url' =>  $pdfUrl
            ], 200);
        } else {
            return response()->json([
                'message' => 'Data Not Found',
            ], 200);
        }
    }

    // function labourcontractor($request)
    // {
    //     $labourContractorId = $request->labourContractor;
    //     $authCompany = Auth::guard('company-api')->user()->company_id;
    //     $topHeadDetails = [];
    //     $vessd = [];
    //     $fetchData = LabourHistory::with(['labours', 'dpr'])
    //         ->where('company_id', $authCompany)
    //         ->whereHas('dpr', function ($query) use ($request) {
    //             $query->where('projects_id', $request->projectId);
    //         })
    //         ->whereHas('dpr', function ($q) use ($request) {
    //             $q->where('sub_projects_id', $request->subProjectId);
    //         })
    //         ->whereHas('dpr', function ($q) use ($request) {
    //             $q->whereNotNull('name');
    //             $q->where('name', '>=', $request->dateForm)
    //                 ->where('name', '<=', $request->dateTo);
    //         })
    //         ->orderBy('vendors_id', 'asc')
    //         ->get();

    //     foreach ($fetchData as $jhgf) {
    //         $exists = in_array($jhgf->vendors_id, $vessd);
    //         if ($exists == false) {
    //             $vessd[] = $jhgf->vendors_id;
    //         }
    //     }

    //     $topHeadDetails['project'] = $fetchData->first()->dpr->projects->project_name;
    //     $topHeadDetails['subproject'] = $fetchData->first()->dpr->subProjects->name;
    //     $topHeadDetails['dateform'] = $request->dateForm;
    //     $topHeadDetails['dateto'] = $request->dateTo;
    //     $datas = compact('fetchData', 'vessd', 'topHeadDetails');
    //     return $datas;
    // }


    function labourcontractor($request)
    {
        $authCompany = Auth::guard('company-api')->user()->company_id;

        $query = LabourHistory::with(['labours', 'dpr'])
            ->where('company_id', $authCompany)
            ->whereHas('dpr', function ($query) use ($request) {
                $query->where('projects_id', $request->projectId)
                    ->where('sub_projects_id', $request->subProjectId)
                    ->whereNotNull('name')
                    ->whereBetween('name', [$request->dateForm, $request->dateTo]);
            })
            ->orderBy('vendors_id', 'asc');

        $fetchData = $query->get();

        $vessd = $fetchData->whereNotNull('vendors_id')->pluck('vendors_id')->unique()->toArray();
        $topHeadDetails = [
            'project' => $fetchData->first()?->dpr->projects->project_name,
            'subproject' => $fetchData->first()?->dpr->subProjects->name,
            'dateform' => $request->dateForm,
            'dateto' => $request->dateTo,
        ];

        $datas = compact('fetchData', 'vessd', 'topHeadDetails');
        // dd($datas);
        return $datas;
    }

    function workcontractor($request)
    {
        $labourContractorId = $request->labourContractor;
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $topHeadDetails =
            $vessd = [];
        // Build the query
        $fetchData = ActivityHistory::with(['activities', 'dpr'])
            ->whereNotNull('vendors_id')
            ->where('company_id', $authCompany)
            ->where(function ($query) use ($request) {
                $query->whereHas('dpr', function ($q) use ($request) {
                    $q->where('projects_id', $request->projectId);
                })
                    ->orWhereHas('dpr', function ($q) use ($request) {
                        $q->where('sub_projects_id', $request->subProjectId);
                    })
                    ->orWhereHas('dpr', function ($q) use ($request) {
                        $q->whereNotNull('date')
                            ->where('date', '>=', $request->dateForm)
                            ->where('date', '<=', $request->dateTo);
                    });
            })
            ->orderBy('vendors_id', 'asc')
            ->get();
        $activityDetails = [];
        foreach ($fetchData as $item) {
            $vendorId = $item->vendors_id;
            if (!isset($activityDetails[$vendorId])) {
                $activityDetails[$vendorId] = [
                    'activities' => [],
                    'total' => 0,
                ];
            }
            $activityDetails[$vendorId]['vendorId'] = $vendorId; // Store vendor ID
            $activityDetails[$vendorId]['activities'][] = $item;
            $activityDetails[$vendorId]['total'] += $item->amount; // Assuming there's an 'amount' field to sum
        }
        // Collect unique vendor IDs
        foreach ($fetchData as $item) {
            if ($item->vendors_id !== null && !in_array($item->vendors_id, $vessd)) {
                $vessd[] = $item->vendors_id;
            }
        }
        // Populate topHeadDetails
        $topHeadDetails['project'] = $fetchData->first()?->dpr?->projects?->project_name ?? null;
        $topHeadDetails['subproject'] = $fetchData->first()?->dpr?->subProjects?->name ?? null;
        $topHeadDetails['dateform'] = $request->dateForm;
        $topHeadDetails['dateto'] = $request->dateTo;
        // Prepare the final data array
        $datas = compact('fetchData', 'vessd', 'topHeadDetails', 'activityDetails');
        return $datas; // Ensure to return the data

    }


    function rfq($request)
    {
        // dd($request);
        $topHeadDetails = [];
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $fetchData = Quote::with(['quotesdetails'])
            ->where('company_id', $authCompany)
            ->where('projects_id', $request->projectId)
            ->where('user_id', $request->prepared)
            // ->orWhere('sub_projects_id', $request->subProjectId)
            ->where('date', '>=', $request->dateForm)->where('date', '<=', $request->dateTo);
        if ($request->rfqno) {
            $fetchData = $fetchData->where('request_no', $request->rfqno);
        }
        $fetchData = $fetchData->get();

        // $fetchData = Quote::where('company_id', $authCompany);
        // $fetchData = $fetchData->get();
        // dd($fetchData);
        $topHeadDetails['project'] = $fetchData?->first()->projects?->project_name ?? '';
        $topHeadDetails['user'] = $fetchData?->first()->users?->name ?? '';
        $topHeadDetails['request_no'] = $fetchData?->first()->request_no ?? '';
        $topHeadDetails['dateform'] = $request?->dateForm ?? '';
        $topHeadDetails['dateto'] = $request?->dateTo ?? '';
        $datas = compact('fetchData', 'topHeadDetails');
        // dd($datas);
        if ($fetchData->count() > 0 && !empty($topHeadDetails)) {
            return $datas;
        }
        // return $datas;
    }



    // function stockstatement($request)
    // {
    //     $labourContractorId = $request->labourContractor;
    //     $authCompany = Auth::guard('company-api')->user()->company_id;
    //     $type = $request->product_type == 'material' ? 'materials' : 'machines';

    //     $datas = Inventory::where('company_id', $authCompany)
    //         ->where('type', $type)
    //         ->where(function ($q) use ($request) {
    //         $q->where('projects_id', $request->projectId)
    //             ->orWhereHas('inventoryStore', function ($q) use ($request) {
    //                 $q->where('store_warehouses_id', $request->storeId);
    //             });
    //         })->get();

    //     // dd($datas);
    //     // dd($datas->toArray());
    //     // filter data and calculate total issue quantity
    //     $filteredData = $datas->map(function ($item) use ($request) {
    //         // dd($item);
    //         $findItems = InvIssuesDetails::where('type', $item->type)
    //             ->where($item->type == 'machines' ? 'assets_id' : 'materials_id', $item->{$item->type == 'machines' ? 'assets_id' : 'materials_id'})
    //             ->whereHas('InvIssueGood.invIssue', function ($q) use ($request) {
    //                 $q->where('projects_id', $request->projectId)
    //                     ->orWhereHas('InvIssueStore', function ($q) use ($request) {
    //                         $q->where('store_warehouses_id', $request->storeId);
    //                     });
    //             })->first();
    //         // dd($findItems);
    //         //sum of issue quantity
    //         $item->total_issue_qty = $findItems?->issue_qty ?? 0;
    //         return $item;
    //     })->pluck('total_issue_qty')->sum();

    //     // dd()
    //     $filteredDatareciptd = $datas->map(function ($item) use ($request) {
    //         // dd($item);
    //         $findItems = InwardGoodsDetails::where('type', $item->type)
    //             ->where($item->type == 'machines' ? 'assets_id' : 'materials_id', $item->{$item->type == 'machines' ? 'assets_id' : 'materials_id'})
    //             ->whereHas('InvInwardGood.InvInward', function ($q) use ($request) {
    //                 $q->where('projects_id', $request->projectId)
    //                     ->orWhereHas('InvInwardStore', function ($q) use ($request) {
    //                         $q->where('store_warehouses_id', $request->storeId);
    //                     });
    //             })->first();
    //         // dd($findItems);
    //         //sum of issue quantity
    //         $item->total_accept_qty = $findItems?->accept_qty ?? 0;
    //         return $item;
    //     })->pluck('total_accept_qty')->sum();

    //     $datas->total_issue_qty = $filteredData;
    //     $datas->total_accept_qty = $filteredDatareciptd;

    //     // dd($datas->toArray());
    //     // $datas->total_issue_qty = $filteredData;
    //     return $datas;
    // }


    function stockstatement($request)
    {
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $type = $request->product_type == 'material' ? 'materials' : 'machines';
        $projectId = $request->projectId;
        $storeId = $request->storeId;

        $datas = Inventory::where('company_id', $authCompany)
            ->where('type', $type)
            ->where(function ($q) use ($projectId, $storeId) {
                if ($projectId) {
                    $q->where('projects_id', $projectId);
                }
                if ($storeId) {
                    $q->orWhereHas('inventoryStore', function ($subQ) use ($storeId) {
                        $subQ->where('store_warehouses_id', $storeId);
                    });
            }
        })
            ->get();

        // Transform each item with computed fields
        $result = $datas->map(function ($item) use ($request, $type) {
            $idColumn = $type === 'machines' ? 'assets_id' : 'materials_id';
            $itemId = $item->$idColumn;

            // Total issued for this item in the given project/store context
            $totalIssueQty = InvIssuesDetails::where('type', $type)
                ->where($idColumn, $itemId)
                ->whereHas('InvIssueGood.invIssue', function ($q) use ($request) {
                    $q->where('projects_id', $request->projectId)
                    ->orWhereHas('InvIssueStore', function ($q2) use ($request) {
                        $q2->where('store_warehouses_id', $request->storeId);
                        });
                })
                ->sum('issue_qty');

            // Total accepted (inward) for this item
            $totalAcceptQty = InwardGoodsDetails::where('type', $type)
                ->where($idColumn, $itemId)
                ->whereHas('InvInwardGood.InvInward', function ($q) use ($request) {
                    $q->where('projects_id', $request->projectId)
                    ->orWhereHas('InvInwardStore', function ($q2) use ($request) {
                        $q2->where('store_warehouses_id', $request->storeId);
                        });
                })
                ->sum('accept_qty');

            // Available = accepted - issued
            $totalAvailableQty = $totalAcceptQty - $totalIssueQty;

            // Add to item (as array or object attributes)
            $item->totalIssueQty = (float) $totalIssueQty;
            $item->totalAcceptQty = (float) $totalAcceptQty;
            $item->totalAvailableQty = (float) $totalAvailableQty;

            return $item;
        });

        // dd($result);
        return $result;
    }



    function issuereturn($request)
    {
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $vessd = [];
        $datas = InvReturn::with(['InvReturnStore']) // Ensure the relationship is correct
            ->where('company_id', $authCompany)
            ->where('projects_id', $request->projectId)
            ->whereBetween('date', [$request->dateForm, $request->dateTo])
            ->orWhereHas('InvReturnStore', function ($q) use ($request) {
                $q->where('store_warehouses_id', $request->storeWarehousesId);
            })
            ->get();

        foreach ($datas as $item) {
            foreach ($item->invReturnsGoods as $invReturnGood) { // Iterate through the collection
                if ($invReturnGood->inv_issue_lists_id !== null && $invReturnGood->tag_id !== null) {
                    $vessd['inv_issue_lists'][] = $invReturnGood->inv_issue_lists_id; // Access the property on the individual item
                    $vessd['tag_id'][] = $invReturnGood->tag_id; // Access the property on the individual item
                }
            }
        }
        if (!empty($vessd['inv_issue_lists'])) {
            $invIssueLists = array_unique($vessd['inv_issue_lists']);
        }

        $activityDetails = [];
        foreach ($datas as $item) {
            foreach ($item->invReturnsGoods as $invReturnGood) {
                $tagData = $invReturnGood->inv_issue_lists_id;
                if (!isset($activityDetails[$tagData])) {
                    $activityDetails[$tagData] = [
                        'activities' => [],
                    ];
                }
                $activityDetails[$tagData]['activities'][] = $invReturnGood;
            }
        }

        $topHeadDetails = [
            'project' => $datas?->first()?->projects?->project_name,
            'subproject' => $datas?->first()?->InvReturnStore?->first()->name,
            'dateform' => $request?->dateForm,
            'dateto' => $request?->dateTo,
        ];
        // dd($invIssueLists);
        if (!empty($activityDetails) && !empty($invIssueLists) && !empty($topHeadDetails) && !empty($vessd)) {
            $fetchDatas = compact('activityDetails', 'invIssueLists', 'topHeadDetails', 'vessd');
            return $fetchDatas;
        }
    }

    function issuedetails($request)
    {
        // dd($request->toArray());
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $datas = InvIssuesDetails::with(['InvIssueGood'])
            ->where('company_id', $authCompany)
            ->whereHas('InvIssueGood.invIssue', function ($query) use ($request) {
                $query->where('projects_id', $request->projectId)
                    ->orwhereHas('InvIssueStore', function ($q) use ($request) {
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
        $datas = InvIssuesDetails::with(['InvIssueGood'])
            ->where('company_id', $authCompany)
            ->whereHas('InvIssueGood.invIssue', function ($query) use ($request) {
                $query->where('projects_id', $request->projectId)->where('date', $request->date)
                    ->orwhereHas('InvIssueStore', function ($q) use ($request) {
                        $q->where('store_warehouses_id', $request->storeWarehousesId);
                    });
            })
            ->get();
        // dd($datas);
        if ($datas->count() > 0) {
            return $datas;
        }
    }

    function grnslip($request)
    {
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $fetch = InvInward::where('company_id', $authCompany)
            ->where('projects_id', $request->projectId)
            ->where('date', $request->date)
            ->whereHas('InvInwardStore', function ($q) use ($request) {
                $q->where('store_warehouses_id', $request->storeId);
            })
            ->get();

        $fetchHeadData = [];
        foreach ($fetch as $key => $inward) {
            $fetchHeadData['projects'] = $inward->projects->project_name ?? "";
            $fetchHeadData['date'] = $request->date ?? "";
            $fetchHeadData['store'] = $inward->InvInwardStore->first()->name ?? "";
            $fetchHeadData['store_loc'] = $inward->InvInwardStore->first()->location ?? "";
            // dd($inward);
            if (!empty($inward?->invInwardGood)) {
                foreach ($inward?->invInwardGood as $iwgkey => $iwgood) {
                    // dd($iwgood);
                    $fetchHeadData['inv_inward_entry_types_id'] = $iwgood->inv_inward_entry_types_id ?? "";
                    $fetchHeadData['supplier'] = $iwgood->vendor_id ?? "";
                    $fetchHeadData['delivery_ref_copy_date'] = $iwgood->delivery_ref_copy_date ?? "";
                    $fetchHeadData['delivery_ref_copy_no'] = $iwgood->delivery_ref_copy_no ?? "";
                    $fetchHeadData['grn_no'] = $iwgood->grn_no ?? "";
                }
            }
        }
        $result = [];
        foreach ($fetch as $key => $inward) {
            if (!empty($inward?->invInwardGood)) {
                foreach ($inward?->invInwardGood as $iwgkey => $iwgood) {
                    foreach ($iwgood->invInwardGoodDetails as $gddkey => $goodetails) {
                        $result[] = $goodetails;
                    }
                }
            }
        }
        if (!empty($result) && !empty($fetchHeadData) && !empty($fetch)) {
            // dd($fetch);
            return compact('result', 'fetchHeadData', 'fetch');
        }
    }
    // *******************************Dashboard****************************************************

    function fetchActivities(Request $request)
    {
        $authCompany = Auth::guard('company-api')->user()->company_id;

        $query = Activities::with('activitiesHistory')
            ->where('company_id', $authCompany)
            ->where('project_id', $request->projectId)
            ->where('type', 'activites');

        if (!empty($request->storeId)) {
            $query->where('subproject_id', $request->storeId);
        }
        return $query->get();
    }

    function inProgess(Request $request)
    {
        $fetchActivities = $this->fetchActivities($request);
        $headDetails = $fetchActivities->first();

        $inProgress = $fetchActivities->filter(function ($activity) {
            return $activity->activitiesHistory->isNotEmpty();
        })->pluck('activitiesHistory');

        return compact('inProgress', 'headDetails', 'fetchActivities');
    }

    function workComplete(Request $request)
    {
        $fetchActivities = $this->fetchActivities($request);
        $headDetails = $fetchActivities->first();

        $completed = $fetchActivities->filter(function ($activity) {
            $totalQty = $activity->activitiesHistory->sum('qty');
            return $activity->qty == $totalQty;
        })->pluck('activitiesHistory');
        // dd($completed);
        return compact('completed', 'headDetails', 'fetchActivities');
    }

    function notStatus(Request $request)
    {
        $fetchActivities = $this->fetchActivities($request);
        $headDetails = $fetchActivities->first();

        // Filter activities that have not started
        $notStarted = $fetchActivities->filter(function ($activity) {
            $totalQty = $activity->activitiesHistory->sum('qty');
            return $activity->qty !== $totalQty && $activity->activitiesHistory->isEmpty();
        });
        return compact('notStarted', 'headDetails', 'fetchActivities');
    }
}
    // *******************************Dashboard****************************************************
    // function inProgess($request){
    //     $inProgress=[];
    //     $authCompany = Auth::guard('company-api')->user()->company_id;
    //     $fetchActivites = Activities::with('activitiesHistory')
    //             ->where('company_id', $authCompany)
    //             ->where('project_id', $request->projectId);
    //             if(!empty($request->storeId)){
    //                $fetchActivites= $fetchActivites->where('subproject_id', $request->storeId);
    //             }
    //            $fetchActivites= $fetchActivites->where('type', 'activites')
    //             ->get();
    //             $headDetails=$fetchActivites->first();
    //             // dd($headDetails);
    //             // dd($fetchActivites->toArray());

    //             foreach ($fetchActivites as $val) {
    //                 if (($val->activitiesHistory)->count() > 0) {
    //                         $inProgress[] = $val;
    //                 }
    //             }
    //             return compact('inProgress','headDetails','fetchActivites');
    // }

    // function workComplete($request){
    //     $completed=[];
    //     $authCompany = Auth::guard('company-api')->user()->company_id;
    //     $fetchActivites = Activities::with('activitiesHistory')
    //             ->where('company_id', $authCompany)
    //             ->where('project_id', $request->projectId);
    //             if(!empty($request->storeId)){
    //                $fetchActivites= $fetchActivites->where('subproject_id', $request->storeId);
    //             }
    //            $fetchActivites= $fetchActivites->where('type', 'activites')
    //             ->get();
    //             $headDetails=$fetchActivites->first();
    //             // dd($headDetails);
    //             // dd($fetchActivites->toArray());

    //             foreach ($fetchActivites as $val) {
    //                 if (($val->activitiesHistory)->count() > 0) {
    //                                 $asdfgh = collect($val->activitiesHistory)->sum(function ($item) {
    //                                     return (float) $item->qty;
    //                                 });

    //                                 if ($val->qty == $asdfgh) {
    //                                     $completed[] = $val;
    //                                 }
    //                             }
    //             }
    //             return compact('completed','headDetails','fetchActivites');
    // }

    // function notStatus($request){
    //     $notStart=[];
    //     $authCompany = Auth::guard('company-api')->user()->company_id;
    //     $fetchActivites = Activities::with('activitiesHistory')
    //             ->where('company_id', $authCompany)
    //             ->where('project_id', $request->projectId);
    //             if(!empty($request->storeId)){
    //                $fetchActivites= $fetchActivites->where('subproject_id', $request->storeId);
    //             }
    //            $fetchActivites= $fetchActivites->where('type', 'activites')
    //             ->get();
    //             $headDetails=$fetchActivites->first();
    //             // dd($headDetails);
    //             // dd($fetchActivites->toArray());

    //             foreach ($fetchActivites as $val) {
    //                 if (($val->activitiesHistory)->count() > 0) {
    //                                 $asdfgh = collect($val->activitiesHistory)->sum(function ($item) {
    //                                     return (float) $item->qty;
    //                                 });
    //                                 if (($val->qty !== $asdfgh) && ($val->activitiesHistory)->count() <= 0) {
    //                                     $notStart[] = $val;
    //                                 }
    //                             }

    //             }
    //             return compact('notStart','headDetails','fetchActivites');
    // }

// }

// function projectwisedpr($data)
// {
//     // dd($data);
//     $workStatus = [];
//     $inProgress = 0;
//     $completed = 0;
//     // $authCompany = Auth::guard('company-api')->user()->company_id;
//     $authCompany = Auth::guard('company')->user()->company_id ?? Auth::guard('company-api')->user()->company_id;
//     $fetchActivites = Activities::with('activitiesHistory')->where('company_id', $authCompany)
//         ->where('project_id', $data['project'])
//         ->where('type', 'activites')
//         ->get();
//     foreach ($fetchActivites as $val) {
//         if (($val->activitiesHistory)->count() > 0) {
//             $asdfgh = collect($val->activitiesHistory)->sum(function ($item) {
//                 return (float) $item->qty;
//             });
//             if ($val->qty == $asdfgh) {
//                 $completed = $completed + 1;
//             }
//         }
//         if (($val->activitiesHistory)->count() > 0) {
//             $inProgress = $inProgress + 1;
//         }
//     }
//     $workStatus['totalActivites'] = $fetchActivites->count();
//     $workStatus['inProgress'] = $inProgress;
//     $workStatus['notStart'] = (($fetchActivites->count() - $inProgress) - $completed);
//     $workStatus['completed'] = $completed;
//     return $workStatus;
// }
