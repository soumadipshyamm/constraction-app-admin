<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Str;
use App\Models\Company\Labour;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MyDataImport implements ToModel, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public function model(array $row)
    {

        $authConpany = Auth::guard('company')->user()->id;
        $companyId = searchCompanyId($authConpany);
        $data = new Labour([
            'uuid' => Str::uuid(),
            'name' => $row['name'],
            'category' => $row['category'],
            'unit_id' => nametoid($row['unit'], 'units') == false ? createunit($row['unit'], $companyId) : nametoid($row['unit'], 'units'),
            'company_id' => $companyId,
        ]);
        return $data;
    }
}
