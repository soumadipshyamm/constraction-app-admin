<?php

namespace App\Http\Controllers\API\dashboard;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\InvInward;
use Faker\Provider\Base;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DashboardController extends BaseController
{
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
        $data['estimatedCost'] = number_format($estimatedCost,2);
        $data['estimatedCostForExecutedQty'] = number_format($estimatedCostForExecutedQty,2);
        $data['balanceEstimate'] = number_format((($estimatedCost - $estimatedCostForExecutedQty) > 0 ? ($estimatedCost - $estimatedCostForExecutedQty) : 0),2);
        $data['excessEstimateCost'] = number_format((($estimatedCost - $estimatedCostForExecutedQty) < 0 ? ($estimatedCost - $estimatedCostForExecutedQty) : 0),2);

        $data['totalActivites'] = $projectWiseDpr['totalActivites'];
        $data['inProgress'] = $projectWiseDpr['inProgress'];
        $data['notStart'] = $projectWiseDpr['notStart'];
        $data['completed'] = $projectWiseDpr['completed'];

        $data['totalDuration'] = number_format($timelineProgress['totalDuration'],2);
        $data['projectcompleted'] = number_format($timelineProgress['projectcompleted'],2);
        $data['remaining'] = number_format($timelineProgress['remaining'],2);
        $data['planeProgress'] = number_format($timelineProgress['planeProgress'],2);
        $data['actualProgress'] = number_format($timelineProgress['actualProgress'],2);
        $data['variation'] = number_format($timelineProgress['variation'],2);

        $data['users'] = $dilyprogessreport['users'];
        $data['fetchDpr'] = $dilyprogessreport['fetchDpr'];

        $data['totalLabourCount'] = $labourStrength['totalLabourCount'];
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
            ['y' =>  $data['estimatedCostForExecutedQty'], 'legendText' => $data['estimatedCostForExecutedQty']],
            ['y' => $data['balanceEstimate'], 'legendText' => $data['balanceEstimate']],
            ['y' => $data['excessEstimateCost'], 'legendText' => $data['excessEstimateCost']]
        ];
        // dd($data);
        return $data;
    }

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

    public function getInwardStocks(Request $request)
    {
        Log::info($request->all());
        $data = [];
        $authCompany = Auth::guard('company')->user()->company_id ?? Auth::guard('company-api')->user()->company_id;
        $fetchData=InvInward::with('invInwardGood.InvInwardGoodDetails','users','projects','InvInwardStore')
        ->where('company_id',$authCompany)
        ->where('date',$request->date)
        ->where('projects_id',$request->project)
        ->WhereHas('InvInwardStore',function($q) use($request){
            $q->where('store_warehouses_id',$request->store);
        })
        ->get();

        // $fetchInInWardGoods= $fetchData->map(function($item){
        //     return $item->invInwardGood->map(function($invGoodDetails){
        //         return $invGoodDetails->InvInwardGoodDetails;
        //     });
        // });

        // $flattenedArray = [];

        // foreach ($fetchInInWardGoods as $outer) {
        //     foreach ($outer as $inner) {
        //         foreach ($inner as $item) {
        //             $flattenedArray[] =  $item;
        //         }
        //     }
        // }

        return $fetchData;
    }
}
