<?php

namespace App\Http\Controllers\API\inventory;

use App\Http\Controllers\BaseController;
use App\Http\Resources\API\Inventory\inventor\InventoryResources;
use App\Http\Resources\API\Inventory\Quotes\QuotesDetailsresources;
use App\Http\Resources\API\Inventory\Quotes\Quotesresources;
use App\Http\Resources\API\Materials\MaterialsResources;
use App\Models\QuotesDetails;
use Illuminate\Http\Request;
use App\Models\Company\Quote;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class QuotesDetailsController extends BaseController
{
    public function index()
    {
        $authConpany = Auth::guard('company-api')->user()->company_id;
        $data = Quote::where('company_id', $authConpany)->get();
        if (isset($data)) {
            return $this->responseJson(true, 200, 'Fetch Quote List Successfullsy', InventoryResources::collection($data));
        } else {
            return $this->responseJson(true, 200, 'Quote List Data Not Found', []);
        }
    }

    public function add(Request $request)
    {
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $validator = Validator::make($request->all(), [
            'projects_id' => 'required',
            'request_no' => 'required',
            'date' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->responseJson(false, 422, $validator->errors()->first(), []);
        }
        DB::beginTransaction();
        try {
            $uuid = Str::uuid();
            $quotes_id = $request->quotes_id;
            $request_no = $request->request_no;
            $date = $request->date;
            $company_id = $authCompany;
            $remarkes = $request->remarkes;
            $img = $request->img;
            $quoteDetail = QuotesDetails::updateOrCreate(
                ['request_no' => $request_no, 'company_id' => $company_id, 'quotes_id' => $quotes_id,],
                ['uuid' => $uuid, 'date' => $date, 'remarkes' => $remarkes]
            );
            if ($request->has('materials')) {
                foreach ($request->materials as $materialId) {
                    $quoteDetail->material_requests_id = $materialId;
                    $quoteDetail->save();
                }
            }
            if ($request->hasFile('img')) {
                $quoteDetail->img = getImgUpload($request->img, 'upload');
                $quoteDetail->save();
            }
            DB::commit();
            return $this->responseJson(true, 201, 'Quote Details Updated Successfully', $quoteDetail);
        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage() . ' on ' . $e->getFile() . ' in ' . $e->getLine());
            return $this->responseJson(false, 500, $e->getMessage(), []);
        }
    }
    public function edit(Request $request)
    {
        $fetches = [];
        $dataimg = [];
        $id = $request->quotesId;
        $findId = Quote::find($id);
        $fetchData = [];
        if ($findId) {
            $authCompany = Auth::guard('company-api')->user()->company_id;
            $data = Quote::with(['quotesdetails' => function ($q) use ($id) {
                $q->where('quotes_id', $id);
            }])
                ->where('company_id', $authCompany)
                ->where('id', $id)
                ->first();


            $fetchData['project'] = $data->projects_id;
            $combinedCollection = $data->quotesdetails->each(function ($q) {
                $reqId = $q->material_requests_id;
                $q->load(['quotsmaterialsRequest' => function ($qu) use ($reqId) {
                    $qu->where('id', $reqId)->with(['materialRequestDetails' => function ($mqu) use ($reqId) {
                        $mqu->where('material_requests_id', $reqId)->with('materials');
                    }]);
                }]);
            });

            foreach ($combinedCollection as $key => $value) {
                if ($value->material_requests_id != null) {
                    $qwert = $value->quotsmaterialsRequest?->materialRequestDetails;
                    if ($qwert != null) {
                        foreach ($qwert as $valQumal) {
                            $fetches[] = $valQumal->materials;
                        }
                    }
                } else {
                    $dataimg[] = $value;
                }
            }
            // dd($dataimg);
            if ($dataimg) {
                $fetchData['flage'] = 0;
                $fetchData['data'] = QuotesDetailsresources::collection($dataimg);
            } else {
                $fetchData['flage'] = 1;
                $fetchData['data'] = MaterialsResources::collection($fetches);
                // $fetchData['data'] = Quotesresources::collection($fetches);
            }
            $message = 'Fetch Quote List Successfully';
        } else {
            $data = [];
            $message = 'ID Do Not Found';
        }
        return $this->responseJson(true, 200, $message, $fetchData);
    }
}
    // public function add(Request $request)
    // {
    //     $authCompany = Auth::guard('company-api')->user()->company_id;
    //     $validator = Validator::make($request->all(), [
    //         'projects_id' => 'required',
    //         'request_no' => 'required',
    //         'date' => 'required',
    //     ]);
    //     if ($validator->fails()) {
    //         $status = false;
    //         $code = 422;
    //         $response = [];
    //         $message = $validator->errors()->first();
    //         return $this->responseJson($status, $code, $message, $response);
    //     }
    //     DB::beginTransaction();
    //     try {
    //         $materialIds = $request->materials;
    //         $uuid = Str::uuid();
    //         $quotes_id = $request->quotes_id;
    //         $request_no = $request->request_no;
    //         $date = $request->date;
    //         $company_id = $authCompany;
    //         $remarkes = $request->remarkes;
    //         $img = $request->img;
    //         if (!empty($request->materials)) {
    //             foreach ($materialIds as $materialId) {
    //                 $isActivityCreated = new  QuotesDetails();
    //                 $isActivityCreated->uuid = $uuid;
    //                 $isActivityCreated->material_requests_id = $materialId;
    //                 $isActivityCreated->quotes_id = $quotes_id;
    //                 $isActivityCreated->request_no = $request_no;
    //                 $isActivityCreated->date = $date;
    //                 $isActivityCreated->company_id = $company_id;
    //                 $isActivityCreated->save();
    //             }
    //         } else {
    //             if ($request->hasFile('img')) {
    //                 $isActivityCreated = new  QuotesDetails();
    //                 $isActivityCreated->uuid = $uuid;
    //                 $isActivityCreated->quotes_id = $quotes_id;
    //                 $isActivityCreated->request_no = $request_no;
    //                 $isActivityCreated->date = $date;
    //                 $isActivityCreated->company_id = $company_id;
    //                 $isActivityCreated->img = getImgUpload($request->img, 'upload');
    //                 $isActivityCreated->remarkes = $remarkes;
    //             }
    //         }
    //         $isActivityCreated->save();
    //         $message = 'Quote Details Updated Successfullsy';
    //         if (isset($isActivityCreated)) {
    //             DB::commit();
    //             return $this->responseJson(true, 201, $message, $isActivityCreated);
    //         }
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         logger($e->getMessage() . 'on' . $e->getFile() . 'in' . $e->getLine());
    //         return $this->responseJson(false, 500, $e->getMessage(), []);
    //     }
    // }
    // public function edit(Request $request)
    // {
    //     $id=$request->quotesId;
    //     $findId = Quote::find($id);
    //     if ($findId) {
    //         $authCompany = Auth::guard('company-api')->user()->company_id;
    //         $data = Quote::where('company_id', $authCompany)
    //             ->where('id', $id)
    //             ->latest('id')
    //             ->first();
    //         $message = 'Fetch Quote List Successfullsy';
    //     } else {
    //         $data = [];
    //         $message = 'ID Do Not Found';
    //     }
    //     return $this->responseJson(true, 200, $message, $data);
    // }
// "projects_id" => 3
// "quotes_id" => 2
// "request_no" => "hdgfswe54673"
// "date" => "2013-11-10"
// "remarkes" => "this is a specification"
// "img" => null
// "materials_id" => 1
