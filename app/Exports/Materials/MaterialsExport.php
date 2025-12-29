<?php

namespace App\Exports\Materials;

use App\Http\Resources\Export\MaterialsExportResources;
use App\Models\Company\Unit;
use App\Models\Company\Materials;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Events\AfterSheet;
use App\Http\Resources\MaterialsResource;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;

class MaterialsExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents, WithStyles
{
    protected $selects;
    protected $row_count;
    protected $column_count;
    protected $units;

    public function __construct()
    {
        $this->units = getUnit();          // Fetch unit options dynamically
        $this->row_count = 100;
        $this->column_count = 5;
    }

    public function collection()
    {
        $authCompany = Auth::guard('company')->user()->id;
        $companyId = searchCompanyId($authCompany);

        $materials = Materials::with('units')->where('company_id', $companyId)->get();
        $this->row_count = $materials->count() + 1;
        return MaterialsExportResources::collection($materials)->collect();
    }

    public function headings(): array
    {
        return [
            '#',
            'Uuid',
            'Code',
            'Name',
            'Class',
            'Unit',
            'Specification',
            // 'Opening Stock',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $this->applyAutoSizing($event, $this->column_count);
                $this->hideColumns($event, ['B']);
                $this->applyDropdownValidation($event, 'E', ['A', 'B','C']);
                $this->applyDropdownValidation($event, 'F', $this->units);
            },
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }

    private function hideColumns($event, $columns)
    {
        foreach ($columns as $column) {
            $event->sheet->getDelegate()->getColumnDimension($column)->setVisible(false);
        }
    }

    private function applyDropdownValidation($event, $column, $options)
    {
        for ($row = 2; $row <= $this->row_count; $row++) {
            $validation = $event->sheet->getCell("{$column}{$row}")->getDataValidation();
            $validation->setType(DataValidation::TYPE_LIST);
            $validation->setErrorStyle(DataValidation::STYLE_STOP);
            $validation->setAllowBlank(false);
            $validation->setShowDropDown(true);
            $validation->setFormula1(sprintf('"%s"', implode(',', $options)));
        }
    }

    private function applyAutoSizing(AfterSheet $event, $columnCount)
    {
        for ($i = 1; $i <= $columnCount; $i++) {
            $column = Coordinate::stringFromColumnIndex($i);
            $event->sheet->getColumnDimension($column)->setAutoSize(true);
        }
    }

}
