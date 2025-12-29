<?php

namespace App\Exports\Materials;

use App\Http\Resources\Export\MaterialsExportResources;
use App\Http\Resources\Export\MaterialsOpeningStockExportResources;
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
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MaterialsOpeningStockExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    protected  $selects;
    protected  $row_count;
    protected  $column_count;

    public function __construct()
    {
        $status = Unit::pluck('unit')->toArray();
        $class = ['Class-A', 'Class-B', 'Class-C'];
        // dd($status);
        // $departments = ['Account', 'Admin', 'Ict', 'Sales'];
        //$departments=\ModelName::pluck('name')->toArray();
        $selects = [  //selects should have column_name and options
            // ['columns_name' => 'D', 'options' => $departments],
            ['columns_name' => 'C', 'options' => $class],
            ['columns_name' => 'E', 'options' => $status],
        ];
        $this->selects = $selects;
        $this->row_count = 2; //number of rows that will have the dropdown
        $this->column_count = 5; //number of columns to be auto sized
    }

    public function collection()
    {

        $authConpany = Auth::guard('company')->user()->id;
        $companyId = searchCompanyId($authConpany);

        $materials = Materials::with('units')->where('company_id', $companyId)->get();
        // $materials = Materials::with('units', 'projects', 'stores')->where('company_id', $companyId)->get();
        $collection = MaterialsOpeningStockExportResources::collection($materials);

        return collect($collection);
    }

    public function headings(): array
    {
        return [
            '#',
            'Name',
            'Class',
            'Code',
            'Unit',
            'Specification',
            'Opening Qty'
        ];
    }

    public function registerEvents(): array
    {
        return [
            // handle by a closure.
            AfterSheet::class => function (AfterSheet $event) {
                $row_count = $this->row_count;
                $column_count = $this->column_count;
                foreach ($this->selects as $select) {
                    $drop_column = $select['columns_name'];
                    $options = $select['options'];
                    // set dropdown list for first data row
                    // $validation = $event->sheet->getCell("{$drop_column}2")->getDataValidation();
                    // $validation->setType(DataValidation::TYPE_LIST);
                    // $validation->setErrorStyle(DataValidation::STYLE_INFORMATION);
                    // $validation->setAllowBlank(false);
                    // $validation->setShowInputMessage(true);
                    // $validation->setShowErrorMessage(true);
                    // $validation->setShowDropDown(true);
                    // $validation->setErrorTitle('Input error');
                    // $validation->setError('Value is not in list.');
                    // $validation->setPromptTitle('Pick from list');
                    // $validation->setPrompt('Please pick a value from the drop-down list.');
                    // $validation->setFormula1(sprintf('"%s"', implode(',', $options)));

                    // // clone validation to remaining rows
                    // for ($i = 3; $i <= $row_count; $i++) {
                    //     $event->sheet->getCell("{$drop_column}{$i}")->setDataValidation(clone $validation);
                    // }
                    // set columns to autosize
                    for ($i = 1; $i <= $column_count; $i++) {
                        $column = Coordinate::stringFromColumnIndex($i);
                        $event->sheet->getColumnDimension($column)->setAutoSize(true);
                    }
                }
            },
        ];
    }


    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true], 'freeze' => true],
        ];
    }
}
