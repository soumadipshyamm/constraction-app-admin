<?php

namespace App\Http\Controllers\Company;

use App\Exports\Projects\ProjectsExport;
use App\Http\Controllers\BaseController;
use App\Models\Company\Client;
use App\Models\Company\Project;
use App\Models\Company\StoreWarehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class ProjectController extends BaseController
{

    public function index(Request $request)
    {
        Session::put('navbar', 'show');
        $this->setPageTitle('Projects');
        $authConpany = Auth::guard('company')->user()->id;
        $companyId = searchCompanyId($authConpany);
        // dd(Auth::guard('company')->user()->companyUserRole);
        $datas = Project::with('client', 'companys', 'companiesProject', 'members')->where('company_id', $companyId)->where('is_active', 1);
        if (Auth::guard('company')->user()->companyUserRole->slug !== 'super-admin') {
            $datas->whereHas('members', function ($query) use ($authConpany) {
                $query->where('user_id', $authConpany->id);
            });
        }

        if ($request->has('search_keyword')) {
            $datas->Where('project_name', 'LIKE', '%' . $request->search_keyword . '%');
        }
        if ($request->has('project_status')) {
            $datas->Where('project_completed', $request->project_status);
        }
        if ($request->has('search_keyword') || $request->has($request->project_status)) {
            $datas = $datas->where(function ($q) use ($request) {
                $q->Where('project_name', 'LIKE', '%' . $request->search_keyword . '%');
                $q->Where('project_completed', 'LIKE', '%' . $request->project_status . '%');
            });
        }
        $datas = $datas->paginate(10);
        if ($request->ajax()) {
            $datas = $datas->appends($request->all());
            return view('Company.projects.include.project-list', compact('datas'))->render();
        }
        // dd($datas);
        return view('Company.projects.index', compact('datas'));
    }


    public function edit(Request $request, $uuid)
    {
        $id = uuidtoid($uuid, 'projects');
        $data = Project::with('client', 'companys', 'companiesProject')->where('id', $id)->first();
        // dd($data->members);
        if ($data) {
            return view('Company.projects.add-edit', compact('data'));
        }
        return $this->responseJson(false, 200, 'No data found');
    }

    public function export()
    {
        return Excel::download(new ProjectsExport, 'project.xlsx');
    }


    public function add(Request $request)
    {
        $authCompanyId = Auth::guard('company')->user()->id;
        $companyId = searchCompanyId($authCompanyId);

        if ($request->isMethod('post')) {
            // dd($request->all());
            $this->validateRequest($request);

            DB::beginTransaction();
            try {
                $project = $this->createOrUpdateProject($request, $companyId);
                $this->handleClient($request, $project);
                if (isset($request->tag_member)) {
                    $this->syncMembers($request, $project);
                    foreach ($request->tag_member as $member) {
                        addNotifaction("Project and Client Created Successfully", $project, $project->id, $companyId, $member, 'Project');
                    }
                }
                DB::commit();
                return redirect()->route('company.project.list')->with('success', 'Project ' . ($request->uuid ? 'Updated' : 'Created') . ' Successfully');
            } catch (\Exception $e) {
                DB::rollBack();
                logger($e->getMessage() . '--' . $e->getFile() . '--' . $e->getLine());
                return redirect()->route('company.project.list')->with('error', 'Something went wrong: ' . $e->getMessage());
            }
        }

        return view('Company.projects.add-edit');
    }

    private function validateRequest(Request $request)
    {
        $request->validate([
            'project_name' => 'required',
            'planned_start_date' => 'required',
            'address' => 'required',
            'planned_end_date' => 'date',
            'tag_company' => 'required',
            'own_project_or_contractor' => 'required|in:yes,no',
            'client_name' => 'required_if:own_project_or_contractor,yes',
            'client_company_address' => 'required_if:own_project_or_contractor,yes',
            'client_company_name' => 'required_if:own_project_or_contractor,yes',
            'client_designation' => 'required_if:own_project_or_contractor,yes',
            'client_email' => 'required_if:own_project_or_contractor,yes',
            'client_phone' => 'required_if:own_project_or_contractor,yes',
        ]);
    }

    private function createOrUpdateProject(Request $request, $companyId)
    {
        if ($request->uuid) {
            $pid = uuidtoid($request->uuid, 'projects');
            $project = Project::findOrFail($pid);
            $project->update($this->getProjectData($request, $companyId, $project->logo));
        } else {
            $project = Project::create($this->getProjectData($request, $companyId));
            $this->createStoreWarehouse($request, $project, $companyId);
        }
        return $project;
    }


    private function createStoreWarehouse(Request $request, $project, $companyId)
    {
        $isSubProjectCreated = StoreWarehouse::create([
            'uuid' => Str::uuid(),
            'name' => 'Main Store',
            'location' => Null,
            'projects_id' => $project->id,
            'company_id' => $companyId,
        ]);
    }


    private function getProjectData(Request $request, $companyId, $existingLogo = null)
    {
        return [
            'uuid' => Str::uuid(),
            'project_name' => $request->project_name,
            'planned_start_date' => $request->planned_start_date,
            'address' => $request->address,
            'planned_end_date' => $request->planned_end_date,
            'own_project_or_contractor' => $request->own_project_or_contractor,
            'project_completed' => $request->project_completed == 'yes' ? 'yes' : 'no',
            'company_id' => $companyId,
            'companies_id' => $request->tag_company,
            'project_completed_date' => $request->project_completed_date,
            'logo' => $request->logo ? getImgUpload($request->logo, 'logo') : $existingLogo,
        ];
    }

    private function handleClient(Request $request, $project)
    {
        if ($request->own_project_or_contractor == 'yes') {
            if ($request->clientUuid) {
                $cid = uuidtoid($request->clientUuid, 'clients');
                Client::where('id', $cid)->where('project_id', $project->id)->update($this->getClientData($request));
            } else {
                Client::create(array_merge($this->getClientData($request), ['project_id' => $project->id]));
            }
        } else {
            if ($request->clientUuid) {
                $cid = uuidtoid($request->clientUuid, 'clients');
                Client::where('id', $cid)->delete();
            }
        }
    }

    private function getClientData(Request $request)
    {
        return [
            'uuid' => Str::uuid(),
            'client_name' => $request->client_name,
            'client_designation' => $request->client_designation,
            'client_email' => $request->client_email,
            'client_phone' => $request->client_phone,
            'client_mobile' => $request->client_mobile,
            'client_company_name' => $request->client_company_name,
            'client_company_address' => $request->client_company_address,
        ];
    }

    private function syncMembers(Request $request, $project)
    {
        if (is_array($request->tag_member)) {
            $project->members()->sync($request->tag_member);
        } else {
            logger('tag_member is not an array');
        }
    }



    // public function add(Request $request)
    // {
    //     $authConpany = Auth::guard('company')->user()->id;
    //     $companyId = searchCompanyId($authConpany);
    //     if ($request->isMethod('post')) {
    //         $request->validate([
    //             'project_name' => 'required',
    //             'planned_start_date' => 'required',
    //             'address' => 'required',
    //             'planned_end_date' => 'date',
    //             'tag_company' => 'required',
    //             'own_project_or_contractor' => 'required|in:yes,no',
    //             'client_name' => 'required_if:own_project_or_contractor,yes',
    //             'client_company_address' => 'required_if:own_project_or_contractor,yes',
    //             'client_company_name' => 'required_if:own_project_or_contractor,yes',
    //             'client_designation' => 'required_if:own_project_or_contractor,yes',
    //             'client_email' => 'required_if:own_project_or_contractor,yes',
    //             'client_phone' => 'required_if:own_project_or_contractor,yes',
    //         ]);
    //         // dd($request->all());
    //         DB::beginTransaction();
    //         if ($request->uuid) {
    //             try {
    //                 $pid = uuidtoid($request->uuid, 'projects');
    //                 $fetchLogo = Project::find($pid);
    //                 $isProjectUpdated = Project::where('id', $pid)->update([
    //                     'project_name' => $request->project_name,
    //                     'planned_start_date' => $request->planned_start_date,
    //                     'address' => $request->address,
    //                     'planned_end_date' => $request->planned_end_date,
    //                     'own_project_or_contractor' => $request->own_project_or_contractor,
    //                     'project_completed' => $request->project_completed == 'yes' ? 'yes' : 'no',
    //                     'company_id' => $companyId,
    //                     'companies_id' => $request->tag_company,
    //                     'project_completed_date' => $request->project_completed_date,
    //                     'logo' => $request->logo ? getImgUpload($request->logo, 'logo') : $fetchLogo->logo,
    //                 ]);
    //                 // }
    //                 // dd($request->own_project_or_contractor);
    //                 if ($request->own_project_or_contractor == 'yes') {
    //                     if ($request->clientUuid != null) {
    //                         $cid = uuidtoid($request->clientUuid, 'clients');
    //                         $isClientUpdated = Client::where('id', $cid)->where('project_id', $pid)->update([
    //                             'client_name' => $request->client_name,
    //                             'client_designation' => $request->client_designation,
    //                             'client_email' => $request->client_email,
    //                             'client_phone' => $request->client_phone,
    //                             'client_mobile' => $request->client_mobile,
    //                             'client_company_name' => $request->client_company_name,
    //                             'client_company_address' => $request->client_company_address,
    //                         ]);
    //                         if ($isClientUpdated) {
    //                             DB::commit();
    //                             return redirect()->route('company.project.list')->with('success', 'Project Updated Successfully');
    //                         }
    //                     } else {
    //                         // dd($isProjectUpdated);
    //                         $isClientCreated = Client::create([
    //                             'uuid' => Str::uuid(),
    //                             'client_name' => $request->client_name,
    //                             'client_designation' => $request->client_designation,
    //                             'client_email' => $request->client_email,
    //                             'client_phone' => $request->client_phone,
    //                             'client_mobile' => $request->client_mobile,
    //                             'client_company_name' => $request->client_company_name,
    //                             'client_company_address' => $request->client_company_address,
    //                             'project_id' => $pid,
    //                         ]);
    //                         if ($isClientCreated) {
    //                             // dd($request->all());
    //                             DB::commit();
    //                             return redirect()->route('company.project.list')->with('success', 'Project Updated Successfully');
    //                         }
    //                     }
    //                 } else {
    //                     // dd($request->all());
    //                     if ($request->clientUuid) {
    //                         $cid = uuidtoid($request->clientUuid, 'clients');
    //                         $res = Client::where('id', $cid)->delete();
    //                     }
    //                     DB::commit();
    //                     return redirect()->route('company.project.list')->with('success', 'Project Updated Successfully');
    //                 }
    //                 //  dd($request->all());
    //             } catch (\Exception $e) {
    //                 DB::rollBack();
    //                 logger($e->getMessage() . '--' . $e->getFile() . '--' . $e->getLine());
    //                 return redirect()->route('company.project.list')->with('error', 'something want to be worng');
    //             }
    //         } else {
    //             //create a new project
    //             try {
    //                 $isProjectCreated = Project::create([
    //                     'uuid' => Str::uuid(),
    //                     'project_name' => $request->project_name,
    //                     'planned_start_date' => $request->planned_start_date,
    //                     'address' => $request->address,
    //                     'planned_end_date' => $request->planned_end_date,
    //                     'own_project_or_contractor' => $request->own_project_or_contractor,
    //                     'project_completed' => $request->project_completed == 'yes' ? 'yes' : 'no',
    //                     'company_id' => $companyId,
    //                     'companies_id' => $request->tag_company,
    //                     'project_completed_date' => $request->project_completed_date,
    //                     'logo' => $request->logo ? getImgUpload($request->logo, 'logo') : '',
    //                 ]);
    //                 if ($request->own_project_or_contractor == 'yes') {
    //                     $isClientCreated = Client::create([
    //                         'uuid' => Str::uuid(),
    //                         'client_name' => $request->client_name,
    //                         'client_designation' => $request->client_designation,
    //                         'client_email' => $request->client_email,
    //                         'client_phone' => $request->client_phone,
    //                         'client_mobile' => $request->client_mobile,
    //                         'client_company_name' => $request->client_company_name,
    //                         'client_company_address' => $request->client_company_address,
    //                         'project_id' => $isProjectCreated->id,
    //                     ]);
    //                 }

    //                 $isSubProjectCreated = StoreWarehouse::create([
    //                     'uuid' => Str::uuid(),
    //                     'name' => 'Main Store',
    //                     'location' => Null,
    //                     'projects_id' => $isProjectCreated->id,
    //                     'company_id' => $companyId,
    //                 ]);

    //                 if ($isProjectCreated) {
    //                     DB::commit();
    //                     return redirect()->route('company.project.list')->with('success', 'Project Created Successfully');
    //                 }
    //             } catch (\Exception $e) {
    //                 DB::rollBack();
    //                 // dd($e->getMessage());
    //                 logger($e->getMessage() . '--' . $e->getFile() . '--' . $e->getLine());
    //                 return redirect()->route('company.project.list')->with('error', $e->getMessage());
    //             }
    //         }
    //     }
    //     return view('Company.projects.add-edit');
    // }
}
