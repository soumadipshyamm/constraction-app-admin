<?php

namespace App\Exports\Companies;

use App\Http\Resources\API\Companies\CompaniesResources;
use App\Http\Resources\Export\CompaniesExportResources;
use App\Http\Resources\VendorResource;
use App\Models\Company\Companies;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CompaniesExport implements FromCollection, WithHeadings, ShouldAutoSize
{

    public function collection()
    {
        $companies = Companies::all();
        $collection = CompaniesExportResources::collection($companies);
        return collect($collection);
    }

    public function headings(): array
    {
        return [
            '#',
            'registration_name',
            'company_registration_no',
            'registered_address',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true], 'freeze' => true],
        ];
    }
}
