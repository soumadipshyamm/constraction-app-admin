<?php

namespace App\Exports\Vendor;

use App\Http\Resources\VendorResource;
use Maatwebsite\Excel\Concerns\FromCollection;
use App\Http\Resources\LaboursResource;
use App\Models\Company\Labour;
use App\Models\Company\Vendor;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExportVendor  implements FromCollection, WithHeadings, ShouldAutoSize
{

        public function collection()
    {
        $vendor = Vendor::all();
        $collection = VendorResource::collection($vendor);
        return collect($collection);
    }

    public function headings(): array
    {
        return [
            '#',
            'Name',
            'Type',
            'Gst No',
            'Address',
            'Contact Person Name',
            'Contact Person Phone',
            'Contact Person Email',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true], 'freeze' => true],
        ];
    }

}