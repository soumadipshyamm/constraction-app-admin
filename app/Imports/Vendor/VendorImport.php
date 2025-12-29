<?php

namespace App\Imports\Vendor;

use App\Models\Company\Vendor;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;


class VendorImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $authCompany = Auth::guard('company')->user()->id;
        $companyId = searchCompanyId($authCompany);

        // Check if the vendor with the given UUID exists
        $vendor = Vendor::where([ 'name' => $row['name']])->orwhere('uuid',$row['uuid'])->first();

        if ($vendor) {
            // If vendor exists, update the data
            $vendor->update([
                'name' => $row['name'],
                'gst_no' => $row['gst_no'] ?? null,
                'type' => $row['type'],
                'address' => $row['address'] ?? null,
                'contact_person_name' => $row['contact_person_name'] ?? null,
                'phone' => $row['contact_person_phone'] ?? null, // Map 'contact_person_phone' to 'phone'
                'email' => $row['contact_person_email'] ?? null,
                // 'company_id' => $companyId,
            ]);
            return $vendor; // Return the updated vendor
        } else {
            // If vendor does not exist, create a new vendor
            return new Vendor([
                'name' => $row['name'],
                'gst_no' => $row['gst_no'] ?? null,
                'type' => $row['type'],
                'address' => $row['address'] ?? null,
                'contact_person_name' => $row['contact_person_name'] ?? null,
                'phone' => $row['contact_person_phone'] ?? null,
                'email' => $row['contact_person_email'] ?? null,
                'company_id' => $companyId,
            ]);
        }
    }

}
