<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Company\PrApprovalMember;
use App\Models\Company\PrMemberManagment;
use App\Models\Company\Project;
use App\Models\MaterialRequest;
use Illuminate\Http\Request;

class purchaseRequestController extends BaseController
{
    public function index(Request $request)
    {
        // $datas = MaterialRequest::with('materialRequest', 'materialRequestDetails')->where('company_id', auth()->user()->company_id)->whereHas('materialRequest', function ($q) {
        //     $q->whereNotNull('material_requests_id'); // checking that material_requests_id exists (is not null)
        // })->orderBy('id', 'desc')->get();
        // dd(auth()->user()->companyUserRole);

        $user_id = auth()->user()->id;
        $datas = [];
        if (auth()->user()->companyUserRole->slug == 'super-admin') {
            $datas = MaterialRequest::where('company_id', auth()->user()->company_id)
                ->whereHas('materialRequest', function ($q) {
                    $q->whereNotNull('material_requests_id'); // checking that material_requests_id exists (is not null)
                })
                // ->where('status', 0)
                ->get(); // 1:approved,3:allocation
            //    dd($fetchPrList);
        } else {
            $fetchPrListMaem = PrMemberManagment::where('company_id', auth()->user()->company_id)->where('user_id', $user_id)
                // ->where('is_active',0)
                ->get();
            foreach ($fetchPrListMaem as $key => $value) {
                $levelCheck = (int)$value?->leavel - 1;
                if ($levelCheck !== 0) {
                    $findPrApprovalPreviousLevel = findprApprovalLevelMemebr($value?->material_request_id, $value?->project_id, auth()->user()->company_id, $levelCheck);
                    if (isset($findPrApprovalPreviousLevel)) {
                        $datas[] = MaterialRequest::where('company_id',  auth()->user()->company_id)->where('id', $value?->material_request_id)
                            ->whereHas('materialRequest', function ($q) {
                                $q->whereNotNull('material_requests_id'); // checking that material_requests_id exists (is not null)
                            })
                            // ->where('status', 0)
                            ->first();
                        // dd( $fetchPrList);
                    }
                }
            }
        }

        return view('Company.purchRequest.index', compact('datas'));
    }

    public function details(Request $request, $uuid)
    {
        // dd($uuid);
        $datas = MaterialRequest::with('materialRequest', 'materialRequestDetails')->where('company_id', auth()->user()->company_id)->where('uuid', $uuid)->first();
        // dd($datas);
        return view('Company.purchRequest.material-request-details', compact('datas'));
    }
    // ************************************************************************************************

    public function approvalList(Request $request)
    {
        $datas = PrMemberManagment::where('company_id', auth()->user()->company_id)->get();
        return view('Company.purchRequest.approval.index', compact('datas'));
    }

    // ************************************************************************************************
    public function approvalAdd(Request $request)
    {
        if ($request->isMethod('post')) {
            // dd($request->all());
            $userAllocations = $request->user_alloction; // This is an array of user IDs
            $materialRequestId = $request->material_request_id; // Project Id

            $isCreatedss = [];
            foreach ($userAllocations as $key => $userId) {
                $isCreatedss[] = PrApprovalMember::create([
                    // $isCreatedss[] = PrMemberManagment::create([
                    'company_id' => auth()->user()->company_id,
                    'user_id' => $userId, // Store the individual user ID
                    'leavel' => $key + 1, // Set the leave to the user ID as well
                    // 'material_request_id' => $materialRequestId ?? ''
                    'project_id' => $materialRequestId ?? ''
                ]);
            }
            // dd($isCreatedss);
            return redirect()->route('company.project.list')->with('success', 'Units Updated Successfully');
            // return view('Company.purchRequest.approval.add-edit', compact('isCreated'));
        }
        return view('Company.purchRequest.approval.add-edit');
    }

    public function approvaledit(Request $request, $pid)
    {
        $findProjectApprovalMember = PrApprovalMember::where("project_id", $pid)->where('company_id', auth()->user()->company_id)->get();
        // $findProjectApprovalMember=PrMemberManagment::where("project_id",$pid)->where('company_id',auth()->user()->company_id)->get();
        // dd($findProjectApprovalMember);
        return view('Company.purchRequest.approval.add-edit', compact('pid', 'findProjectApprovalMember'));
    }

    public function approvalsetup(Request $request, $pid)
    {
        return view('Company.purchRequest.approval.add-edit', compact('pid'));
    }
}
