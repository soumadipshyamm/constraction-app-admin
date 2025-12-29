<?php

namespace App\Exports\Materials;

use App\Models\Company\Materials;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\MaterialsResource;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DemoMaterialsExport implements FromCollection, ShouldAutoSize
{
    public function collection()
    {
        return collect([
            [
                '#',
                'Name',
                'Class',
                'Unit',
                'Specification',

            ],
            [
                '1',
                'Stone',
                'Class-A',
                'kg',
                'Stones are solid aggregates of minerals such as flint, granite, limestone, sandstone and gems. Small rocks such as gravel and sand are also common materials.',

            ],
            [
                '2',
                'Minerals',
                'Class-B',
                'kg',
                'Minerals are naturally occurring chemical compounds. These include talc, gypsum, calcite, fluorite, apatite, quartz, topaz and corundum.',
            ]
        ]);
    }


    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true], 'freeze' => true],
        ];
    }
}
