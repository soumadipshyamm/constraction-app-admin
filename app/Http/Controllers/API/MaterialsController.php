<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Company\Materials;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BaseController;
use App\Http\Resources\API\Materials\MaterialsResources;

class MaterialsController extends BaseController
{

    public function materialsList(Request $request)
    {
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $data = Materials::with('units')->where('company_id', $authCompany)->get();
        $message = $data->isNotEmpty() ? 'Fetch Materials List Successfully' : 'Materials List Data Not Found';
        return $this->responseJson(true, 200, $message, $data);
    }


    public function materialsAdd(Request $request)
    {
        $authCompany = Auth::guard('company-api')->user()->company_id;
        if ($request->updateId) {
            $validatedData = $request->validate([
                'class' => 'required|in:Class-A,Class-B,Class-C',
                'name' => 'required',
                'unit_id' => 'required',
            ]);
        } else {
            $validatedData = $request->validate([
                'class' => 'required|in:Class-A,Class-B,Class-C',
                'name' => ' required|unique:materials,name',
                'unit_id' => 'required',
            ]);
        }
        DB::beginTransaction();
        try {
            if ($request->updateId) {
                $id = $request->updateId;
                $isUpdated = Materials::where('id', $id)->update([
                    'class' => $request->class,
                    'name' => $request->name,
                    'specification' => $request->specification,
                    'unit_id' => $request->unit_id,
                ]);
                $message = "Materials Updated Successfully";
            } else {
                $ismaterialCreated = Materials::create([
                    'uuid' => Str::uuid(),
                    'class' => $request->class,
                    'code' => uniqid(6),
                    'name' => $request->name,
                    'specification' => $request->specification,
                    'unit_id' => $request->unit_id,
                    'company_id' => $authCompany,
                ]);
                $message = 'Materials Created Successfully';
            }
            if (isset($ismaterialCreated) || isset($isUpdated)) {
                // Commit the transaction on success
                DB::commit();
                return $this->responseJson(true, 201, $message, $ismaterialCreated ?? $isUpdated);
            }
        } catch (\Exception $e) {
            // Rollback the transaction on error and log the exception
            DB::rollBack();
            logger($e->getMessage() . ' on ' . $e->getFile() . ' in ' . $e->getLine());
            // Return an error response in JSON
            return $this->responseJson(false, 500, $e->getMessage(), []);
        }
    }


    public function materialsSearch(Request $request)
    {
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $datas = Materials::where('company_id', $authCompany)
            ->where('is_active', 1);
        if ($request->has('search_keyword') && $request->search_keyword != "") {
            $datas->where(function ($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->search_keyword . '%')
                    ->orWhere('code', 'LIKE', '%' . $request->search_keyword . '%');
            });
        }
        $datas = $datas->get();
        if (count($datas) > 0) {
            return $this->responseJson(true, 200, 'Fetch Search List Successfullsy', $datas);
        } else {
            return $this->responseJson(true, 200, 'Materials Search Data Not Found', []);
        }
    }




    public function edit($uuid)
    {
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $datas = Materials::where('id', $uuid)->where('company_id', $authCompany)->first();
        $message =  'Fetch Materials List Successfully';

        return $this->responseJson(true, 200, $message, new MaterialsResources($datas));
    }



    public function delete($uuid)
    {
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $data = Materials::where('id', $uuid)
            ->where('company_id', $authCompany)
            ->delete();
        $message = $data > 0 ? 'Materials Delete Successfully' : 'Materials Data Not Found';
        return $this->responseJson(true, 200, $message, $data);
    }
}
