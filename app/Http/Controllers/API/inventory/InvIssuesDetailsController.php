<?php

namespace App\Http\Controllers\API\inventory;

use App\Http\Controllers\BaseController;
use App\Models\Inventory;
use App\Models\InvIssue;
use App\Models\InvIssuesDetails;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class InvIssuesDetailsController extends BaseController
{
    // public function add(Request $request)
    // {
    //     $authCompany = Auth::guard('company-api')->user();
    //     $datas = $request->all();
    //     DB::beginTransaction();

    //     try {
    //         foreach ($datas as $data) {
    //             // Determine the type and set the corresponding ID
    //             if ($data['type'] == 'materials') {
    //                 $materialsId = $data['materials_id'];
    //                 // $assetsId = NULL;
    //             } else {
    //                 $assetsId = $data['materials_id'];
    //                 // $materialsId = NULL;
    //             }
    //             $invIssuesQty = $data['issue_qty'] ?? 0;
    //             if (!empty($data['id'] || $data['id'] != null)) {
    //                 $invIssuesDetailsissue_qty = InvIssuesDetails::where('id', $data['id'])->first();
    //                 $invIssuesQty = compareAndCalculate($invIssuesDetailsissue_qty->issue_qty, $data['issue_qty'], $data['stock_qty']);
    //             }
    //             $attributes = [
    //                 'uuid' => Str::uuid(),
    //                 'inv_issue_goods_id' => $data['inv_issue_goods_id'],
    //                 'materials_id' => $materialsId ?? NULL,
    //                 'issue_qty' => $data['issue_qty'],
    //                 'stock_qty' => $data['stock_qty'],
    //                 'remarkes' => $data['remarkes'] ?? null,
    //                 'company_id' => $authCompany->company_id,
    //                 'type' => $data['type'],
    //                 'assets_id' => $assetsId ?? NULL,
    //                 'activities_id' => $data['activities_id'] ?? NULL
    //             ];

    //             if (!empty($data['id'] || $data['id'] != null)) {
    //                 // Use updateOrCreate to update the record if it exists
    //                 InvIssuesDetails::updateOrCreate(
    //                     ['id' => $data['id']], // Search criteria
    //                     $attributes // Attributes to update or create
    //                 );
    //             } else {
    //                 // Use create to create a new record if ID is not provided
    //                 InvIssuesDetails::create($attributes);
    //             }
    //         }

    //         foreach ($datas as $data) {
    //             $isDataExites = inventoryDataChecking($data);

    //             if ($data['type'] == 'materials') {
    //                 $materialsId = $data['materials_id'];
    //             } else {
    //                 $assetsId = $data['materials_id'];
    //             }

    //             $totalQty =  $invIssuesQty ?? 0;
    //             // $totalQty =  $data['issue_qty'];
    //             if (isset($isDataExites) && $isDataExites != NULL) {
    //                 $inventory = Inventory::where('id', $isDataExites->id)->first();
    //                 $inventoryData = $inventory;
    //                 $inventory->update([
    //                     'total_qty' => $totalQty,
    //                     // 'total_qty' => $isDataExites->total_qty - $totalQty,
    //                 ]);
    //                 inventoryLog($inventoryData, "update issue qty pre-$invIssuesDetailsissue_qty?->issue_qty to $invIssuesQty total $totalQty", $inventoryData->id);
    //             } else {
    //                 $inventory = Inventory::create([
    //                     'uuid' => Str::uuid(),
    //                     'projects_id' => $data['projects_id'],
    //                     'materials_id' => $materialsId ?? null,
    //                     'assets_id' => $assetsId ?? null,
    //                     'user_id' => $authCompany->id,
    //                     'date' => $date = Carbon::now(),
    //                     'type' => $data['type'],
    //                     'recipt_qty' => $data['issue_qty'] ?? 0,
    //                     // 'reject_qty' => $data['reject_qty'] ?? 0,
    //                     // 'total_qty' => ($data['issue_qty'] - $data['reject_qty']),
    //                     'price' => $data['price'] ?? 0.00,
    //                     'remarks' => $data['remarkes'] ?? '',
    //                     'company_id' => $authCompany->company_id,
    //                 ]);
    //                 $inventory->inventoryStore()->sync($data['store_warehouses_id']);
    //                 inventoryLog($inventory, "create issue qty '{$data['issue_qty']}'", $inventory?->id, $data['store_warehouses_id']);
    //             }
    //         }

    //         DB::commit();
    //         $message = 'Issue Goods Details Details Updated Successfully';
    //         // addNotifaction($message, $datas, $request->projects_id ?? null,$authCompany->company_id);
    //         return $this->responseJson(true, 201, $message, $datas);
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         logger($e->getMessage() . ' on ' . $e->getFile() . ' in ' . $e->getLine());
    //         return $this->responseJson(false, 500, $e->getMessage(), []);
    //     }
    // }

    public function add(Request $request)
    {
        log_daily('InvIssuesDetailsController', 'Inventory InvIssuesDetailsController', 'add', 'info', json_encode($request->all()));
        $authCompany = Auth::guard('company-api')->user();
        $datas = $request->all();
        DB::beginTransaction();
        // dd($datas);
        try {
            foreach ($datas as $data) {
                // Determine the type and set the corresponding ID
                $materialsId = null;
                $assetsId = null;

                if ($data['type'] === 'materials') {
                    $materialsId = $data['materials_id'];
                } else {
                    $assetsId = $data['materials_id'];
                }
                // dd($data);
                // Calculate the issue quantity based on existing record
                $invIssuesQty = $this->calculateIssueQty($data);
                // dd($invIssuesQty);
                // Prepare attributes for database operations
                $attributes = $this->prepareAttributes($data, $authCompany, $materialsId, $assetsId);
                // dd($attributes);
                // Update or create inventory issue details
                $sedrfghjk = $this->updateOrCreateInventoryIssue($data, $attributes);
                // dd($sedrfghjk);
                // Handle inventory updates
                $dfghjk = $this->handleInventoryUpdate($data, $invIssuesQty, $authCompany, $materialsId, $assetsId);
                // dd($dfghjk);
            }
            // dd($datas);
            log_daily('InvIssuesDetailsController', 'Inventory InvIssuesDetailsController result', 'add', 'info', json_encode($datas));
            DB::commit();
            return $this->responseJson(true, 201, 'Issue Goods Details Updated Successfully', $datas);
        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage() . ' on ' . $e->getFile() . ' in ' . $e->getLine());
            return $this->responseJson(false, 500, 'An error occurred while processing your request.', []);
        }
    }

    /**
     * Calculate the issue quantity based on existing record.
     */
    private function calculateIssueQty($data)
    {
        log_daily('InvIssuesDetailsController', 'Inventory InvIssuesDetailsController', 'calculateIssueQty', 'info', json_encode($data));

        // Default issue quantity
        $invIssuesQty = $data['issue_qty'] ?? 0;

        if (!empty($data['id'])) {
            $invIssuesDetails = InvIssuesDetails::find($data['id']);
            if ($invIssuesDetails) {
                $invIssuesQty = compareAndCalculate($invIssuesDetails->issue_qty, $data['issue_qty'], $data['stock_qty']);
            }
        }

        return $invIssuesQty;
    }

    /**
     * Prepare attributes for database operations.
     */
    private function prepareAttributes($data, $authCompany, $materialsId, $assetsId)
    {
        log_daily('InvIssuesDetailsController', 'Inventory InvIssuesDetailsController', 'prepareAttributes', 'info', json_encode([$data, $authCompany, $materialsId, $assetsId]));

        return [
            // 'uuid' => Str::uuid(),
            'inv_issue_goods_id' => $data['inv_issue_goods_id'],
            'materials_id' => $materialsId,
            'issue_qty' => $data['issue_qty'] ?? 0.0,
            'stock_qty' => $data['stock_qty'] ?? 0.0,
            'remarkes' => $data['remarkes'] ?? null,
            'company_id' => $authCompany->company_id,
            'type' => $data['type'],
            'assets_id' => $assetsId,
            'activities_id' => $data['activities_id'] ?? null
        ];
    }

    /**
     * Update or create inventory issue details.
     */
    public function updateOrCreateInventoryIssue($data, $attributes)
    {
        log_daily('InvIssuesDetailsController', 'Inventory InvIssuesDetailsController', 'updateOrCreateInventoryIssue', 'info', json_encode([$data, $attributes]));
        if (!empty($data['id'])) {
            $invIssuesDetails = InvIssuesDetails::updateOrCreate(
                ['id' => $data['id']], // Search criteria
                $attributes // Attributes to update or create
            );
            // dd($invIssuesDetails);
            return $invIssuesDetails;
        } else {
            $invIssuesDetails = InvIssuesDetails::create($attributes); // Create a new record
            // dd($invIssuesDetails);
            return $invIssuesDetails;
        }
    }

    /**
     * Handle inventory updates based on the issue details.
     */
    private function handleInventoryUpdate($data, $invIssuesQty, $authCompany, $materialsId, $assetsId)
    {
        log_daily('InvIssuesDetailsController', 'Inventory InvIssuesDetailsController', 'handleInventoryUpdate', 'info', json_encode([$data, $invIssuesQty, $authCompany, $materialsId, $assetsId]));
        $isDataExists = inventoryDataChecking($data);
        // dd($isDataExists);
        $inventory = null;
        if ($isDataExists) {
            $inventory = Inventory::find($isDataExists->id);
            // dd($invIssuesQty);
            // dd(((float)$inventory?->total_qty) - ((float)$invIssuesQty));
            //$inventory?->total_qty - $invIssuesQty make a decimal value
            $totalQty = ((float)$inventory?->total_qty) - ((float)$invIssuesQty);
            $total_issue = ((float)$inventory?->total_issue) + ((float)$invIssuesQty);
            // dd($totalQty);
            $inventory->update(['total_qty' => $totalQty, 'total_issue' => $total_issue]);
            // dd($inventory);
            // Log the inventory update
            $message = "update issue qty pre-{$isDataExists->issue_qty} to $invIssuesQty total {$inventory->total_qty}";
            inventoryLog($inventory, $message, $inventory->id, $data['store_warehouses_id'], $invIssuesQty, 'ISSUE');
        } else {
            // dd($data);
            $inventory = Inventory::create([
                'uuid' => Str::uuid(),
                'projects_id' => $data['projects_id'],
                'materials_id' => $materialsId,
                'assets_id' => $assetsId,
                'user_id' => $authCompany->id,
                'date' => Carbon::now(),
                'type' => $data['type'],
                'total_issue' => (float)($data['issue_qty'] ?? 0.0),
                'price' => (float)($data['price'] ?? 0.00),
                'remarks' => $data['remarkes'] ?? '',
                'company_id' => $authCompany->company_id,
            ]);

            $inventory->inventoryStore()->sync($data['store_warehouses_id']);
            inventoryLog($inventory, "create issue qty '{$data['issue_qty']}'", $inventory->id, $data['store_warehouses_id'], $invIssuesQty, 'ISSUE');
        }
        // dd($inventory);
        return $inventory;
    }
}
