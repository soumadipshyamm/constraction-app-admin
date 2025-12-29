<?php

namespace App\Http\Controllers\API\inventory;

use App\Http\Controllers\BaseController;
use App\Http\Resources\API\Inventory\inventor\InventoryDtailsResources;
use App\Http\Resources\API\Inventory\IssueInward\InwardMaterialListResources;
use App\Http\Resources\API\Inventory\IssueInward\IssueListResources;
use App\Http\Resources\API\Inventory\IssueInward\IssueMaterialResource;
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
use Illuminate\Support\Facades\Log;

class InvIssueController extends BaseController
{
    public function add(Request $request)
    {
        log_daily('Issue', 'Inventory Issue Add', 'add', 'info', json_encode($request->all()));
        $store_warehouses_id = $request->store_warehouses_id;
        $authCompany = Auth::guard('company-api')->user();

        $record = InvIssue::create(
            [
                'projects_id' => $request->projects_id,
                'company_id' => $authCompany->company_id,
                'user_id' => $authCompany->id,
                'date' => Carbon::now()->format('Y-m-d'),
                'name' => $request->name
            ]
        );
        $record->InvIssueStore()->sync($store_warehouses_id);
        $message = 'Inward Details Updated Successfullsy';
        // addNotifaction($message, $record, $request->projects_id ?? null,$authCompany->company_id);
        return $this->responseJson(true, 201, $message, $record);
    }




    public function materialsList(Request $request)
    {
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $projectId = $request->project_id;
        $goodsType = $request->goods_type;
        $type = $request->type;
        // dd($authCompany);
        // Identify foreign key based on goods type
        $foreignKey = ($goodsType === 'materials') ? 'materials_id' : 'assets_id';

        // Helper to get relevant material/asset IDs based on type
        $materialOrAssetIds = $this->getMaterialOrAssetIds($authCompany, $projectId, $goodsType, $type, $foreignKey);
        // dd($materialOrAssetIds);
        // If no material/asset IDs are found, return empty response
        if ($materialOrAssetIds->isEmpty()) {
            return $this->responseJson(true, 200, 'No Materials/Assets Found', []);
        }

        // Fetch materials/assets based on relevant IDs
        $model = ($goodsType === 'materials') ? Materials::class : Assets::class;
        $relation = ($type === 'issue') ? 'invInwardGoodDetails' : 'invIssuesDetails';

        // Fetch and filter materials/assets with stock data
        $materialList = $model::whereIn('id', $materialOrAssetIds)
            ->whereHas($relation, fn($q) => $q->whereNotNull($foreignKey))
            ->whereHas('inventorys', function ($query) use ($projectId, $foreignKey, $materialOrAssetIds) {
                $query->where('projects_id', $projectId)
                    ->whereIn($foreignKey, $materialOrAssetIds)
                    ->where('total_qty', '>', 0);
            })
            ->with(['inventorys' => function ($query) use ($projectId, $foreignKey, $materialOrAssetIds) {
                $query->where('projects_id', $projectId)
                    ->whereIn($foreignKey, $materialOrAssetIds)
                    ->where('total_qty', '>', 0);
            }])
            ->get()
            ->map(function ($item) {
                $totalQty = optional($item->inventorys)->total_qty ?? 0;
                $item->total_stk_qty = ($totalQty > 0) ? $totalQty : null;
                return $item;
            })
            ->filter(fn($item) => !is_null($item->total_stk_qty));

        // dd($materialList);
        return $this->responseJson(true, 200, 'Materials List Fetched Successfully', IssueMaterialResource::collection($materialList));
    }

    // Helper method to extract relevant material/asset IDs
    private function getMaterialOrAssetIds($authCompany, $projectId, $goodsType, $type, $foreignKey)
    {
        log_daily('Issue', 'Inventory Issue Add', 'getMaterialOrAssetIds', 'info', json_encode([
            'authCompany' => $authCompany,
            'projectId' => $projectId,
            'goodsType' => $goodsType,
            'type' => $type,
            'foreignKey' => $foreignKey
        ]));


        if ($type === 'issue') {
            return InvInward::where('company_id', $authCompany)
                ->where('projects_id', $projectId)
                ->whereHas('invInwardGood', fn($query) => $query->where('type', $goodsType))
                ->with('invInwardGood.invInwardGoodDetails')
                ->get()
                ->pluck('invInwardGood.*.invInwardGoodDetails.*.' . $foreignKey)
                ->flatten()
                ->filter()
                ->unique();
        }

        if ($type === 'return') {
            return InvIssue::where('company_id', $authCompany)
                ->where('projects_id', $projectId)
                ->whereHas('invIssueGoods', fn($query) => $query->where('type', $goodsType))
                ->with('invIssueGoods.invIssueDetails')
                ->get()
                ->pluck('invIssueGoods.*.invIssueDetails.*.' . $foreignKey)
                ->flatten()
                ->filter()
                ->unique();
        }


        log_daily('Issue', 'getMaterialOrAssetIds before result', 'getMaterialOrAssetIds', 'info', json_encode(collect()));
        return collect(); // Return an empty collection if type doesn't match
    }


    // ************************************************************************

    // public function materialsList(Request $request)
    // {
    //     $authCompany = Auth::guard('company-api')->user()->company_id;
    //     $projectId = $request->project_id;
    //     $goodsType = $request->goods_type;
    //     $type = $request->type;
    //     // dd($authCompany);
    //     // Identify foreign key based on goods type
    //     $foreignKey = ($goodsType === 'materials') ? 'materials_id' : 'assets_id';

    //     // Helper to get relevant material/asset IDs based on type
    //     $materialOrAssetIds = $this->getMaterialOrAssetIds($authCompany, $projectId, $goodsType, $type, $foreignKey);
    //     // dd($materialOrAssetIds);
    //     // If no material/asset IDs are found, return empty response
    //     if ($materialOrAssetIds->isEmpty()) {
    //         return $this->responseJson(true, 200, 'No Materials/Assets Found', []);
    //     }

    //     // Fetch materials/assets based on relevant IDs
    //     $query = ($goodsType === 'materials') ? Materials::whereIn('id', $materialOrAssetIds) : Assets::whereIn('id', $materialOrAssetIds);

    //     // dd( $query);
    //     // Determine relationship for stock data
    //     $relation = ($type === 'issue') ? 'invInwardGoodDetails' : 'invIssuesDetails';

    //     // Fetch and filter materials/assets with stock data
    //     $materialList = $query
    //         ->whereHas($relation, fn($q) => $q->whereNotNull($foreignKey))
    //         ->with('inventorys') // Load inventory stock details
    //         ->get()
    //         ->map(function ($item) {
    //             $totalQty = optional($item->inventorys)->total_qty ?? 0;
    //             $item->total_stk_qty = ($totalQty > 0) ? $totalQty : null; // Only keep valid stock values
    //             return $item;
    //         })
    //         ->filter(fn($item) => !is_null($item->total_stk_qty)); // Remove null values

    //     // dd($materialList);
    //     // Return response
    //     return $this->responseJson(true, 200, 'Materials List Fetched Successfully', IssueMaterialResource::collection($materialList));
    // }
    // private function getMaterialOrAssetIds($authCompany, $projectId, $goodsType, $type, $foreignKey)
    // {
    //     log_daily('Issue', 'Inventory Issue Add', 'getMaterialOrAssetIds', 'info', json_encode([
    //         'authCompany' => $authCompany,
    //         'projectId' => $projectId,
    //         'goodsType' => $goodsType,
    //         'type' => $type,
    //         'foreignKey' => $foreignKey
    //     ]));


    //     // dd($authCompany, $projectId, $goodsType, $type, $foreignKey);
    //     if ($type === 'issue') {
    //         // Fetch Inward Goods with related data
    //         $fetchInwardGoods = InvInward::with('invInwardGood.invInwardGoodDetails')
    //             ->where('company_id', $authCompany)
    //             ->where('projects_id', $projectId)
    //             ->whereHas('invInwardGood', function ($query) use ($goodsType) {
    //                 $query->where('type', $goodsType);
    //             })
    //             ->get();
    //         // dd($fetchInwardGoods);

    //         // Extract relevant invInwardGoodDetails that contain materials/assets
    //         return $fetchInwardGoods->flatMap(function ($item) {
    //             return $item->invInwardGood->flatMap(function ($good) {
    //                 return $good->invInwardGoodDetails;
    //             });
    //         })->pluck($foreignKey)->filter()->unique();
    //     }

    //     if ($type === 'return') {
    //         // Fetch Issue Goods with related data
    //         $fetchIssueGoods = InvIssue::with('invIssueGoods.invIssueDetails')
    //             ->where('company_id', $authCompany)
    //             ->where('projects_id', $projectId)
    //             ->whereHas('invIssueGoods', function ($query) use ($goodsType) {
    //                 $query->where('type', $goodsType);
    //             })
    //             ->get();

    //         // Extract relevant invIssueDetails that contain materials/assets
    //         return $fetchIssueGoods->flatMap(function ($item) {
    //             return $item->invIssueGoods->flatMap(function ($good) {
    //                 return $good->invIssueDetails;
    //             });
    //         })->pluck($foreignKey)->filter()->unique();
    //     }



    //     log_daily('Issue', 'getMaterialOrAssetIds before result', 'getMaterialOrAssetIds', 'info', json_encode(collect()));
    //     return collect(); // Return an empty collection if type doesn't match
    // }

    // ************************************************************************

    public function issueTypeList(Request $request)
    {
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $data = InvIssueList::orderBy('id', 'desc')->get();
        $message = 'Type List Fetch Successfullsy';
        return $this->responseJson(true, 201, $message, IssueTypeResources::collection($data));
    }


    public function list(Request $request)
    {
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $data = InvIssue::orderBy('id', 'desc')
            ->where('company_id', $authCompany)
            ->whereHas('invIssueGoods', function ($q) {
                $q->whereNotNull('inv_issues_id'); // Check for 'inv_issues_id' not being null
            })
            ->get();
        $message = 'Type List Fetch Successfullsy';
        return $this->responseJson(true, 200, $message, IssueListResources::collection($data));
    }

    public function issueTypeTagList(Request $request)
    {
        $authCompany = Auth::guard('company-api')->user()->company_id;
        // dd($authCompany);
        Log::info($request->all());
        $type = $request->type;
        $project_id = $request->project_id;
        $store_id = $request->store_id;
        switch ($type) {
            case 'staff':
                $data = CompanyUser::where('company_id', $authCompany)->orderBy('id', 'desc')->get();
                $message = 'Staff Fetch Successfull';
                break;
            case 'contractor':
                $data = Vendor::where('company_id', $authCompany)->whereIn('type', ['both', 'contractor'])->orderBy('id', 'desc')->get();
                $message = 'Vendor Fetch Successfull';
                break;
            case 'machines-or-other-assets':
                $data = Assets::where('company_id', $authCompany)->orderBy('id', 'desc')->get();
                $message = 'Assets Fetch Successfull';
                break;
            case 'other-project':
                // $data = Project::where('company_id', $authCompany)->whereNot('id', $project_id)->orderBy('id', 'desc')->get();
                // $message = 'Project Fetch Successfull';
                $data = Project::where('company_id', $authCompany)->whereNot('id', $project_id)->orderBy('id', 'desc')->get()->map(function ($project) {
                    $project->name = $project->project_name; // Change project_name to name
                    unset($project->project_name); // Remove the old project_name field
                    return $project;
                });
                $message = 'Project Fetch Successfull';
                break;
            case 'same-project-other-stores':
                $data = StoreWarehouse::where('company_id', $authCompany)->where('projects_id', $project_id)->whereNot('id', $store_id)->orderBy('id', 'desc')->get();
                $message = 'Store/ Warehouse Fetch Successfull';
                break;
            case 'same project-other stores':
                $data = StoreWarehouse::where('company_id', $authCompany)->where('projects_id', $project_id)->whereNot('id', $store_id)->orderBy('id', 'desc')->get();
                $message = 'Store/ Warehouse Fetch Successfull';
                break;

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
