<?php

namespace app\Http\Controllers\API\inventory;

use App\Http\Controllers\BaseController;
use App\Http\Resources\API\Inventory\inventor\InventoryResources;
use App\Models\Company\Quote;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class QuoteController extends BaseController
{
    public function index()
    {
        $authCompany = Auth::guard('company-api')->user();
        $this->setPageTitle('Quote Management');
        $datas = Quote::where('company_id', $authCompany->company_id)
            ->where('user_id', $authCompany->id)->get();
        if (isset($data)) {
            // return $this->responseJson(true, 200, 'Fetch Quote List Successfullsy', InventoryResources::collection($data));
            return $this->responseJson(true, 200, 'Fetch Quote List Successfullsy', $data);
        } else {
            return $this->responseJson(true, 200, 'Quote List Data Not Found', []);
        }
    }
    public function add(Request $request)
    {
        $authCompany = Auth::guard('company-api')->user();
        try {
            $isInventoryDatas = Quote::updateOrCreate(
                [
                    'date' => Carbon::now()->format('Y-m-d'),
                    'projects_id' => $request->projects_id,
                    'user_id' => $authCompany->id
                ],
                [
                    'name' => $request->name,
                    'company_id' => $authCompany->company_id,
                    'user_id' => $authCompany->id,
                    'projects_id' => $request->projects_id
                ]
            );
            if ($request->id) {
                $message = 'Quote Details Updated Successfully';
            } else {
                $message = 'Quote Details Created Successfully';
            }
            return $this->responseJson(true, 201, $message, $isInventoryDatas);
        } catch (\Exception $e) {
            logger($e->getMessage() . ' on ' . $e->getFile() . ' in ' . $e->getLine());
            return $this->responseJson(false, 500, $e->getMessage(), []);
        }
    }
    // public function add(Request $request)
    // {
    //     // dd($request->all());
    //     $authCompany = Auth::guard('company-api')->user();
    //     DB::beginTransaction();
    //     $checkInventory = Quote::where(['date' => Carbon::now()->format('Y-m-d'), 'projects_id' => $request->projects_id, 'user_id' => $authCompany->id])->first();
    //     try {
    //         if ($request->id == null && $checkInventory == null) {
    //             $isInventoryDatas = new Quote();
    //             $isInventoryDatas->name = $request->name;
    //             $isInventoryDatas->date = Carbon::now()->format('Y-m-d');
    //             $isInventoryDatas->company_id = $authCompany->company_id;
    //             $isInventoryDatas->user_id = $authCompany->id;
    //             $isInventoryDatas->projects_id = $request->projects_id;
    //             // $isInventoryDatas->store_id = $request->store_id;
    //         } else {
    //             $isInventoryDatas = Quote::find($checkInventory->id);
    //         }
    //         $isInventoryDatas->projects_id = $request->projects_id;
    //         // $isInventoryDatas->store_id = $request->store_id;
    //         $isInventoryDatas->save();
    //         if ($request->id) {
    //             $message = 'Quote Details Updated Successfullsy';
    //         } else {
    //             $message = 'Quote Details Created Successfullsy';
    //         }
    //         if (isset($isInventoryDatas)) {
    //             DB::commit();
    //             return $this->responseJson(true, 201, $message, $isInventoryDatas);
    //         }
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         logger($e->getMessage() . 'on' . $e->getFile() . 'in' . $e->getLine());
    //         return $this->responseJson(false, 500, $e->getMessage(), []);
    //     }
    // }
}
