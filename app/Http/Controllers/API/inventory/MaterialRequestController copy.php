<?php

namespace App\Http\Controllers\API\inventory;

use App\Http\Controllers\BaseController;
use App\Http\Resources\API\Inventory\inventor\InventoryResources;
use App\Http\Resources\API\Inventory\MaterialRequest\InvMaterialsRequestResources;
use App\Http\Resources\API\Inventory\MaterialRequest\MaterialRequestDetailsResources;
use App\Http\Resources\API\Inventory\MaterialRequest\MaterialRequestResources;
use App\Http\Resources\API\Inventory\Quotes\InvQuoteMaterialsRequestDetailResource;
use App\Models\Company\Materials;
use App\Models\Inventory;
use App\Models\MaterialRequest;
use App\Models\MaterialRequestDetails;
use App\Models\QuotesDetails;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class MaterialRequestController extends BaseController
{

    public function add(Request $request)
    {
        // dd($request->all());
        $authCompany = Auth::guard('company-api')->user();
        DB::beginTransaction();
        // $checkInventory = MaterialRequest::with('materialRequestDetails')

        //     // ->where([
        //     //     'date' => Carbon::now()->format('Y-m-d'),
        //     //     'projects_id' => $request->projects_id,
        //     //     'user_id' => $authCompany->id,
        //     //     'sub_projects_id' => $request->sub_projects_id
        //     // ])
        //     ->first();
        // dd($checkInventory);
        $checkInventory = MaterialRequest::where([
            'id' => $request->id
        ])->first();

        try {
            $isInventoryDatas = $checkInventory ?: new MaterialRequest();
            // $isInventoryDatas = new MaterialRequest();
            $isInventoryDatas->fill([
                'name' => Carbon::now()->format('Y-m-d'),
                'date' => Carbon::now()->format('Y-m-d'),
                'company_id' => $authCompany->company_id,
                'user_id' => $authCompany->id,
                'projects_id' => $request->projects_id,
                'sub_projects_id' => $request->sub_projects_id,

            ]);
            $isInventoryDatas->save();
            // dd($isInventoryDatas);
            $message = $request->id ? 'Inventory Details Updated Successfully' : 'Inventory Details Created Successfully';
            DB::commit();
            // addNotifaction($message, $isInventoryDatas, $request->projects_id ?? null,$authCompany->company_id);
            return $this->responseJson(true, 200, $message, $isInventoryDatas);
        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage() . ' on ' . $e->getFile() . ' in ' . $e->getLine());
            return $this->responseJson(false, 500, $e->getMessage(), []);
        }
    }
    public function edit(Request $request)
    {
        $authCompany = Auth::guard('company-api')->user();
        $data = MaterialRequestDetails::where('material_requests_id', $request->id)->where('company_id', $authCompany->company_id)
            ->whereHas('materialrequests', function ($jhgfd) use ($authCompany) {
                $jhgfd->where('user_id', $authCompany->id);
            })->get();
        $message = $data->isNotEmpty() ? 'Fetch Inventory List Successfully' : 'Inventory List Data Not Found';
        return $this->responseJson(true, 200, $message, $data);
        // return $this->responseJson(true, 200, $message, MaterialRequestDetailsResources::collection($data));
        // return $this->responseJson(true, 200, $message, InventoryResources::collection($data));
    }


    // public function edit(Request $request)
    // {
    //     $authCompany = Auth::guard('company-api')->user();
    //     $data = MaterialRequestDetails::where('material_requests_id', $request->id)->where('company_id', $authCompany->company_id)
    //         ->whereHas('materialrequests', function ($jhgfd) use ($authCompany) {
    //             $jhgfd->where('user_id', $authCompany->id);
    //         })
    //         // ->where('user_id', $authCompany->id)
    //         ->get();
    //     $message = $data->isNotEmpty() ? 'Fetch Inventory List Successfully' : 'Inventory List Data Not Found';
    //     return $this->responseJson(true, 200, $message, MaterialRequestDetailsResources::collection($data));
    //     // return $this->responseJson(true, 200, $message, InventoryResources::collection($data));
    // }

    // public function edit(Request $request)
    // {
    //     $authCompany = Auth::guard('company-api')->user();
    //     $data = MaterialRequest::where('id', $request->id)->where('company_id', $authCompany->company_id)
    //         ->where('user_id', $authCompany->id)->get();
    //     $message = $data->isNotEmpty() ? 'Fetch Inventory List Successfully' : 'Inventory List Data Not Found';
    //     return $this->responseJson(true, 200, $message, MaterialRequestResources::collection($data));
    //     // return $this->responseJson(true, 200, $message, InventoryResources::collection($data));
    // }


    public function index(Request $request)
    {
        // Assuming you're using Laravel's Auth facade to retrieve the authenticated user
        $authCompany = Auth::guard('company-api')->user();
        // Set page title (assuming this method exists and sets the title for the view)
        $this->setPageTitle('Inventory Management');
        // Retrieve projectId and subprojectId from the request
        $projectId = $request->input('projectId');
        $subprojectId = $request->input('subprojectId');
        // Start building the query for MaterialRequest
        $query = MaterialRequest::where('company_id', $authCompany->company_id)
            ->where('user_id', $authCompany->id)
            ->whereNotNull('request_id');
        // If it's a POST request, filter by projectId and subprojectId
        if ($request->isMethod('post')) {
            $date15DaysAgo = now()->subDays(15);
            if ($projectId) {
                $query->where('projects_id', $projectId)
                    // ->where('created_at', '>=', $date15DaysAgo)
                ;
            }
            if ($subprojectId) {
                $query->orWhere('sub_projects_id', $subprojectId);
            }
        }
        // Retrieve the data
        $datas = $query->orderBy('id', 'desc')->get();
        // Check if data is found
        if ($datas->isNotEmpty()) {
            return $this->responseJson(true, 200, 'Fetch Inventory List Successfully', MaterialRequestResources::collection($datas));
        } else {
            return $this->responseJson(true, 200, 'Inventory List Data Not Found', []);
        }
    }

    // ***************************************************************************************************
    public function materialsRequestNoWiseMaterialsShow(Request $request)
    {
        $searchkey = $request->searchkey;
        $projectId = $request->projectId;
        $request_no = $request->request_no;

        // dd($request_no);
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $querssy = MaterialRequest::where('company_id', $authCompany)->where('request_id', $request_no)->first();
        // ->whereHas('materialrequests', function ($mrq) use ($request_no) {
        //     $mrq->where('request_id', $request_no);
        // })
        // ->get();
        // dd($querssy);
        $query = Materials::with('materialsRequestDetails.materialrequests', 'units')
            ->whereHas('materialsRequestDetails', function ($mrd) use ($querssy, $request_no) {
                // $mrd->whereHas('materialrequests', function ($mr) use ($request_no) {
                //     $mr->where('request_id', $request_no);
                // });
                $mrd->where('material_requests_id', $querssy->id);
                // });
            })->where('company_id', $authCompany)
            ->get();
        $query = collect($query)->each(function ($value, $key) use ($querssy) {
            $value->material_requests_id = $querssy->id;
        });
        // $query = MaterialRequestDetails::with('materialrequests', 'materials')->where('company_id', $authCompany)
        //     ->whereHas('materialrequests', function ($mr) use ($request_no) {
        //         $mr->where('request_id', $request_no);
        //     })
        //     ->get();


        // dd($query->toArray());
        if ($query->isNotEmpty()) {
            return $this->responseJson(
                true,
                200,
                'Fetch Inward Goods Details List Successfullsy',
                InvQuoteMaterialsRequestDetailResource::collection($query)
                // InvMaterialsRequestResources::collection($query)
                // MaterialRequestResources::collection($query)
            );
        } else {
            return $this->responseJson(true, 200, 'Inward Goods Details List Data Not Found', []);
        }
    }
    public function materialsRequestNoWiseMaterialsEdit(Request $request)
    {
        // dd($request->all());
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
            $qty = $request->qty;
            $request_qty = $request->request_qty;
            $quoteDetail = [];
            $getMaterialsId = (array)$request->get('materials');
            $existingQuoteDetail = $request->id != null ? QuotesDetails::where('id', $request->id)->first() : null;
            // dd($existingQuoteDetail);
            if ($request->has('materials')) {
                // dd($request->all());
                if ($existingQuoteDetail) {
                    // dd($request->all());
                    foreach ($getMaterialsId as $materialId) {
                        $quoteDetail = $existingQuoteDetail->update([
                            'date' => $date,
                            'remarkes' => $remarkes,
                            'material_requests_id' => $materialId,
                            'qty' => $qty,
                            'request_qty' => $request_qty
                        ]);
                    }
                } else {
                    // dd($request->all());
                    foreach ($getMaterialsId as $materialId) {
                        // dd($materialId);
                        $quoteDetail = QuotesDetails::create([
                            'request_no' => $request_no,
                            'company_id' => $company_id,
                            'quotes_id' => $quotes_id,
                            'uuid' => $uuid,
                            'date' => $date,
                            'qty' => $qty,
                            'request_qty' => $request_qty,
                            'remarkes' => $remarkes,
                            'material_requests_id' => $materialId
                        ]);
                    }
                }
            }
            if ($request->hasFile('img')) {
                if ($existingQuoteDetail) {
                    $quoteDetail = $existingQuoteDetail->update([
                        'date' => $date,
                        'remarkes' => $remarkes,
                        'img' => getImgUpload($request->img, 'upload')
                    ]);
                } else {
                    $quoteDetail = QuotesDetails::create([
                        'request_no' => $request_no,
                        'company_id' => $company_id,
                        'quotes_id' => $quotes_id,
                        'uuid' => $uuid,
                        'date' => $date,
                        'remarkes' => $remarkes,
                        'material_requests_id' => null,
                        'img' => getImgUpload($request->img, 'upload')
                    ]);
                }
            }
            DB::commit();
            // addNotifaction('Quote Details Updated Successfully', $quoteDetail, $request->projects_id ?? null,$authCompany);
            return $this->responseJson(true, 200, 'Quote Details Updated Successfully', $quoteDetail);
        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage() . ' on ' . $e->getFile() . ' in ' . $e->getLine());
            return $this->responseJson(false, 500, $e->getMessage(), []);
        }
    }
}
// {
//     "status": true,
//     "response_code": 200,
//     "message": "Fetch Inventory List Successfully",
//     "data": [
//         {
//             "id": 17,
//             "uuid": "bb11cdfb-0712-4d1c-abbc-df237763c223",
//             "projects": {
//                 "id": 2,
//                 "uuid": "582389f7-0a6c-424f-9cb1-b178e56b8161",
//                 "project_name": "Project 19062024",
//                 "planned_start_date": "2024-06-01",
//                 "address": "Raiganj, West Bengal, India",
//                 "planned_end_date": "2024-11-01",
//                 "own_project_or_contractor": "no",
//                 "project_completed": "no",
//                 "project_completed_date": null,
//                 "companies": {
//                     "id": 2,
//                     "uuid": "9d7d5c6d-8496-4dde-ba9c-5250f51b92a7",
//                     "registration_name": "KP Builders Ltd",
//                     "company_registration_no": "KPwe3432",
//                     "registered_address": "kolkata",
//                     "logo": ""
//                 },
//                 "client": "",
//                 "logo": "http://3.108.121.124/koncite/construction-app-admin/logo/171879726643.jpg"
//             },
//             "sub_projects": {
//                 "id": 2,
//                 "uuid": "b45c58dc-e745-401f-acea-e564738b62d2",
//                 "name": "a wing19062024",
//                 "start_date": "2024-06-01",
//                 "end_date": "2024-08-03",
//                 "project": {
//                     "id": 2,
//                     "uuid": "582389f7-0a6c-424f-9cb1-b178e56b8161",
//                     "project_name": "Project 19062024",
//                     "planned_start_date": "2024-06-01",
//                     "address": "Raiganj, West Bengal, India",
//                     "planned_end_date": "2024-11-01",
//                     "own_project_or_contractor": "no",
//                     "project_completed": "no",
//                     "project_completed_date": null,
//                     "companies": {
//                         "id": 2,
//                         "uuid": "9d7d5c6d-8496-4dde-ba9c-5250f51b92a7",
//                         "registration_name": "KP Builders Ltd",
//                         "company_registration_no": "KPwe3432",
//                         "registered_address": "kolkata",
//                         "logo": ""
//                     },
//                     "client": "",
//                     "logo": "http://3.108.121.124/koncite/construction-app-admin/logo/171879726643.jpg"
//                 }
//             },
//             "material_requests": {
//                 "id": 15,
//                 "uuid": "67523f5c-f746-4ab7-99db-88c0402e8459",
//                 "request_no": "545303",
//                 "materials_id": null,
//                 "inventories_id": null,
//                 "activities_id": null,
//                 "date": "2024-07-29",
//                 "qty": null,
//                 "projects_id": {
//                     "id": 2,
//                     "uuid": "582389f7-0a6c-424f-9cb1-b178e56b8161",
//                     "project_name": "Project 19062024",
//                     "planned_start_date": "2024-06-01",
//                     "address": "Raiganj, West Bengal, India",
//                     "planned_end_date": "2024-11-01",
//                     "own_project_or_contractor": "no",
//                     "project_completed": "no",
//                     "project_completed_date": null,
//                     "companies": {
//                         "id": 2,
//                         "uuid": "9d7d5c6d-8496-4dde-ba9c-5250f51b92a7",
//                         "registration_name": "KP Builders Ltd",
//                         "company_registration_no": "KPwe3432",
//                         "registered_address": "kolkata",
//                         "logo": ""
//                     },
//                     "client": "",
//                     "logo": "http://3.108.121.124/koncite/construction-app-admin/logo/171879726643.jpg"
//                 },
//                 "remarks": null,
//                 "company_id": 2,
//                 "is_active": 1
//             },
//             "activities": null,
//             "date": "2024-07-30",
//             "qty": 10,
//             "remarks": "ok",
//             "company": 2
//         }
//     ]
// }
    // public function projectToSubprojectList(Request $request)
    // {
    // }
