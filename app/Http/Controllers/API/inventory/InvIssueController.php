<?php

namespace App\Http\Controllers\API\inventory;

use App\Http\Controllers\BaseController;
use App\Http\Resources\API\Inventory\inventor\InventoryDtailsResources;
use App\Http\Resources\API\Inventory\IssueInward\InwardMaterialListResources;
use App\Http\Resources\API\Inventory\IssueInward\IssueListResources;
use App\Http\Resources\API\Inventory\IssueInward\IssueTypeResources;
use App\Models\Company\Assets;
use App\Models\Company\CompanyUser;
use App\Models\Company\InwardGoodsDetails;
use App\Models\Company\Materials;
use App\Models\Company\Project;
use App\Models\Company\StoreWarehouse;
use App\Models\Company\Vendor;
use App\Models\InvInward;
use App\Models\InvIssue;
use App\Models\InvIssueList;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InvIssueController extends BaseController
{
    public function add(Request $request)
    {
        $store_warehouses_id = $request->store_warehouses_id;
        $authCompany = Auth::guard('company-api')->user();
        $record = InvIssue::updateOrCreate(
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

        $record->InvIssueStore()->sync($store_warehouses_id);
        $message = 'Inward Details Updated Successfullsy';
        return $this->responseJson(true, 201, $message, $record);
    }

    public function materialsList(Request $request)
    {
        $authCompany = Auth::guard('company-api')->user()->company_id;
        // machines,materials
        // if ($request->type == 'materials') {
        //     $fetchMaterial = InwardGoodsDetails::with('materials')->where('accept_qty', '>', 0)->where('company_id', $authCompany)->get();
        // } else {
        //     $fetchMaterial = InwardGoodsDetails::with('assets')->where('accept_qty', '>', 0)->where('company_id', $authCompany)->get();
        // }
        if ($request->goods_type == 'materials') {
            $fetchMaterial = Materials::with(['InvInwardGoodDetails' => function ($q) {
                $q->where('accept_qty', '>', 0);
            }])->where('company_id', $authCompany)
                ->orderBy('id', 'DESC')
                ->get();
        } else {
            $fetchMaterial = Assets::with(['InvInwardGoodDetails' => function ($q) {
                $q->where('accept_qty', '>', 0);
            }])->where('company_id', $authCompany)
                ->orderBy('id', 'DESC')
                ->get();
            // dd( $requestMaterialsData->toArray());
        }
        $message = 'Materials List Fetch Successfullsy';
        // return $this->responseJson(true, 201, $message, InwardMaterialListResources::collection($fetchMaterial));
        return $this->responseJson(true, 201, $message, InventoryDtailsResources::collection($fetchMaterial));
    }



    public function issueTypeList(Request $request)
    {
        $data = InvIssueList::all();
        $message = 'Type List Fetch Successfullsy';
        return $this->responseJson(true, 201, $message, IssueTypeResources::collection($data));
    }


    public function list(Request $request)
    {
        $data = InvIssue::all();
        $message = 'Type List Fetch Successfullsy';
        // return $this->responseJson(true, 201, $message, $data);
        return $this->responseJson(true, 201, $message, IssueListResources::collection($data));
    }

    // C:\xampp\htdocs\php82\Konsite\construction-app-admin\app\Http\Resources\API\Inventory\IssueInward\IssueTypeResources.php


    public function issueTypeTagList(Request $request)
    {
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $type = $request->type;
        switch ($type) {
            case 'staff':
                $data = CompanyUser::where('company_id', $authCompany)->get();
                $message = 'Staff Fetch Successfull';
                break;
            case 'contractor':
                $data = Vendor::where('company_id', $authCompany)->get();
                $message = 'Vendor Fetch Successfull';
                break;
            case 'machines-or-other-assets':
                $data = Assets::where('company_id', $authCompany)->get();
                $message = 'Assets Fetch Successfull';
                break;
            case 'other-project':
                $data = Project::where('company_id', $authCompany)->get();
                $message = 'Project Fetch Successfull';
                break;
            case 'same-project-other-stores':
                $data = StoreWarehouse::where('company_id', $authCompany)->get();
                $message = 'Store/Warehouse Fetch Successfull';
                break;
                // case 'theft':
                //     $data = CompanyUser::where('company_id', $authCompany)->get();
                //     $message = 'Staff Fetch Successfull';
                //     break;
                // case 'scrap-sell':
                //     $data = CompanyUser::where('company_id', $authCompany)->get();
                //     $message = 'Staff Fetch Successfull';
                //     break;
                // case 'damage':
                //     $data = CompanyUser::where('company_id', $authCompany)->get();
                //     $message = 'Staff Fetch Successfull';
                //     break;
            default:
                return $this->responseJson(false, 200, 'Something Wrong Happened');
        }

        if ($data) {
            return $this->responseJson(true, 200, $message, $data);
        } else {
            return $this->responseJson(false, 200, 'Something Wrong Happened');
        }
    }
}

// staff
// contractor
// machines-or-other-assets
// scrap-sell
// damage
// other-project
// same-project-other-stores
// theft
