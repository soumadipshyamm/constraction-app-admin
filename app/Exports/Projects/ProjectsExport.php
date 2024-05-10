<?php

namespace App\Exports\Projects;

use App\Http\Resources\API\Project\ProjectResource;
use App\Http\Resources\Export\ProjectsExportResources;
use App\Models\Company\Project;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProjectsExport implements FromCollection, WithHeadings, ShouldAutoSize
{

    public function collection()
    {
        $project = Project::all();
        $collection = ProjectsExportResources::collection($project);
        return collect($collection);
    }

    public function headings(): array
    {
        return [
            '#',
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
