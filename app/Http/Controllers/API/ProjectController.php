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
use App\Models\Company\SubProject;
use Illuminate\Support\Facades\Validator;

class ProjectController extends BaseController
{
    public function projectlist()
    {
        // dd(Auth::guard('company')->user());
        $authCompany = Auth::guard('company-api')->user();
        $data = Project::with('subProject', 'client')->where('company_id', $authCompany?->company_id)->get();
        // dd($data->toArray());
        $message = $data->isNotEmpty() ? 'Fetch Project List Successfully' : 'Project List Data Not Found';
        return $this->responseJson(true, 200, $message, ProjectResource::collection($data));
    }

    public function projectAdd(Request $request)
    {
        $authConpany = Auth::guard('company-api')->user()->company_id;

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
            $status = false;
            $code = 422;
            $response = [];
            $message = $validator->errors()->first();
            return $this->responseJson($status, $code, $message, $response);
        }

        try {
            DB::beginTransaction();

            if ($request->projectUpdateId) {
                // Update an existing project
                $pid = $request->projectUpdateId;
                $fetchLogo = Project::find($pid);
                $isProjectUpdated = Project::where('id', $pid)->update([
                    'project_name' => $request->project_name,
                    'planned_start_date' => $request->planned_start_date,
                    'address' => $request->address,
                    'planned_end_date' => $request->planned_end_date,
                    'own_project_or_contractor' => $request->own_project_or_contractor,
                    'project_completed' => $request->project_completed == 'yes' ? 'yes' : 'no',
                    'company_id' => $authConpany,
                    'companies_id' => $request->companies_id,
                    'project_completed_date' => $request->project_completed_date,
                    'logo' => $request->logo ? getImgUpload($request->logo, 'logo') : $fetchLogo->logo,
                ]);

                if ($request->own_project_or_contractor == 'yes') {
                    $clientData = [
                        'client_name' => $request->client_name,
                        'client_designation' => $request->client_designation,
                        'client_email' => $request->client_email,
                        'client_phone' => $request->client_phone,
                        'client_mobile' => $request->client_mobile,
                        'client_company_name' => $request->client_company_name,
                        'client_company_address' => $request->client_company_address,
                    ];

                    if ($request->clientId != null) {
                        $cid = $request->clientId;
                        Client::where('id', $cid)->where('project_id', $pid)->update($clientData);
                    } else {
                        $clientData['uuid'] = Str::uuid();
                        $clientData['project_id'] = $pid;
                        Client::create($clientData);
                    }
                }
                DB::commit();
                return $this->responseJson(true, 200, 'Project and Client Updated Successfully', $isProjectUpdated);
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
                    'company_id' => $authConpany,
                    'companies_id' => $request->companies_id,
                    'project_completed_date' => $request->project_completed_date,
                    'logo' => $request->logo ? getImgUpload($request->logo, 'logo') : '',
                ];

                $data['Project'] = Project::create($projectData);
                if ($request->own_project_or_contractor == 'yes') {
                    $clientData = [
                        'uuid' => Str::uuid(),
                        'client_name' => $request->client_name,
                        'client_designation' => $request->client_designation,
                        'client_email' => $request->client_email,
                        'client_phone' => $request->client_phone,
                        'client_mobile' => $request->client_mobile,
                        'client_company_name' => $request->client_company_name,
                        'client_company_address' => $request->client_company_address,
                        'project_id' => $data['Project']->id,
                    ];

                    $data['projectClient'] = Client::create($clientData);
                }
            }

            DB::commit();

            return $this->responseJson(true, 200, 'Project Created Successfully', $data);
        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage() . ' on ' . $e->getFile() . ' in ' . $e->getLine());
            return $this->responseJson(false, 500, $e->getMessage(), []);
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
        // $data=$data->first()->companys;
        // dd($data);
        $message = 'Fetch Project List Successfully';
        return $this->responseJson(true, 200, $message, new ProjectResource($data));
    }

    public function delete($uuid)
    {
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $data = Project::where('id', $uuid)
            ->where('company_id', $authCompany)
            ->delete();
        $message = $data > 0 ? 'Project Delete Successfully' : 'Project Data Not Found';
        return $this->responseJson(true, 200, $message, $data);
    }

    public function projectSubproject(Request $request)
    {
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $data = Project::where('id', $request->project_id)->where('company_id', $authCompany)->get();
        $data = $data->first()->subProject;
        $message = $data->isNotEmpty() ? 'Fetch Project List Successfully' : 'Project List Data Not Found';
        return $this->responseJson(true, 200, $message, $data);
    }

    // **************************DPR***************************************************************

    // public function fetchprojectSubproject(Request $request)
    // {
    //     $subprojectId = $request->subproject;
    //     $project = $request->project;
    //     $authCompany = Auth::guard('company-api')->user()->company_id;

    //     $project = Project::where('id', $project)->where('company_id', $authCompany)->first();
    //     $subproject = SubProject::where('id', $subprojectId)->where('company_id', $authCompany)->first();
    //     $data = [];

    //     if ($project && $subproject) {
    //         $existsInPivot = $project->subProject()->wherePivot('subproject_id', $subprojectId)->exists();

    //         if ($existsInPivot) {
    //             $data = $project->subProject()->wherePivot('subproject_id', $subprojectId)->first();

    //             // $data = $project->with(['subProject' => function ($q) use ($subprojectId) {
    //             //     $q->where('subproject_id', $subprojectId);
    //             // }])->where('company_id', $authCompany)->first();

    //             // dd($data->toArray());
    //             $message = $data ? 'Fetch Project List Successfully' : 'Project List Data Not Found';
    //             return $this->responseJson(true, 200, $message, new SubProjectResources($data));
    //             // return $this->responseJson(true, 200, $message, new ProjectSubProjectResources($existsInPivot11));
    //         }
    //         $message = $data ? 'Fetch Project List Successfully' : 'Project List Data Not Found';
    //         return $this->responseJson(true, 200, $message, []);
    //     }
    //     $message = $data ? 'Fetch Project List Successfully' : 'Project List Data Not Found';
    //     return $this->responseJson(true, 200, $message, []);
    // }

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

    // public function projectWiseSubprojectSearch(Request $request)
    // {
    //     $subprojectName = $request->subproject;
    //     $projectId = $request->project;
    //     $authCompany = Auth::guard('company-api')->user()->company_id;

    //     $project = Project::where('id', $projectId)->where('company_id', $authCompany)->first();

    //     $subprojects = SubProject::where('name', 'LIKE', '%' . $subprojectName . '%')->where('company_id', $authCompany)->get();
    //     $data = [];
    //     if ($project && $subprojects) {
    //         // Correction
    //         // $subprojectIds = [1, 2, 3];
    //         $data= $project->with(['subProject' => function ($q)  {
    //             // $q->whereIn('name', 'SFT');
    //             dd($q);
    //         }])->where('company_id', $authCompany)->get();
    //         dd($data);
    //         $message = $data->isNotEmpty() ? 'Fetch Project List Successfully' : 'Project List Data Not Found';
    //         return $this->responseJson(true, 200, $message, ProjectSubProjectResources::collection($data));
    //     }

    //     $message = $data ? 'Fetch Project List Successfully' : 'Project List Data Not Found';
    //     return $this->responseJson(true, 200, $message, []);
    // }
}
