<?php

namespace App\Imports\Assets;

use App\Models\Assets\AssetsOpeningStock;
use Illuminate\Support\Str;
use App\Models\Company\Assets;
use App\Models\Inventory;
use App\Models\InventoryLog;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportAssesOpeningStock implements ToModel, WithHeadingRow
{
    protected $project;
    protected $warehouses;
    protected $openingStockDate;

    public function __construct($project, $warehouses, $openingStockDate)
    {
        $this->project = $project;
        $this->warehouses = $warehouses;
        $this->openingStockDate = $openingStockDate;
    }

    public function model(array $row)
    {
        // dd($row);
        $authConpany = Auth::guard('company')->user()->id;
        $companyId = searchCompanyId($authConpany);

        $assets = Assets::where('code', $row['code'])->first();
        // dd(nametoid($row['unit'], 'units'));

        $assetsOpeningStock = AssetsOpeningStock::where('project_id', $this->project)
            ->where('store_id', $this->warehouses)
            ->where('assets_id', $assets->id)
            ->where('company_id', $companyId)
            ->first();
        // dd($row,$assetsOpeningStock);
        $previewStock = (!empty($assetsOpeningStock->quantity) ? $assetsOpeningStock->quantity : 0);
        if (!empty($assetsOpeningStock)) {
            // dd($row);
            // foreach ($materialsOpeningStock as $openingStock) {
            AssetsOpeningStock::where('id', $assetsOpeningStock->id)->update([
                'quantity' => $row['opening_qty'],
            ]);
        } else {
            // dd($assets->id);
            $data = new AssetsOpeningStock([
                'uuid' => Str::uuid(),
                'assets_id' => $assets->id,
                'quantity' => $row['opening_qty'],
                'project_id' => $this->project,
                'store_id' => $this->warehouses,
                'opeing_stock_date' => $this->openingStockDate, // Corrected field name
                'company_id' => $companyId,
            ]);

            $isDataExites = Inventory::where('projects_id', $this->project)
                ->where('assets_id', $assets->id)
                ->where('company_id', $companyId)
                ->first();
            // dd($isDataExites);
            if ($row['opening_qty'] > 0) {
                if ($isDataExites) {
                    // dd($storeWarehousesId);
                    Inventory::where('id', $isDataExites->id)->update([
                        // 'opening_stock' => number_format((float)$isDataExites->opening_qty + (float)$row['opening_qty'], 2, '.', ''),
                        'total_qty' => number_format((float)$isDataExites->total_qty + (float)$row['opening_qty'], 2, '.', ''),
                    ]);
                    $inventoryData = Inventory::find($isDataExites->id);
                    inventoryLog($inventoryData, "Update opening qty", $isDataExites->id, $this->warehouses, number_format((float)$row['opening_qty'] ?? 0, 2, '.', ''), 'OPENING_STOCK');
                } else {
                    // Create new inventory entry
                    $inventoryData = [
                        'projects_id' => $this->project,
                        'assets_id' => $assets->id,
                        'user_id' => $authConpany,
                        'date' =>  $this->openingStockDate ?? Carbon::now()->format('Y-m-d'),
                        'type' => 'machines',
                        'total_qty' => number_format((float)$row['opening_qty'], 2, '.', ''),
                        'remarks' => $data['remarkes'] ?? '',
                        'company_id' => $companyId,
                        'opening_stock' => $row['opening_qty'] ?? 0
                    ];
                    $inventory = Inventory::create($inventoryData);
                    if ($this->warehouses) {
                        $inventory->inventoryStore()->sync($this->warehouses);
                    }
                    InventoryLog::create([
                        'inventory_id' => $inventory->id,
                        'message' => 'add opening qty machines opening stock',
                        'qty' => number_format((float)$row['opening_qty'] ?? 0, 2, '.', ''),
                        'type' => 'machines',
                        'company_id' => $companyId
                    ]);
                }
            }
            return  $data;
        }
    }
}
