<?php

namespace App\Http\Controllers\API\inventory;

use App\Http\Controllers\BaseController;
use App\Http\Resources\API\Inventory\inventor\InventoryResources;
use App\Http\Resources\API\Inventory\Quotes\QuotesDetailsresources;
use App\Http\Resources\API\Inventory\Quotes\QuotesMaterialRequestSendVendorResource;
use App\Http\Resources\API\Inventory\Quotes\QuotesMaterialsDetailsresources;
use App\Http\Resources\API\Inventory\Quotes\Quotesresources;
use App\Http\Resources\API\Materials\MaterialsResources;
use App\Http\Resources\API\Vendor\VendorResources;
use App\Models\QuotesDetails;
use Illuminate\Http\Request;
use App\Models\Company\Quote;
use App\Models\QuotesMaterialRequest;
use App\Models\QuotesMaterialSendVendor;
use Google\Service\ShoppingContent\Resource\Collections;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class QuotesDetailsController extends BaseController
{
    public function index()
    {
        $authConpany = Auth::guard('company-api')->user()->company_id;
        $data = Quote::where('company_id', $authConpany)
            ->where('created_at', '>=', now()->subDays(15))
            ->orderBy('id', 'desc')
            ->get();
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
            // 'quotes_id' => 'required',
            // 'materials_id' => 'required',
            // 'material_requests_id' => 'required',
            // 'material_request_details_id' => 'required',
            // 'date' => 'required',
            // 'remarkes' => 'required',
            // 'img' => 'required|image',
            // 'qty' => 'required|numeric',
            // 'request_qty' => 'required|numeric',
            // 'price' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return $this->responseJson(false, 422, $validator->errors()->first(), []);
        }
        DB::beginTransaction();
        try {
            $quoteDetail = [];
            $datas = $request->all();
            // dd($datas);
            if (isset($datas['img'])) {
                $remarkes = $datas['remarkes'];
                $img = $request->img ? getImgUpload($request->img, 'upload') : null;
                $existingQuoteDetail = $datas['id'] != null ? QuotesDetails::where('id', $datas['id'])->first() : null;
                if ($existingQuoteDetail?->id != null) {
                    $quoteDetail = $existingQuoteDetail->update([
                        'date' => null,
                        'remarkes' => $remarkes,
                        'img' => $img ?? null
                    ]);
                } else {
                    $quoteDetail = QuotesDetails::create([
                        'company_id' => $authCompany,
                        'quotes_id' => $datas['quotes_id'],
                        'date' => $datas['date'],
                        'remarkes' => $remarkes,
                        'activities_id' => $datas['activities_id']->id,
                        'materials_id' => null,
                        'material_requests_id' => null,
                        'material_request_details_id' => null,
                        'img' => $img ?? null
                    ]);
                }
            } else {
                // dd($datas);
                foreach ($datas as $value) {
                    if (!empty($value['id'])) {
                        $quoteDetailItem = QuotesDetails::find($value['id']);
                        if (!$quoteDetailItem) {
                            return $this->responseJson(false, 404, 'Quote Detail not found', []);
                        }
                        $quoteDetail[] = $quoteDetailItem;
                        // Update existing quote detail
                        $quoteDetailItem->update([
                            'materials_id' => $value['materials'],
                            'material_requests_id' => $value['material_requests_id'],
                            'material_request_details_id' => $value['material_request_details_id'],
                            'date' => $value['date'],
                            'request_qty' => $value['request_qty'],
                            'price' => $value['price'],
                        ]);
                    } else {
                        // Create new quote detail
                        $quoteDetail[] = QuotesDetails::create([
                            'quotes_id' => $value['quotes_id'],
                            'materials_id' => $value['materials'],
                            'material_requests_id' => $value['material_requests_id'],
                            'material_request_details_id' => $value['material_request_details_id'],
                            'date' => $value['date'],
                            'qty' => $value['qty'],
                            'request_qty' => $value['request_qty'],
                            'price' => $value['price'],
                            'company_id' => $authCompany,
                        ]);
                    }
                }
            }
            DB::commit();
            return $this->responseJson(true, 200, 'Quote Detail Added Successfully', $quoteDetail);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to add quote detail: ' . $e->getMessage());
            return $this->responseJson(false, 500, 'Failed to add quote detail', []);
        }
    }







    // *******************************************************************************************************

    public function edit(Request $request)
    {
        $fetchVendorDatas = [];
        $fetches = [];
        $dataimg = [];
        $fetchData = [];
        $id = $request->quotesId;
        $findId = Quote::find($id);

        if (!$findId) {
            return $this->responseJson(false, 404, 'ID Not Found', []);
        }

        $authCompany = Auth::guard('company-api')->user()->company_id;
        $data = Quote::with('quotesdetails')
            ->where('company_id', $authCompany)
            ->where('id', $id)
            ->first();

            // dd($data);
        $data->quotesdetails->each(function ($q) {
            $q->load(['materialsRequest']);
        });
        // dd($data);
        foreach ($data->quotesdetails as $value) {
            if ($value->material_requests_id) {
                $fetches = $value;
            } else {
                $dataimg = $value;
            }
        }
        // dd($fetches->quotes->materialrequestvendor);
        $fetchVendorData = $fetches?->quotes?->materialrequestvendor;
        // $fetchVendorDatas = $fetchVendorData->each(function ($value, $key) {
        //     return $value->vendorlist;
        //     // dd(->toArray());
        //     // $value->material_requests_id = $querssy->id;
        // });
        // dd($fetchVendorDatas);
        $fetchData['flage'] = empty($dataimg) ? 1 : 0;
        $fetchData['vendor_data'] = $fetchVendorData ? QuotesMaterialRequestSendVendorResource::collection($fetchVendorData) : [];
        $fetchData['data'] = empty($dataimg) ? ($fetches ? new QuotesMaterialsDetailsresources($fetches) : []) : ($dataimg ? new QuotesDetailsresources($dataimg) : []);

        return $this->responseJson(true, 200, 'Fetch Quote List Successfully', $fetchData);
    }

    // *******************************************************************************************************
    public function materialrequestSendToVendor(Request $request)
    {
        // Validate incoming request if needed
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $validator = Validator::make($request->all(), [
            'type' => 'required|integer',
            'vendor_id' => 'required|array',
            // 'quotes_details_id' => 'required|array',
        ]);
        if ($validator->fails()) {
            return $this->responseJson(false, 422, $validator->errors()->first(), []);
        }
        DB::beginTransaction();
        try {
            // dd($request->all());
            $quoteDetail = [];
            // Extract data from the request
            $type = $request->input('type');
            $vendorIds = $request->input('vendor_id');
            $quoteDetailsIds = $request->input('quotes_details_id');
            $quotes_id = $request->input('quotes_id');
            $material_request_details_id = $request->input('material_request_details_id');
            $material_requests_id = $request->input('material_requests_id');
            $materials_id = $request->input('materials_id');
            // $quoteDetailsId = $quoteDetailsIds[$index];
            foreach ($vendorIds as $index => $vendorId) {
                foreach ($quotes_id as $key => $qtrdetails) {
                    $quoteDetail[] = QuotesMaterialSendVendor::create([
                        'vendors_id' => $vendorId,
                        'materials_id' => $materials_id ? $materials_id[$key] : null,
                        'quotes_details_id' => $quoteDetailsIds ? $quoteDetailsIds[$key] : null,
                        'quotes_id' => $qtrdetails,
                        'material_request_details_id' => $material_request_details_id ? $material_request_details_id[$key] : null,
                        'type' => $type,
                        'company_id' => $authCompany
                    ]);
                }
            }

            DB::commit();
            $quoteDetailResource = QuotesMaterialRequestSendVendorResource::collection($quoteDetail);

            return $this->responseJson(true, 200, 'Quote Details Updated Successfully',  $quoteDetailResource);
        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage() . ' on ' . $e->getFile() . ' in ' . $e->getLine());
            return $this->responseJson(false, 500, $e->getMessage(), []);
        }
    }
}
