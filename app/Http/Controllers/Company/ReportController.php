<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\API\Dpr;
use App\Models\Company\Activities;
use App\Models\Company\ActivityHistory;
use App\Models\Company\InwardGoods;
use App\Models\Company\LabourHistory;
use App\Models\InvIssueGood;
use App\Models\InvReturn;
use App\Models\InvReturnGood;
use App\Models\MaterialRequest;
use App\Models\MaterialRequestDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ReportController extends BaseController
{
    public function workProgressDetails(Request $request)
    {
        Session::put('work_progress_reports', 'show');
        return view('Company.reports.workProgessDetails');
    }
    // ************************************************************************************************
    public function dprDetails(Request $request, $pid = null, $uid = null, $date = null)
    {
        Session::put('dpr_details_reports', 'show');
        if (!empty($pid) && !empty($uid) && !empty($date)) {
            return view('Company.reports.dprs', compact('pid', 'uid', 'date'));
        }
        return view('Company.reports.dprs');
    }
    // *********************************************************************************************
    public function resourcesUsageFromDPRdetails(Request $request)
    {
        Session::put('work_progress_reports', 'show');
        return view('Company.reports.resourcesUsageFromDPR');
    }
    // *********************************************************************************************
    public function matrialusedVsStoreIssuedetails(Request $request)
    {
        Session::put('work_progress_reports', 'show');
        return view('Company.reports.matrialusedvsStoreIssue');
    }
    // *********************************************************************************************
    public function inventorypr(Request $request)
    {
        Session::put('inventory_reports', 'show');
        return view('Company.reports.pr');
    }
    // *********************************************************************************************
    public function rfq(Request $request)
    {
        Session::put('inventory_reports', 'show');
        return view('Company.reports.rfq');
    }
    // *********************************************************************************************
    public function grnSlip(Request $request)
    {
        Session::put('inventory_reports', 'show');
        return view('Company.reports.grnSlip');
    }
    // *********************************************************************************************
    public function grnDetails(Request $request)
    {
        Session::put('inventory_reports', 'show');
        return view('Company.reports.grnDetails');
    }
    // *********************************************************************************************
    public function issueSlip(Request $request)
    {
        Session::put('inventory_reports', 'show');
        return view('Company.reports.issueSlip');
    }
    // *********************************************************************************************
    public function issueDetails(Request $request)
    {
        Session::put('inventory_reports', 'show');
        return view('Company.reports.issueDetails');
    }
    // *********************************************************************************************
    public function issueReturn(Request $request)
    {
        Session::put('inventory_reports', 'show');
        return view('Company.reports.issueReturn');
    }
    // *********************************************************************************************
    public function globalStockDetails(Request $request)
    {
        Session::put('inventory_reports', 'show');
        return view('Company.reports.globalStockDetails');
    }
    // *********************************************************************************************
    public function stockStatement(Request $request)
    {
        Session::put('inventory_reports', 'show');
        return view('Company.reports.stockStatement');
    }
    // *********************************************************************************************
    public function labourContractor(Request $request)
    {
        Session::put('inventory_reports', 'show');
        return view('Company.reports.labourContractor');
    }
    // *********************************************************************************************
    public function workContractor(Request $request)
    {
        Session::put('inventory_reports', 'show');
        return view('Company.reports.workContractor');
    }
    // *********************************************************************************************
    public function labourStrength(Request $request)
    {
        Session::put('inventory_reports', 'show');
        return view('Company.reports.labourStrength');
    }
    // *********************************************************************************************

}
