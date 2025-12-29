<?php

namespace App\Http\Controllers\API;

use App\Models\API\Hinderance;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Http\Resources\API\Hinderance\HinderanceResouces;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class HinderanceController extends BaseController
{
    public function index(Request $request)
    {

        // dd($request->all());
        $id = $request->dprId;
        $datas="";
        $projectId = $request->projects_id;
        $subprojectId = $request->sub_projects_id;
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $this->setPageTitle('User Management');
        if (isset($id) && $id != null) {
            $datas = Hinderance::where('company_id', $authCompany)->where('dpr_id', $id)->orderBy('id', 'desc')->get();
            // } else {
            //     $datas =[];
        }
        // dd($datas);
        if (isset($datas) && $datas->isNotEmpty()) {
            return $this->responseJson(true, 200, 'Fetch Hinderance List Successfullsy', HinderanceResouces::collection($datas));
        } else {
            return $this->responseJson(true, 200, 'Hinderance List Data Not Found', []);
        }
    }
    public function add(Request $request)
    {
        // Log::info("***************************************88isHinderanceDatas");
        // Log::info($request->all());

        $authCompany = Auth::guard('company-api')->user()->company_id;
        DB::beginTransaction();

        try {
            // Handle file upload if 'img' is present in the request
            $imgName = null;
            if ($request->hasFile('img')) {
                $imgName = getImgUpload($request->file('img'), 'upload'); // Assuming getImgUpload() is a valid function
            }

            // Determine if we are updating existing or creating new Hinderance data
            if ($request->id) {
                $isHinderanceDatas = Hinderance::findOrFail($request->id);
                $message = 'Hinderance Details Updated Successfully';
            } else {
                $isHinderanceDatas = new Hinderance();
                $message = 'Hinderance Details Created Successfully';
            }

            // Assign values from request to the Hinderance model
            $isHinderanceDatas->name = $request->name;
            $isHinderanceDatas->date = $request->date;
            $isHinderanceDatas->details = $request->details;
            $isHinderanceDatas->remarks = $request->remarks;

            // Correctly check for company_users_id and projects_id
            $isHinderanceDatas->company_users_id = $request->company_users_id !== 'undefined' ? $request->company_users_id : null;
            $isHinderanceDatas->projects_id = $request->projects_id !== 'undefined' ? $request->projects_id : null;

            // Correctly check for sub_projects_id
            $isHinderanceDatas->sub_projects_id = isset($request->sub_projects_id) &&
                $request->sub_projects_id !== 'undefined' &&
                $request->sub_projects_id !== 'null'
                ? (int)$request->sub_projects_id // Cast to integer if valid
                : null;

            $isHinderanceDatas->dpr_id = $request->dpr_id;
            $isHinderanceDatas->company_id = $authCompany;
            $isHinderanceDatas->img = $imgName;

            // Save the Hinderance data
            $isHinderanceDatas->save();

            // Prepare the result
            $result = new HinderanceResouces($isHinderanceDatas);

            // Commit the transaction
            DB::commit();

            // Return success response
            return $this->responseJson(true, 201, $message, $result);
        } catch (\Exception $e) {
            // Rollback the transaction on error
            DB::rollBack();
            Log::error($e->getMessage() . ' on ' . $e->getFile() . ' in ' . $e->getLine());
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