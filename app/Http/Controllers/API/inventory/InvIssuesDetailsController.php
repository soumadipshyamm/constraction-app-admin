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
    public function add(Request $request)
    {
        $authCompany = Auth::guard('company-api')->user();
        $datas = $request->all();
        DB::beginTransaction();
        try {
            foreach ($datas as $data) {
                InvIssuesDetails::create([
                    'uuid' => Str::uuid(),
                    'inv_issue_goods_id' => $data['inv_issue_goods_id'],
                    'materials_id' => $data['materials_id'],
                    'issue_qty' => $data['issue_qty'],
                    'stock_qty' => $data['stock_qty'],
                    // 'remarkes' => $data['remarkes'],
                    'company_id' => $authCompany->company_id,
                ]);
            }

            foreach ($datas as $data) {
                $isDataExites = inventoryDataChecking($data);
                // dd($data);
                // dd($isDataExites->toArray());
                if ($data['type'] == 'materials') {
                    $materialsId = $data['materials_id'];
                } else {
                    $assetsId = $data['materials_id'];
                }
                // dd($isDataExites);
                // dd($totalQty);
                // $totalQty = $data['stock_qty'] - $data['issue_qty'];
                $totalQty =  $data['issue_qty'];
                if (isset($isDataExites) && $isDataExites != NULL) {
                    $inventory = Inventory::where('id', $isDataExites->id)->update([
                        'total_qty' => $isDataExites->total_qty - $totalQty,
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
                        'recipt_qty' => $data['issue_qty'] ?? 0,
                        // 'reject_qty' => $data['reject_qty'] ?? 0,
                        // 'total_qty' => ($data['issue_qty'] - $data['reject_qty']),
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


// "id" => 24
//   "uuid" => "a6c07fc3-f9be-4cc9-812a-392a32494605"
//   "projects_id" => 1
//   "store_warehouses_id" => null
//   "materials_id" => 1
//   "activities_id" => null
//   "user_id" => 2
//   "date" => "2024-04-16"
//   "type" => "materials"
//   "qty" => null
//   "remarks" => "eeeeeeeeeeeeeeeeeeeeeeeeeeeeee"
//   "company_id" => 2
//   "is_active" => 1
//   "created_at" => "2024-04-16T15:41:32.000000Z"
//   "updated_at" => "2024-04-17T14:40:42.000000Z"
//   "assets_id" => null
//   "recipt_qty" => "144"
//   "reject_qty" => 44
//   "total_qty" => 219
//   "price" => "12.000"
