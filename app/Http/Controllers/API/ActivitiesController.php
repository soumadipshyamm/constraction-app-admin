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

        $activities = Activities::with('units', 'project', 'subproject', 'parent', 'children')
            ->where('company_id', $authCompany)
            ->whereNull('parent_id');

        if ($request->isMethod('post')) {
            if ($request->filled('project') &&  !empty($request->project)) {
                $activities->where('project_id', $request->project);
            }

            // Uncomment the following section if you want to filter based on 'subproject'
            // if ($request->filled('subproject')) {
            //     $activities->where('subproject_id', $request->subproject);
            // }
            // dd($request->search_keyword);


            if ($request->filled('project') && $request->filled('subproject')) {
                $activities->where(function ($q) use ($request) {
                    $q->where('project_id', $request->project)
                        ->where('subproject_id', $request->subproject);
                });
            }
        }


        if ($request->has('search_keyword') && $request->search_keyword != "") {
            $activities->where(function ($q) use ($request) {
                $q->where('activities', 'LIKE', '%' . $request->search_keyword . '%')
                    ->orWhere('type', 'LIKE', '%' . $request->search_keyword . '%');
            });
        }
        $activities = $activities->get();
        // dd(  $activities);
        if ($activities->isNotEmpty()) {
            return $this->responseJson(true, 200, 'Fetch Activities List Successfully', ActiviteiesResources::collection($activities));
        } else {
            return $this->responseJson(true, 200, 'Activities List Data Not Found', []);
        }
    }
    // public function activitiesList()
    // {
    //     $authCompany = Auth::guard('company-api')->user()->company_id;
    //     $datas = Activities::with('units', 'project', 'subproject', 'parent', 'children')->orderBy('id', 'asc')->where('company_id', $authCompany)->get();
    //     if (count($datas) > 0) {
    //         return $this->responseJson(true, 200, 'Fetch Activities List Successfullsy', ActiviteiesResources::collection($datas));
    //     } else {
    //         return $this->responseJson(true, 200, 'Activities List Data Not Found', []);
    //     }
    // }
    public function activitiesAdd(Request $request)
    {
        $authConpany = Auth::guard('company-api')->user()->company_id;
        $validator = Validator::make($request->all(), [
            'project' => 'required',
            'type' => 'required|in:heading,activites',
            'heading' => 'required_if:type,activites',
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
                    'subproject_id' => $request->subproject,
                    'type' => $request->type,
                    'parent_id' => $request->heading,
                    'activities' => $request->activities,
                    'unit_id' => $unitId,
                    'qty' => $request->quantity,
                    'rate' => $request->rate,
                    'amount' => $request->amount,
                    'start_date' => $request->start_date,
                    'end_date' => $request->end_date,
                ]);
                $message = 'Activities Updated Successfullsy';
            } else {
                $isActivitiesCreated = Activities::create([
                    'uuid' => Str::uuid(),
                    'project_id' => $request->project,
                    'subproject_id' => $request->subproject,
                    'type' => $request->type,
                    'parent_id' => $request->heading,
                    'activities' => $request->activities,
                    'unit_id' => $unitId,
                    'qty' => $request->quantity,
                    'rate' => $request->rate,
                    'amount' => $request->amount,
                    'start_date' => $request->start_date,
                    'end_date' => $request->end_date,
                    'company_id' => $authConpany,
                ]);
                $message = 'Activities Created Successfullsy';
            }
            if (isset($isActivitiesCreated) || isset($isActivitiesUpdate)) {
                DB::commit();
                return $this->responseJson(true, 201, $message, $isActivitiesCreated ?? $isActivitiesUpdate);
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
        $datas = Activities::where('company_id', $authCompany)
            ->where('is_active', 1);
        if ($request->has('search_keyword') && $request->search_keyword != "") {
            $datas->where(function ($q) use ($request) {
                $q->where('activities', 'LIKE', '%' . $request->search_keyword . '%')
                    ->orWhere('type', 'LIKE', '%' . $request->search_keyword . '%')
                    ->orWhere('project_id',  $request->project)
                    ->orWhere('subproject_id', $request->subproject);
                    // ->orWhere('gst_no', 'LIKE', '%' . $request->search_keyword . '%')
                    // ->orWhere('activities', 'LIKE', '%' . $request->search_keyword . '%')
                    // ->orWhere('email', 'LIKE', '%' . $request->search_keyword . '%')
                // ->orWhere('phone', 'LIKE', '%' . $request->search_keyword . '%');
            });
        }
        $datas = $datas->get();
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
        return $this->responseJson(true, 200, $message, new ActiviteiesResources($datas));
    }

    public function delete($uuid)
    {
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
// $keyword = $request->input('search_keyword');
// $users = User::where(function ($query) use ($keyword) {
//     $query->where('name', 'LIKE', '%' . $keyword . '%')
//           ->orWhere('email', 'LIKE', '%' . $keyword . '%');
// })
// ->orWhereHas('posts', function ($query) use ($keyword) {
//     $query->where('title', 'LIKE', '%' . $keyword . '%')
//           ->orWhere('content', 'LIKE', '%' . $keyword . '%');
// })
// ->orWhereHas('comments', function ($query) use ($keyword) {
//     $query->where('text', 'LIKE', '%' . $keyword . '%');
// })
// ->get();
