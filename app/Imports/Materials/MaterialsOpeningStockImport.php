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
        // $data = '';
        $companyId = $this->companyId;
        $materials = Materials::where('code', $row['code'])->first();

        $materialsOpeningStock = MaterialOpeningStock::where('project_id', $this->project)
            ->where('store_id', $this->warehouses)
            ->where('material_id', $materials->id)
            ->where('company_id', $this->companyId)
            ->first();
        // dd($materialsOpeningStock->qty);
        $previewStock = (!empty($materialsOpeningStock->qty) ? $materialsOpeningStock->qty : 0);

        // dd($materialsOpeningStock->id);
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
                'total_qty' => '',
                'code' => $row['code'],
                'type' => 'edit',
                'action' => 'bulk',
                'company_id' => $this->companyId,
            ]);
            // }
        } else {
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
                'total_qty' => '',
                'code' => $row['code'],
                'type' => 'add',
                'action' => 'bulk',
                'company_id' => $this->companyId,
            ]);
            // $data->save(); // Save the new record
            return $data;
        }
    }
}
