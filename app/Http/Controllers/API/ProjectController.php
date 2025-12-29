<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Company\Client;
use App\Models\Company\Project;
use Illuminate\Support\Facades\DB;
use App\Models\Company\CompanyUser;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BaseController;
use App\Http\Resources\API\Project\ProjectResource;
use App\Http\Resources\API\Project\ProjectSubProjectResources;
use App\Http\Resources\API\SubProject\SubProjectResources;
use App\Models\Company\CompanyProjectPermission;
use App\Models\Company\StoreWarehouse;
use App\Models\Company\SubProject;
use Illuminate\Support\Facades\Validator;

class ProjectController extends BaseController
{
    public function projectlist()
    {
        $authCompany = Auth::guard('company-api')->user();
        $query = Project::with('subProject', 'client', 'members')->where('company_id', $authCompany?->company_id)->orderBy('id', 'desc');

        if ($authCompany->companyUserRole->slug == 'project-manager') {
            $query->whereHas('members', function ($query) use ($authCompany) {
                $query->where('user_id', $authCompany->id);
            });
        }
        // dd($authCompany->companyUserRole->slug);
        $assigenMember = CompanyProjectPermission::where('company_id', $authCompany->company_id)
            ->where('company_user_id', $authCompany->id)
            ->exists();
        if (($authCompany->companyUserRole->slug !== 'super-admin' && $authCompany->companyUserRole->slug !== 'project-manager') || $assigenMember) {
            // dd($assigenMember);
            $query->whereHas('projectMemberAllocation', function ($query) use ($authCompany) {
                $query->where('company_user_id', $authCompany->id);
            });
        }
        $data = $query->get();
        // dd($data);
        // dd($data);
        $message = $data->isNotEmpty() ? 'Fetch Project List Successfully' : 'Project List Data Not Found';
        $result = ProjectResource::collection($data);
        // addNotifaction($message, $result, $request->projects_id ?? null,$authCompany->company_id);

        return $this->responseJson(true, 200, $message, $result);
    }

    public function projectAdd(Request $request)
    {
        log_daily('project', 'projectAdd', 'projectAdd', 'info', json_encode($request->all()));
        $authCompany = Auth::guard('company-api')->user()->company_id;

        // Validate the request data
        $validator = Validator::make($request->all(), [
            'project_name' => 'required',
            'address' => 'required',
            'planned_start_date' => 'required|date',
            'planned_end_date' => 'date',
            'companies_id' => 'required',
            'own_project_or_contractor' => 'required|in:yes,no',
            'client_name' => 'required_if:own_project_or_contractor,yes',
            'client_company_address' => 'required_if:own_project_or_contractor,yes',
            'client_company_name' => 'required_if:own_project_or_contractor,yes',
            'client_designation' => 'required_if:own_project_or_contractor,yes',
            'client_email' => 'required_if:own_project_or_contractor,yes',
            'client_phone' => 'required_if:own_project_or_contractor,yes',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return $this->responseJson(false, 422, $validator->errors()->first());
        }

        DB::beginTransaction();

        try {
            $isProjectUpdated = false;
            $clientData = [
                'client_name' => $request->client_name,
                'client_designation' => $request->client_designation,
                'client_email' => $request->client_email,
                'country_code' => $request->country_code,
                'company_country_code' => $request->company_country_code,
                'client_phone' => $request->client_phone,
                'client_mobile' => $request->client_mobile,
                'client_company_name' => $request->client_company_name,
                'client_company_address' => $request->client_company_address,
            ];


            if ($request->projectUpdateId) {
                // Update existing project
                $project = Project::findOrFail($request->projectUpdateId);
                $project->update([
                    'project_name' => $request->project_name,
                    'planned_start_date' => $request->planned_start_date,
                    'address' => $request->address,
                    'planned_end_date' => $request->planned_end_date,
                    'own_project_or_contractor' => $request->own_project_or_contractor,
                    'project_completed' => $request->project_completed == 'yes' ? 'yes' : 'no',
                    'company_id' => $authCompany,
                    'companies_id' => $request->companies_id,
                    'project_completed_date' => $request->project_completed_date,
                    'logo' => $request->logo ? getImgUpload($request->logo, 'logo') : $project->logo,
                ]);

                // Handle client data for existing project
                if ($request->own_project_or_contractor == 'yes') {
                    if ($request->clientId) {

                        Client::where('id', $request->clientId)
                            ->where('project_id', $project->id)
                            ->update($clientData);
                    } else {

                        $clientData['uuid'] = Str::uuid();
                        $clientData['project_id'] = $project->id;
                        Client::create($clientData);
                    }

                    // Sync tagged members
                    if (is_array($request->tag_member)) {
                        $project->members()->sync($request->tag_member);
                    }
                }

                $isProjectUpdated = true;
            } else {

                // Create a new project
                $projectData = [
                    'uuid' => Str::uuid(),
                    'project_name' => $request->project_name,
                    'planned_start_date' => $request->planned_start_date,
                    'address' => $request->address,
                    'planned_end_date' => $request->planned_end_date,
                    'own_project_or_contractor' => $request->own_project_or_contractor,
                    'project_completed' => $request->project_completed == 'yes' ? 'yes' : 'no',
                    'company_id' => $authCompany,
                    'companies_id' => $request->companies_id,
                    'project_completed_date' => $request->project_completed_date,
                    'logo' => $request->logo ? getImgUpload($request->logo, 'logo') : '',
                ];

                log_daily('project', 'Project::create', 'projectAdd', 'info', json_encode($projectData));

                $project = Project::create($projectData);

                // Create client data if applicable
                if ($request->own_project_or_contractor == 'yes') {
                    $clientData['uuid'] = Str::uuid();
                    $clientData['project_id'] = $project->id;
                    $kjhgf = Client::create($clientData);
                }

                // Create a default "Main Store" for the project
                StoreWarehouse::create([
                    'uuid' => Str::uuid(),
                    'name' => 'Main Store',
                    'location' => null,
                    'projects_id' => $project->id,
                    'company_id' => $authCompany,
                ]);

                // Sync tagged members
                if (is_array($request->tag_member)) {
                    $project->members()->sync($request->tag_member);
                }
            }

            DB::commit();

            $message = $isProjectUpdated ? 'Project and Client Updated Successfully' : 'Project and Client Created Successfully';
            return $this->responseJson(true, 200, $message, $project);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->responseJson(false, 500, 'An error occurred: ' . $e->getMessage());
        }
    }

    public function projectSearch(Request $request)
    {
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $datas = Project::with('client', 'companys', 'companiesProject')
            ->where('company_id', $authCompany)
            ->where('is_active', 1);

        if ($request->has('search_keyword') && $request->search_keyword != "") {
            $datas->where(function ($q) use ($request) {
                $q->where('project_name', 'LIKE', '%' . $request->search_keyword . '%');
            });
        }
        $datas = $datas->get();
        return ProjectResource::collection($datas);
    }

    public function edit($uuid)
    {
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $data = Project::where('id', $uuid)->where('company_id', $authCompany)->first();
        // $data->tag_member = $data->members->toArray();
        // $data=$data->first()->companys;
        // dd($data);
        $message = 'Fetch Project List Successfully';
        return $this->responseJson(true, 200, $message, new ProjectResource($data));
    }

    public function delete($uuid)
    {
        log_daily('project', 'delete', 'projectDelete', 'info', json_encode(['uuid' => $uuid]));
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $data = Project::where('id', $uuid)
            ->where('company_id', $authCompany)
            ->delete();
        $message = $data > 0 ? 'Project Delete Successfully' : 'Project Data Not Found';
        return $this->responseJson(true, 200, $message, $data);
    }

    public function projectSubproject(Request $request)
    {
        log_daily(
            'project',
            'projectSubproject',
            'projectSubproject',
            'info',
            json_encode($request->all())
        );
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $data = Project::with('subProject')->where('id', $request->project_id)->where('company_id', $authCompany)->get();
        $data = $data->first()->subProject;
        $message = $data->isNotEmpty() ? 'Fetch Project List Successfully' : 'Project List Data Not Found';
        return $this->responseJson(true, 200, $message, SubProjectResources::collection($data));
    }

    // **************************DPR***************************************************************

    public function fetchprojectSubproject(Request $request)
    {
        // dd($request->all());
        $subprojectId = $request->subproject;
        $project = $request->project;
        $authCompany = Auth::guard('company-api')->user()->company_id;

        $project = Project::with('subProject')->where('id', $project)->where('company_id', $authCompany)->first();
        if (!$project) {
            return $this->responseJson(false, 404, 'Project Not Found', []);
        }
        if (empty($subprojectId)) {
            $data = $project;
            $message = $data ? 'Fetch Project List Successfully' : 'No Project Found';
            return $this->responseJson(true, 200, $message, new ProjectResource($data));
        }

        if (!empty($subprojectId) && $subprojectId != null) {
            $subproject = SubProject::with('project')->where('id', $subprojectId)->where('company_id', $authCompany)->first();
            if (!$subproject) {
                return $this->responseJson(false, 404, 'Subproject Not Found', []);
            }
            $existsInPivot = $project->subProject()->wherePivot('subproject_id', $subproject->id)->exists();
            if ($existsInPivot) {
                $data = $project->subProject()->wherePivot('subproject_id', $subproject->id)->first();
                $message = 'Fetch Subproject Successfully';
                return $this->responseJson(true, 200, $message, new SubProjectResources($data));
            }
        }
        return $this->responseJson(false, 404, 'Subproject Not Associated with Project', []);
    }


    public function projectWiseSubprojectSearch(Request $request)
    {
        $subprojectId = $request->subproject;
        $project = $request->project;
        $authCompany = Auth::guard('company-api')->user()->company_id;

        $project = Project::where('id', $project)->where('company_id', $authCompany)->first();

        $subproject = SubProject::where('name', 'LIKE', '%' . $subprojectId . '%')->where('company_id', $authCompany)->first();

        $data = [];
        if ($project && $subproject) {

            $existsInPivot = $project->subProject()->wherePivot('subproject_id', $subproject->id)->exists();
            if ($existsInPivot) {
                $data = $project->with(['subProject' => function ($q) use ($subproject) {
                    $q->where('subproject_id', $subproject->id);
                }])->where('company_id', $authCompany)->first();
                // dd( $data);
                $message = $data ? 'Fetch Project List Successfully' : 'Project List Data Not Found';
                return $this->responseJson(true, 200, $message, new ProjectSubProjectResources($data));
            }
            $message = $data ? 'Fetch Project List Successfully' : 'Project List Data Not Found';
            return $this->responseJson(true, 200, $message, []);
        }
        $message = $data ? 'Fetch Project List Successfully' : 'Project List Data Not Found';
        return $this->responseJson(true, 200, $message, []);
    }
}
