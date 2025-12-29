<?php

namespace App\Http\Controllers\Ajax;

use App\Models\Cities;
use App\Models\User;
use App\Models\Company\Unit;
use Illuminate\Http\Request;
use App\Models\Company\Assets;
use App\Models\Company\Labour;
use App\Models\Company\Vendor;
use App\Models\Admin\AdminRole;
use App\Models\Company\Project;
use App\Models\Company\Companies;
use App\Models\Company\Materials;
use App\Models\Admin\Cms\HomePage;
use App\Models\Company\Activities;
use App\Models\Company\SubProject;
use App\Models\Admin\PageManagment;
use App\Models\Company\CompanyUser;
use App\Models\Admin\Cms\BannerPage;
use App\Models\Company\Company_role;
use App\Models\Company\OpeningStock;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin\CompanyManagment;
use App\Models\Company\StoreWarehouse;
use App\Models\Admin\Cms\MenuManagment;
use App\Http\Controllers\BaseController;
use App\Models\API\Dpr;
use App\Models\Assets\AssetsOpeningStock;
use App\Models\Company\ActivityHistory;
use App\Models\Company\CompanyProjectPermission;
use App\Models\Company\InwardGoodsDetails;
use App\Models\Company\LabourHistory;
use App\Models\Company\MaterialOpeningStock;
use App\Models\Inventory;
use App\Models\InvIssuesDetails;
use App\Models\InvReturnsDetails;
use App\Models\MaterialRequest;
use App\Models\MaterialRequestDetails;
use App\Models\States;
use App\Models\Subscription\SubscriptionPackage;
use App\Models\Subscription\SubscriptionPackageOptions;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class AjaxController extends BaseController
{
    //*****************************Company*************************************************
    public function subprojects(Request $request)
    {
        dd($request->all());
    }
    // *************************************************************************************
    public function getMaterials(Request $request, $id)
    {
        $authConpany = Auth::guard('company')->user()->id;
        $companyId = searchCompanyId($authConpany);
        if ($request->ajax()) {
            // dd($id);
            // $id = uuidtoid($request->uuid, 'materials');
            $fetchIdExitOrNot = Materials::with('units')->where('id', $id)->where('company_id', $companyId)->first();
            return $fetchIdExitOrNot;
        }
        abort(405);
    }
    // **************************************************************************************
    public function getStates(Request $request)
    {
        $states = States::where('country_id', $request->countryId)->get();
        return $states;
    }
    // **************************************************************************************
    public function getCities(Request $request)
    {
        // dd($request->stateId);
        $cities = Cities::where('state_id', $request->stateId)->get();
        // dd($cities);
        return $cities;
    }
    // **************************************************************************************
    public function workstatus(Request $request)
    {
        $data = [];
        $projectWiseDpr = projectwisedpr($request);
        $timelineProgress = timelineProgress($request);
        $estimatedCost = estimatedcost($request);
        $estimatedCostForExecutedQty = estimatedcostforexecutedqty($estimatedCost, $request);
        $dilyprogessreport = dilyprogessreport($request);
        $labourStrength = labourStrength($request);
        $inventorysdata = inventorysdata($request);
        $monthwiseworkProgess = monthwiseworkProgess($request);
        // dd($estimatedCost, $estimatedCostForExecutedQty);
        // dd($monthwiseworkProgess['chartData']);
        $data['monthwiseworkProgess'] = $monthwiseworkProgess;

        $data['estimatedCost'] = $estimatedCost;
        $data['estimatedCostForExecutedQty'] = $estimatedCostForExecutedQty;
        $data['balanceEstimate'] = (($estimatedCost - $estimatedCostForExecutedQty) > 0 ? ($estimatedCost - $estimatedCostForExecutedQty) : 0);
        $data['excessEstimateCost'] = (($estimatedCost - $estimatedCostForExecutedQty) < 0 ? ($estimatedCost - $estimatedCostForExecutedQty) : 0);

        $data['totalActivites'] = $projectWiseDpr['totalActivites'];
        $data['inProgress'] = $projectWiseDpr['inProgress'];
        $data['notStart'] = $projectWiseDpr['notStart'];
        $data['completed'] = $projectWiseDpr['completed'];

        $data['totalDuration'] = $timelineProgress['totalDuration'];
        $data['projectcompleted'] = $timelineProgress['projectcompleted'];
        $data['remaining'] = $timelineProgress['remaining'];
        $data['planeProgress'] = $timelineProgress['planeProgress'];
        $data['actualProgress'] = $timelineProgress['actualProgress'];
        $data['variation'] = $timelineProgress['variation'];

        $data['users'] = $dilyprogessreport['users'];
        $data['fetchDpr'] = $dilyprogessreport['fetchDpr'];

        $data['totalLabourCount'] = $labourStrength['totalLabourCount'];
        $data['totalLabourTotal'] = $labourStrength['totalLabourTotal'];
        $data['vendorWiseLabourListing'] = $labourStrength['vendorWiseLabourListing'];

        $data['purchaseRequests'] = $inventorysdata['purchaseRequests'];
        $data['goodsReceipt'] = $inventorysdata['goodsReceipt'];
        $data['issueOutward'] = $inventorysdata['issueOutward'];
        $data['materialReturn'] = $inventorysdata['materialReturn'];
        $data['pORaised'] = $inventorysdata['pORaised'];

        $data['workStatusData'] = [
            ['y' => $projectWiseDpr['inProgress'], 'legendText' => 'In Progress'],
            ['y' => $projectWiseDpr['completed'], 'legendText' => 'Completed'],
            ['y' => $projectWiseDpr['notStart'], 'legendText' => 'Not started'],
            ['y' => $projectWiseDpr['totalActivites'], 'legendText' => 'Total Activities']
        ];

        $data['months'] = $monthwiseworkProgess['months'];
        $data['labels'] = $monthwiseworkProgess['labels'];
        $data['data'] = $monthwiseworkProgess['data'];
        $data['actualProgress'] = $monthwiseworkProgess['actualProgress'];
        $data['plannedProgress'] = $monthwiseworkProgess['plannedProgress'];
        $data['chartData'] = $monthwiseworkProgess['chartData'];
        return $data;
    }

    // **************************************************************************************
    // public function monthlyProgress(Request $request)
    // {
    //     $data = [];
    //     $projectWiseDpr = projectwisedpr($request);
    //     $timelineProgress = timelineProgress($request);
    //     $estimatedCost = estimatedcost($request);
    //     $estimatedCostForExecutedQty = estimatedcostforexecutedqty($estimatedCost, $request);
    //     $dilyprogessreport = dilyprogessreport($request);
    //     $labourStrength = labourStrength($request);
    //     $inventorysdata = inventorysdata($request);
    //     // dd($inventorysdata);
    //     $data['estimatedCost'] = $estimatedCost;
    //     $data['estimatedCostForExecutedQty'] = $estimatedCostForExecutedQty;
    //     $data['balanceEstimate'] = (($estimatedCost - $estimatedCostForExecutedQty) > 0 ? ($estimatedCost - $estimatedCostForExecutedQty) : 0);
    //     $data['excessEstimateCost'] = (($estimatedCost - $estimatedCostForExecutedQty) < 0 ? ($estimatedCost - $estimatedCostForExecutedQty) : 0);
    //     $data['totalActivites'] = $projectWiseDpr['totalActivites'];
    //     $data['inProgress'] = $projectWiseDpr['inProgress'];
    //     $data['notStart'] = $projectWiseDpr['notStart'];
    //     $data['completed'] = $projectWiseDpr['completed'];
    //     $data['totalDuration'] = $timelineProgress['totalDuration'];
    //     $data['projectcompleted'] = $timelineProgress['projectcompleted'];
    //     $data['remaining'] = $timelineProgress['remaining'];
    //     $data['planeProgress'] = $timelineProgress['planeProgress'];
    //     $data['actualProgress'] = $timelineProgress['actualProgress'];
    //     $data['variation'] = $timelineProgress['variation'];
    //     $data['users'] = $dilyprogessreport['users'];
    //     $data['fetchDpr'] = $dilyprogessreport['fetchDpr'];
    //     $data['totalLabourCount'] = $labourStrength['totalLabourCount'];
    //     $data['vendorWiseLabourListing'] = $labourStrength['vendorWiseLabourListing'];
    //     $data['purchaseRequests'] = $inventorysdata['purchaseRequests'];
    //     $data['goodsReceipt'] = $inventorysdata['goodsReceipt'];
    //     $data['issueOutward'] = $inventorysdata['issueOutward'];
    //     $data['materialReturn'] = $inventorysdata['materialReturn'];
    //     $data['pORaised'] = $inventorysdata['pORaised'];
    //     $data['workStatusData'] = [
    //         ['y' => $projectWiseDpr['inProgress'], 'legendText' => 'In Progress'],
    //         ['y' => $projectWiseDpr['completed'], 'legendText' => 'Completed'],
    //         ['y' => $projectWiseDpr['notStart'], 'legendText' => 'Not started'],
    //         ['y' => $projectWiseDpr['totalActivites'], 'legendText' => 'Total Activities']
    //     ];
    //     return $data;
    // }

    // **************************************************************************************
    public function workprocess(Request $request)
    {
        // dd($request);
        $data = [];
        $estimatedCost = estimatedcost($request);
        $estimatedCostForExecutedQty = estimatedcostforexecutedqty($estimatedCost, $request);
        $projectWiseDpr = projectwisedpr($request);
        $activitesWorkDetails = activitesWorkDetails($request);
        // dd($activitesWorkDetails);
        $data['estimatedCost'] = $estimatedCost;
        $data['estimatedCostForExecutedQty'] = $estimatedCostForExecutedQty;
        $data['balanceEstimate'] = (($estimatedCost - $estimatedCostForExecutedQty) > 0 ? ($estimatedCost - $estimatedCostForExecutedQty) : 0);
        $data['excessEstimateCost'] = (($estimatedCost - $estimatedCostForExecutedQty) < 0 ? ($estimatedCost - $estimatedCostForExecutedQty) : 0);
        $data['totalActivites'] = $projectWiseDpr['totalActivites'];
        $data['inProgress'] = $projectWiseDpr['inProgress'];
        $data['notStart'] = $projectWiseDpr['notStart'];
        $data['completed'] = $projectWiseDpr['completed'];
        $data['workProcessData'] = [
            ['y' => $data['estimatedCost'], 'legendText' => $data['estimatedCost']],
            ['y' => $data['estimatedCostForExecutedQty'], 'legendText' => $data['estimatedCostForExecutedQty']],
            ['y' => $data['balanceEstimate'], 'legendText' => $data['balanceEstimate']],
            ['y' => $data['excessEstimateCost'], 'legendText' => $data['excessEstimateCost']]
        ];
        // dd($data);
        return $data;
    }
    // ****************************************************************************************
    public function getworkProcessActivities(Request $request)
    {
        $activitesWorkDetails = activitesWorkDetails($request);
        $data = [];
        switch ($request->filterName) {
            case 'inprogress':
                $data['inProgressactivites'] = $activitesWorkDetails['inProgress'];
                break;
            case 'completed':
                $data['completedactivites'] = $activitesWorkDetails['completed'];
                break;
            case 'notstart':
                $data['notStartactivites'] = $activitesWorkDetails['notStart'];
                break;
            case 'delay':
                $data['delayactivites'] = $activitesWorkDetails['delayactivites'];
                break;
        }
        // dd($data);
        return $data;
    }
    // *******************************************************************************************
    public function getstocksinventory(Request $request)
    {
        $activitesStocksDetails = activitesStocksDetails($request);
        //   dd($activitesStocksDetails );
        $data = [];
        $tabName = $request->filterName ? $request->filterName : 'material';
        switch ($tabName) {
            case 'material':
                $data['materialStocks'] = $activitesStocksDetails;
                break;
            case 'machine':
                $data['machineStocks'] = $activitesStocksDetails;
                break;
        }
        // dd($data);
        return $data;
    }
    // ********************************************************************************************
    public function workProgressDetails(Request $request)
    {
        $projectId = $request->project;
        $subProjectId = $request->subproject; // Nullable, no default empty string
        $fromDate = $request->date_from;
        $toDate = $request->date_to;
        $authCompany = Auth::guard('company')->user()->id;
        $companyId = searchCompanyId($authCompany);

        // Query activities with relationships and filters
        $query = Activities::with(['units', 'project', 'subproject', 'activitiesHistory'])
            ->where('company_id', $companyId)
            ->where(function ($query) use ($projectId, $subProjectId) {
                $query->where('project_id', $projectId);
                if ($subProjectId) {
                    $query->orWhere('subproject_id', $subProjectId);
                }
            })
            ->whereHas('activitiesHistory', function ($q) use ($projectId, $subProjectId, $fromDate, $toDate) {
                $q->whereHas('dpr', function ($qq) use ($projectId, $subProjectId, $fromDate, $toDate) {
                    $qq->where('projects_id', $projectId)
                        ->where('sub_projects_id', $subProjectId ?? null)
                        ->whereBetween('date', [$fromDate, $toDate]);
                });
            })
            ->get();

        // dd($query);
        // Process activities
        $activities = [];
        $headerDetails = [
            'projectId' => '',
            'subProjectId' => '',
            'fromDate' => $fromDate,
            'toDate' => $toDate,
            'logo' => '',
        ];

        if ($query->isNotEmpty()) {
            // Set header details from the first activity
            $firstActivity = $query->first();
            $headerDetails['projectId'] = $firstActivity->project?->project_name ?? '';
            $headerDetails['subProjectId'] = $firstActivity->subproject?->project_name ?? '';
            $headerDetails['logo'] = $firstActivity->project?->logo ?? '';

            // Process each activity
            $query->each(function ($activity, $key) use (&$activities) {
                $totalQty = $activity->activitiesHistory->sum('qty') ?? 0;
                $activity->setAttribute('totalQtyInHistory', $totalQty);
                $totalIssueQty = $activity->invIssuesDetails ? $activity->invIssuesDetails->sum('issue_qty') : 0;
                $activity->setAttribute('totalIssueQty', $totalIssueQty);

                $activities[$key] = [
                    'sl_no' => $key + 1,
                    'activities' => $activity->activities ?? '',
                    'unit' => $activity->units?->unit ?? '',
                    'est_qty' => $activity->qty ?? 0,
                    'est_rate' => $activity->rate ?? 0,
                    'est_amount' => formatAmount(($activity->qty ?? 0) * ($activity->rate ?? 0), 2),
                    'completed_qty' => formatAmount($totalQty, 2),
                    'est_amount_completion' => formatAmount($totalQty * ($activity->rate ?? 0), 2),
                    'completion' => ($activity->qty && $totalQty) ? formatAmount(($totalQty / $activity->qty) * 100, 2) : '0.00',
                    'balance_qty' => formatAmount(($activity->qty ?? 0) - $totalQty, 2),
                ];
            });
        }

        // dd($activities);
        return compact('activities', 'headerDetails');
        // } catch (\Exception $e) {
        //     Log::error('Error fetching work progress details', [
        //         'error' => $e->getMessage(),
        //         'trace' => $e->getTraceAsString(),
        //     ]);
        //     return response()->json([
        //         'message' => 'Internal Server Error',
        //         'errors' => [],
        //     ], 500);
        // }
    }

    // Placeholder for searchCompanyId function
    private function searchCompanyId($authCompany)
    {
        // Implement your logic here
        return $authCompany; // Example
    }

    // Placeholder for formatAmount function
    private function formatAmount($value, $decimals = 2)
    {
        return number_format($value, $decimals, '.', '');
    }

    // public function workProgressDetails(Request $request)
    // {
    //     $activites = [];
    //     $headerDetails = [];
    //     $projectId = $request->project;
    //     $subProjectId = $request->subproject ?? '';
    //     $fromDate = $request->date_from;
    //     $toDate = $request->date_to;
    //     $authConpany = Auth::guard('company')->user()->id;
    //     $companyId = searchCompanyId($authConpany);
    //     if (!$projectId) {
    //         return response()->json(['message' => 'Project not found'], 404);
    //     }
    //     $exists = Activities::where(function ($query) {
    //         $query->whereNotNull('project_id')
    //             ->orWhereNotNull('subproject_id');
    //     })->exists();
    //     if ($exists) {
    //         // If records exist, proceed with the main query
    //         $query = Activities::with('units', 'project', 'subproject', 'activitiesHistory')
    //             ->where('company_id', $companyId)
    //             ->where(function ($query) {
    //                 $query->whereNotNull('project_id')->orWhereNotNull('subproject_id');
    //             })
    //             ->where(function ($query) use ($projectId, $subProjectId) {
    //                 $query->where('project_id', $projectId)
    //                     ->orWhere('subproject_id', $subProjectId);
    //             })
    //             ->whereHas('activitiesHistory', function ($q) use ($request) {
    //                 $q->whereHas('dpr', function ($qq) use ($request) {
    //                     $qq->where('projects_id', $request->project)
    //                         ->Where('sub_projects_id', $request->subproject)
    //                         ->whereBetween('date', [$request->date_from, $request->date_to]);
    //                 });
    //             })
    //             ->get();

    //         // $query->each(function ($activity) {
    //         //     $totalQty = $activity->activitiesHistory->sum('qty');
    // $activity->setAttribute('totalQtyInHistory', $totalQty);
    //         //     $totalIssueQty = $activity->invIssuesDetails->sum('issue_qty');
    //         //     $activity->setAttribute('totalIssueQty', $totalIssueQty);
    //         // });
    //         $query->each(function ($activity) {
    //             $totalQty = $activity->activitiesHistory->sum('qty');
    //             $activity->setAttribute('totalQtyInHistory', $totalQty);

    //             // Add null check before calling sum()
    //             $totalIssueQty = $activity->invIssuesDetails ? $activity->invIssuesDetails->sum('issue_qty') : 0;
    //             $activity->setAttribute('totalIssueQty', $totalIssueQty);
    //         });
    //         // dd($query);
    //     } else {
    //         // Handle the case where no records exist
    //         $query = collect(); // Empty collection or any other handling logic
    //     }
    //     $datas = $query;
    //     // dd($datas?->first()->project?->project_name);
    //     // dd($datas->first()->project->project_name);
    //     $headerDetails['projectId'] = $datas?->first()?->project?->project_name ?? '';
    //     $headerDetails['subProjectId'] = $datas?->first()?->subproject?->project_name ?? '';
    //     $headerDetails['fromDate'] = $fromDate;
    //     $headerDetails['toDate'] = $toDate;
    //     $headerDetails['logo'] = $datas?->first()?->project?->logo;
    //     foreach ($datas as $key => $val) {
    //         $activites[$key]['sl_no'] = $key + 1;
    //         $activites[$key]['activities'] = $val->activities;
    //         $activites[$key]['unit'] = $val?->units?->unit ?? '';
    //         $activites[$key]['est_qty'] = $val?->qty ?? '';
    //         $activites[$key]['est_rate'] = $val?->rate ?? '';
    //         $activites[$key]['est_amount'] = formatAmount(($val?->qty * $val?->rate),0) ?? '00'; // Formatting to 2 decimal places
    //         $activites[$key]['completed_qty'] = formatAmount($val?->totalQtyInHistory,0) ?? '';
    //         $activites[$key]['est_amount_completion'] =formatAmount(((int)$val?->totalQtyInHistory * (int)$val?->rate)/100,0); // Formatting to 2 decimal places
    //         $activities[$key]['completion'] = formatAmount(((int)$val->qty !== 0 && (int)($val->totalQtyInHistory ?? 0) !== 0) ? ((int)$val->qty / (int)($val->totalQtyInHistory)) : 0, 2 );
    //         $activites[$key]['balance_qty'] = $val?->totalQtyInHistory ? formatAmount((int)$val?->qty - (int)$val?->totalQtyInHistory,2) : 00; // Formatting to 2 decimal places



    //         // $activites[$key]['est_amount_completion'] = formatAmount(($val?->totalQtyInHistory * (int)$val?->rate) /100) ?? '00'; // Formatting to 2 decimal places
    //         // $activites[$key]['completion'] = ((int) $val->qty != 0 && (int)$val?->totalQtyInHistory != 0) ? formatAmount(((int) $val?->qty / (int) $val?->totalQtyInHistory) /100) : '00'; // Formatting to 2 decimal places
    //         // $activites[$key]['balance_qty'] = $val?->totalQtyInHistory ? formatAmount(abs((int)$val?->qty - $val?->totalQtyInHistory)) : '00'; // Formatting to 2 decimal places
    //     }
    //     // dd($activites);
    //     return compact('activites', 'headerDetails');
    // }
    // **********************************************************************************************
    public function workProgressDprDetails(Request $request)
    {
        // dd($request->all());
        $assets = [];
        $activities = [];
        $labour = [];
        $material = [];
        $historie = [];
        $safetie = [];
        $projectId = $request->project;
        $fromDate = $request->date_from;
        $userId = $request->user_id;
        $emp_id = $request->emp_id;
        $authConpany = Auth::guard('company')->user()->id;
        $companyId = searchCompanyId($authConpany);
        $datas = Dpr::with('assets', 'activities', 'labour', 'material', 'historie', 'safetie')
            ->where('projects_id', $projectId)
            ->where('date', $fromDate)
            ->orWhere('name', $fromDate)
            ->where('company_id', $companyId)
            ->when($emp_id, function ($q) use ($emp_id) {
                return $q->where('user_id', $emp_id);
            })
            ->first();
        // dd($datas);
        if (!empty($datas) || $datas != null) {
            foreach ($datas->assets as $key => $ast) {
                $assets[$key]['sl_no'] = $key + 1;
                $assets[$key]['machinery_names'] = $ast->assets->name ?? '';
                $assets[$key]['specification'] = $ast->assets->specification !== null && $ast->assets->specification !== "NULL" ? $ast->assets->specification : '';
                $assets[$key]['unit'] = $ast->assets->units->unit ?? '';
                $assets[$key]['quantity'] = $ast->qty ?? '';
                $assets[$key]['contractor'] = $ast->vendors->name ?? '';
                $assets[$key]['rate'] = $ast->rate_per_unit ?? '';
                $assets[$key]['remarks'] = $ast->remarkes !== null && $ast->remarkes !== "NULL" ? $ast->remarkes : '';
            }
        }

        //         array:5 [ // app\Http\Controllers\Ajax\AjaxController.php:478
        //   "originalQty" => "50"
        //   "totalQtyUsed" => 2
        //   "remainingQty" => 48
        //   "percentageUsed" => "4.00"
        //   "percentageRemaining" => "96.00"
        // ]
        if (!empty($datas) || $datas != null) {
            foreach ($datas->activities as $key => $act) {
                $totalUsage = totalActivitiesUsage($act?->activities?->id);
                // dd($act?->activities, $act);
                $activities[$key]['sl_no'] = $key + 1;
                $activities[$key]['activities'] = $act?->activities?->activities ?? '';
                $activities[$key]['unit'] = $act?->activities?->units->unit ?? '';
                $activities[$key]['est_qty'] = $act?->activities?->qty ?? '';
                $activities[$key]['est_rate'] = $act?->activities?->rate ?? '';
                $activities[$key]['est_amount'] = $act?->activities?->qty * $act?->activities?->rate ?? '';
                $activities[$key]['completed_qty'] = $totalUsage['totalQtyUsed'] ?? '';
                $activities[$key]['est_amount_completion'] = $totalUsage['remainingQty'] * $act?->activities?->rate ?? '';
                $activities[$key]['completion'] = $totalUsage['percentageUsed'] ?? '';
                $activities[$key]['balance_qty'] = $totalUsage['remainingQty'] ?? '';
                $activities[$key]['vendors'] = $act->vendors?->name ?? '';
                $activities[$key]['remarks'] = $act?->remarkes !== null && $act?->remarkes !== "NULL" ? $act?->remarkes : '';
            }
        }
        if (!empty($datas) || $datas != null) {
            foreach ($datas->labour as $key => $lab) {
                $labour[$key]['sl_no'] = $key + 1;
                $labour[$key]['labour_details'] = $lab?->labours?->name ?? '';
                $labour[$key]['unit'] = $lab?->labours?->units->unit ?? '';
                $labour[$key]['qty'] = $lab?->qty ?? '';
                $labour[$key]['ot_qty'] = $lab?->ot_qty ?? '';
                $labour[$key]['labour_contractor'] = $lab?->vendors?->name ?? '';
                $labour[$key]['rate'] = $lab?->rate_per_unit ?? '';
                $labour[$key]['remarks'] = $lab?->remarkes !== null && $lab?->remarkes !== "NULL" ? $lab?->remarkes : '';
            }
        }
        if (!empty($datas) || $datas != null) {
            foreach ($datas->material as $key => $mat) {
                $material[$key]['sl_no'] = $key + 1;
                $material[$key]['materials'] = $mat?->materials?->name ?? '';
                $material[$key]['specification'] = $mat?->materials?->specification !== null && $mat?->materials?->specification !== "NULL" ? $mat?->materials?->specification : '';
                $material[$key]['unit'] = $mat?->materials?->units->unit ?? '';
                $material[$key]['qty_used'] = $mat?->qty ?? '';
                $material[$key]['work_details'] = $mat?->activities->activities ?? '';
                $material[$key]['remarks'] = $mat?->remarkes !== null && $mat?->remarkes !== "NULL" ? $mat?->remarkes : '';
            }
        }
        if (!empty($datas) || $datas != null) {
            foreach ($datas->historie as $key => $hist) {
                $historie[$key]['sl_no'] = $key + 1;
                $historie[$key]['hinderances_details'] = $hist?->details ?? '';
                $historie[$key]['concern_team_members'] = $hist?->companyUsers->name ?? '';
                $historie[$key]['remarks'] = $hist?->remarks !== null && $hist?->remarks !== "NULL" ? $hist?->remarks : '';
                $historie[$key]['img'] = $hist?->img ?? '';
            }
        }
        if (!empty($datas) || $datas != null) {
            foreach ($datas->safetie as $key => $saf) {
                $safetie[$key]['sl_no'] = $key + 1;
                $safetie[$key]['safety_problem_details'] = $saf?->name ?? '';
                $safetie[$key]['concern_team_members'] = $saf?->companyUsers->name ?? '';
                $safetie[$key]['remarks'] = $saf?->remarks !== null && $saf?->remarks !== "NULL" ? $saf?->remarks : '';
                $safetie[$key]['img'] = $saf?->img ?? '';
            }
        }
        return compact(
            'activities',
            'material',
            'labour',
            'assets',
            'historie',
            'safetie'
        );
    }
    // **********************************************************************************************
    public function workProgressDprDetailsPdf(Request $request)
    {
        try {
            // Fetch authenticated company ID
            $authCompany = Auth::guard('company')->user();
            if (!$authCompany) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
            $companyId = searchCompanyId($authCompany->id);
            if (!$companyId) {
                // dd($companyId);
                return response()->json(['error' => 'Company ID not found'], 404);
            }
            // Access individual form fields
            $fromProject = $request->input('project');
            $empId = $request->input('emp_id');
            $fromDate = $request->input('date_from');

            // Validate and format date
            $fromDate = Carbon::parse($fromDate)->format('Y-m-d');
            // Retrieve data from database
            $datas = Dpr::with('assets', 'activities', 'labour', 'material', 'historie', 'safetie')
                ->where('projects_id', $fromProject)
                ->where('date', $fromDate)
                ->orWhere('name', $fromDate)
                ->where('company_id', $companyId)
                ->when($empId, function ($q) use ($empId) {
                    return $q->where('user_id', $empId);
                })
                ->get();
            // dd($datas);
            // Generate PDF
            $pdf = PDF::loadView('common.report.dpr_web', compact('datas'));
            $filename = 'dpr_' . date('YmdHis') . '.pdf';
            // $pdf->save(storage_path('app/public/' . $filename));
            // $data = storage_path('app/public/' . $filename);
            $filePath = storage_path('app/public/' . $filename);
            // Save PDF to storage
            $pdf->save($filePath);
            // dd($filename);
            return response()->json(['filename' => $filename], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to generate PDF: ' . $e->getMessage()], 500);
        }
    }
    // **********************************************************************************************
    public function downloadPdf($filename)
    {
        try {
            $filePath = storage_path('app/public/' . $filename);
            if (!Storage::exists('public/' . $filename)) {
                abort(404, 'File not found.');
            }
            // Return the file as a download response
            return response()->download($filePath)->deleteFileAfterSend(true);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to download PDF: ' . $e->getMessage()], 500);
        }
    }
    // **********************************************************************************************
    public function resourcesUsageFromDprDate(Request $request)
    {
        $authCompany = Auth::guard('company-api')->user();
        $project = $request->project;
        $subproject = $request->subproject;
        $date = $request->date;
        $dprprojectfinder = dprprojectfinder($project, $subproject, $date);
        $material = [];
        $labour = [];
        $assets = [];
        $materialTotal = 0;
        $labourTotal = 0;
        $assetsTotal = 0;
        // dd($dprprojectfinder);

        // Add null check before foreach
        if ($dprprojectfinder && $dprprojectfinder->labour) {
            foreach ($dprprojectfinder->labour as $key => $lab) {
                $labour[$key]['id'] = $lab?->id;
                $labour[$key]['date'] = $lab?->created_at ? $lab->created_at->format('Y-m-d') : ''; // Only date
                $labour[$key]['name'] = $lab?->labours?->name;
                $labour[$key]['unit'] = $lab?->units?->units;
                $labour[$key]['qty'] = $lab?->qty ?? 0; // Default to 0 if null
                $labour[$key]['ot_qty'] = $lab?->ot_qty ?? 0; // Default to 0 if null
                $labour[$key]['rate'] = $lab?->rate_per_unit ?? 0; // Default to 0 if null
                $labour[$key]['amount'] = (($lab?->qty ?? 0) * ($lab?->rate_per_unit ?? 0)) + (($lab?->ot_qty ?? 0) * ($lab?->rate_per_unit ?? 0));
            }
        }

        if ($dprprojectfinder && $dprprojectfinder?->material) {
            foreach ($dprprojectfinder?->material as $key => $mat) {
                $material[$key]['id'] = $mat?->id;
                $material[$key]['date'] = $mat?->created_at ? $mat->created_at->format('Y-m-d') : '';
                $material[$key]['code'] = $mat?->materials?->code;
                $material[$key]['name'] = $mat?->materials?->name;
                $material[$key]['specification'] = $mat?->materials?->specification !== null && $mat?->materials?->specification !== "NULL" ? $mat?->materials?->specification : '';
                $material[$key]['unit'] = $mat?->units?->unit;
                $material[$key]['qty'] = $mat?->qty ?? 0; // Default to 0 if null
                $material[$key]['rate'] = $mat?->materials?->rate ?? 0; // Default to 0 if null
                $material[$key]['amount'] = ($mat?->qty ?? 0) * ($mat?->materials?->rate ?? 0); // Default to 0 if null
                $materialTotal = ($materialTotal ?? 0) + ($mat?->qty ?? 0) * ($mat?->materials?->rate ?? 0);
            }
        }
        if ($dprprojectfinder && $dprprojectfinder?->assets) {
            foreach ($dprprojectfinder?->assets as $key => $ast) {
                $assets[$key]['id'] = $ast?->id;
                $assets[$key]['date'] = $ast?->assets?->created_at ? $ast->assets->created_at->format('Y-m-d') : '';
                $assets[$key]['code'] = $ast?->assets?->code;
                $assets[$key]['name'] = $ast?->assets?->name;
                $assets[$key]['specification'] = $ast?->assets?->specification !== null && $ast?->assets?->specification !== "NULL" ? $ast?->assets?->specification : '';
                $assets[$key]['unit'] = $ast?->assets?->units?->unit;
                $assets[$key]['qty'] = $ast?->qty ?? 0; // Default to 0 if null
                $assets[$key]['rate'] = $ast?->rate_per_unit ?? 0; // Default to 0 if null
                $assets[$key]['amount'] = ($ast?->qty ?? 0) * ($ast?->rate_per_unit ?? 0); // Default to 0 if null
                $assetsTotal = ($assetsTotal ?? 0) + ($ast?->qty ?? 0) * ($ast?->rate_per_unit ?? 0);
            }
        }
        return compact('labour', 'material', 'assets');
    }
    // **********************************************************************************************
    public function resourcesUsageFromDprDays(Request $request)
    {
        $material = [];
        $labour = [];
        $assets = [];
        $materialTotal = 0;
        $labourTotal = 0;
        $assetsTotal = 0;
        $authCompany = Auth::guard('company')->user();
        $companyId = searchCompanyId($authCompany->id);
        $project = $request->project;
        $subproject = $request->subproject;
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $datas = Dpr::with('assets', 'labour', 'material')
            ->where('projects_id', $project)
            ->where('sub_projects_id', $subproject)
            ->whereBetween('date', [$from_date, $to_date])
            ->where('company_id', $companyId)
            ->get();
        foreach ($datas as $key => $dprprojectfinder) {
            // Initialize arrays to hold processed data
            $labour = [];
            $material = [];
            $assets = [];

            foreach ($dprprojectfinder->labour as $labKey => $lab) {
                $labour[$labKey]['id'] = $lab->id ?? null;
                $labour[$labKey]['name'] = $lab->labours->name ?? null;
                $labour[$labKey]['unit'] = $lab->units->units ?? null;
                $labour[$labKey]['qty'] = $lab->qty ?? 0;
                $labour[$labKey]['ot_qty'] = $lab->ot_qty ?? 0;
                $labour[$labKey]['rate'] = $lab->rate_per_unit ?? 0;
                $labour[$labKey]['amount'] = (($lab->qty ?? 0) * ($lab->rate_per_unit ?? 0)) + (($lab->ot_qty ?? 0) * ($lab->rate_per_unit ?? 0));
                $labour[$labKey]['work_details'] = $lab->remarkes ?? '';
                $labour[$labKey]['entered_by'] = $dprprojectfinder->users->name ?? 'Unknown';
                $labour[$labKey]['remarks'] = $lab->labours->remarkes !== null && $lab->labours->remarkes !== "NULL" ? $lab->labours->remarkes : '';
                $labour[$labKey]['labour_contractor'] = $lab->vendors->name ?? '';
                // Add date if available
                $labour[$key]['date'] = $lab?->created_at ? $lab->created_at->format('Y-m-d') : ''; // Only date

            }

            foreach ($dprprojectfinder->material as $matKey => $mat) {
                $material[$matKey]['id'] = $mat->id ?? null;
                $material[$matKey]['code'] = $mat->materials->code ?? null;
                $material[$matKey]['name'] = $mat->materials->name ?? null;
                $material[$matKey]['specification'] = $mat->materials->specification !== null && $mat->materials->specification !== "NULL" ? $mat->materials->specification : '';
                $material[$matKey]['unit'] = $mat->units->unit ?? null;
                $material[$matKey]['qty'] = $mat->qty ?? 0;
                $material[$matKey]['rate'] = 0; // Assuming rate is not provided
                $material[$matKey]['amount'] = 0; // Assuming amount is not calculated
                $material[$matKey]['work_details'] = $mat->remarkes ?? '';
                $material[$matKey]['entered_by'] = $dprprojectfinder->users->name ?? 'Unknown';
                $material[$matKey]['remarks'] = $mat->materials->remarkes ?? '';
                // Add date if available
                $material[$key]['date'] = $mat?->created_at ? $mat->created_at->format('Y-m-d') : '';
            }

            foreach ($dprprojectfinder->assets as $astKey => $ast) {
                $assets[$astKey]['id'] = $ast->id ?? null;
                $assets[$astKey]['code'] = $ast->assets->code ?? null;
                $assets[$astKey]['name'] = $ast->assets->name ?? null;
                $assets[$astKey]['specification'] = $ast->assets->specification !== null && $ast->assets->specification !== "NULL" ? $ast->assets->specification : '';
                $assets[$astKey]['unit'] = $ast->assets->units->unit ?? null;
                $assets[$astKey]['qty'] = $ast->qty ?? 0;
                $assets[$astKey]['rate'] = $ast->rate_per_unit ?? 0;
                $assets[$astKey]['amount'] = ($ast->qty ?? 0) * ($ast->rate_per_unit ?? 0);
                $assets[$astKey]['work_details'] = $ast->assets->remarkes ?? '';
                $assets[$astKey]['entered_by'] = $dprprojectfinder->users->name ?? 'Unknown';
                $assets[$astKey]['remarks'] = $ast->remarkes ?? '';
                $assets[$astKey]['contractor_supplier'] = $ast->vendors->name ?? '';
                $assets[$key]['date'] = $ast?->assets?->created_at ? $ast->assets->created_at->format('Y-m-d') : '';
            }
        }

        return compact('labour', 'material', 'assets');
    }
    // **********************************************************************************************
    public function matrialusedVsStoreIssue(Request $request)
    {
        $material = [];
        $authCompany = Auth::guard('company')->user();
        $companyId = searchCompanyId($authCompany->id);
        $project = $request->project;
        $subproject = $request->subproject;
        $store = $request->store;
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $total = 0;
        $datas = Materials::with('materialsHistory', 'inventorys', 'invIssuesDetails')
            ->where('company_id', $companyId)
            ->whereHas('invIssuesDetails', function ($invd) use ($project, $subproject, $store, $from_date, $to_date, $companyId) {
                $invd->whereHas('InvIssueGood', function ($invissueg) use ($project, $subproject, $store, $from_date, $to_date, $companyId) {
                    $invissueg->whereHas('invIssue', function ($invissue) use ($project, $subproject, $store, $from_date, $to_date, $companyId) {
                        $invissue->with('InvIssueStore', function ($que) use ($store) {
                            $que->where('store_warehouses_id', $store);
                        })->where('projects_id', $project);
                    });
                });
            })
            ->whereHas('materialsHistory', function ($mh) use ($project, $subproject, $store, $from_date, $to_date, $companyId) {
                $mh->whereHas('dpr', function ($dp) use ($project, $subproject, $store, $from_date, $to_date, $companyId) {
                    $dp->where('projects_id', $project)
                        ->where('sub_projects_id', $subproject)
                        ->whereBetween('date', [$from_date, $to_date])
                        ->where('company_id', $companyId);
                });
            })->get();
        $datas->each(function ($material) {
            $totalQty = $material->materialsHistory->sum('qty');
            $material->setAttribute('totalQtyInHistory', $totalQty);
            $totalIssueQty = $material->invIssuesDetails->sum('issue_qty');
            $material->setAttribute('totalIssueQty', $totalIssueQty);
        });
        // dd($datas->toArray());
        foreach ($datas as $key => $val) {
            $material[$key]['code'] = $val?->code;
            $material[$key]['name'] = $val?->name;
            $material[$key]['specification'] = $val?->specification !== null && $val?->specification !== 'NULL' ? $val?->specification ?? '' : '';
            $material[$key]['unit'] = $val?->units?->unit;
            $material[$key]['issue_qty'] = $val?->totalIssueQty ?? 0;
            $material[$key]['dpr_qty'] = $val?->totalQtyInHistory ?? 0;
            $material[$key]['variation'] = ($val?->totalIssueQty - $val?->totalQtyInHistory) ?? 0;
        }
        return compact('material');
    }
    // **********************************************************************************************
    public function inventorypr(Request $request)
    {
        // dd($request->all());
        $material = [];
        $authCompany = Auth::guard('company')->user();
        $companyId = searchCompanyId($authCompany->id);
        $project = $request->project;
        $subproject = $request->subproject;
        $from_date = $request->date_from;
        $to_date = $request->date_to;
        $indent_no = $request->indent_no;
        // $datas = Materials::with(['inventorys', 'materialsRequestDetails.materialrequests'])
        //     ->where('company_id', $companyId)
        //     ->whereHas('materialsRequestDetails', function ($mrdQuery) use ($from_date, $to_date, $indent_no, $project, $subproject, $companyId) {
        //         $mrdQuery->whereHas('materialrequests', function ($mrQuery) use ($from_date, $to_date, $project, $subproject, $companyId) {
        //             $mrQuery->orWhere(function ($query) use ($project, $subproject, $companyId) {
        //                 $query->where('projects_id', $project)->where('sub_projects_id', $subproject);
        //             })->where(function ($query) use ($from_date, $to_date, $companyId) {
        //                 $query->whereBetween('date', [$from_date, $to_date]);
        //             })->where('company_id', $companyId);
        //         });
        //         $mrdQuery->when($indent_no, function ($query) use ($indent_no, $companyId) {
        //             $query->where('request_id', $indent_no)
        //                 ->where('company_id', $companyId);
        //         });
        //     })
        //     ->get();
        // $datas->where(function ($material) {
        //     $totalQty = $material->materialsRequestDetails->orderBy('id', 'desc')->limit(1);
        //     $material->totalRequiredQty = $totalQty;
        // });
        // dd($datas);

        $datas = Materials::with(['inventorys', 'materialsRequestDetails.materialrequests'])
            ->where('company_id', $companyId)
            ->whereHas('materialsRequestDetails', function ($mrdQuery) use ($from_date, $to_date, $indent_no, $project, $subproject, $companyId) {
                // Base query for material requests
                $mrdQuery->whereHas('materialrequests', function ($mrQuery) use ($from_date, $to_date, $indent_no, $project, $subproject, $companyId) {
                    $mrQuery->where('company_id', $companyId);
                    if ($project) {
                        $mrQuery->where('projects_id', $project)
                            ->where('sub_projects_id', $subproject);
                    }
                    if ($from_date) {
                        $mrQuery->whereBetween('date', [$from_date, $to_date]);
                    }
                    if ($indent_no) {
                        $mrQuery->where('request_id', $indent_no);
                    }
                });
            })
            ->get();
        // dd($datas);

        foreach ($datas as $key => $invpr) {
            // dd($invpr);
            $material[$key]['sl_no'] = $key + 1;
            $material[$key]['name'] = $invpr?->name;
            $material[$key]['specification'] = $invpr?->specification !== null && $invpr?->specification !== 'NULL' ? $invpr?->specification ?? '' : '';
            $material[$key]['code'] = $invpr?->code;
            $material[$key]['unit'] = $invpr?->units?->unit;
            $material[$key]['totalRequiredQty'] = $invpr?->materialsRequestDetails?->first()?->qty;
            $material[$key]['totalRequiredDate'] = $invpr?->materialsRequestDetails?->first()->date;
            $material[$key]['requiredforActivities'] = $invpr?->materialsRequestDetails?->first()->activites?->activities;
            $material[$key]['remarks'] = $invpr?->materialsRequestDetails?->first()->remarks;
            $material[$key]['currentStock'] = $invpr?->inventorys?->total_qty ?? 0;
        }
        // dd($material);
        return compact('material');
    }
    // ***********************************************************************************************
    public function inventoryrfq(Request $request)
    {
        $material = [];
        $authCompany = Auth::guard('company')->user();
        $companyId = searchCompanyId($authCompany->id);
        $project = $request->project;
        $subproject = $request->subproject;
        $from_date = $request->date_from;
        $to_date = $request->date_to;
        $prepared_by = $request->prepared_by;
        $rfq_no = $request->rfq_no;

        //1
        // $datas = Materials::with(['inventorys', 'materialsRequestDetails.materialrequests.hasquotesDetails.quotes'])
        //     ->where('company_id', $companyId)
        //     ->orwhereHas('materialsRequestDetails.materialrequests', function ($mrQuery) use ($from_date, $to_date, $prepared_by, $rfq_no, $project, $subproject, $companyId) {
        //         $mrQuery->where('projects_id', $project)
        //             ->where('sub_projects_id', $subproject)
        //             ->where('company_id', $companyId)
        //             // ->orwhereHas('hasquotesDetails', function ($quotesDetailQuery) use ($from_date, $to_date, $prepared_by, $rfq_no, $project, $companyId) {
        //             ->whereHas('hasquotesDetails', function ($quotesDetailQuery) use ($from_date, $to_date, $prepared_by, $rfq_no, $project, $companyId) {
        //                 $quotesDetailQuery->whereHas('quotes', function ($quotesQuery) use ($from_date, $to_date, $prepared_by, $rfq_no, $project, $companyId) {
        //                     $quotesQuery->where('projects_id', $project)
        //                         ->when($prepared_by, function ($query) use ($prepared_by) {
        //                             $query->where('user_id', $prepared_by);
        //                         })
        //                         ->whereBetween('date', [$from_date, $to_date])
        //                         ->where('company_id', $companyId);
        //                 })
        //                     ->when($rfq_no, function ($query) use ($rfq_no) {
        //                         $query->where('request_no', $rfq_no);
        //                     });
        //             });
        //     })
        //     ->get();


        //2
        // $datas = Materials::with(['inventorys', 'materialsRequestDetails.materialrequests.hasquotesDetails.quotes'])
        //     ->where('company_id', $companyId)
        //     ->whereHas('materialsRequestDetails.materialrequests', function ($mrQuery) use ($from_date, $to_date, $prepared_by, $rfq_no, $project, $subproject, $companyId) {
        //         $mrQuery->where('company_id', $companyId)->where('status', 1)
        //             ->when($project, function ($query) use ($project, $subproject) {
        //                 $query->where('projects_id', $project)
        //                     ->where('sub_projects_id', $subproject);
        //             })
        //             ->whereHas('hasquotesDetails', function ($quotesDetailQuery) use ($from_date, $to_date, $prepared_by, $rfq_no, $project, $companyId) {
        //                 $quotesDetailQuery->whereHas('quotes', function ($quotesQuery) use ($from_date, $to_date, $prepared_by, $project, $companyId) {
        //                     $quotesQuery->where('company_id', $companyId)
        //                         ->when($project, function ($query) use ($project) {
        //                             $query->where('projects_id', $project);
        //                         })
        //                         ->when($prepared_by, function ($query) use ($prepared_by) {
        //                             $query->where('user_id', $prepared_by);
        //                         })
        //                         ->when($from_date && $to_date, function ($query) use ($from_date, $to_date) {
        //                             $query->whereBetween('date', [$from_date, $to_date]);
        //                         });
        //                 })
        //                     ->when($rfq_no, function ($query) use ($rfq_no) {
        //                         $query->where('request_no', $rfq_no);
        //                     });
        //             });
        //     })
        //     ->get();

        //3
        $datas = Materials::with(['inventorys', 'invQurtsDetail.materialsRequest', 'invQurtsDetail.quotes'])
            ->where('company_id', $companyId)
            ->whereHas('invQurtsDetail', function ($mrQuery) use ($from_date, $to_date, $prepared_by, $rfq_no, $project, $subproject, $companyId) {
                $mrQuery->whereHas('materialsRequest', function ($mr) use ($from_date, $to_date, $prepared_by, $rfq_no, $project, $subproject, $companyId) {
                    $mr->where('status', 1);
                });
                $mrQuery->whereHas('quotes', function ($quotesQuery) use ($from_date, $to_date, $prepared_by, $project, $companyId) {
                    $quotesQuery->where('company_id', $companyId)
                        ->when($project, function ($query) use ($project) {
                            $query->where('projects_id', $project);
                        })
                        ->when($prepared_by, function ($query) use ($prepared_by) {
                            $query->where('user_id', $prepared_by);
                        })
                        ->when($from_date && $to_date, function ($query) use ($from_date, $to_date) {
                            $query->whereBetween('date', [$from_date, $to_date]);
                        });
                })->when($rfq_no, function ($query) use ($rfq_no) {
                    $query->where('request_no', $rfq_no);
                });
            })
            ->get();

        // dd($datas);
        foreach ($datas as $key => $mat) {
            // dd($mat->invQurtsDetail->first()->request_qty);
            $material[$key]['sl_no'] = $key + 1;
            $material[$key]['code'] = $mat?->code;
            $material[$key]['name'] = $mat?->name;
            $material[$key]['specification'] = $mat?->specification !== null && $mat?->specification !== 'NULL' ? $mat?->specification ?? '' : '';
            $material[$key]['unit'] = $mat?->units?->unit;
            $material[$key]['required_qty'] = $mat?->invQurtsDetail?->first()?->request_qty ?? 0;
            $material[$key]['required_date'] = $mat?->invQurtsDetail?->first()?->date ?? 0;
            $material[$key]['quote_rate'] = $mat?->invQurtsDetail?->first()?->price ?? 0;
        }
        return compact('material');
    }
    // ***********************************************************************************************
    public function inventoryProjectStock(Request $request)
    {
        $material = [];
        $assets = [];
        $authCompany = Auth::guard('company')->user();
        $companyId = searchCompanyId($authCompany->id);
        $project = $request->project;
        $store = $request->store;
        // $search = $request->search;
        // $date = $request->date;
        $type = $request->type;
        $datas = Inventory::with(['inventoryStore', 'materials', 'assets', 'projects.invInward.invInwardGood.InvInwardGoodDetails', 'projects.invIssues.invIssueGoods.invIssueDetails'])
            ->where('projects_id', $project)
            ->where('company_id', $companyId)
            ->whereHas('inventoryStore', function ($q) use ($store) {
                $q->where('store_warehouses_id', $store);
            })
            ->get();
        // dd($datas);
        foreach ($datas as $key => $matast) {

            // dd($matast->materials?->units->unit);
            if ($matast->type == 'machines') {
                $totalInwardAssets = getTotalInwardQtyAssets($matast->assets?->id, $project, $companyId);
                $totalIssueAssets = getTotalIssueQtyAssets($matast->assets?->id, $project, $companyId);
                $assets[$key]['sl_no'] = $key + 1;
                $assets[$key]['code'] = $matast->assets?->code;
                $assets[$key]['name'] = $matast->assets?->name;
                $assets[$key]['specification'] = $matast->assets?->specification !== null && $matast->assets?->specification !== 'NULL' ? $matast->assets?->specification : '';
                $assets[$key]['unit'] = $matast->assets?->units->unit;
                $assets[$key]['total_inward'] = $totalInwardAssets ?? 0;
                $assets[$key]['total_issue'] = $totalIssueAssets ?? 0;
                $assets[$key]['available_stock'] = $matast->total_qty;
            } else {
                $totalInward = getTotalInwardQty($matast->materials?->id, $project, $companyId);
                $totalIssue = getTotalIssueQty($matast->materials?->id, $project, $companyId);
                $material[$key]['sl_no'] = $key + 1;
                $material[$key]['code'] = $matast->materials?->code;
                $material[$key]['class'] = $matast->materials?->class;
                $material[$key]['name'] = $matast->materials?->name;
                $material[$key]['specification'] = $matast->materials?->specification !== null && $matast->materials?->specification !== 'NULL' ? $matast->materials?->specification : '';
                $material[$key]['unit'] = $matast->materials?->units?->unit ?? '';
                $material[$key]['total_inward'] = $totalInward ?? 0;
                $material[$key]['total_issue'] = $totalIssue ?? 0;
                $material[$key]['available_stock'] = $matast->total_qty;
            }
        }
        return compact('assets', 'material');
    }
    // ***********************************************************************************************
    public function inventoryGlobalProjectStock(Request $request)
    {
        $material = [];
        $assets = [];
        $authCompany = Auth::guard('company')->user();
        $companyId = searchCompanyId($authCompany->id);
        $type = $request->type;
        $datas = Inventory::with(['materials', 'assets', 'projects'])
            ->where('company_id', $companyId)
            ->get();
        foreach ($datas as $key => $matast) {
            // dd($matast->materials?->units->unit);
            if ($matast->type == 'machines') {
                $assets[$key]['sl_no'] = $key + 1;
                $assets[$key]['code'] = $matast->assets?->code;
                $assets[$key]['name'] = $matast->assets?->name;
                $assets[$key]['specification'] = $matast->assets?->specification !== null && $matast->assets?->specification !== 'NULL' ? $matast->assets?->specification ?? '' : '';
                $assets[$key]['unit'] = $matast->assets?->units->unit ?? '';
                $assets[$key]['project'] = $matast->projects->project_name ?? '';
                $assets[$key]['total_inward'] = $matast->total_qty;
            } else {
                $material[$key]['sl_no'] = $key + 1;
                $material[$key]['code'] = $matast->materials?->code;
                $material[$key]['name'] = $matast->materials?->name;
                $material[$key]['specification'] = $matast->materials?->specification !== null && $matast->materials?->specification !== 'NULL' ? $matast->materials?->specification ?? '' : '';
                $material[$key]['unit'] = $matast->materials?->units?->unit ?? '';
                $material[$key]['project'] = $matast->projects?->project_name ?? '';
                $material[$key]['total_inward'] = $matast->total_qty;
            }
        }
        return compact('assets', 'material');
    }
    // ***********************************************************************************************
    public function inventoryIssueReturn(Request $request)
    {
        // dd($request->all());
        $material = [];
        $assets = [];
        $authCompany = Auth::guard('company')->user();
        $companyId = searchCompanyId($authCompany->id);
        $project = $request->project;
        $store = $request->store;
        $search = $request->search;
        $entry_type = $request->entry_type;
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $type = $request->type;
        $datas = InvReturnsDetails::with('invReturnGood.invIssueList', 'invReturnGood.invReturn', 'materials', 'assets')->where('company_id', $companyId)
            ->whereHas('invReturnGood', function ($invretgd) use ($request, $type, $entry_type, $companyId) {
                // $invretgd->where('type', $type);
                $invretgd->when($type, function ($q) use ($type) {
                    return $q->where('type', $type);
                })
                    ->when($entry_type, function ($q) use ($entry_type) {
                    return $q->where('inv_issue_lists_id', $entry_type);
                });
                $invretgd->whereHas('invReturn', function ($invret) use ($request, $companyId) {
                    $invret->where('projects_id', $request->project)->where('company_id', $companyId)
                        ->whereHas('InvReturnStore', function ($invstore) use ($request) {
                            $invstore->where('store_warehouses_id', $request->store)
                                ->whereBetween('date', [$request->from_date, $request->to_date]);
                        });
                });
            })->get();
        $datas = collect($datas)->each(function ($querys) {
            $querys->invReturnGood->invIssueList;
        });
        // dd(  $datas->toArray() );
        // ->when($userId, function ($q) use ($userId) {
        //     return $q->where('user_id',  $userId);
        // })
        // $datas = Inventory::with(['materials', 'assets', 'projects'])
        //     ->where('company_id', $companyId)
        //     ->get();
        foreach ($datas as $key => $matast) {
            //     // dd($matast->materials?->units->unit);
            $issueTo = (!empty($entry_type) && !empty($matast?->invReturnGood->tag_id)) ? issueTagFinder($matast?->invReturnGood?->tag_id, $entry_type) : null;
            // dd($matast?->stock_qty);
            if ($matast->type == 'machines') {
                $assets[$key]['return_no'] = $matast->invReturnGood->return_no;
                $assets[$key]['date'] = $matast->invReturnGood?->invReturn?->date;
                $assets[$key]['code'] = $matast->assets?->code;
                $assets[$key]['name'] = $matast->assets?->name;
                $assets[$key]['specification'] = $matast->assets?->specification !== null && $matast->assets?->specification !== 'NULL' ? $matast->assets?->specification ?? '' : '';
                $assets[$key]['unit'] = $matast->assets->units->unit ?? '';
                $assets[$key]['entry_by'] = $matast->invReturnGood->invReturn->users->name;
                $assets[$key]['return_qty'] = $matast->return_qty;
                $assets[$key]['stock_qty'] = ($matast?->stock_qty - $matast?->return_qty) ?? '';
                $assets[$key]['issue_to'] = $issueTo?->name ?? $issueTo?->project_name ?? '';
            } else {
                $assets[$key]['return_no'] = $matast->invReturnGood->return_no;
                $assets[$key]['date'] = $matast->invReturnGood?->invReturn?->date;
                $assets[$key]['code'] = $matast->materials?->code;
                $assets[$key]['name'] = $matast->materials?->name;
                $assets[$key]['specification'] = $matast->materials?->specification !== null && $matast->materials?->specification !== 'NULL' ? $matast->materials?->specification ?? '' : '';
                $assets[$key]['unit'] = $matast->materials->units->unit ?? '';
                $assets[$key]['entry_by'] = $matast->invReturnGood->invReturn->users->name;
                $assets[$key]['return_qty'] = $matast->return_qty;
                $assets[$key]['stock_qty'] = ($matast?->stock_qty - $matast?->return_qty) ?? '';
                $assets[$key]['issue_to'] = $issueTo?->name ?? $issueTo?->project_name ?? '';
            }
        }
        // dd($assets);
        return compact('assets');
    }
    // ***********************************************************************************************
    public function inventoryIssueReturnDetails(Request $request)
    {
        // dd($request->all());
        $material = [];
        $assets = [];
        $authCompany = Auth::guard('company')->user();
        $companyId = searchCompanyId($authCompany->id);
        $project = $request->project;
        $store = $request->store;
        $search = $request->search;
        $entry_type = $request->entry_type;
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $type = $request->type;
        $datas = InvIssuesDetails::with('InvIssueGood.invIssueList', 'InvIssueGood.invIssue', 'materials', 'assets')->where('company_id', $companyId)
            ->whereHas('InvIssueGood', function ($invretgd) use ($request, $type, $entry_type, $companyId) {
                // $invretgd->where('type', $type);
                $invretgd->when($type, function ($q) use ($type) {
                    return $q->where('type', $type);
                });
                // ->when($entry_type, function ($q) use ($entry_type) {
                //     return $q->where('tag_id',  $entry_type);
                // });
                $invretgd->whereHas('invIssue', function ($invret) use ($request, $companyId) {
                    $invret->where('projects_id', $request->project)->where('company_id', $companyId)
                        ->whereHas('InvIssueStore', function ($invstore) use ($request) {
                            $invstore->where('store_warehouses_id', $request->store)
                                ->whereBetween('date', [$request->from_date, $request->to_date]);
                        });
                });
            })
            ->get();
        $datas = collect($datas)->each(function ($querys) {
            $querys->InvIssueGood->invIssueList;
        });
        foreach ($datas as $key => $matast) {
            $issueTo = (!empty($entry_type) && !empty($matast->InvIssueGood->tag_id)) ? issueTagFinder($matast->InvIssueGood->tag_id, $entry_type) : null;
            $issueto = $issueTo?->name ?? $issueTo?->project_name;

            if ($matast->type == 'machines') {
                $assets[$key]['issue_no'] = $matast->InvIssueGood->issue_no;
                $assets[$key]['date'] = $matast->InvIssueGood?->invIssue?->date;
                $assets[$key]['code'] = $matast->assets?->code;
                $assets[$key]['name'] = $matast->assets?->name;
                $assets[$key]['specification'] = $matast->assets?->specification !== null && $matast->assets?->specification !== 'NULL' ? $matast->assets?->specification ?? '' : '';
                $assets[$key]['unit'] = $matast->assets->units->unit ?? '';
                $assets[$key]['issue_qty'] = $matast->issue_qty;
                $assets[$key]['activites'] = $matast->activites?->activities ?? '';
                $assets[$key]['issue_by'] = $matast->InvIssueGood->invIssue->users->name;
                $assets[$key]['issue_to'] = $issueto;
            } else {
                $assets[$key]['issue_no'] = $matast->InvIssueGood->issue_no;
                $assets[$key]['date'] = $matast->InvIssueGood?->invIssue?->date;
                $assets[$key]['code'] = $matast->materials?->code;
                $assets[$key]['name'] = $matast->materials?->name;
                $assets[$key]['specification'] = $matast->materials?->specification !== null && $matast->materials?->specification !== 'NULL' ? $matast->materials?->specification ?? '' : '';
                $assets[$key]['unit'] = $matast->materials->units->unit ?? '';
                $assets[$key]['issue_qty'] = $matast->issue_qty;
                $assets[$key]['activites'] = $matast->activites?->activities ?? '';
                $assets[$key]['issue_by'] = $matast->InvIssueGood->invIssue->users->name;
                $assets[$key]['issue_to'] = $issueto;
            }
        }
        // dd($assets);
        return compact('assets');
    }
    // ***********************************************************************************************
    public function inventoryIssueSlip(Request $request)
    {
        // dd($request->all());
        $material = [];
        $assets = [];
        $authCompany = Auth::guard('company')->user();
        $companyId = searchCompanyId($authCompany->id);
        $project = $request->project;
        $store = $request->store;
        $search = $request->search;
        $entry_type = $request->entry_type;
        $from_date = $request->from_date;
        // $to_date = $request->to_date;
        $type = $request->type;
        $datas = InvIssuesDetails::with('InvIssueGood.invIssueList', 'InvIssueGood.invIssue', 'materials', 'assets')->where('company_id', $companyId)
            ->whereHas('InvIssueGood', function ($invretgd) use ($request, $type, $entry_type, $companyId) {
                // $invretgd->where('type', $type);
                $invretgd->when($type, function ($q) use ($type) {
                    return $q->where('type', $type);
                });

                $invretgd->when($entry_type, function ($q) use ($entry_type) {
                    return $q->where('inv_issue_lists_id', $entry_type);
                });

                $invretgd->whereHas('invIssue', function ($invret) use ($request, $companyId) {
                    $invret->where('projects_id', $request->project)->where('company_id', $companyId)
                        ->whereHas('InvIssueStore', function ($invstore) use ($request) {
                            $invstore->where('store_warehouses_id', $request->store);
                        })->where('date', $request->from_date);
                });
            })
            ->get();
        $datas = collect($datas)->each(function ($querys) {
            $querys->InvIssueGood->invIssueList;
        });
        // dd($datas->toArray());
        foreach ($datas as $key => $matast) {
            $issueTo = (!empty($entry_type) && !empty($matast->InvIssueGood->tag_id)) ? issueTagFinder($matast->InvIssueGood->tag_id, $entry_type) : null;
            $issueto = $issueTo?->name ?? $issueTo?->project_name;
            // dd($issueto);
            if ($matast->type == 'machines') {
                $assets[$key]['issue_no'] = $matast->InvIssueGood->issue_no;
                $assets[$key]['date'] = $matast->InvIssueGood?->invIssue?->date;
                $assets[$key]['code'] = $matast->assets?->code;
                $assets[$key]['name'] = $matast->assets?->name;
                $assets[$key]['specification'] = $matast->assets?->specification !== null && $matast->assets?->specification !== 'NULL' ? $matast->assets?->specification ?? '' : '';
                $assets[$key]['unit'] = $matast->assets->units->unit ?? '';
                $assets[$key]['issue_qty'] = $matast->issue_qty;
                $assets[$key]['activites'] = $matast->activites?->activities ?? '';
                $assets[$key]['issue_by'] = $matast->InvIssueGood->invIssue->users->name;
                $assets[$key]['issue_to'] = $issueto;
            } else {
                $assets[$key]['issue_no'] = $matast->InvIssueGood->issue_no;
                $assets[$key]['date'] = $matast->InvIssueGood?->invIssue?->date;
                $assets[$key]['code'] = $matast->materials?->code;
                $assets[$key]['name'] = $matast->materials?->name;
                $assets[$key]['specification'] = $matast->materials?->specification !== null && $matast->materials?->specification !== 'NULL' ? $matast->materials?->specification ?? '' : '';
                $assets[$key]['unit'] = $matast->materials->units->unit ?? '';
                $assets[$key]['issue_qty'] = $matast->issue_qty;
                $assets[$key]['activites'] = $matast->activites?->activities ?? '';
                $assets[$key]['issue_by'] = $matast->InvIssueGood->invIssue->users->name;
                $assets[$key]['issue_to'] = $issueto;
            }
        }
        // dd($assets);
        return compact('assets');
    }
    // ***********************************************************************************************
    public function inventoryGrnDetails(Request $request)
    {
        // dd($request->all());
        $material = [];
        $assets = [];
        $authCompany = Auth::guard('company')->user();
        $companyId = searchCompanyId($authCompany->id);
        $project = $request->project;
        $store = $request->store;
        $search = $request->search;
        $supplier = $request->supplier;
        $entry_type = $request->entry_type;
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $type = $request->type;
        $datas = InwardGoodsDetails::with('InvInwardGood.entryType', 'InvInwardGood.vendores', 'InvInwardGood.InvInward', 'materials', 'assets')->where('company_id', $companyId)
            ->whereHas('InvInwardGood', function ($invretgd) use ($request, $type, $entry_type, $companyId, $supplier, $from_date, $to_date) {
                $invretgd->when($type, function ($q) use ($type) {
                    return $q->where('type', $type);
                });
                $invretgd->whereHas('InvInward', function ($invret) use ($request, $companyId, $from_date, $to_date) {
                    $invret->where('projects_id', $request->project)->where('company_id', $companyId)
                        ->whereHas('InvInwardStore', function ($invstore) use ($request) {
                            $invstore->where('store_warehouses_id', $request->store);
                        })->whereBetween('date', [$from_date, $to_date]);
                });
                $invretgd->when($supplier, function ($q) use ($supplier) {
                    return $q->where('vendor_id', $supplier);
                });
                $invretgd->when($entry_type, function ($q) use ($entry_type) {
                    return $q->where('inv_inward_entry_types_id', $entry_type);
                });
            })
            ->get();
        $datas = collect($datas)->each(function ($querys) {
            $querys->InvInwardGood->entryType;
        });
        // dd($datas->toArray());
        foreach ($datas as $key => $matast) {
            if ($matast->type == 'machines') {
                $assets[$key]['grn_no'] = $matast->InvInwardGood->grn_no;
                $assets[$key]['date'] = $matast->InvInwardGood?->InvInward?->date;
                $assets[$key]['code'] = $matast->assets?->code;
                $assets[$key]['name'] = $matast->assets?->name;
                $assets[$key]['specification'] = $matast->assets?->specification !== null && $matast->assets?->specification !== 'NULL' ? $matast->assets?->specification ?? '' : '';
                $assets[$key]['unit'] = $matast->assets->units->unit ?? '';
                $assets[$key]['receipt_qty'] = $matast->recipt_qty ?? 0;
                $assets[$key]['reject_qty'] = $matast->reject_qty ?? 0;
                $assets[$key]['accepted_qty'] = $matast->accept_qty ?? 0;
                $assets[$key]['rate'] = $matast?->price ?? 0.0;
                $assets[$key]['amount'] = ($matast->accept_qty * $matast?->price) ?? 0.0;
                $assets[$key]['po_qty'] = $matast->po_qty ?? 0;
                $assets[$key]['po_balance'] = $matast?->inventorys?->po_qty ?? 0.0;
                $assets[$key]['remarks'] = $matast->remarkes;
            } else {
                $assets[$key]['grn_no'] = $matast->InvInwardGood->grn_no;
                $assets[$key]['date'] = $matast->InvInwardGood?->InvInward?->date;
                $assets[$key]['code'] = $matast->materials?->code;
                $assets[$key]['name'] = $matast->materials?->name;
                $assets[$key]['specification'] = $matast->materials?->specification !== null && $matast->materials?->specification !== 'NULL' ? $matast->materials?->specification ?? '' : '';
                $assets[$key]['unit'] = $matast->materials->units->unit ?? '';
                $assets[$key]['receipt_qty'] = $matast->recipt_qty ?? 0;
                $assets[$key]['reject_qty'] = $matast->reject_qty ?? 0;
                $assets[$key]['accepted_qty'] = $matast->accept_qty ?? 0;
                $assets[$key]['rate'] = $matast?->price ?? 0.0;
                $assets[$key]['amount'] = ($matast->accept_qty * $matast?->price) ?? 0.0;
                $assets[$key]['po_qty'] = $matast->po_qty ?? 0;
                $assets[$key]['po_balance'] = $matast?->inventorys?->po_qty ?? 0.0;
                $assets[$key]['remarks'] = $matast->remarkes;
            }
        }
        // dd($assets);
        return compact('assets');
    }
    // ***********************************************************************************************
    public function inventoryGrnSlips(Request $request)
    {
        // dd($request->all());
        $material = [];
        $assets = [];
        $authCompany = Auth::guard('company')->user();
        $companyId = searchCompanyId($authCompany->id);
        $project = $request->project;
        $store = $request->store;
        $search = $request->search;
        $supplier = $request->supplier;
        $entry_type = $request->entry_type;
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $type = $request->type;
        // dd($entry_type);
        $datas = InwardGoodsDetails::with('InvInwardGood.entryType', 'InvInwardGood.vendores', 'InvInwardGood.InvInward', 'materials', 'assets')->where('company_id', $companyId)
            ->whereHas('InvInwardGood', function ($invretgd) use ($request, $search, $type, $entry_type, $companyId, $supplier, $from_date) {
                $invretgd->whereHas('InvInward', function ($invret) use ($request, $companyId, $from_date) {
                    $invret->where('projects_id', $request->project)->where('company_id', $companyId)
                        ->whereHas('InvInwardStore', function ($invstore) use ($request) {
                            $invstore->where('store_warehouses_id', $request->store);
                        })->when($from_date, function ($q) use ($from_date) {
                            return $q->where('date', $from_date);
                        });
                });
                $invretgd->when($supplier, function ($q) use ($supplier) {
                    return $q->where('vendor_id', $supplier);
                });
                $invretgd->when($type, function ($q) use ($type) {
                    return $q->where('type', $type);
                });
                $invretgd->when($search, function ($q) use ($search) {
                    return $q->where('grn_no', $search)->orWhere('delivery_ref_copy_no', $search);
                });
                $invretgd->when($entry_type, function ($q) use ($entry_type) {
                    return $q->where('inv_inward_entry_types_id', $entry_type);
                });
            })
            ->get();
        $datas = collect($datas)->each(function ($querys) {
            $querys?->InvInwardGood?->entryType;
        });
        // dd($datas);
        foreach ($datas as $key => $matast) {
            // dd($matast);
            if ($matast->type == 'machines') {
                $assets[$key]['sl_no'] = $key + 1;
                $assets[$key]['grn_no'] = $matast->InvInwardGood->grn_no;
                $assets[$key]['date'] = $matast->InvInwardGood?->InvInward?->date;
                $assets[$key]['code'] = $matast->assets?->code;
                $assets[$key]['name'] = $matast->assets?->name;
                $assets[$key]['specification'] = $matast->assets?->specification !== null && $matast->assets?->specification !== 'NULL' ? $matast->assets?->specification ?? '' : '';
                $assets[$key]['unit'] = $matast->assets->units->unit ?? '';
                $assets[$key]['receipt_qty'] = $matast->recipt_qty ?? 0;
                $assets[$key]['reject_qty'] = $matast->reject_qty ?? 0;
                $assets[$key]['accepted_qty'] = $matast->accept_qty ?? 0;
                $assets[$key]['rate'] = $matast?->price ?? 0.0;
                $assets[$key]['amount'] = ($matast->accept_qty * $matast?->price) ?? 0.0;
                $assets[$key]['po_qty'] = $matast?->po_qty ?? 0;
                $assets[$key]['po_balance'] = $matast?->inventorys?->po_qty ?? 0.0;
                $assets[$key]['remarks'] = $matast?->remarkes;
            } else {
                $assets[$key]['sl_no'] = $key + 1;
                $assets[$key]['grn_no'] = $matast->InvInwardGood->grn_no;
                $assets[$key]['date'] = $matast->InvInwardGood?->InvInward?->date;
                $assets[$key]['code'] = $matast->materials?->code;
                $assets[$key]['name'] = $matast->materials?->name;
                $assets[$key]['specification'] = $matast->materials?->specification !== null && $matast->materials?->specification !== 'NULL' ? $matast->materials?->specification ?? '' : '';
                $assets[$key]['unit'] = $matast->materials->units->unit ?? '';
                $assets[$key]['receipt_qty'] = $matast->recipt_qty ?? 0;
                $assets[$key]['reject_qty'] = $matast->reject_qty ?? 0;
                $assets[$key]['accepted_qty'] = $matast->accept_qty ?? 0;
                $assets[$key]['rate'] = $matast?->price ?? 0.0;
                $assets[$key]['amount'] = ($matast->accept_qty * $matast?->price) ?? 0.0;
                $assets[$key]['po_qty'] = $matast?->po_qty ?? 0;
                $assets[$key]['po_balance'] = $matast?->inventorys?->po_qty ?? 0.0;
                $assets[$key]['remarks'] = $matast->remarkes;
            }
        }
        // dd($assets);
        return compact('assets');
    }
    // *************************************************************************************************
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
    // *************************************************************************************************
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
    // *************************************************************************************************
    // *************************************************************************************************
    // *************************************************************************************************
    // *************************************************************************************************
    // *************************************************************************************************
    public function labourStrengthreport(Request $request)
    {
        $authCompany = Auth::guard('company')->user();
        $companyId = $this->searchCompanyId($authCompany->id);
        $project = $request->project;
        $subproject = $request->subproject;
        $from_date = $request->from_date;
        $to_date = $request->to_date;

        // Fetch LabourHistory with related models and filter by project, subproject, and date if provided
        $query = LabourHistory::with(['dpr.projects', 'dpr.subProjects', 'vendors', 'activities', 'labours'])
            ->where('company_id', $companyId);

        if ($project) {
            $query->whereHas('dpr', function ($q) use ($project) {
                $q->where('projects_id', $project);
            });
        }
        if ($subproject) {
            $query->whereHas('dpr', function ($q) use ($subproject) {
                $q->where('sub_projects_id', $subproject);
            });
        }
        if ($from_date) {
            $query->whereHas('dpr', function ($q) use ($from_date) {
                $q->when('date', $from_date);
            });
        }

        $labourHistories = $query->get();

        // Group by vendor and summarize labour strength
        $vendorWiseLabour = [];
        foreach ($labourHistories as $history) {
            $vendorId = $history->vendors?->id ?? 0;
            if (!isset($vendorWiseLabour[$vendorId])) {
                $vendorWiseLabour[$vendorId] = [
                    'vendor' => $history->vendors,
                    'labour_count' => 0,
                    'labour_details' => [],
                ];
            }
            $vendorWiseLabour[$vendorId]['labour_count'] += ($history->qty ?? 0) + ($history->ot_qty ?? 0);
            $vendorWiseLabour[$vendorId]['labour_details'][] = [
                'labour' => $history->labours,
                'qty' => $history->qty,
                'ot_qty' => $history->ot_qty,
                'date' => $history->dpr?->date,
                'activity' => $history->activities?->activities,
            ];
        }

        // Prepare summary
        $totalLabourCount = $labourHistories->sum(function ($item) {
            return ($item->qty ?? 0) + ($item->ot_qty ?? 0);
        });

        return [
            'totalLabourCount' => $totalLabourCount,
            'vendorWiseLabour' => array_values($vendorWiseLabour),
        ];
    }

    // *************************************************************************************************
    public function setStatus(Request $request)
    {
        // dd($request);
        if ($request->ajax()) {
            $table = $request->find;
            $data = $request->value;
            //  $id = uuidtoid($request->uuid, $table);
            switch ($table) {
                case 'users':
                    $id = uuidtoid($request->uuid, $table);
                    $data = User::where('id', $id)->update(['is_active' => $request->is_active]);
                    $message = 'Users Status updated';
                    break;
                case 'admin_roles':
                    $id = $request->uuid;
                    $data = AdminRole::where('id', $id)->update(['is_active' => $request->is_active]);
                    $message = 'Role Status updated';
                    break;
                case 'company_managments':
                    $id = uuidtoid($request->uuid, $table);
                    $data = CompanyManagment::where('id', $id)->update(['is_active' => $request->is_active]);
                    $message = 'Company Managment Status updated';
                    break;
                case 'page_managments':
                    $id = uuidtoid($request->uuid, $table);
                    $data = PageManagment::where('id', $id)->update(['is_active' => $request->is_active]);
                    $message = 'page Managment Status updated';
                    break;
                case 'home_pages':
                    $id = uuidtoid($request->uuid, $table);
                    $data = HomePage::where('id', $id)->update(['is_active' => $request->is_active]);
                    $message = 'Section Status updated';
                    break;
                case 'banner_pages':
                    $id = uuidtoid($request->uuid, $table);
                    $data = BannerPage::where('id', $id)->update(['is_active' => $request->is_active]);
                    $message = 'Page Status updated';
                    break;
                case 'menu_managments':
                    $id = uuidtoid($request->uuid, $table);
                    $data = MenuManagment::where('id', $id)->update(['is_active' => $request->is_active]);
                    $message = 'Menu Status updated';
                    break;
                case 'subscription_packages':
                    $id = uuidtoid($request->uuid, $table);
                    $data = SubscriptionPackage::where('id', $id)->update(['is_active' => $request->is_active]);
                    $message = 'Subscription Package Status updated';
                    break;
                case 'company_users':
                    $id = uuidtoid($request->uuid, $table);
                    $data = CompanyUser::where('id', $id)->update(['is_active' => $request->is_active]);
                    $message = 'Users Status updated';
                    break;
                case 'labours':
                    $id = uuidtoid($request->uuid, $table);
                    $data = Labour::where('id', $id)->update(['is_active' => $request->is_active]);
                    $message = 'Labour Status updated';
                    break;
                case 'assets':
                    $id = uuidtoid($request->uuid, $table);
                    $data = Assets::where('id', $id)->update(['is_active' => $request->is_active]);
                    $message = 'Assets Status updated';
                    break;
                case 'vendors':
                    $id = uuidtoid($request->uuid, $table);
                    $data = Vendor::where('id', $id)->update(['is_active' => $request->is_active]);
                    $message = 'Vendor Status updated';
                    break;
                case 'opening_stocks':
                    $id = uuidtoid($request->uuid, $table);
                    $data = OpeningStock::where('id', $id)->update(['is_active' => $request->is_active]);
                    $message = 'Opening Stock Status updated';
                    break;
                case 'assets_opening_stocks':
                    $id = uuidtoid($request->uuid, $table);
                    $data = AssetsOpeningStock::where('id', $id)->update(['is_active' => $request->is_active]);
                    $message = 'Assets Opening Stock Status updated';
                    break;
                default:
                    return $this->responseJson(false, 200, 'Something Wrong Happened');
            }
            if ($data) {
                return $this->responseJson(true, 200, $message);
            } else {
                return $this->responseJson(false, 200, 'Something Wrong Happened');
            }
        }
        abort(405);
    }
    // *************************************************************************************************

    public function companyCustomeUpdateStatus(Request $request)
    {
        if ($request->ajax()) {
            $title = $request->title;
            $table = $request->find;
            // dd($request->status);
            switch ($title) {
                case 'pr_status':
                    $id = uuidtoid($request->uuid, $table);
                    // dd($id,$request->status);
                    $data = MaterialRequest::where('id', $id)->update(['status' => $request->status]);
                    prManagmentUpdateStatus($id, $request->status);
                    $message = 'Users Status updated';
                    break;
                default:
                    return $this->responseJson(false, 200, 'Something Wrong Happened');
            }
            if ($data) {
                return $this->responseJson(true, 200, $message);
            } else {
                return $this->responseJson(false, 200, 'Something Wrong Happened');
            }
        }
        abort(405);
    }
    // *************************************************************************************************
    public function deleteData(Request $request)
    {
        // dd("dataaa");
        // dd($request->all());

        if ($request->ajax()) {
            $table = $request->find;
            switch ($table) {
                case 'users':
                    $id = uuidtoid($request->uuid, $table);
                    $data = User::where('id', $id)->delete();
                    $message = 'Users Deleted';
                    break;
                case 'admin_roles':
                    $id = $request->uuid;
                    // dd($request->uuid);
                    $data = AdminRole::where('id', $id)->delete();
                    $message = 'Role  Deleted';
                    break;
                case 'company_managments':
                    $id = uuidtoid($request->uuid, $table);
                    $data = CompanyManagment::where('id', $id)->delete();
                    $message = 'Company Managment  Deleted';
                    break;
                case 'company_users':
                    $id = uuidtoid($request->uuid, $table);
                    $data = CompanyUser::where('id', $id)->delete();
                    $message = ' User  Deleted';
                    break;
                case 'page_managments':
                    $id = uuidtoid($request->uuid, $table);
                    $data = pageManagment::where('id', $id)->delete();
                    $message = 'page Managment  Deleted';
                    break;
                case 'menu_managments':
                    $id = uuidtoid($request->uuid, $table);
                    $data = MenuManagment::where('id', $id)->delete();
                    $message = 'Menu Managment  Deleted';
                    break;
                case 'company_roles':
                    $id = $request->getIdType == 'id' ? $request->uuid : uuidtoid($request->uuid, $table);
                    $data = Company_role::where('id', $id)->delete();
                    $message = 'Role Managment  Deleted';
                    break;
                case 'banner_pages':
                    $id = uuidtoid($request->uuid, $table);
                    $data = BannerPage::where('id', $id)->delete();
                    $message = 'Banner Managment  Deleted';
                    break;
                case 'subscription_packages':
                    $id = uuidtoid($request->uuid, $table);
                    $subscription = SubscriptionPackage::find($id);
                    if ($subscription->company == null) {
                        $data = $subscription->delete();
                        $message = 'Subscription Package Deleted';
                    } else {
                        $message = 'Subscription Package has an associated company, cannot delete';
                    }
                    break;
                // **************************Company Managment*****************************************************************
                case 'companies':
                    $id = uuidtoid($request->uuid, $table);
                    $data = Companies::where('id', $id)->delete();
                    $message = 'Companies Managment  Deleted';
                    break;
                case 'projects':
                    $id = uuidtoid($request->uuid, $table);
                    $data = Project::where('id', $id)->delete();
                    $message = 'Project Managment  Deleted';
                    break;
                case 'company_project_permissions':
                    // dd($request->all());
                    $id = $request->uuid;
                    $data = CompanyProjectPermission::where('id', $id)->delete();
                    $message = 'Project Permission Managment  Deleted';
                    break;
                case 'sub_projects':
                    $id = uuidtoid($request->uuid, $table);
                    $data = SubProject::where('id', $id)->delete();
                    $message = 'Sub-Project Managment  Deleted';
                    break;
                case 'store_warehouses':
                    $id = uuidtoid($request->uuid, $table);
                    $data = StoreWarehouse::where('id', $id)->delete();
                    $message = 'Store/Warehouses Managment  Deleted';
                    break;
                case 'labours':
                    $id = uuidtoid($request->uuid, $table);
                    $data = Labour::where('id', $id)->delete();
                    $message = 'Labour Managment  Deleted';
                    break;
                case 'units':
                    $id = uuidtoid($request->uuid, $table);
                    $data = Unit::where('id', $id)->delete();
                    $message = 'Labour Managment  Deleted';
                    break;
                case 'assets':
                    $id = uuidtoid($request->uuid, $table);
                    $data = Assets::where('id', $id)->delete();
                    $message = 'Assets Managment  Deleted';
                    break;
                case 'vendors':
                    $id = uuidtoid($request->uuid, $table);
                    $data = Vendor::where('id', $id)->delete();
                    $message = 'Vendor Managment  Deleted';
                    break;
                case 'opening_stocks':
                    $id = uuidtoid($request->uuid, $table);
                    $data = OpeningStock::where('id', $id)->delete();
                    $message = 'Opening Stock Managment  Deleted';
                    break;
                case 'assets_opening_stocks':
                    $id = uuidtoid($request->uuid, $table);
                    $data = AssetsOpeningStock::where('id', $id)->delete();
                    $message = 'Assets Opening Stock Managment  Deleted';
                    break;
                case 'activities':
                    $id = $request->uuid;
                    $dataType = $request->dataType;
                    // dd($id);
                    if ($dataType === "activities") {
                        $data = Activities::where('id', $id)->delete();
                    } elseif ($dataType == 'subheading') {
                        $subheading = Activities::where('parent_id', $id)->get();
                        $data = Activities::where('id', $id)->delete();
                        foreach ($subheading as $deleteData) {
                            $data = Activities::where('id', $deleteData->id)->delete();
                        }
                    } elseif ($dataType == 'heading') {
                        $heading = Activities::where('parent_id', $id)->get();
                        if (empty($heading) || $heading == null || count($heading) == 0) {
                            // dd($id);
                            $data = Activities::where('id', $id)->delete();
                        } else {
                            Activities::where('id', $id)->delete();
                            foreach ($heading as $deleteData) {
                                $subHeadingId = Activities::where('parent_id', $deleteData->id)->get();
                                $data = Activities::where('id', $deleteData->id)->delete();
                                foreach ($subHeadingId as $deleteData) {
                                    $data = Activities::where('id', $deleteData->id)->delete();
                                    // dd($subHeadingId->toArray());
                                }
                            };
                        }
                    }
                    $message = 'Activities  Deleted';
                    break;
                case 'materials':
                    $id = uuidtoid($request->uuid, $table);
                    $data = Materials::where('id', $id)->delete();
                    $message = 'Materials  Deleted';
                    break;
                case 'material_opening_stocks':
                    $id = uuidtoid($request->uuid, $table);
                    $data = MaterialOpeningStock::where('id', $id)->delete();
                    $message = 'Materials Opening Stock  Deleted';
                    break;
            }
            if (isset($data)) {
                return $this->responseJson(true, 200, $message);
            } else {
                $err_message = $message ? $message : "We are facing some technical issue now. Please try again after some time";
                return $this->responseJson(false, 500, $err_message);
            }
        } else {
            abort(405);
        }
    }
    // *************************************************************************************************
    // public function subscriptionAdd(Request $request)
    // {
    //     $authCompany = Auth::guard('company')->user();
    //     $companyId = searchCompanyId($authCompany->id);
    //     $date = Carbon::now()->format('Y-m-d');
    //     $id = uuidtoid($request->uuid, 'subscription_packages');
    //     $fetchSubscription = SubscriptionPackage::where('id', $id)->first();
    //     dd($fetchSubscription);
    // }
    // *************************************************************************************************


    public function getPrDetails(Request $request)
    {
        $authCompany = Auth::guard('company')->user()->company_id;
        // dd($authCompany);
        $datas = MaterialRequest::with('materialRequest.materials', 'materialRequest.activites', 'materialRequestDetails')->where('company_id', $authCompany)->where('id', $request->id)->first();
        return $datas;
        // dd($datas);
        // $fetchPrDetails=MaterialRequestDetails::where()->get();
    }
    // *************************************************************************************************
    // materialOpeningStock


    public function materialOpeningStock(Request $request)
    {
        $authCompany = Auth::guard('company')->user()->company_id;
        $fethchOpeningStock = MaterialOpeningStock::where('company_id', $authCompany)->where('project_id', $request->project)
            ->orWhere('store_id', $request->store)->get();
        // dd($fethchOpeningStock);
        // $fetchPrDetails=MaterialRequestDetails::where()->get();
        return $fethchOpeningStock;
    }
}
