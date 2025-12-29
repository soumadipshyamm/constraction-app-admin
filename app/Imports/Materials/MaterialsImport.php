<?php

namespace App\Imports\Materials;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Company\Materials;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Models\Company\MaterialsStockReport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class MaterialsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $authCompany = Auth::guard('company')->user();
        $companyId = searchCompanyId($authCompany->id);
        // dd($row);
        // Prepare the unique attributes and update data
        $attributes =Materials::where('company_id', $companyId)->where([
            'uuid'=> $row['uuid'],
        ])->where(DB::raw('LOWER(name)'), strtolower($row['name']))
        ->first();
        // ])->orwhere('name',$row['name'])->first();
info("*********************************attributes********************************************");
info($attributes);
        if ($attributes) {
            // Update existing asset
            $attributes->update([
                'name' => $row['name'],
                'class' => $row['class'],
                'specification' => $row['specification'],
                'unit_id' => nametoid($row['unit'], 'units') ?: createunit($row['unit'], $companyId),
            ]);
            Log::info("$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$ Updated Materials: ", $attributes->toArray());
            return $attributes;
        } else {
            // Create a new asset
            $data = new Materials([
                'name' => $row['name'],
                'specification' => $row['specification'],
                'class' => $row['class'],
                'unit_id' => nametoid($row['unit'], 'units') ?: createunit($row['unit'], $companyId),
                'company_id' => $companyId,
            ]);
            Log::info("################################Created new Materials: ", $data->toArray());
            return $data;
        }

    }
}
