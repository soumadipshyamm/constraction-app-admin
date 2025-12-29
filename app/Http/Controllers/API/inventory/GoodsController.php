<?php

namespace App\Http\Controllers\API\inventory;

use App\Http\Controllers\BaseController;

use App\Models\Company\Goods;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class GoodsController extends BaseController
{
    public function index()
    {
        $authConpany = Auth::guard('company-api')->user()->company_id;
        $data = Goods::where('company_id', $authConpany)->orderBy('id', 'asc')->get();
        if (isset($data)) {
            return $this->responseJson(true, 200, 'Fetch Goods List Successfullsy', $data);
        } else {
            return $this->responseJson(true, 200, 'Goods List Data Not Found', []);
        }
    }

    public function add(Request $request)
    {
        log_daily('Inward', 'Inventory Inward Goods Add GoodsController', 'add', 'info', json_encode($request->all()));

        $authCompany = Auth::guard('company-api')->user()->company_id;
        $validator = Validator::make($request->all(), [
            'type' => 'required',
            'code' => 'required',
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            $status = false;
            $code = 422;
            $response = [];
            $message = $validator->errors()->first();
            return $this->responseJson($status, $code, $message, $response);
        }
        // dd($request->all());
        DB::beginTransaction();
        try {
            $isActivityCreated = Goods::create([
                'uuid' => Str::uuid(),
                'type' => $request->type,
                'code' => $request->code,
                'name' => $request->name,
                'specification' => $request->specification,
                'material_class' => $request->material_class,
                'img' => $request->img,
                'company_id' => $authCompany,
            ]);
            $message = 'Goods Details Updated Successfullsy';
            // }
            if (isset($isActivityCreated)) {
                DB::commit();
                return $this->responseJson(true, 201, $message, $isActivityCreated);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage() . 'on' . $e->getFile() . 'in' . $e->getLine());
            return $this->responseJson(false, 500, $e->getMessage(), []);
        }
    }
    public function edit($id)
    {
        $findId = Goods::find($id);
        if ($findId) {
            $authCompany = Auth::guard('company-api')->user()->company_id;
            $data = Goods::where('company_id', $authCompany)
                ->where('id', $id)
                ->latest('id')
                ->first();
            $message = 'Fetch Goods List Successfullsy';
        } else {
            $data = [];
            $message = 'ID Do Not Found';
        }
        return $this->responseJson(true, 200, $message, $data);
    }
}
