<?php

namespace App\Imports\Assets;

use App\Models\Assets\AssetsOpeningStock;
use Illuminate\Support\Str;
use App\Models\Company\Assets;
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
        // dd($assetsOpeningStock);
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
            return  $data;
        }
        // dd($data);
    }
}


// "project" => "SFT Project"
// "storeware_house" => "saarthi"
// "code" => "code123"
// "assetequipmentsmachinery" => "labourwwwwaaaaaaas"
// "unit" => "KG"
// "specification" => "jhgfgqqqqqqqqqqqqqqq"
// "opening_qty" => null