<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\BaseController;
use App\Models\Company\CompanyProjectPermission;
use Illuminate\Http\Request;

class CompanyProjectPermissionController extends BaseController
{
    public function index()
    {
        $company_id = auth()->user()->company_id;
        // dd($company_id);
        $datas = CompanyProjectPermission::where('company_id', $company_id)
            ->orderBy('project_id', 'desc')
            ->get();
        // ->groupBy('project_id');
        // dd($datas->toArray());
        return view('Company.projectPermission.index', compact('datas'));
    }

    public function add(Request $request)
    {
        if ($request->isMethod('post')) {
            // dd($request->all());
            $userAllocations = $request->user_alloction; // This is an array of user IDs
            $projectId = $request->project_id; // Project Id
            $sub_project_id = $request->sub_project_id;
            $isCreatedss = [];
            $company_id = auth()->user()->company_id;
            // dd($userAllocations);
            foreach ($userAllocations as $key => $userId) {
                $isCreatedss[] = CompanyProjectPermission::create([
                    'company_id' => $company_id,
                    'company_user_id' => $userId, // Store the individual user ID
                    'project_id' => $projectId ?? null,
                    'sub_project_id' => $sub_project_id ?? null,
                ]);
            }
            // dd($isCreatedss);
            return redirect()->route('company.projectPermission.list')->with('success', 'Project Permission Updated Successfully');
        }
        return view('Company.projectPermission.approval.add-edit');
    }

    public function edit(Request $request, $pid)
    {
        $findProjectApprovalMember = CompanyProjectPermission::where("project_id", $pid)->where('company_id', auth()->user()->company_id)->get();
        // dd($findProjectApprovalMember);
        return view('Company.projectPermission.approval.add-edit', compact('pid', 'findProjectApprovalMember'));
    }
}
