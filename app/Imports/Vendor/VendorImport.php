<?php

namespace App\Imports\Vendor;

use App\Models\Company\Vendor;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;

class VendorImport implements ToModel, WithHeadingRow
{

    public function model(array $row)
    {
        $authConpany = Auth::guard('company')->user()->id;
        $companyId = searchCompanyId($authConpany);
        $data = new Vendor([
            'uuid' => Str::uuid(),
            'name' => $row['name'],
            'gst_no' => $row['gst_no'],
            'type' => $row['type'],
            'address' => $row['address'],
            'contact_person_name' => $row['contact_person_name'],
            'phone' => $row['contact_person_phone'],
            'email' => $row['contact_person_email'],
            'company_id' => $companyId,
        ]);
        return $data;
    }
}
