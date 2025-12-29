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
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ActivityHistoryController extends BaseController
{

    public function activitiesProjectSearch(Request $request)
    {
        $authCompany = Auth::guard('company-api')->user()->company_id;
        // Build the base query with eager loading and conditions
        $query = Activities::with([
            'units',
            'project',
            'subproject',
            'parent',
            'children.children.activitiesHistory' // Eager load nested relationships
        ])
            ->where('company_id', $authCompany)
            ->where('type', 'heading') // Filter by type 'heading'
            ->where('project_id', $request->project); // Filter by project ID

        // Apply optional filters
        if ($request->filled('subproject')) {
            $query->where('subproject_id', $request->subproject); // Optional subproject filter
        }

        if ($request->filled('search_keyword')) {
            $keyword = '%' . $request->search_keyword . '%';
            $query->where(function ($q) use ($keyword) {
                $q->where('activities', 'LIKE', $keyword)
                    ->orWhere('type', 'LIKE', $keyword); // Search by keyword
            });
        }

        // Execute the query
        $activities = $query->get();

        if ($activities->isEmpty()) {
            return $this->responseJson(true, 200, 'Activities Search Data Not Found', []);
        }

        // Flatten activities with their nested children without duplicates
        $allActivities = $activities->flatMap(function ($activity) {
            // Include the parent activity
            $activitiesCollection = collect([$activity]);

            // Include its children and grandchildren
            if ($activity->children) {
                $activitiesCollection = $activitiesCollection->merge(
                    $activity->children->flatMap(function ($child) {
                        $childCollection = collect([$child]);

                        if ($child->children) {
                            $childCollection = $childCollection->merge($child->children);
                        }
                        return $childCollection;
                    })
                );
            }

            return $activitiesCollection;
        })->unique('id'); // Ensure no duplicates based on the 'id' field

        // Return the response using the flattened activities
        return $this->responseJson(true, 200, 'Fetch Search List Successfully', ActiviteiesResources::collection($allActivities));
    }


    // public function activitiesProjectSearch(Request $request)
    // {
    //     $authCompany = Auth::guard('company-api')->user()->company_id;
    //     // Build the base query with eager loading and conditions
    //     $query = Activities::with([
    //         'units',
    //         'project',
    //         'subproject',
    //         'parent',
    //         'children.children.activitiesHistory' // Eager load nested relationships
    //     ])
    //         ->where('company_id', $authCompany)
    //         ->where('type', 'heading') // Filter by type 'heading'
    //         ->where('project_id', $request->project) // Filter by project ID
    //         ->when($request->filled('subproject'), function ($query) use ($request) {
    //             return $query->orWhere('subproject_id', $request->subproject); // Optional subproject filter
    //         })
    //         ->when($request->filled('search_keyword'), function ($query) use ($request) {
    //             $keyword = '%' . $request->search_keyword . '%';
    //             $query->where(function ($q) use ($keyword) {
    //                 $q->where('activities', 'LIKE', $keyword)
    //                     ->orWhere('type', 'LIKE', $keyword); // Search by keyword
    //             });
    //         });

    //     // Execute the query
    //     $activities = $query->get();

    //     if ($activities->isEmpty()) {
    //         return $this->responseJson(true, 200, 'Activities Search Data Not Found', []);
    //     }

    //     // Flatten activities with their nested children without duplicates
    //     $allActivities = $activities->flatMap(function ($activity) {
    //         // Include the parent activity
    //         $activitiesCollection = collect([$activity]);

    //         // Include its children and grandchildren
    //         if ($activity->children) {
    //             $activitiesCollection = $activitiesCollection->merge(
    //                 $activity->children->flatMap(function ($child) {
    //                     $childCollection = collect([$child]);

    //                     if ($child->children) {
    //                         $childCollection = $childCollection->merge($child->children);
    //                     }

    //                     return $childCollection;
    //                 })
    //             );
    //         }

    //         return $activitiesCollection;
    //     })->unique('id'); // Ensure no duplicates based on the 'id' field

    //     // Return the response using the flattened activities
    //     return $this->responseJson(true, 200, 'Fetch Search List Successfully', ActiviteiesResources::collection($allActivities));
    // }


    // $activites = [];
    // $authCompany = Auth::guard('company-api')->user()->company_id;
    // // Build the base query with eager loading and conditions
    // $query = Activities::with(['units', 'project', 'subproject', 'parent', 'children.children.activitiesHistory'])
    //     ->where('company_id', $authCompany)
    //     ->where('type', 'heading')
    //     ->where('project_id', $request->project)
    //     ->when($request->filled('subproject'), function ($query) use ($request) {
    //         return $query->orWhere('subproject_id', $request->subproject);
    //     })
    //     ->when($request->filled('search_keyword'), function ($query) use ($request) {
    //         $keyword = '%' . $request->search_keyword . '%';
    //         $query->where(function ($q) use ($keyword) {
    //             $q->where('activities', 'LIKE', $keyword)->orWhere('type', 'LIKE', $keyword);
    //         });
    //     });
    // // Execute the query
    // $activities = $query->get();
    // if ($activities->isEmpty()) {
    //     return $this->responseJson(true, 200, 'Activities Search Data Not Found', []);
    // }
    // // Flatten activities with their nested children
    // $allActivities = $activities->flatMap(function ($activity) {
    //     return collect([$activity])->merge(
    //         $activity->children->flatMap(function ($child) {
    //             return collect([$child])->merge($child->children);
    //         }),
    //     );
    // });

    // if ($activities->isNotEmpty()) {
    //     $activites = [];
    //     foreach ($activities as $activity) {
    //         $activites[] = $activity;
    //         if ($activity->children->count()) {
    //             foreach ($activity->children as $childActivity) {
    //                 $activites[] = $childActivity;
    //                 if ($childActivity->children->count()) {
    //                     foreach ($childActivity->children as $siblingActivity) {
    //                         $activites[] = $siblingActivity;
    //                     }
    //                 }
    //             }
    //         }
    //     }
    // }else{
    //     return $this->responseJson(true, 200, 'Data Not Found', []);
    // }
    // // dd($activites);
    // // return $this->responseJson(true, 200, 'Fetch Search List Successfully', ActiviteiesResources::collection($activites));
    // return $this->responseJson(true, 200, 'Fetch Search List Successfully', ActiviteiesResources::collection($activites));
    // }

    public function index(Request $request)
    {
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $fetchDpr = Dpr::where(['date' => Carbon::now()->format('Y-m-d'), 'projects_id' => $request->project_id, 'sub_projects_id' => $request->subproject_id, 'company_id' => $authCompany])
            ->orderBy('id', 'desc')
            ->first();
        $result = '';
        if ($fetchDpr) {
            // dd($fetchDpr);
            $dprId = $fetchDpr->id;
            $authCompany = Auth::guard('company-api')->user()->company_id;
            $activitesData = Activities::with([
                'units',
                'project',
                'subproject',
                'parent',
                'children',
                'activitiesHistory' => function ($q) use ($dprId) {
                    $q->where('dpr_id', $dprId);
                },
            ])
                ->whereHas('activitiesHistory', function ($q) use ($dprId) {
                    $q->where('dpr_id', $dprId);
                })
                ->where('company_id', $authCompany)
                ->get();
            $result = DprActivitesResources::collection($activitesData);
            // dd($result);
        } else {
            $datas = Activities::with('units', 'project', 'subproject', 'parent', 'children', 'activitiesHistory')
                ->orderBy('id', 'asc')
                ->where('company_id', $authCompany)
                ->where(['project_id' => $request->project_id, 'subproject_id' => $request->subproject_id])
                ->get();
            $result = ActiviteiesResources::collection($datas);
        }
        // dd($result);
        if (count($result) > 0) {
            return $this->responseJson(true, 200, 'Fetch Activities List Successfullsy', $result);
        } else {
            return $this->responseJson(true, 200, 'Activities List Data Not Found', []);
        }
    }

    public function add(Request $request)
    {
        log_daily(
            'activities',
            'Activities request received with data.',
            'add',
            'info',
            json_encode($request->all())
        );
        $authCompany = Auth::guard('company-api')->user();
        $validator = Validator::make(
            $request->all(),
            [
                '*.activities_history_qty' => 'required',
            ],
            [
                'required' => 'The :attribute field is required.',
            ],
        );
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
            $message = '';
            $img = null;
            $activitesDprId = Dpr::where('user_id', $authCompany->id)
                ->where('company_id', $authCompany->company_id)
                ->latest()
                ->first();

            foreach ($request->all() as $data) {

                $result = searchActivitiesToId($data);
                if (!empty($data['activities_history_img'])) {
                    $img = $data['activities_history_img'] = base64ImageUpload($data['activities_history_img'], 'upload');
                }
                $activity = ActivityHistory::updateOrCreate(
                    [
                        'activities_id' => $data['activities_history_activities_id'],
                        'dpr_id' => $data['activities_history_dpr_id'] != null ? $data['activities_history_dpr_id'] : $activitesDprId->id,
                        'company_id' => $authCompany->company_id,
                    ],
                    [
                        // 'activities_id' => $data['activities_history_activities_id'],
                        'qty' => $data['activities_history_qty'],
                        'completion' => $data['activities_history_completion'] != null ? $data['activities_history_completion'] : 0,
                        'vendors_id' => $data['activities_history_vendors_id'],
                        'remaining_qty' => $result['remaining_qty'] ?? 0,
                        'total_qty' => $result['total_qty'] ?? 0,
                        'remarkes' => $data['activities_history_remarkes'],
                        'img' => $img,
                        'company_id' => $authCompany->company_id,
                    ],
                );

                $activityHistory[] = $activity;
            }

            log_daily(
                'activities',
                'Activities added successfully with data updateOrCreate.',
                'add',
                'info',
                json_encode($activityHistory)
            );
            $message = 'Activity Details Updated Successfully';
            $result = ActivitesResource::collection($activityHistory);
            // }
            DB::commit();
            return response()->json([
                'status' => true,
                'code' => 200,
                'message' => $message,
                'response' => $result,
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
        // dd($request->all());
        $getActivitesId = $request->getActivites;
        $dprId = $request->dprId;
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $activitesData = Activities::with([
            'units',
            'project',
            'subproject',
            'parent',
            'children',
            'activitiesHistory' => function ($q) use ($dprId, $getActivitesId) {
                $q->where('dpr_id', $dprId);
            },
        ])

            ->whereIn('id', $getActivitesId)
            ->where('company_id', $authCompany)
            ->get();
        // Log::info("activites Edit*************************************8");
        // Log::info($activitesData);
        // dd($activitesData);
        $activites = DprActivitesResources::collection($activitesData);
        $message = 'Fetch Activites List Successfully';
        return $this->responseJson(true, 200, $message, $activites);
    }
}
