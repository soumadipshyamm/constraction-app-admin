<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Company\Project;
use App\Models\Company\SubProject;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\API\SubProject\SubProjectResources;

class SubProjectController extends BaseController
{
    public function subProjectlist()
    {
        $authConpany = Auth::guard('company-api')->user()->company_id;
        $data = SubProject::with('project')->where('company_id', $authConpany)->orderBy('id','desc')->get();
        $message = $data->isNotEmpty() ? 'Fetch Sub Project List Successfully' : 'Sub Project List Data Not Found';
        return $this->responseJson(true, 200, $message, $data);
    }

    public function subProjectAdd(Request $request)
    {
        // dd($request->all());
        $authConpany = Auth::guard('company-api')->user()->company_id;
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'tag_project' => 'required',
        ]);
        if ($validator->fails()) {
            $status = false;
            $code = 422;
            $response = [];
            $message = $validator->errors()->first();
            return $this->responseJson($status, $code, $message, $response);
        }
        try {
            DB::beginTransaction();

            if ($request->updateId) {
                // Update existing sub-project
                $id = $request->updateId;
                $SubProject=SubProject::find($id);
                $project = Project::find($request->tag_project);
                // dd($SubProject->project()->sync($project->id));
                $SubProject->project()->sync($project->id);
                $isProjectUpdated = SubProject::where('id', $id)
                    ->update([
                        'name' => $request->name,
                        'start_date' => $request->start_date,
                        'end_date' => $request->end_date,
                    ]);
                $message = 'Sub-Project Updated Successfully';
            } else {
                // Create a new sub-project
                $isSubProjectCreated = SubProject::create([
                    'uuid' => Str::uuid(),
                    'name' => $request->name,
                    'start_date' => $request->start_date,
                    'end_date' => $request->end_date,
                    'company_id' => $authConpany, // Assuming $authCompany contains the correct value

                ]);

                $project = Project::find($request->tag_project);
                $isSubProjectCreated->project()->attach($project->id);

                $message = 'Sub-Project Created Successfully';
            }

            if (isset($isProjectUpdated) || isset($isSubProjectCreated)) {
                // Commit the transaction on success
                DB::commit();
                return $this->responseJson(true, 201, $message, $isProjectUpdated ?? $isSubProjectCreated);
            }
        } catch (\Exception $e) {
            // Rollback the transaction on error and log the exception
            DB::rollBack();
            logger($e->getMessage() . ' on ' . $e->getFile() . ' in ' . $e->getLine());

            // Return an error response in JSON
            return $this->responseJson(false, 500, $e->getMessage(), []);
        }
    }

    public function subProjectSearch(Request $request)
    {
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $datas = SubProject::where('company_id', $authCompany)
            ->where('is_active', 1);

        if ($request->has('search_keyword') && $request->search_keyword != "") {
            $datas->where(function ($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->search_keyword . '%');
            });
        }
        $datas = $datas->get();
        return SubProjectResources::collection($datas);
    }
    public function edit($id)
    {
        $authConpany = Auth::guard('company-api')->user()->company_id;
        $data = SubProject::where('company_id', $authConpany)->where('id', $id)->first();
        $message = ' Sub Project Fetch Successfully';
        // dd($data);
        return $this->responseJson(true, 200, $message, new SubProjectResources($data));
    }
    public function delete($uuid)
    {
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $data = SubProject::where('id', $uuid)
            ->where('company_id', $authCompany)
            ->delete();
        $message = $data > 0 ? 'Sub-Project Delete Successfully' : 'Sub-Project Data Not Found';
        return $this->responseJson(true, 200, $message, $data);
    }
}
