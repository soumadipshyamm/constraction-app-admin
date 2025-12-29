<?php
namespace App\Http\Controllers\API\inventory;
use App\Http\Controllers\BaseController;
use App\Http\Resources\API\Inventory\inventor\InventoryResources;
use App\Http\Resources\API\Inventory\Quotes\QuotesDetailsresources;
use App\Http\Resources\API\Inventory\Quotes\QuotesMaterialRequestSendVendorResource;
use App\Http\Resources\API\Inventory\Quotes\QuotesMaterialsDetailsresources;
use App\Http\Resources\API\Inventory\Quotes\Quotesresources;
use App\Http\Resources\API\Materials\MaterialsResources;
use App\Models\QuotesDetails;
use Illuminate\Http\Request;
use App\Models\Company\Quote;
use App\Models\QuotesMaterialRequest;
use App\Models\QuotesMaterialSendVendor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
// class QuotesDetailsController extends BaseController
// {
//     public function index()
//     {
//         $authConpany = Auth::guard('company-api')->user()->company_id;
//         $data = Quote::where('company_id', $authConpany)->orderBy('id', 'desc')->get();
//         if (isset($data)) {
//             return $this->responseJson(true, 200, 'Fetch Quote List Successfullsy', InventoryResources::collection($data));
//         } else {
//             return $this->responseJson(true, 200, 'Quote List Data Not Found', []);
//         }
//     }

// <<<<<<< HEAD
//     public function add(Request $request)
//     {
//         $authCompany = Auth::guard('company-api')->user()->company_id;
//         $validator = Validator::make($request->all(), [
//             // 'quotes_id' => 'required',
//             // 'materials_id' => 'required',
//             // 'material_requests_id' => 'required',
//             // 'material_request_details_id' => 'required',
//             // 'date' => 'required',
//             // 'remarkes' => 'required',
//             // 'img' => 'required|image',
//             // 'qty' => 'required|numeric',
//             // 'request_qty' => 'required|numeric',
//             // 'price' => 'required|numeric',
//         ]);
//         if ($validator->fails()) {
//             return $this->responseJson(false, 422, $validator->errors()->first(), []);
//         }
//         DB::beginTransaction();
//         try {
//             $quoteDetail = [];
//             $datas = $request->all();
//             foreach ($datas as $value) {
//                 if (!empty($value['id'])) {
//                     $quoteDetailItem = QuotesDetails::find($value['id']);
//                     if (!$quoteDetailItem) {
//                         return $this->responseJson(false, 404, 'Quote Detail not found', []);
//                     }
//                     // Update existing quote detail
//                     $quoteDetail[] = $quoteDetailItem->update([
//                         'materials_id' => $value['materials'],
//                         'material_requests_id' => $value['material_requests_id'],
//                         'material_request_details_id' => $value['material_request_details_id'],
//                         'date' => $value['date'],
//                         'request_qty' => $value['request_qty'],
//                         'price' => $value['price'],
//                     ]);
//                 } else {
//                     // Create new quote detail
//                     $quoteDetail[] = QuotesDetails::create([
//                         'quotes_id' => $value['quotes_id'],
//                         'materials_id' => $value['materials'],
//                         'material_requests_id' => $value['material_requests_id'],
//                         'material_request_details_id' => $value['material_request_details_id'],
//                         'date' => $value['date'],
//                         'qty' => $value['qty'],
//                         'request_qty' => $value['request_qty'],
//                         'price' => $value['price'],
//                         'company_id' => $authCompany,
//                     ]);
//                 }
//             }
//             DB::commit();
//             return $this->responseJson(true, 201, 'Quote Detail Added Successfully', $quoteDetail);
//         } catch (\Exception $e) {
//             DB::rollBack();
//             Log::error('Failed to add quote detail: ' . $e->getMessage());
//             return $this->responseJson(false, 500, 'Failed to add quote detail', []);
//         }
//     }
//     // public function add(Request $request)
//     // {
//     //     $authCompany = Auth::guard('company-api')->user()->company_id;
//     //     $validator = Validator::make($request->all(), [
//     //         // 'quotes_id' => 'required',
//     //         // 'materials_id' => 'required',
//     //         // 'material_requests_id' => 'required',
//     //         // 'material_request_details_id' => 'required',
//     //         // 'date' => 'required',
//     //         // 'remarkes' => 'required',
//     //         // 'img' => 'required|image',
//     //         // 'qty' => 'required|numeric',
//     //         // 'request_qty' => 'required|numeric',
//     //         // 'price' => 'required|numeric',
//     //     ]);
//     //     if ($validator->fails()) {
//     //         return $this->responseJson(false, 422, $validator->errors()->first(), []);
//     //     }
//     //     DB::beginTransaction();
//     //     try {
//     //         $quoteDetail = QuotesDetails::create([
//     //             'quotes_id' => $request->quotes_id,
//     //             'materials_id' => $request->materials_id,
//     //             'material_requests_id' => $request->material_requests_id,
//     //             'material_request_details_id' => $request->material_request_details_id,
//     //             'date' => $request->date,
//     //             'remarkes' => $request->remarkes,
//     //             'img' => $request->img->store('quotes_details', 'public'),
//     //             'qty' => $request->qty,
//     //             'request_qty' => $request->request_qty,
//     //             'price' => $request->price,
//     //             'company_id' => $authCompany,
//     //         ]);
//     //         DB::commit();
//     //         return $this->responseJson(true, 201, 'Quote Detail Added Successfully', QuotesDetailsresources::make($quoteDetail));
//     //     } catch (\Exception $e) {
//     //         DB::rollBack();
//     //         Log::error('Failed to add quote detail: ' . $e->getMessage());
//     //         return $this->responseJson(false, 500, 'Failed to add quote detail', []);
//     //     }
//     // }

//     // public function update(Request $request, $id)
//     // {
//     //     $authCompany = Auth::guard('company-api')->user()->company_id;
//     //     $validator = Validator::make($request->all(), [
//     //         'quotes_id' => 'required',
//     //         'materials_id' => 'required',
//     //         'material_requests_id' => 'required',
//     //         'material_request_details_id' => 'required',
//     //         'date' => 'required',
//     //         'remarkes' => 'required',
//     //         'img' => 'nullable|image',
//     //         'qty' => 'required|numeric',
//     //         'request_qty' => 'required|numeric',
//     //         'price' => 'required|numeric',
//     //     ]);
//     //     if ($validator->fails()) {
//     //         return $this->responseJson(false, 422, $validator->errors()->first(), []);
//     //     }
//     //     $quoteDetail = QuotesDetails::find($id);
//     //     if (!$quoteDetail) {
//     //         return $this->responseJson(false, 404, 'Quote Detail not found', []);
//     //     }
//     //     DB::beginTransaction();
//     //     try {
//     //         $quoteDetail->update([
//     //             'quotes_id' => $request->quotes_id,
//     //             'materials_id' => $request->materials_id,
//     //             'material_requests_id' => $request->material_requests_id,
//     //             'material_request_details_id' => $request->material_request_details_id,
//     //             'date' => $request->date,
//     //             'remarkes' => $request->remarkes,
//     //             'img' => $request->img ? $request->img->store('quotes_details', 'public') : $quoteDetail->img,
//     //             'qty' => $request->qty,
//     //             'request_qty' => $request->request_qty,
//     //             'price' => $request->price,
//     //             'company_id' => $authCompany,
//     //         ]);
//     //         DB::commit();
//     //         return $this->responseJson(true, 200, 'Quote Detail Updated Successfully', QuotesDetailsresources::make($quoteDetail));
//     //     } catch (\Exception $e) {
//     //         DB::rollBack();
//     //         Log::error('Failed to update quote detail: ' . $e->getMessage());
//     //         return $this->responseJson(false, 500, 'Failed to update quote detail', []);
//     //     }
//     // }
//     // public function add(Request $request)
//     // {
//     //     $authCompany = Auth::guard('company-api')->user()->company_id;
//     //     $validator = Validator::make($request->all(), [
//     //         // 'quotes_id' => 'required',
//     //         // 'materials_id' => 'required',
//     //         // 'material_requests_id' => 'required',
//     //         // 'material_request_details_id' => 'required',
//     //         // 'date' => 'required',
//     //         // 'remarkes' => 'required',
//     //         // 'img' => 'required|image',
//     //         // 'qty' => 'required|numeric',
//     //         // 'request_qty' => 'required|numeric',
//     //         // 'price' => 'required|numeric',
//     //     ]);
//     //     if ($validator->fails()) {
//     //         return $this->responseJson(false, 422, $validator->errors()->first(), []);
//     //     }
//     //     DB::beginTransaction();
//     //     try {
//     //         $quoteDetail = [];
//     //         $datas = $request->all();
//     //         foreach ($datas as $value) {
//     //             if (!empty($value['id'])) {
//     //                 $quoteDetailItem = QuotesDetails::find($value['id']);
//     //                 if (!$quoteDetailItem) {
//     //                     return $this->responseJson(false, 404, 'Quote Detail not found', []);
//     //                 }
//     //                 // Update existing quote detail
//     //                 $quoteDetail[] = $quoteDetailItem->update([
//     //                     'materials_id' => $value['materials'],
//     //                     'material_requests_id' => $value['material_requests_id'],
//     //                     'material_request_details_id' => $value['material_request_details_id'],
//     //                     'date' => $value['date'],
//     //                     'request_qty' => $value['request_qty'],
//     //                     'price' => $value['price'],
//     //                 ]);
//     //             } else {
//     //                 // Create new quote detail
//     //                 $quoteDetail[] = QuotesDetails::create([
//     //                     'quotes_id' => $value['quotes_id'],
//     //                     'materials_id' => $value['materials'],
//     //                     'material_requests_id' => $value['material_requests_id'],
//     //                     'material_request_details_id' => $value['material_request_details_id'],
//     //                     'date' => $value['date'],
//     //                     'qty' => $value['qty'],
//     //                     'request_qty' => $value['request_qty'],
//     //                     'price' => $value['price'],
//     //                     'company_id' => $authCompany,
//     //                 ]);
//     //             }
//     //         }
//     //         DB::commit();
//     //         return $this->responseJson(true, 201, 'Quote Detail Added Successfully', $quoteDetail);
//     //     } catch (\Exception $e) {
//     //         DB::rollBack();
//     //         Log::error('Failed to add quote detail: ' . $e->getMessage());
//     //         return $this->responseJson(false, 500, 'Failed to add quote detail', []);
//     //     }
//     // }

//     // public function add(Request $request)
//     // {
//     //     $authCompany = Auth::guard('company-api')->user()->company_id;
//     //     $validator = Validator::make($request->all(), [
//     //         '*.projects_id' => 'required',
//     //         // 'request_no' => 'required',
//     //         // 'date' => 'required',
//     //     ]);
//     //     if ($validator->fails()) {
//     //         return $this->responseJson(false, 422, $validator->errors()->first(), []);
//     //     }
//     //     DB::beginTransaction();
//     //     try {
//     //         // dd($request->all());
//     //         $uuid = Str::uuid();
//     //         $quotes_id = $request->quotes_id;
//     //         // $request_no = $request->request_no;
//     //         $date = $request->date;
//     //         $company_id = $authCompany;
//     //         $remarkes = $request->remarkes;
//     //         $img = $request->img;
//     //         $qty = $request->qty;
//     //         $request_qty = $request->request_qty;
//     //         $price = $request->price;
//     //         $material_requests_id = $request->material_requests_id;
//     //         $quoteDetail = [];
//     //         $getMaterialsId = (array)$request->get('materials');
//     //         $getMaterialsReqDetailsIds = (array)$request->get('material_request_details_id');
//     //         $getRequiredMaterialsDates = (array)$request->get('date');
//     //         $existingQuoteDetail = $request->id != null ? QuotesDetails::where('id', $request->id)->first() : null;
//     //         // dd($existingQuoteDetail);
//     //         if ($request->has('materials')) {
//     //             // dd($request->all());
//     //             if ($existingQuoteDetail) {
//     //                 // dd($request->all());
//     //                 foreach ($getMaterialsId as $index =>  $materialId) {
//     //                     $getMaterialsReqDetailsId = $getMaterialsReqDetailsIds[$index];
//     //                     $getRequiredMaterialsDate = $getRequiredMaterialsDates[$index];
//     //                     $quoteDetail = $existingQuoteDetail->update([
//     //                         'date' => $getRequiredMaterialsDate,
//     //                         'remarkes' => $remarkes,
//     //                         'materials_id' => $materialId,
//     //                         'material_requests_id' => $material_requests_id,
//     //                         'material_request_details_id' => $materialId,
//     //                         'qty' => $qty,
//     //                         'request_qty' => $request_qty,
//     //                         'price' => $price,
//     //                     ]);
//     //                 }
//     //             } else {
//     //                 // dd($request->all());
//     //                 // dd($getMaterialsReqDetailsIds);
//     //                 foreach ($getMaterialsId as $index => $materialId) {
//     //                     $getMaterialsReqDetailsId = $getMaterialsReqDetailsIds[$index];
//     //                     $getRequiredMaterialsDate = $getRequiredMaterialsDates[$index];
//     //                     // dd($getMaterialsReqDetailsId);
//     //                     $quoteDetail = QuotesDetails::create([
//     //                         // 'request_no' => $request_no,
//     //                         'company_id' => $company_id,
//     //                         'quotes_id' => $quotes_id,
//     //                         'uuid' => $uuid,
//     //                         // 'date' => $getRequiredMaterialsDate,
//     //                         'qty' => $qty,
//     //                         'request_qty' => $request_qty,
//     //                         'price' => $price,
//     //                         'remarkes' => $remarkes,
//     //                         'materials_id' => $materialId,
//     //                         'material_requests_id' => $material_requests_id,
//     //                         'material_request_details_id' => $getMaterialsReqDetailsId
//     //                     ]);
//     //                 }
//     //             }
//     //         }
//     //         if ($request->hasFile('img')) {
//     //             if ($existingQuoteDetail) {
//     //                 $quoteDetail = $existingQuoteDetail->update([
//     //                     'date' => null,
//     //                     'remarkes' => $remarkes,
//     //                     'img' => getImgUpload($request->img, 'upload')
//     //                 ]);
//     //             } else {
//     //                 $quoteDetail = QuotesDetails::create([
//     //                     // 'request_no' => $request_no,
//     //                     'company_id' => $company_id,
//     //                     'quotes_id' => $quotes_id,
//     //                     'uuid' => $uuid,
//     //                     'date' => null,
//     //                     'remarkes' => $remarkes,
//     //                     'materials_id' => null,
//     //                     'material_requests_id' => null,
//     //                     'material_request_details_id' => null,
//     //                     'img' => getImgUpload($request->img, 'upload')
//     //                 ]);
//     //             }
//     //         }
//     //         DB::commit();
//     //         return $this->responseJson(true, 200, 'Quote Details Updated Successfully', $quoteDetail);
//     //     } catch (\Exception $e) {
//     //         DB::rollBack();
//     //         logger($e->getMessage() . ' on ' . $e->getFile() . ' in ' . $e->getLine());
//     //         return $this->responseJson(false, 500, $e->getMessage(), []);
//     //     }
//     // }
// <<<<<<< HEAD
// =======

// >>>>>>> a4c4f0098ff3da887c51224a7ae89aa3ff9f6978

//     public function add(Request $request)
//     {
//         $authCompany = Auth::guard('company-api')->user()->company_id;
//         $validator = Validator::make($request->all(), [
// <<<<<<< HEAD
//             // 'quotes_id' => 'required',
//             // 'materials_id' => 'required',
//             // 'material_requests_id' => 'required',
//             // 'material_request_details_id' => 'required',
//             // 'date' => 'required',
//             // 'remarkes' => 'required',
//             // 'img' => 'required|image',
//             // 'qty' => 'required|numeric',
//             // 'request_qty' => 'required|numeric',
//             // 'price' => 'required|numeric',
// =======
//             '*.projects_id' => 'required',

// >>>>>>> a4c4f0098ff3da887c51224a7ae89aa3ff9f6978
//         ]);

//         if ($validator->fails()) {
//             return $this->responseJson(false, 422, $validator->errors()->first(), []);
//         }

//         DB::beginTransaction();
//         try {
// <<<<<<< HEAD
//             $quoteDetail = [];
//             $datas = $request->all();
//             foreach ($datas as $value) {
//                 if (!empty($value['id'])) {
//                     $quoteDetailItem = QuotesDetails::find($value['id']);
//                     if (!$quoteDetailItem) {
//                         return $this->responseJson(false, 404, 'Quote Detail not found', []);
//                     }
//                     $quoteDetail[] = $quoteDetailItem;
//                     // Update existing quote detail
//                     $quoteDetailItem->update([
//                         'materials_id' => $value['materials'],
//                         'material_requests_id' => $value['material_requests_id'],
//                         'material_request_details_id' => $value['material_request_details_id'],
//                         'date' => $value['date'],
//                         'request_qty' => $value['request_qty'],
//                         'price' => $value['price'],
//                     ]);
//                 } else {
//                     // Create new quote detail
//                     $quoteDetail[] = QuotesDetails::create([
//                         'quotes_id' => $value['quotes_id'],
//                         'materials_id' => $value['materials'],
//                         'material_requests_id' => $value['material_requests_id'],
//                         'material_request_details_id' => $value['material_request_details_id'],
//                         'date' => $value['date'],
//                         'qty' => $value['qty'],
//                         'request_qty' => $value['request_qty'],
//                         'price' => $value['price'],
//                         'company_id' => $authCompany,
//                     ]);
//                 }
//             }
//             DB::commit();

//             return $this->responseJson(true, 201, 'Quote Detail Added Successfully', $quoteDetail);
// =======
//             // dd($request->all());

//             foreach ($request->all() as $quoteData) {

//                 // dd($quoteData);
//                 $conditions = [
//                     'id' => $quoteData['id'],
//                 ];

//                 $data = [
//                     // 'projects_id' => $quoteData['projects_id'],
//                     'quotes_id' => $quoteData['quotes_id'],
//                     'materials_id' => $quoteData['materials'],
//                     'qty' => $quoteData['qty'],
//                     'request_qty' => $quoteData['request_qty'],
//                     'price' => $quoteData['price'],
//                     'material_request_details_id' => $quoteData['material_request_details_id'],
//                     'date' => $quoteData['date'],
//                     'material_requests_id' => $quoteData['material_requests_id'],
//                     'company_id'=> $authCompany
//                 ];

//                 // dd($data);
//                 // Use updateOrCreate to either update existing record or create new one
//                 QuotesDetails::updateOrCreate($conditions, $data);
//             }
//             DB::commit();
//             return $this->responseJson(true, 200, 'Quote Details Updated Successfully', []);
// >>>>>>> a4c4f0098ff3da887c51224a7ae89aa3ff9f6978
//         } catch (\Exception $e) {
//             DB::rollBack();
//             Log::error('Failed to add quote detail: ' . $e->getMessage());
//             return $this->responseJson(false, 500, 'Failed to add quote detail', []);
//         }
//     }


// <<<<<<< HEAD

// >>>>>>> 938fa9697054f8a3565a8ac37d4f0351b119d97f
//     // public function add(Request $request)
//     // {
//     //     $authCompany = Auth::guard('company-api')->user()->company_id;
//     //     $validator = Validator::make($request->all(), [
// <<<<<<< HEAD
//     //         '*.projects_id' => 'required',
// =======
//     //         'projects_id' => 'required',
//     //         // 'request_no' => 'required',
//     //         // 'date' => 'required',
// >>>>>>> 938fa9697054f8a3565a8ac37d4f0351b119d97f
//     //     ]);
//     //     if ($validator->fails()) {
//     //         return $this->responseJson(false, 422, $validator->errors()->first(), []);
//     //     }
//     //     DB::beginTransaction();
//     //     try {
// <<<<<<< HEAD
//     //         // dd($request->all());
//     //         foreach ($request->all() as $quoteData) {
//     //             // dd($quoteData);
//     //             $conditions = [
//     //                 'id' => $quoteData['id'],
//     //             ];
//     //             $data = [
//     //                 // 'projects_id' => $quoteData['projects_id'],
//     //                 'quotes_id' => $quoteData['quotes_id'],
//     //                 'materials_id' => $quoteData['materials'],
//     //                 'qty' => $quoteData['qty'],
//     //                 'request_qty' => $quoteData['request_qty'],
//     //                 'price' => $quoteData['price'],
//     //                 'material_request_details_id' => $quoteData['material_request_details_id'],
//     //                 'date' => $quoteData['date'],
//     //                 'material_requests_id' => $quoteData['material_requests_id'],
//     //                 'company_id' => $authCompany
//     //             ];
//     //             // dd($data);
//     //             // Use updateOrCreate to either update existing record or create new one
//     //             $datasssss =  QuotesDetails::updateOrCreate($conditions, $data);
//     //         }
//     //         dd($datasssss);
//     //         DB::commit();
//     //         return $this->responseJson(true, 200, 'Quote Details Updated Successfully', $datasssss);
// =======
//     //         $uuid = Str::uuid();
//     //         $quotes_id = $request->quotes_id;
//     //         // $request_no = $request->request_no;
//     //         $date = $request->date;
//     //         $company_id = $authCompany;
//     //         $remarkes = $request->remarkes;
//     //         $img = $request->img;
//     //         $qty = $request->qty;
//     //         $request_qty = $request->request_qty;
//     //         $price = $request->price;
//     //         $material_requests_id = $request->material_requests_id;
//     //         $quoteDetail = [];
//     //         $getMaterialsId = (array)$request->get('materials');
//     //         $getMaterialsReqDetailsIds = (array)$request->get('material_request_details_id');
//     //         $getRequiredMaterialsDates = (array)$request->get('date');
//     //         $existingQuoteDetail = $request->id != null ? QuotesDetails::where('id', $request->id)->first() : null;
//     //         // dd($existingQuoteDetail);

//     //         if ($request->has('materials')) {
//     //             // dd($request->all());

//     //             if ($existingQuoteDetail) {
//     //                 // dd($request->all());

//     //                 foreach ($getMaterialsId as $index =>  $materialId) {
//     //                     $getMaterialsReqDetailsId = $getMaterialsReqDetailsIds[$index];
//     //                     $getRequiredMaterialsDate = $getRequiredMaterialsDates[$index];
//     //                     $quoteDetail = $existingQuoteDetail->update([
//     //                         'date' => $getRequiredMaterialsDate,
//     //                         'remarkes' => $remarkes,
//     //                         'materials_id' => $materialId,
//     //                         'material_requests_id' => $material_requests_id,
//     //                         'material_request_details_id' => $materialId,
//     //                         'qty' => $qty,
//     //                         'request_qty' => $request_qty,
//     //                         'price' => $price,

//     //                     ]);
//     //                 }
//     //             } else {
//     //                 // dd($request->all());
//     //                 // dd($getMaterialsReqDetailsIds);
//     //                 foreach ($getMaterialsId as $index => $materialId) {
//     //                     $getMaterialsReqDetailsId = $getMaterialsReqDetailsIds[$index];
//     //                     $getRequiredMaterialsDate = $getRequiredMaterialsDates[$index];

//     //                     // dd($getMaterialsReqDetailsId);
//     //                     $quoteDetail = QuotesDetails::create([
//     //                         // 'request_no' => $request_no,
//     //                         'company_id' => $company_id,
//     //                         'quotes_id' => $quotes_id,
//     //                         'uuid' => $uuid,
//     //                         // 'date' => $getRequiredMaterialsDate,
//     //                         'qty' => $qty,
//     //                         'request_qty' => $request_qty,
//     //                         'price' => $price,
//     //                         'remarkes' => $remarkes,
//     //                         'materials_id' => $materialId,
//     //                         'material_requests_id' => $material_requests_id,
//     //                         'material_request_details_id' => $getMaterialsReqDetailsId
//     //                     ]);
//     //                 }
//     //             }
//     //         }

//     //         if ($request->hasFile('img')) {
//     //             if ($existingQuoteDetail) {
//     //                 $quoteDetail = $existingQuoteDetail->update([
//     //                     'date' => null,
//     //                     'remarkes' => $remarkes,
//     //                     'img' => getImgUpload($request->img, 'upload')
//     //                 ]);
//     //             } else {
//     //                 $quoteDetail = QuotesDetails::create([
//     //                     // 'request_no' => $request_no,
//     //                     'company_id' => $company_id,
//     //                     'quotes_id' => $quotes_id,
//     //                     'uuid' => $uuid,
//     //                     'date' => null,
//     //                     'remarkes' => $remarkes,
//     //                     'materials_id' => null,
//     //                     'material_requests_id' => null,
//     //                     'material_request_details_id' => null,
//     //                     'img' => getImgUpload($request->img, 'upload')
//     //                 ]);
//     //             }
//     //         }

//     //         DB::commit();
//     //         return $this->responseJson(true, 200, 'Quote Details Updated Successfully', $quoteDetail);
// >>>>>>> 938fa9697054f8a3565a8ac37d4f0351b119d97f
//     //     } catch (\Exception $e) {
//     //         DB::rollBack();
//     //         logger($e->getMessage() . ' on ' . $e->getFile() . ' in ' . $e->getLine());
//     //         return $this->responseJson(false, 500, $e->getMessage(), []);
//     //     }
//     // }
// <<<<<<< HEAD
// =======




// =======
// >>>>>>> a4c4f0098ff3da887c51224a7ae89aa3ff9f6978
// >>>>>>> 938fa9697054f8a3565a8ac37d4f0351b119d97f
//     public function edit(Request $request)
//     {
//         $fetches = [];
//         $dataimg = [];
//         $id = $request->quotesId;
//         $findId = Quote::find($id);
//         $fetchData = [];
//         if ($findId) {
//             $authCompany = Auth::guard('company-api')->user()->company_id;
//             $data = Quote::with('quotesdetails')
//                 ->where('company_id', $authCompany)
//                 ->where('id', $id)
//                 ->first();
//             $combinedCollection = $data->quotesdetails->each(function ($q) {
//                 $reqId = $q->material_requests_id;
//                 $q->load(['quotsmaterialsRequest' => function ($qu) use ($reqId) {
//                     $qu->with(['materialRequestDetails' => function ($mqu) use ($reqId) {
//                         return $mqu->where('material_requests_id', $reqId)->with('materials');
//                     }]);
//                 }]);
//             });
//             foreach ($combinedCollection as $key => $value) {
//                 if ($value->material_requests_id != null) {
//                     $qwert = $value->quotsmaterialsRequest?->materialRequestDetails;
//                     if ($qwert != null) {
//                         foreach ($qwert as $valQumal) {
//                             if (!empty($valQumal->materials)) {
//                                 $fetches[] = $value;
//                             }
//                         }
//                     }
//                 } else {
//                     $dataimg[] = $value;
//                 }
//             }
//             if ($dataimg) {
//                 $fetchData['flage'] = 0;
//                 $fetchData['data'] = QuotesDetailsresources::collection($dataimg);
//             } else {
//                 $fetchData['flage'] = 1;
//                 $fetchData['data'] = QuotesMaterialsDetailsresources::collection($fetches);
//             }
//             $message = 'Fetch Quote List Successfully';
//         } else {
//             $data = [];
//             $message = 'ID Do Not Found';
//         }
//         return $this->responseJson(true, 200, $message, $fetchData);
//     }
//     public function materialrequestSendToVendor(Request $request)
//     {
//         // Validate incoming request if needed
//         $authCompany = Auth::guard('company-api')->user()->company_id;
//         $validator = Validator::make($request->all(), [
//             'type' => 'required|integer',
//             'vendor_id' => 'required|array',
//             'quotes_details_id' => 'required|array',
//         ]);
//         if ($validator->fails()) {
//             return $this->responseJson(false, 422, $validator->errors()->first(), []);
//         }
//         DB::beginTransaction();
//         try {
//             // dd($request->all());
//             $quoteDetail = [];
//             // Extract data from the request
//             $type = $request->input('type');
//             $vendorIds = $request->input('vendor_id');
//             $quoteDetailsIds = $request->input('quotes_details_id');
//             // $quoteDetailsId = $quoteDetailsIds[$index];
//             foreach ($vendorIds as $index => $vendorId) {
//                 foreach ($quoteDetailsIds as $key => $qtrdetails) {
//                     $quoteDetail[] = QuotesMaterialSendVendor::create([
//                         'vendors_id' => $vendorId,
//                         'quotes_details_id' => $qtrdetails,
//                         'type' => $type,
//                         'company_id' => $authCompany
//                     ]);
//                 }
//             }
//             DB::commit();
//             $quoteDetailResource = QuotesMaterialRequestSendVendorResource::collection($quoteDetail);
//             // dd($quoteDetailResource);
//             // return $this->responseJson(true, 200, 'Quote Details Updated Successfully', $quoteDetail);
//             return $this->responseJson(true, 200, 'Quote Details Updated Successfully',  $quoteDetailResource);
//         } catch (\Exception $e) {
//             DB::rollBack();
//             logger($e->getMessage() . ' on ' . $e->getFile() . ' in ' . $e->getLine());
//             return $this->responseJson(false, 500, $e->getMessage(), []);
//         }
//     }
// }
// <<<<<<< HEAD
// // public function add(Request $request)
// // {
// //     $authCompany = Auth::guard('company-api')->user()->company_id;
// //     $validator = Validator::make($request->all(), [
// //         'projects_id' => 'required',
// //         'request_no' => 'required',
// //         'date' => 'required',
// //     ]);
// //     if ($validator->fails()) {
// //         $status = false;
// //         $code = 422;
// //         $response = [];
// //         $message = $validator->errors()->first();
// //         return $this->responseJson($status, $code, $message, $response);
// //     }
// //     DB::beginTransaction();
// //     try {
// //         $materialIds = $request->materials;
// //         $uuid = Str::uuid();
// //         $quotes_id = $request->quotes_id;
// //         $request_no = $request->request_no;
// //         $date = $request->date;
// //         $company_id = $authCompany;
// //         $remarkes = $request->remarkes;
// //         $img = $request->img;
// //         if (!empty($request->materials)) {
// //             foreach ($materialIds as $materialId) {
// //                 $isActivityCreated = new  QuotesDetails();
// //                 $isActivityCreated->uuid = $uuid;
// //                 $isActivityCreated->material_requests_id = $materialId;
// //                 $isActivityCreated->quotes_id = $quotes_id;
// //                 $isActivityCreated->request_no = $request_no;
// //                 $isActivityCreated->date = $date;
// //                 $isActivityCreated->company_id = $company_id;
// //                 $isActivityCreated->save();
// //             }
// //         } else {
// //             if ($request->hasFile('img')) {
// //                 $isActivityCreated = new  QuotesDetails();
// //                 $isActivityCreated->uuid = $uuid;
// //                 $isActivityCreated->quotes_id = $quotes_id;
// //                 $isActivityCreated->request_no = $request_no;
// //                 $isActivityCreated->date = $date;
// //                 $isActivityCreated->company_id = $company_id;
// //                 $isActivityCreated->img = getImgUpload($request->img, 'upload');
// //                 $isActivityCreated->remarkes = $remarkes;
// //             }
// //         }
// //         $isActivityCreated->save();
// //         $message = 'Quote Details Updated Successfullsy';
// //         if (isset($isActivityCreated)) {
// //             DB::commit();
// //             return $this->responseJson(true, 201, $message, $isActivityCreated);
// //         }
// //     } catch (\Exception $e) {
// //         DB::rollBack();
// //         logger($e->getMessage() . 'on' . $e->getFile() . 'in' . $e->getLine());
// //         return $this->responseJson(false, 500, $e->getMessage(), []);
// //     }
// // }
// // public function edit(Request $request)
// // {
// //     $id=$request->quotesId;
// //     $findId = Quote::find($id);
// //     if ($findId) {
// //         $authCompany = Auth::guard('company-api')->user()->company_id;
// //         $data = Quote::where('company_id', $authCompany)
// //             ->where('id', $id)
// //             ->latest('id')
// //             ->first();
// //         $message = 'Fetch Quote List Successfullsy';
// //     } else {
// //         $data = [];
// //         $message = 'ID Do Not Found';
// //     }
// //     return $this->responseJson(true, 200, $message, $data);
// // }
// // "projects_id" => 3
// // "quotes_id" => 2
// // "request_no" => "hdgfswe54673"
// // "date" => "2013-11-10"
// // "remarkes" => "this is a specification"
// // "img" => null
// // "materials_id" => 1
// =======
// >>>>>>> 938fa9697054f8a3565a8ac37d4f0351b119d97f
