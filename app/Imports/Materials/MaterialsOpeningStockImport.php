<?php

namespace App\Imports\Materials;

use Illuminate\Support\Str;
use App\Models\Company\Materials;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\Company\MaterialIssue;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Models\Company\MaterialIssueStock;
use App\Models\Company\MaterialOpeningStock;
use App\Models\Inventory;
use App\Models\InventoryLog;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class MaterialsOpeningStockImport implements ToModel, WithHeadingRow
{
    protected $project;
    protected $warehouses;
    protected $openingStockDate;
    protected $companyId;

    public function __construct($project, $warehouses, $openingStockDate, $companyId)
    {
        $this->project = $project;
        $this->warehouses = $warehouses;
        $this->openingStockDate = $openingStockDate;
        $this->companyId = $companyId;
    }

    public function model(array $row)
    {
        // dd($row);
        // dd(
        //     $this->project,
        //     $this->warehouses,
        //     $this->openingStockDate,
        //     $this->companyId
        // );
        // $data = '';
        $authConpany = Auth::guard('company')->user()->id;
        $companyId = $this->companyId;
        $materials = Materials::where('code', $row['code'])->first();

        $materialsOpeningStock = MaterialOpeningStock::where('project_id', $this->project)
            ->where('store_id', $this->warehouses)
            ->where('material_id', $materials->id)
            ->where('company_id', $this->companyId)
            ->first();
        // dd($materialsOpeningStock);
        $previewStock = (!empty($materialsOpeningStock->qty) ? $materialsOpeningStock->qty : 0);

        // dd($materialsOpeningStock);
        if (!empty($materialsOpeningStock)) {
            // foreach ($materialsOpeningStock as $openingStock) {
            MaterialOpeningStock::where('id', $materialsOpeningStock->id)->update([
                'qty' => $row['opening_qty'],
            ]);

            $isCompaniesCreated = MaterialIssueStock::create([
                'project_id' => $this->project,
                'store_id' => $this->warehouses,
                'material_id' => (!empty($materials->id) ? $materials->id : null),
                'in_stock' => $previewStock,
                'add_stock' => $row['opening_qty'],
                'less_stock' => $previewStock - $row['opening_qty'],
                'total_qty' => 0.0,
                'code' => $row['code'],
                'type' => 'edit',
                'action' => 'bulk',
                'company_id' => $this->companyId,
            ]);
            // }
        } else {
            // dd($materials);
            $data = new MaterialOpeningStock([
                'uuid' => Str::uuid(),
                'material_id' => $materials->id,
                'qty' => $row['opening_qty'],
                'project_id' => $this->project,
                'store_id' => $this->warehouses,
                'opeing_stock_date' => $this->openingStockDate, // Corrected field name
                'company_id' => $companyId,
            ]);

            $isCompaniesCreated = MaterialIssueStock::create([
                'project_id' => $this->project,
                'store_id' => $this->warehouses,
                'material_id' => (!empty($materials->id) ? $materials->id : null),
                'in_stock' => $previewStock,
                'add_stock' => $row['opening_qty'],
                'less_stock' => $previewStock - $row['opening_qty'],
                'total_qty' => 0.0,
                'code' => $row['code'],
                'type' => 'add',
                'action' => 'bulk',
                'company_id' => $this->companyId,
            ]);


            $isDataExites = Inventory::where('projects_id', $this->project)
                ->where('materials_id', $materials->id)
                ->where('company_id', $companyId)
                ->first();
            // dd($isDataExites);
            if ($row['opening_qty'] > 0) {
                if ($isDataExites) {
                    // dd($storeWarehousesId);
                    Inventory::where('id', $isDataExites->id)->update([
                        // 'recipt_qty' => number_format((float)$isDataExites->recipt_qty + (float)$recipt_qty, 2, '.', ''),
                        // 'total_inward' => number_format((float)$isDataExites->total_inward + (float)$totalQty, 2, '.', ''),
                        'total_qty' => number_format((float)$isDataExites->total_qty + (float)$row['opening_qty'], 2, '.', ''),
                        // 'price' => $data['price'] ?? 0,
                    ]);
                    $inventoryData = Inventory::find($isDataExites->id);
                    inventoryLog($inventoryData, "Update opening qty", $isDataExites->id, $this->warehouses, number_format((float)$row['opening_qty'] ?? 0, 2, '.', ''), 'OPENING_STOCK');
                } else {
                    // Create new inventory entry
                    $inventoryData = [
                        'projects_id' => $this->project,
                        // 'materials_id' => $materialsId,
                        'materials_id' => $materials->id,
                        'user_id' => $authConpany,
                        'date' =>  $this->openingStockDate ?? Carbon::now()->format('Y-m-d'),
                        'type' => 'materials',
                        // 'recipt_qty' => number_format((float)$recipt_qty ?? 0, 2, '.', ''),
                        // 'reject_qty' => number_format((float)$data['reject_qty'] ?? 0, 2, '.', ''),
                        'total_qty' => number_format((float)$row['opening_qty'], 2, '.', ''),
                        // 'total_inward' => number_format((float)$totalQty, 2, '.', ''),
                        // 'po_qty' => $data['po_qty'] ?? null,
                        // 'price' => number_format((float)$data['price'] ?? 0, 2, '.', ''),
                        // 'remarks' => $data['remarkes'] ?? '',
                        'company_id' => $companyId,
                        'opening_stock' => $row['opening_qty']
                    ];
                    $inventory = Inventory::create($inventoryData);
                    if ($this->warehouses) {
                        $inventory->inventoryStore()->sync($this->warehouses);
                    }
                    InventoryLog::create([
                        'inventory_id' => $inventory->id,
                        'message' => 'add opening qty materials opening stock',
                        'qty' => number_format((float)$row['opening_qty'] ?? 0, 2, '.', ''),
                        'type' => 'materials',
                        'company_id' => $companyId
                    ]);
                }
            }
            return $data;
        }
    }
}
