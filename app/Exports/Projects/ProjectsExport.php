<?php

namespace App\Exports\Projects;

use App\Http\Resources\API\Project\ProjectResource;
use App\Http\Resources\Export\ProjectsExportResources;
use App\Models\Company\Project;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProjectsExport implements FromCollection, WithHeadings, ShouldAutoSize
{

    public function collection()
    {
        $authCompany = Auth::guard('company')->user()->id;
        $companyId = searchCompanyId($authCompany);

        $project = Project::where('company_id',$companyId)->get();
        $collection = ProjectsExportResources::collection($project);
        return collect($collection);
    }

    public function headings(): array
    {
        return [
            '#',
            'Project Name',
            'Planned Start Date',
            'Address',
            'Planned End Date',
            'Project/Contractor',
            'Project Completed',
            'Project Completed Date',
            'Companies',
            'Client'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true], 'freeze' => true],
        ];
    }
}
