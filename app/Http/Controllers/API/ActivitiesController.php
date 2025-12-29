<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Company\Activities;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\API\Activities\ActiviteiesResources;

class ActivitiesController extends BaseController
{

    public function activitiesList(Request $request)
    {
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $subprojectId = $request->subproject;
        $projectId = $request->project;

        if ($projectId === null) {
            return $this->responseJson(true, 200, 'Activities List Data Not Found', []);
        }

        // Fetch activities with relationships
        $fetchActivities = Activities::with(['units', 'project', 'subproject', 'activitiesHistory', 'children.children'])
            ->where('type', 'heading')
            ->where('project_id', $projectId)
            ->where('company_id', $authCompany)
            ->when($subprojectId, function ($query, $subprojectId) {
                return $query->where('subproject_id', $subprojectId);
            })

            ->get();

        if ($fetchActivities->isEmpty()) {
            return $this->responseJson(true, 200, 'Activities List Data Not Found', []);
        }

        // Flatten the hierarchy into a single list
        $activities = [];
        foreach ($fetchActivities as $activity) {
            $activities[] = $activity;
            if ($activity->children->isNotEmpty()) {
                foreach ($activity->children as $childActivity) {
                    $activities[] = $childActivity;
                    if ($childActivity->children->isNotEmpty()) {
                        foreach ($childActivity->children as $siblingActivity) {
                            $activities[] = $siblingActivity;
                        }
                    }
                }
            }
        }
        // Apply search filtering on final result
        if ($request->has('search_keyword') && !empty($request->search_keyword)) {
            $searchKeyword = strtolower($request->search_keyword);
            $activities = collect($activities)->filter(function ($activity) use ($searchKeyword) {
                return str_contains(strtolower($activity->activities), $searchKeyword);
            })->values();
        }

        return $this->responseJson(true, 200, 'Fetch Activities List Successfully', ActiviteiesResources::collection($activities));
    }


    public function activitiesAdd(Request $request)
    {
        log_daily(
            'activities',
            'activitiesAdd',
            'activitiesAdd',
            'info',
            json_encode($request->all())
        );
        $authConpany = Auth::guard('company-api')->user()->company_id;
        $validator = Validator::make($request->all(), [
            'project' => 'required|exists:projects,id',
            'subproject' => 'sometimes',
            'type' => 'required|in:heading,activites',
            'heading' => 'required_if:type,activites',
            'unit_id' => 'required_if:type,activites',
            // 'unit_id' => 'required',
            'activities' => 'required',
        ]);
        if ($validator->fails()) {
            $status = false;
            $code = 422;
            $response = [];
            $message = $validator->errors()->first();
            return $this->responseJson($status, $code, $message, $response);
        }
        if ($request->unit_id) {
            $unitId = $request->unit_id;
        } else {
            $unitId = null;
        }

        DB::beginTransaction();
        try {
            // dd($request->all());
            $findId = Activities::find($request->updateId);
            if (isset($findId)) {
                $isActivitiesUpdate = Activities::where('id', $request->updateId)->update([
                    'project_id' => $request->project,
                    'subproject_id' => $request->subproject ?? null,
                    'type' => $request->type ?? null,
                    'parent_id' => $request->heading ?? null,
                    'activities' => $request->activities ?? null,
                    'unit_id' => $unitId ?? null,
                    'qty' => $request->quantity ?? $request->qty ?? 0,
                    'rate' => $request->rate ?? 0,
                    'amount' => $request->amount ?? 0,
                    'start_date' => $request->start_date ?? null,
                    'end_date' => $request->end_date ?? null,
                ]);
                $message = 'Activities Updated Successfullsy';
            } else {
                $isActivitiesCreated = Activities::create([
                    'uuid' => Str::uuid(),
                    'project_id' => $request->project,
                    'subproject_id' => $request->subproject ?? null,
                    'type' => $request->type ?? null,
                    'parent_id' => $request->heading ?? null,
                    'activities' => $request->activities ?? null,
                    'unit_id' => $unitId ?? null,
                    'qty' => $request->quantity ?? $request->qty ?? 0,
                    'rate' => $request->rate ?? 0,
                    'amount' => $request->amount ?? 0,
                    'start_date' => $request->start_date ?? null,
                    'end_date' => $request->end_date ?? null,
                    'company_id' => $authConpany,
                ]);
                $message = 'Activities Created Successfullsy';
            }
            if (isset($isActivitiesCreated) || isset($isActivitiesUpdate)) {
                DB::commit();
                return $this->responseJson(true, 200, $message, $isActivitiesCreated ?? $isActivitiesUpdate);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage() . 'on' . $e->getFile() . 'in' . $e->getLine());
            return $this->responseJson(false, 500, $e->getMessage(), []);
        }
    }


    public function activitiesSearch(Request $request)
    {
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $validator = Validator::make($request->all(), [
            'search_keyword' => 'required',
            'project' => 'required',
        ]);
        if ($validator->fails()) {
            $status = false;
            $code = 422;
            $response = [];
            $message = $validator->errors()->first();
            return $this->responseJson($status, $code, $message, $response);
        }
        $datas = Activities::where('company_id', $authCompany)
            ->where('is_active', 1)
            ->when($request->has('search_keyword') && $request->search_keyword != "", function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('activities', 'LIKE', '%' . $request->search_keyword . '%');
                    // ->orWhere('type', 'LIKE', '%' . $request->search_keyword . '%');
                    // if ($request->has('project')) {
                    //     $q->orWhere('project_id', $request->project);
                    // }
                    // if ($request->has('subproject')) {
                    //     $q->orWhere('subproject_id', $request->subproject);
                    // }
                });
            })
            ->get();

        if (count($datas) > 0) {
            return $this->responseJson(true, 200, 'Fetch Search List Successfullsy', ActiviteiesResources::collection($datas));
        } else {
            return $this->responseJson(true, 200, 'Activities Search Data Not Found', []);
        }
    }

    public function edit($uuid)
    {
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $datas = Activities::where('id', $uuid)->where('company_id', $authCompany)->first();
        $message = 'Fetch Activities List Successfully';
        if ($datas) {
            return $this->responseJson(true, 200, $message, new ActiviteiesResources($datas));
        } else {
            return $this->responseJson(true, 200, $message, []);
        }
    }

    public function delete($uuid)
    {
        log_daily(
            'activities',
            'delete',
            'delete',
            'info',
            json_encode(['uuid' => $uuid])
        );
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $data = Activities::where('id', $uuid)
            ->where('company_id', $authCompany)
            ->delete();
        $message = $data > 0 ? 'Activities Delete Successfully' : 'Activities Data Not Found';
        return $this->responseJson(true, 200, $message, $data);
    }


    // public function headingActivitiesprantChild()
    // {
    //     $activites=[];
    //     $authCompany = Auth::guard('company-api')->user()->company_id;
    //     $data = Activities::with('parentActivites')
    //         ->where('company_id', $authCompany)
    //         ->whereIn('type', ['heading', 'activites'])
    //         ->get();
    //         foreach ($data as $key => $val) {
    //             if ($val->type == 'heading') {
    //                 $activites=$val;
    //                 // echo "<option class='groupHeading' value='" . $val->id . "'>"  . $val->activities . "</option>"; // Close <option> tag properly
    //             }
    //             if (count($val->parentAndSelf) < 2) {
    //                 foreach ($val->children as $childkey => $childval) {
    //                     if ($childval->type == 'activites') {
    //                         $activites=$val;
    //                         // echo "<option value='" . $childval->id . "'>"  . $childval->activities . "</option>"; // Close <option> tag properly
    //                     }
    //                 }
    //             }
    //         }
    //         return $activites;
    // }

}
