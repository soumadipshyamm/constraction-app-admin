<?php

namespace App\Http\Controllers\API;

use App\Models\API\Safety;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Http\Controllers\BaseController;
use App\Http\Resources\API\Safety\SafetyResouces;
use Illuminate\Support\Facades\Log;

class SafetyController extends BaseController
{
    // public function index(Request $request)
    // {
    //     $id = $request->dprId;
    //     // dd($id);
    //     $datas="";
    //     $projectId = $request->projects_id;
    //     $subprojectId = $request->sub_projects_id;
    //     $authCompany = Auth::guard('company-api')->user()->company_id;
    //     $this->setPageTitle('Safety');
    //     if (isset($id) && $id != null) {
    //         $datas = Safety::with('companyUsers')->where('company_id', $authCompany)->where('dpr_id', $id)->get();
    //     }
    //     // else {
    //     //     $datas = Safety::with('companyUsers')->where('company_id', $authCompany)->where('projects_id', $projectId)->orWhere('sub_projects_id', $subprojectId)->get()->sortByDesc('id');
    //     // }
    //     dd($datas);
    //     if (isset($datas)) {
    //     // if (is_array($datas) ) {
    //     // if (count($datas) > 0) {
    //         return $this->responseJson(true, 200, 'Fetch Safety List Successfullsy', SafetyResouces::collection($datas));
    //     } else {
    //         return $this->responseJson(true, 200, 'Safety List Data Not Found', []);
    //     }
    // }

    public function index(Request $request)
    {
        $id = $request->dprId;
        $datas = null; // Initialize $datas as null
        $projectId = $request->projects_id;
        $subprojectId = $request->sub_projects_id;
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $this->setPageTitle('Safety');

        if (isset($id) && $id != null) {
            $datas = Safety::with('companyUsers')
                ->where('company_id', $authCompany)
                ->where('dpr_id', $id)
                ->get();
        // } else {
        //     $datas = Safety::with('companyUsers')
        //         ->where('company_id', $authCompany)
        //         ->where(function ($query) use ($projectId, $subprojectId) {
        //             $query->where('projects_id', $projectId)
        //                 ->orWhere('sub_projects_id', $subprojectId);
        //         })
        //         ->get()
        //         ->sortByDesc('id');
        }

        if (isset($datas) && $datas->isNotEmpty()) {
            return $this->responseJson(true, 200, 'Fetch Safety List Successfully', SafetyResouces::collection($datas));
        } else {
            return $this->responseJson(true, 200, 'Safety List Data Not Found', []);
        }
    }

    public function add(Request $request)
    {
        // Log::info("***********************************************isSafetyData");
        // Log::info($request->all());
        // Start a database transaction
        DB::beginTransaction();
        try {
            // Get the authenticated company ID
            $authCompany = Auth::guard('company-api')->user()->company_id;

            // Handle file upload if 'img' is present in the request
            $imgName = null;
            if ($request->hasFile('img')) {
                $imgName = getImgUpload($request->file('img'), 'upload'); // Assuming getImgUpload() is a valid function
            }

            // Determine if we are updating existing or creating new Safety data
            if ($request->id) {
                $isSafetyData = Safety::findOrFail($request->id);
                $message = 'Safety Details Updated Successfully';
            } else {
                $isSafetyData = new Safety();
                $message = 'Safety Details Created Successfully';
            }

            // Assign values from request to the Safety model
            $isSafetyData->name = $request->name;
            $isSafetyData->date = $request->date;
            $isSafetyData->details = $request->details;
            $isSafetyData->remarks = $request->remarks;

            // Check for undefined or null values
            $isSafetyData->company_users_id = $request->company_users_id !== 'undefined' ? $request->company_users_id : null;
            $isSafetyData->projects_id = $request->projects_id !== 'undefined' ? $request->projects_id : null;

            // Correctly check for sub_projects_id
            $isSafetyData->sub_projects_id = !empty($request->sub_projects_id) && $request->sub_projects_id !== 'undefined' && $request->sub_projects_id !== 'null'
                ? $request->sub_projects_id
                : null;

            $isSafetyData->dpr_id = $request->dpr_id;
            $isSafetyData->company_id = $authCompany; // Assuming $authCompany is defined elsewhere
            $isSafetyData->img = $imgName;

            // Save the Safety data
            $isSafetyData->save();

            // Prepare the result
            $result = new SafetyResouces($isSafetyData);

            // Commit the transaction
            DB::commit();

            // Return success response
            return $this->responseJson(true, 200, $message, $result);
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