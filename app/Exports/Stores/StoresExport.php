<?php

namespace App\Exports\Stores;

use App\Http\Resources\API\Store\StoreResources;
use App\Models\Company\StoreWarehouse;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StoresExport  implements FromCollection, WithHeadings, ShouldAutoSize
{

    public function collection()
    {
        $subproject = StoreWarehouse::all();
        $collection = StoreResources::collection($subproject);
        return collect($collection);
    }

    public function headings(): array
    {
        return [
            '#',
            'uuid',
            'project_name',
            'planned_start_date',
            'address',
            'planned_end_date',
            'own_project_or_contractor',
            'project_completed',
            'project_completed_date',
            'companies',
            'client'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true], 'freeze' => true],
        ];
    }
}
