<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\BaseController;
use App\Http\Resources\ActivitesResource;
use App\Http\Resources\API\Activites\DprActivites;
use App\Http\Resources\API\Activities\ActiviteiesResources;
use App\Http\Resources\API\Activities\DprActivitesResources;
use App\Models\API\Dpr;
use App\Models\Company\Activities;
use App\Models\Company\ActivityHistory;
use App\Models\Company\Project;
use App\Models\Company\SubProject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ActivityHistoryController extends BaseController
{
    public function activitiesProjectSearch(Request $request)
    {
        $subprojectId = $request->subproject;
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $fetchActivites = Activities::with('units', 'project', 'subproject', 'parent', 'children', 'activitiesHistory')->where('company_id', $authCompany)->where('project_id', $request->project)

            ->when($subprojectId, function ($query, $subprojectId) {
                return  $query->where('subproject_id', $subprojectId);
            });
        if ($request->has('search_keyword') && $request->search_keyword != "") {
            $fetchActivites->where(function ($q) use ($request) {
                $q->where('activities', 'LIKE', '%' . $request->search_keyword . '%')
                    ->orWhere('type', 'LIKE', '%' . $request->search_keyword . '%')
                    ->orWhere('project_id',  $request->project)
                    ->orWhere('subproject_id', $request->subproject);
            });
        }
        $fetchActivites = $fetchActivites->get();

        // activitiesProjectSearch
        if (count($fetchActivites) > 0) {
            return $this->responseJson(
                true,
                200,
                'Fetch Search List Successfullsy',
                ActiviteiesResources::collection($fetchActivites)
            );
        } else {
            return $this->responseJson(true, 200, 'Activities Search Data Not Found', []);
        }
    }

    public function index(Request $request)
    {
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $datas = Activities::with('units', 'project', 'subproject', 'parent', 'children', 'activitiesHistory')->orderBy('id', 'asc')->where('company_id', $authCompany)->where(['project_id' => $request->project_id, 'subproject_id' => $request->subproject_id])->get();
        if (count($datas) > 0) {
            return $this->responseJson(true, 200, 'Fetch Activities List Successfullsy', ActiviteiesResources::collection($datas));
        } else {
            return $this->responseJson(true, 200, 'Activities List Data Not Found', []);
        }
    }
    public function add(Request $request)
    {
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $validator = Validator::make($request->all(), [
            '*.activities_history_completion' => 'required',
            '*.activities_history_qty' => 'required',
            '*.activities_history_activities_id' => 'required',
        ], [
            'required' => 'The :attribute field is required.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'code' => 422,
                'message' => $validator->errors()->first(),
                'response' => [],
            ]);
        }

        DB::beginTransaction();

        try {
            $activityHistory = [];
            foreach ($request->all() as $data) {
                $result = searchActivitiesToId($data);
                // dd($result);
                $activity = ActivityHistory::updateOrCreate(
                    [
                        'activities_id' => $data['activities_history_activities_id'],
                        'dpr_id' => $data['activities_history_dpr_id']
                    ],
                    [
                        'qty' => $data['activities_history_qty'],
                        'completion' => $data['activities_history_completion'],
                        'vendors_id' => $data['activities_history_vendors_id'],
                        'remaining_qty' => $result['remaining_qty'] ?? '',
                        'total_qty' => $result['total_qty'] ?? '',
                        'remarkes' => $data['activities_history_remarkes'],
                        'img' => $data['activities_history_img'] ? $this->getImgUpload($data['activities_history_img']) : '',
                        'company_id' => $authCompany,
                    ]
                );

                $activityHistory[] = $activity;
            }
            DB::commit();
            return response()->json([
                'status' => true,
                'code' => 200,
                'message' => 'Activity Details Updated Successfully',
                'response' => ActivitesResource::collection($activityHistory),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage() . ' on ' . $e->getFile() . ' in ' . $e->getLine());
            return response()->json([
                'status' => false,
                'code' => 500,
                'message' => $e->getMessage(),
                'response' => [],
            ]);
        }
    }


    public function edit(Request $request)
    {
        $getActivitesId = $request->getActivites;
        $dprId = $request->dprId;
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $activitesData = Activities::with(['units', 'project', 'subproject', 'parent', 'children', 'activitiesHistory' => function ($q) use ($dprId) {
            $q->where('dpr_id', $dprId);
        }])->where('company_id', $authCompany)
            ->whereIn('id', $getActivitesId)
            ->get();
        // dd($activitesData->toArray());
        $activites = DprActivitesResources::collection($activitesData);
        $message = 'Fetch Activites List Successfully';
        return response()->json(['success' => true, 'status' => 200, 'message' => $message, 'data' => $activites]);
    }


    // public function edit(Request $request)
    // {
    //     $getActivitiesId = $request->get('activities');
    //     $dprId = $request->input('dprId');
    //     $authCompany = Auth::guard('company-api')->user();
    //     $activities = [];

    //     foreach ($getActivitiesId as $activityId) {
    //         $activityHistory = ActivityHistory::where('activities_id', $activityId)
    //             ->where('dpr_id', $dprId)
    //             ->where('company_id', $authCompany->company_id)
    //             ->first();

    //         if ($activityHistory) {
    //             $activity = Activities::where('id', $activityId)
    //                 ->where('company_id', $authCompany->company_id)
    //                 ->first();

    //             if ($activity) {
    //                 $activities[] = new DprActivitesResources([
    //                     'activity' => $activity,
    //                     'activity_history' => $activityHistory
    //                 ]);
    //             }
    //         } else {
    //             $activity = Activities::where('id', $activityId)
    //                 ->where('company_id', $authCompany->company_id)
    //                 ->first();

    //             if ($activity) {
    //                 $activities[] = new DprActivitesResources([
    //                     'activity' => $activity
    //                 ]);
    //             }
    //         }
    //     }

    //     $message = 'Fetch Activities List Successfully';
    //     return response()->json(['success' => true, 'status' => 200, 'message' => $message, 'data' => $activities]);
    // }
}
