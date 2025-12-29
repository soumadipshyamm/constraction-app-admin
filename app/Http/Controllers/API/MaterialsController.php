<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Company\Materials;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BaseController;
use App\Http\Resources\API\Materials\MaterialsMasterResources;
use App\Http\Resources\API\Materials\MaterialsResources;
use App\Http\Resources\MasterMaterialResources;

class MaterialsController extends BaseController
{
    public function materialsList(Request $request)
    {
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $data = Materials::with('units')->where('company_id', $authCompany)->orderBy('class', 'asc')->get();
        $message = $data->isNotEmpty() ? 'Fetch Materials List Successfully' : 'Materials List Data Not Found';
        // return $this->responseJson(true, 200, $message, $data);
        return $this->responseJson(true, 200, $message, MasterMaterialResources::collection($data));
    }

    public function materialsAdd(Request $request)
    {
        log_daily(
            'materials',
            'materialsAdd',
            'materialsAdd',
            'info',
            json_encode($request->all())
        );
        $authCompany = Auth::guard('company-api')->user()->company_id;

        // if ($request->updateId) {
        //     $validatedData = $request->validate([
        //         'class' => 'required|in:Class-A,Class-B,Class-C',
        //         'name' => 'required',
        //         'unit_id' => 'required',
        //     ]);
        // } else {
        //     $validatedData = $request->validate([
        //         'class' => 'required|in:Class-A,Class-B,Class-C',
        //         'name' => ' required|unique:materials,name',
        //         'unit_id' => 'required',
        //     ]);
        // }

        $validatedData = $request->validate([
            'class' => 'required|in:A,B,C',
            'name' => [
                'required',
                function ($attribute, $value, $fail) use ($request) {
                    $query = Materials::where('name', $value);

                    // Check if specification is null or matches the provided one
                    if ($request->specification) {
                        $query->where('specification', $request->specification);
                    } else {
                        $query->whereNull('specification');
                    }

                    if ($request->updateId) {
                        // Skip checking if the material already exists if it's an update
                        $query->where('id', '<>', $request->updateId);
                    }

                    if ($query->exists()) {
                        $fail('A material with the same name and specification already exists.');
                    }
                },
            ],
            'specification' => 'nullable|string',
            'unit_id' => 'required|exists:units,id', // Ensure unit_id exists in the units table
        ]);

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
                    // 'code' => uniqid(6),
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
        // dd($datas);
        return $this->responseJson(true, 200, $message, new MaterialsMasterResources($datas));
    }

    public function delete($uuid)
    {
        log_daily(
            'materials',
            'delete',
            'delete',
            'info',
            json_encode(['uuid' => $uuid])
        );
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $data = Materials::where('id', $uuid)
            ->where('company_id', $authCompany)
            ->delete();
        $message = $data > 0 ? 'Materials Delete Successfully' : 'Materials Data Not Found';
        return $this->responseJson(true, 200, $message, $data);
    }
}
