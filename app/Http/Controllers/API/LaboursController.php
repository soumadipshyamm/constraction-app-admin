<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Company\Labour;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\API\Labours\LaboursResources;

class LaboursController extends BaseController
{
    public function listLabour(Request $request)
    {
        // dd(Auth::guard('company')->user());
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $data = Labour::with('units')->where('company_id', $authCompany)->orderBy('id','desc')->get();
        // dd($data->toArray());
        $message = $data->isNotEmpty() ? 'Fetch Labours List Successfully' : 'Labours List Data Not Found';
        return $this->responseJson(true, 200, $message, LaboursResources::collection($data));
    }
    public function addLabour(Request $request)
    {
        $authConpany = Auth::guard('company-api')->user()->company_id;
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'category' => 'required|in:skilled,semiskilled,unskilled',
            'unit_id' => 'required',
        ]);
        if ($validator->fails()) {
            $status = false;
            $code = 422;
            $response = [];
            $message = $validator->errors()->first();
            return $this->responseJson($status, $code, $message, $response);
        }
        DB::beginTransaction();
        try {
            $findId = Labour::find($request->updateId);
            if (isset($findId)) {
                $isLabourUpdate = Labour::where('id', $request->updateId)->update([
                    'name' => $request->name,
                    'category' => $request->category,
                    'unit_id' => $request->unit_id,
                ]);
                $message = 'Labours Update Successfullsy';
            } else {
                $isLabourCreated = Labour::create([
                    'uuid' => Str::uuid(),
                    'name' => $request->name,
                    'category' => $request->category,
                    'unit_id' => $request->unit_id,
                    'company_id' => $authConpany,
                ]);
                $message = 'Labours Create Successfullsy';
            }
            if (isset($isLabourCreated) || isset($isLabourUpdate)) {
                DB::commit();
                return $this->responseJson(true, 201, $message, $isLabourCreated ?? $isLabourUpdate);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage() . 'on' . $e->getFile() . 'in' . $e->getLine());
            return $this->responseJson(false, 500, $e->getMessage(), []);
        }
    }
    public function labourSearch(Request $request)
    {
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $datas = Labour::with('units')
            ->where('company_id', $authCompany)
            ->where('is_active', 1);

        if ($request->has('search_keyword') && $request->search_keyword != "") {
            $datas->where(function ($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->search_keyword . '%');
            });
        }
        $datas = $datas->get();
        return LaboursResources::collection($datas);
    }
    public function edit($uuid)
    {
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $data = Labour::where('id', $uuid)->where('company_id', $authCompany)->first();
        $message ='Fetch Labour List Successfully' ;
        return $this->responseJson(true, 200, $message, new LaboursResources($data));
    }
    public function delete($uuid)
    {
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $data = Labour::where('id', $uuid)
            ->where('company_id', $authCompany)
            ->delete();
        $message = $data > 0 ? 'Labour Delete Successfully' : 'Labour Data Not Found';
        return $this->responseJson(true, 200, $message, $data);
    }
}
