<?php

namespace App\Exports\Stores;

use App\Http\Resources\API\Store\StoreResources;
use App\Http\Resources\Export\LabourExportResources;
use App\Models\Company\StoreWarehouse;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StoresExport  implements FromCollection, WithHeadings, ShouldAutoSize
{

    public function collection()
    {

        $authCompany = Auth::guard('company')->user()->id;
        $companyId = searchCompanyId($authCompany);
        $subproject = StoreWarehouse::where('company_id',$companyId)->get();
        // $subproject = StoreWarehouse::all();
        $collection = LabourExportResources::collection($subproject);
        return collect($collection);
    }

    public function headings(): array
    {
        return [
            '#',
            'Name',
            'Location',
            'Project Name',

        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true], 'freeze' => true],
        ];
    }
}
