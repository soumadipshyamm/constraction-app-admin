<?php

namespace App\Imports\Materials;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Company\Materials;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Models\Company\MaterialsStockReport;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class MaterialsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $authCompany = Auth::guard('company')->user();
        $companyId = searchCompanyId($authCompany->id);
        // $materials = Materials::where('code', $row['code'])->first();

        // Create new materials
        $data = new Materials([
            'uuid' => Str::uuid(),
            'name' => $row['name'],
            'class' => $row['class'],
            'code' =>  uniqid(),
            'specification' => $row['specification'],
            'unit_id' => nametoid($row['unit'], 'units') ?: createunit($row['unit'], $companyId),
            'company_id' => $companyId,
        ]);
        $data->save();
        return  $data;
    }
}
