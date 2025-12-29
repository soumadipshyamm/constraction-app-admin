<?php

namespace App\Http\Controllers\API\inventory;

use App\Http\Controllers\BaseController;
use App\Models\Inventory;
use App\Models\InvReturnsDetails;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class InvReturnsDetailsController extends BaseController
{
    public function add(Request $request)
    {
        log_daily('InvReturnsDetailsController', 'Inventory Return Goods Add', 'add', 'info', json_encode($request->all()));
        $authCompany = Auth::guard('company-api')->user();
        $datas = $request->all();
        DB::beginTransaction();
        try {
            foreach ($datas as $data) {
                // dd($data);
                $attributes = [
                    'uuid' => Str::uuid(),
                    'inv_return_goods_id' => $data['inv_return_goods_id'],
                    'materials_id' => $data['type'] == 'materials' ? $data['materials_id'] : null,
                    'assets_id' => $data['type'] == 'machines' ? $data['materials_id'] : null,
                    'return_qty' => $data['return_qty'],
                    'stock_qty' => $data['stock_qty'],
                    'type' => $data['type'],
                    'company_id' => $authCompany->company_id,
                    'activities_id' => $data['activities_id'] ?? NULL
                    // 'remarkes' => $data['remarkes'],
                ];
                if (!empty($data['id']) || $data['id'] != null) {
                    // dd($attributes);
                    // Use updateOrCreate to update the record if it exists
                    InvReturnsDetails::updateOrCreate(
                        ['id' => $data['id']], // Search criteria
                        $attributes // Attributes to update or create
                    );
                } else {
                    // dd($attributes);
                    // Use create to create a new record if ID is not provided
                    InvReturnsDetails::create($attributes);
                }
            }

            foreach ($datas as $data) {
                $isDataExites = inventoryDataChecking($data);
                if ($data['type'] == 'materials') {
                    $materialsId = $data['materials_id'];
                } else {
                    $assetsId = $data['materials_id'];
                }
                // $totalQty = $data['recipt_qty'] - $data['reject_qty'];
                $totalQty = $data['return_qty'];
                // dd($isDataExites);
                if (isset($isDataExites) && $isDataExites != NULL) {
                    $inventory = Inventory::where('id', $isDataExites->id)->update([
                        'total_qty' => number_format((float)$isDataExites->total_qty + (float)$totalQty, 2, '.', ''),
                        // 'price' => $data['price'],
                    ]);
                } else {
                    $inventory = Inventory::create([
                        'uuid' => Str::uuid(),
                        'projects_id' => $data['projects_id'],
                        'materials_id' => $materialsId ?? null,
                        'assets_id' => $assetsId ?? null,
                        'user_id' => $authCompany->id,
                        'date' => Carbon::now(),
                        'type' => $data['type'],
                        'recipt_qty' => number_format((float)$data['return_qty'], 2, '.', ''),
                        'price' => $data['price'] ?? 0.00,
                        'remarks' => $data['remarkes'] ?? '',
                        'company_id' => $authCompany->company_id,
                        'activities_id' => $data['activities_id'] ?? NULL
                    ]);
                    $inventory->inventoryStore()->sync($data['store_warehouses_id']);
                }
            }
            log_daily('InvReturnsDetailsController', 'Inventory Return Goods Add result', 'add', 'info', json_encode($request->all()));

            DB::commit();
            $message = 'Return Goods Details Updated Successfully';
            // addNotifaction($message, $datas, $request->projects_id ?? null,$authCompany->company_id);
            return $this->responseJson(true, 201, $message, $datas);
        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage() . ' on ' . $e->getFile() . ' in ' . $e->getLine());
            return $this->responseJson(false, 500, $e->getMessage(), []);
        }
    }
}
