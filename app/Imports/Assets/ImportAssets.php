<?php

namespace App\Imports\Assets;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Company\Assets;
use App\Models\Company\OpeningStock;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ImportAssets implements ToModel, WithHeadingRow
{
    protected $project;
    protected $warehouses;

    public function __construct($project, $warehouses)
    {
        $this->project = $project;
        $this->warehouses = $warehouses;
    }

    public function model(array $row)
    {
        $authConpany = Auth::guard('company')->user()->id;
        $companyId = searchCompanyId($authConpany);

        $assets = Assets::where('code', $row['code'])->first();
        // dd(nametoid($row['unit'], 'units'));
        // dd($row);
        if ($assets) {
            // if ($assets->quantity > $row['opening_qty']) {
            //     $totalQty = $assets->quantity - $row['opening_qty'];
            // } elseif ($assets->quantity < $row['opening_qty']) {
            //     $totalQty = $assets->quantity + $row['opening_qty'];
            // } else {
            //     $totalQty = $row['opening_qty'];
            // }


            $assets->update([
                'name' => $row['assetequipmentsmachinery'],
                'specification' => $row['specification'],
                'unit_id' => nametoid($row['unit'], 'units') == false ? createunit($row['unit'], $companyId) : nametoid($row['unit'], 'units'),
                // 'project_id' => $this->project,
                // 'store_warehouses_id' => $this->warehouses,
            ]);
        } else {
            $data = new Assets([
                'uuid' => Str::uuid(),
                'code' => $row['code'],
                'name' => $row['assetequipmentsmachinery'],
                'specification' => $row['specification'],
                // 'quantity' => $row['opening_qty'],
                'unit_id' => nametoid($row['unit'], 'units') == false ? createunit($row['unit'], $companyId) : nametoid($row['unit'], 'units'),
                // 'project_id' => $this->project,
                // 'store_warehouses_id' => $this->warehouses,
                'company_id' => $companyId,
            ]);
        }
        // dd($data);
        return $assets ?? $data;
    }
}
