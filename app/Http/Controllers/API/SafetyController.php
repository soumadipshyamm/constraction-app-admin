<?php

namespace App\Http\Controllers\API;

use App\Models\API\Safety;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Http\Controllers\BaseController;
use App\Http\Resources\API\Safety\SafetyResouces;

class SafetyController extends BaseController
{
    public function index(Request $request)
    {
        $id = $request->dprId;
        $projectId = $request->projects_id;
        $subprojectId = $request->sub_projects_id;
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $this->setPageTitle('Safety');
        if (isset($id) && $id != null) {
            $datas = Safety::with('companyUsers')->where('company_id', $authCompany)->where('projects_id', $projectId)->orWhere('sub_projects_id', $subprojectId)->where('dpr_id', $id)->get();
        } else {
            $datas = Safety::with('companyUsers')->where('company_id', $authCompany)->where('projects_id', $projectId)->orWhere('sub_projects_id', $subprojectId)->get()->sortByDesc('id');
        }
        // dd($datas);
        if (count($datas) > 0) {
            return $this->responseJson(true, 200, 'Fetch Safety List Successfullsy', SafetyResouces::collection($datas));
        } else {
            return $this->responseJson(true, 200, 'Safety List Data Not Found', []);
        }
    }

    public function add(Request $request)
    {
        $authCompany = Auth::guard('company-api')->user()->company_id;
        DB::beginTransaction();
        try {
            $imgName = getImgUpload($request->img, 'upload');
            // dd($imgName);
            if ($request->id) {
                $isSafetyDatas = Safety::find($request->id);
            } else {
                $isSafetyDatas = new Safety();
            }
            $isSafetyDatas->name = $request->name;
            $isSafetyDatas->date = $request->date;
            $isSafetyDatas->details = $request->details;
            $isSafetyDatas->remarks = $request->remarks;
            $isSafetyDatas->company_users_id = $request->company_users_id;
            $isSafetyDatas->projects_id = $request->projects_id;
            $isSafetyDatas->sub_projects_id = $request->sub_projects_id;
            $isSafetyDatas->dpr_id  = $request->dpr_id;
            $isSafetyDatas->company_id = $authCompany;
            $isSafetyDatas->img = $imgName;
            $isSafetyDatas->save();
            if ($request->id) {
                $message = 'Safety Details Updated Successfullsy';
            } else {
                $message = 'Safety Details Created Successfullsy';
            }
            if (isset($isSafetyDatas)) {
                DB::commit();
                return $this->responseJson(true, 201, $message, new SafetyResouces($isSafetyDatas));
            }
        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage() . 'on' . $e->getFile() . 'in' . $e->getLine());
            return $this->responseJson(false, 500, $e->getMessage(), []);
        }
    }
    public function edit($uuid)
    {
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $data = Safety::where('id', $uuid)->where('company_id', $authCompany)->get();
        $message = $data->isNotEmpty() ? 'Fetch Safety List Successfully' : 'Safety List Data Not Found';
        return $this->responseJson(true, 200, $message, $data);
    }
    public function delete($uuid)
    {
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $data = Safety::where('id', $uuid)
            ->where('company_id', $authCompany)
            ->delete();
        $message = $data > 0 ? 'Safety Delete Successfully' : 'Safety Data Not Found';
        return $this->responseJson(true, 200, $message, $data);
    }
}
