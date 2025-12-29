<?php

namespace App\Exports\Subprojects;

use App\Http\Resources\API\SubProject\SubProjectResources;
use App\Http\Resources\Export\SubprojectsExportResources;
use App\Models\Company\SubProject;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SubprojectsExport implements FromCollection, WithHeadings, ShouldAutoSize
{

    public function collection()
    {
        $subproject = SubProject::all();
        $collection = SubprojectsExportResources::collection($subproject);
        return collect($collection);
    }

    public function headings(): array
    {
        return [
            '#',
            'name',
            'start_date',
            'end_date',
            'project_name',
        ];
    }



    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true], 'freeze' => true],
        ];
    }
}
