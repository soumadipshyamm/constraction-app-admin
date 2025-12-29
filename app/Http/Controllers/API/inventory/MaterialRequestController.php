<?php

namespace App\Http\Controllers\API\inventory;

use App\Http\Controllers\BaseController;
use App\Http\Resources\API\Inventory\inventor\InventoryResources;
use App\Http\Resources\API\Inventory\MaterialRequest\InvMaterialsRequestResources;
use App\Http\Resources\API\Inventory\MaterialRequest\MaterialRequestDetailsResources;
use App\Http\Resources\API\Inventory\MaterialRequest\MaterialRequestResources;
use App\Http\Resources\API\Inventory\Quotes\InvQuoteMaterialsRequestDetailResource;
use App\Http\Resources\pendingApprovalResource;
use App\Models\Company\Materials;
use App\Models\Company\PrMemberManagment;
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
        log_daily(
            'MaterialRequestController',
            'Adding or updating material request details',
            'add',
            'info',
            json_encode($request->all()),
        );
        // Start a database transaction
        DB::beginTransaction();

        try {
            // Get the authenticated company
            $authCompany = Auth::guard('company-api')->user();

            // Check if the MaterialRequest exists
            $materialRequest = MaterialRequest::find($request->id);

            // Create a new instance if it doesn't exist
            $isInventoryDatas = $materialRequest ?: new MaterialRequest();
            $isExitespam = checkPrApprovalMemebr($request);

            // Fill the model with request data
            $isInventoryDatas->fill([
                'name' => Carbon::now()->format('Y-m-d'),
                'date' => Carbon::now()->format('Y-m-d'),
                'company_id' => $authCompany->company_id,
                'user_id' => $authCompany->id,
                'projects_id' => $request->projects_id,
                'sub_projects_id' => $request->sub_projects_id,
                'status' => $isExitespam
            ]);

            // Save the model
            $isInventoryDatas->save();

            // Commit the transaction
            DB::commit();

            // Prepare success message
            $message = $request->id ? 'Inventory Details Updated Successfully' : 'Inventory Details Created Successfully';
            return $this->responseJson(true, 200, $message, $isInventoryDatas);
        } catch (\Exception $e) {
            // Rollback the transaction in case of an error
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
    }

    public function index(Request $request)
    {
        $authCompany = Auth::guard('company-api')->user();
        $this->setPageTitle('Inventory Management');
        $projectId = $request->input('projectId');
        $subprojectId = $request->input('subprojectId');
        $query = MaterialRequest::where('company_id', $authCompany->company_id)
            // ->where('user_id', $authCompany->id)
            ->whereNotNull('request_id');
        if ($request->isMethod('post')) {
            $date15DaysAgo = now()->subDays(15);
            if ($projectId) {
                $query->where('projects_id', $projectId)
                    ->where('created_at', '>=', $date15DaysAgo)
                ;
            }
            if ($subprojectId) {
                $query->orWhere('sub_projects_id', $subprojectId);
            }
        }
        // Retrieve the data
        $datas = $query->orderBy('id', 'desc')->where('status', 1)->get();
        // dd($datas);
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
        log_daily(
            'MaterialRequestController',
            'Adding or updating material request details',
            'materialsRequestNoWiseMaterialsShow',
            'info',
            json_encode($request->all()),
        );
        $searchkey = $request->searchkey;
        $projectId = $request->projectId;
        $request_no = $request->request_no;

        // dd($request_no);
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $querssy = MaterialRequest::where('company_id', $authCompany)->where('id', $request_no)->first();

        $query = Materials::with('materialsRequestDetails.materialrequests', 'units')
            ->whereHas('materialsRequestDetails', function ($mrd) use ($querssy, $request_no) {

                $mrd->where('material_requests_id', $querssy->id);
            })->where('company_id', $authCompany)
            ->get();
        $query = collect($query)->each(function ($value, $key) use ($querssy) {
            $value->material_requests_id = $querssy->id;
        });


        if ($query->isNotEmpty()) {
            return $this->responseJson(
                true,
                200,
                'Fetch Inward Goods Details List Successfullsy',
                InvQuoteMaterialsRequestDetailResource::collection($query)

            );
        } else {
            return $this->responseJson(true, 200, 'Inward Goods Details List Data Not Found', []);
        }
    }
    public function materialsRequestNoWiseMaterialsEdit(Request $request)
    {
        log_daily(
            'MaterialRequestController',
            'Adding or updating material request details',
            'materialsRequestNoWiseMaterialsEdit',
            'info',
            json_encode($request->all()),
        );
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
            log_daily(
                'MaterialRequestController',
                'Adding or updating material request details after save',
                'materialsRequestNoWiseMaterialsEdit',
                'info',
                json_encode($quoteDetail),
            );
            DB::commit();
            return $this->responseJson(true, 200, 'Quote Details Updated Successfully', $quoteDetail);
        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage() . ' on ' . $e->getFile() . ' in ' . $e->getLine());
            return $this->responseJson(false, 500, $e->getMessage(), []);
        }
    }


    // ******************************************************************************************************************
    public function materialsRequestListforQuote(Request $request)
    {
        log_daily(
            'Quote',
            'Adding or updating material request details',
            'materialsRequestListforQuote',
            'info',
            json_encode($request->all()),
        );
        $authCompany = Auth::guard('company-api')->user();
        $this->setPageTitle('Inventory Management');
        $projectId = $request->input('projectId');
        $subprojectId = $request->input('subprojectId');

        $query = MaterialRequest::where('company_id', $authCompany->company_id)
            ->whereNotNull('request_id');

        if ($request->isMethod('post')) {
            $date15DaysAgo = now()->subDays(15);
            if ($projectId) {
                $query->where('projects_id', $projectId);
                $query->where('created_at', '>=', $date15DaysAgo);
            }
            if ($subprojectId) {
                $query->orWhere('sub_projects_id', $subprojectId);
            }
        }
        // Retrieve the data
        $datas = $query->orderBy('id', 'desc')->get();

        $datas =  $datas->filter(function ($data) {
            return $data->PrMemberManagment->every(fn($item) => $item->is_active == 1);
        });
        log_daily(
            'Quote',
            'Adding or updating material request details result',
            'materialsRequestListforQuote',
            'info',
            json_encode($request->all()),
        );
        // Check if data is found
        $message = $datas->isNotEmpty() ? 'Fetch Inventory List Successfully' : 'Inventory List Data Not Found';
        return $this->responseJson(true, 200, $message, MaterialRequestResources::collection($datas));
    }
    // ***************************************************************************************************
    public function pendingApprovalList(Request $request)
    {

        $authCompany = Auth::guard('company-api')->user();
        $query = MaterialRequest::where('company_id', $authCompany->company_id);
        if ($authCompany->companyUserRole->slug == 'super-admin') {
            $query = $query->where('status', 0);
            // $query = $query->whereHas('PrMemberManagment', function ($q) {
            //     $q->where('status', 0);
            // });
        } else {
            $query = $query->whereHas('PrMemberManagment', function ($q) {
                $q->where('is_active', 0);
                // $q->where('user_id', 23);
                $q->where('user_id', Auth::guard('company-api')->user()->id);
            });
        }
        $query = $query->get();
        log_daily(
            'MaterialRequestController',
            'Adding or updating material request details',
            'pendingApprovalList',
            'info',
            json_encode($request->all()),
        );
        // dd($query);
        $message = $query->isNotEmpty() ? 'Fetch Inventory List Successfully' : 'Inventory List Data Not Found';
        return $this->responseJson(true, 200, $message, pendingApprovalResource::collection($query));
    }
    // ***************************************************************************************************

    public function pendingApprovalUpdate(Request $request)
    {
        log_daily(
            'MaterialRequestController',
            'Adding or updating material request details',
            'pendingApprovalUpdate',
            'info',
            json_encode($request->all()),
        );
        $authCompany = Auth::guard('company-api')->user();
        MaterialRequest::where('company_id', $authCompany->company_id)->update([
            'status' => $request->status
        ]);

        $statusUpdate = PrMemberManagment::where('company_id', $authCompany->company_id)->where(['user_id' => $authCompany->id, 'material_request_id' => $request->material_request_id])->update([
            'is_active' => $request->status
        ]);
        $message = $statusUpdate ? 'Status Update Successfully' : 'Data Not Found';
        return $this->responseJson(true, 200, $message, $statusUpdate);
    }
    // ***************************************************************************************************

}
