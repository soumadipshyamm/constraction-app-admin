<?php

namespace App\Http\Controllers\API\inventory;

use App\Http\Controllers\BaseController;
use App\Http\Resources\API\Inventory\inventor\InventoryResources;
use App\Models\Company\InwardGoods;
use App\Models\Company\Project;
use App\Models\Company\StoreWarehouse;
use App\Models\InvInward;
use App\Models\InvIssueGood;
use App\Models\InvIssueStore;
use App\Models\InvReturnGood;
use App\Models\InwardStore;
use App\Models\MaterialRequestDetails;
use App\Models\QuotesDetails;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class InvInwardController extends BaseController
{
    public function index(Request $request)
    {
        $authCompany = Auth::guard('company-api')->user();
        $this->setPageTitle('Inventory Management');
        $datas = InvInward::where('company_id', $authCompany->company_id)
            ->where('user_id', $authCompany->id)->get();
        if (count($datas) > 0) {
            return $this->responseJson(true, 200, 'Fetch Inventory List Successfullsy', InventoryResources::collection($datas));
        } else {
            return $this->responseJson(true, 200, 'Inventory List Data Not Found', []);
        }
    }

    public function add(Request $request)
    {
        $store_warehouses_id = $request->store_warehouses_id;
        $authCompany = Auth::guard('company-api')->user();
        $record = InvInward::updateOrCreate(
            [
                'projects_id' => $request->projects_id,
                'company_id' => $authCompany->company_id,
                'user_id' => $authCompany->id,
                'date' => Carbon::now()->format('Y-m-d'),
            ],
            [
                'name' => $request->name
            ]
        );
        $record->InvInwardStore()->sync($store_warehouses_id);
        $message = 'Inward Details Updated Successfullsy';
        return $this->responseJson(true, 201, $message, $record);
    }

    public function projectToStoreList(Request $request)
    {
        $data = [];
        $generateUniqueNumberAndCheck = $this->generateUniqueNumberAndCheck($request->type, $request->request_id);
        if (isset($request->request_id)) {
            $data['date'] = $generateUniqueNumberAndCheck->date ?? '';
            $data['invInwardRegNo'] = $generateUniqueNumberAndCheck->request_id ?? '';
        } else {
            $data['invInwardRegNo'] = $generateUniqueNumberAndCheck;
        }

        if ($request->type == 'quotes') {
            $project = Project::find($request->project_id);
            if ($project) {
                $data['projectStore'] = $project;
                $message = 'Fetch Project wise store';
                return $this->responseJson(true, 200, $message, $data);
            } else {
                return $this->responseJson(false, 404, 'Project not found');
            }
        }
        if ($request->type == 'material_request') {
            $subProjectId = $request->store_id;
            $projectId = $request->project_id;
            $project = Project::where('id', $projectId)
                ->with(['subProject' => function ($query) use ($subProjectId) {
                    $query->where('sub_projects.id', $subProjectId);
                }])
                ->first();
            if ($project) {
                $data['projectSubproject'] = $project;
                $message = 'Fetch Project with subprojects';
                return $this->responseJson(true, 200, $message, $data);
            } else {
                $err_message = "Project or subprojects not found";
                return $this->responseJson(false, 404, $err_message);
            }
        } else {
            $getStores = $request->store_id;
            $project = Project::with(['StoreWarehouse' => function ($q) use ($getStores) {
                $q->whereIn('id', $getStores);
            }])
                ->where('id', $request->project_id)
                ->first();
            if ($project) {
                $data['projectStore'] = $project;
                $message = 'Fetch Project wise store';
                return $this->responseJson(true, 200, $message, $data);
            } else {
                $err_message = "Project not found";
                return $this->responseJson(false, 404, $err_message);
            }
        }
    }

    function generateUniqueNumberAndCheck($type, $requestId)
    {
        // dd($type, $requestId);
        $exists = true;
        $number = null;
        do {
            switch ($type) {
                case 'quotes':
                    if (!empty($requestId) && $requestId != null) {
                        $number = QuotesDetails::select('id', 'request_no as request_id', 'date')->where('quotes_id', $requestId)->first();
                        $exists = false;
                    } else {
                        $number = '';
                        $exists = false;
                    }
                    break;
                case 'inward':
                    if (!empty($requestId) && $requestId != null) {
                        $number = InwardGoods::select('id', 'grn_no as request_id', 'date')->where('inv_inwards_id', $requestId)->first();
                        $exists = false;
                        // dd($number);
                    } else {
                        $number = mt_rand(100000, 999999); // Generate a random 6-digit number
                        $exists = InwardGoods::where('grn_no', $number)->exists(); // Check if number exists in the table
                    }
                    break;
                case 'issue':
                    if (!empty($requestId) && $requestId != null) {
                        $number = InvIssueGood::select('id', 'issue_no as request_id', 'date')->where('inv_issues_id', $requestId)->first();
                        $exists = false;
                    } else {
                    }
                    $number = mt_rand(100000, 999999); // Generate a random 6-digit number
                    $exists = InvIssueGood::where('issue_no', $number)->exists(); // Check if number exists in the table
                    break;
                case 'return':
                    if (!empty($requestId) && $requestId != null) {
                        $number = InvReturnGood::select('id', 'return_no as request_id', 'date')->where('inv_returns_id', $requestId)->first();
                        $exists = false;
                    } else {
                        $number = mt_rand(100000, 999999); // Generate a random 6-digit number
                        $exists = InvReturnGood::where('return_no', $number)->exists(); // Check if number exists in the table
                    }
                    break;
                case 'material_request':
                    if (!empty($requestId) && $requestId != null) {
                        $number = MaterialRequestDetails::where('material_requests_id', $requestId)->first();
                    //   dd($number);
                        $exists = false; // Check if number exists in the table
                    } else {
                        $number = mt_rand(100000, 999999); // Generate a random 6-digit number
                        $exists = MaterialRequestDetails::where('request_id', $number)->exists(); // Check if number exists in the table
                    }
                    break;
            }
        } while ($exists);
        // dd($number); // Repeat if the number exists
        return $number;
    }


    // public function add(Request $request)
    // {
    //     $store = $request->store_id;
    //     $authCompany = Auth::guard('company-api')->user();
    //     DB::beginTransaction();
    //     $checkInventory = InvInward::with('InvInwardStore')->where(['date' => Carbon::now()->format('Y-m-d'), 'projects_id' => $request->projects_id, 'user_id' => $authCompany->id])->first();
    //     // dd($checkInventory);
    //     try {
    //         if ($request->id == null && $checkInventory == null) {
    //             $isInventoryDatas = new InvInward();
    //             $isInventoryDatas->name = $request->name;
    //             $isInventoryDatas->date = Carbon::now()->format('Y-m-d');
    //             $isInventoryDatas->company_id = $authCompany->company_id;
    //             $isInventoryDatas->user_id = $authCompany->id;
    //             $isInventoryDatas->projects_id = $request->projects_id;
    //             // $isInventoryDatas->store_id = $request->store_id;
    //             $isInventoryDatas->save();
    //         } else {
    //             $isInventoryDatas = InvInward::find($checkInventory->id);
    //         }
    //         $isInventoryDatas->projects_id = $request->projects_id;
    //         // $isInventoryDatas->store_id = $request->store_id;
    //         $isInventoryDatas->InvInwardStore()->$store;
    //         $isInventoryDatas->save();
    //         if ($request->id) {
    //             $message = 'Inward Details Updated Successfullsy';
    //         } else {
    //             $message = 'Inward Details Created Successfullsy';
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

    // public function projectToStoreList(Request $request)
    // {
    //     // dd($request->all());
    //     $getStores = $request->store_id;
    //     $data = Project::with(['StoreWarehouse'=> function ($q) use ($getStores) {
    //         $q->whereIn('id', $getStores);
    //     }])->where('id', $request->project_id)->get();        // $data = StoreWarehouse::with('project')->where('projects_id', $request->project_id)->whereIn('id', $getStores)->get();
    //     $message = 'Fetch Project wise store';
    //     if (isset($data)) {
    //         return $this->responseJson(true, 200, $message, $data);
    //     } else {
    //         $err_message = $message ? $message : "We are facing some technical issue now. Please try again after some time";
    //         return $this->responseJson(false, 500, $err_message);
    //     }
    // }

}
