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
        $authCompany = Auth::guard('company-api')->user();
        $datas = $request->all();
        DB::beginTransaction();
        try {
            foreach ($datas as $data) {
                InvReturnsDetails::create([
                    'uuid' => Str::uuid(),
                    'inv_return_goods_id' => $data['inv_return_goods_id'],
                    'materials_id' => $data['materials_id'],
                    'return_qty' => $data['return_qty'],
                    'stock_qty' => $data['stock_qty'],
                    // 'remarkes' => $data['remarkes'],
                    'company_id' => $authCompany->company_id,
                ]);
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
                if (isset($isDataExites) && $isDataExites != NULL) {
                    $inventory = Inventory::where('id', $isDataExites->id)->update([
                        'total_qty' => $isDataExites->total_qty + $totalQty,
                        // 'price' => $data['price'],
                    ]);
                } else {
                    $inventory = Inventory::create([
                        'uuid' => Str::uuid(),
                        'projects_id' => $data['projects_id'],
                        'materials_id' => $materialsId ?? null,
                        'assets_id' => $assetsId ?? null,
                        'user_id' => $authCompany->id,
                        'date' => $date = Carbon::now(),
                        'type' => $data['type'],
                        'recipt_qty' => $data['return_qty'],
                        // 'reject_qty' => $data['reject_qty'],
                        // 'total_qty' => $data['recipt_qty'] - $data['reject_qty'],
                        'price' => $data['price'] ?? 0.00,
                        'remarks' => $data['remarkes'] ?? '',
                        'company_id' => $authCompany->company_id,
                    ]);
                    $inventory->inventoryStore()->sync($data['store_warehouses_id']);
                }
            }

            DB::commit();
            $message = 'Inward Goods Details Details Updated Successfully';
            return $this->responseJson(true, 201, $message, $datas);
        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage() . ' on ' . $e->getFile() . ' in ' . $e->getLine());
            return $this->responseJson(false, 500, $e->getMessage(), []);
        }
    }
}


// "inv_return_goods_id" => 1
// "projects_id" => 2
// "store_warehouses_id" => 3
// "materials_id" => 1
// "type" => 1
// "return_qty" => 144
// "stock_qty" => 44
// "remarkes" => "eeeeeeeeeeeeeeeeeeeeeeeeeeeeee"
