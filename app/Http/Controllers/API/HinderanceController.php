<?php

namespace App\Http\Controllers\API;

use App\Models\API\Hinderance;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Http\Resources\API\Hinderance\HinderanceResouces;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class HinderanceController extends BaseController
{
    public function index(Request $request)
    {
        $id = $request->dprId;
        $projectId = $request->projects_id;
        $subprojectId = $request->sub_projects_id;
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $this->setPageTitle('User Management');
        if (isset($id) && $id != null) {
            $datas = Hinderance::where('company_id', $authCompany)->where('projects_id', $projectId)->orWhere('sub_projects_id', $subprojectId)->where('dpr_id', $id)->get();
        } else {
            $datas = Hinderance::where('company_id', $authCompany)->where('projects_id', $projectId)->orWhere('sub_projects_id', $subprojectId)->get()->sortByDesc('id');
        }

        if (count($datas) > 0) {
            return $this->responseJson(true, 200, 'Fetch Hinderance List Successfullsy', HinderanceResouces::collection($datas));
        } else {
            return $this->responseJson(true, 200, 'Hinderance List Data Not Found', []);
        }
    }
    public function add(Request $request)
    {
        $authCompany = Auth::guard('company-api')->user()->company_id;
        DB::beginTransaction();
        try {
            $imgName = getImgUpload($request->img, 'upload');
            if ($request->id) {
                $isSafetyDatas = Hinderance::find($request->id);
            } else {
                $isHinderanceDatas = new Hinderance();
            }
            $isHinderanceDatas->name = $request->name;
            $isHinderanceDatas->date = $request->date;
            $isHinderanceDatas->details = $request->details;
            $isHinderanceDatas->remarks = $request->remarks;
            $isHinderanceDatas->company_users_id = $request->company_users_id ?? '';
            $isHinderanceDatas->projects_id = $request->projects_id;
            $isHinderanceDatas->sub_projects_id = $request->sub_projects_id;
            $isHinderanceDatas->dpr_id  = $request->dpr_id;
            $isHinderanceDatas->company_id = $authCompany;
            $isHinderanceDatas->img = $imgName;
            $isHinderanceDatas->save();
            if ($request->id) {
                $message = 'Hinderance Details Updated Successfullsy';
            } else {
                $message = 'Hinderance Details Created Successfullsy';
            }
            if (isset($isHinderanceDatas)) {
                DB::commit();
                return $this->responseJson(true, 201, $message, new HinderanceResouces($isHinderanceDatas));
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
        $data = Hinderance::where('id', $uuid)->where('company_id', $authCompany)->get();
        $message = $data->isNotEmpty() ? 'Fetch Hinderance List Successfully' : 'Hinderance List Data Not Found';
        return $this->responseJson(true, 200, $message, $data);
    }
    public function delete($uuid)
    {
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $data = Hinderance::where('id', $uuid)
            ->where('company_id', $authCompany)
            ->delete();
        $message = $data > 0 ? 'Hinderance Delete Successfully' : 'HinderanceHinderance Data Not Found';
        return $this->responseJson(true, 200, $message, $data);
    }
}
