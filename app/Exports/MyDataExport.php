<?php

namespace App\Exports;

use App\Http\Resources\LaboursResource;
use App\Models\Company\Labour;
use App\Models\Company\Unit;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;

class MyDataExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    public function collection()
    {
        $labours = Labour::with('units')->get();
        $collection = LaboursResource::collection($labours);
        return collect($collection);
    }

    public function headings(): array
    {
        return [
            '#',
            'Name',
            'Category',
            'Unit',
        ];
    }


    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true], 'freeze' => true],
        ];
    }

}