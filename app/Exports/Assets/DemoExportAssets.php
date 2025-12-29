<?php

namespace App\Exports\Assets;

use App\Models\Company\Assets;
use App\Models\Company\OpeningStock;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\AssetsResource;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use App\Http\Resources\OpeningStockResource;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;

class DemoExportAssets implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    protected  $selects;
    protected  $row_count;
    protected  $column_count;

    public function __construct()
    {
        $status = getUnit();
        // dd($status);
        // $departments = ['Account', 'Admin', 'Ict', 'Sales'];
        //$departments=\ModelName::pluck('name')->toArray();
        $selects = [  //selects should have column_name and options
            // ['columns_name' => 'D', 'options' => $departments],
            ['columns_name' => 'F', 'options' => $status],
        ];
        $this->selects = $selects;
        $this->row_count = 2; //number of rows that will have the dropdown
        $this->column_count = 5; //number of columns to be auto sized
    }
    public function collection()
    {
        $authConpany = Auth::guard('company')->user()->id;
        $companyId = searchCompanyId($authConpany);

        $labours = Assets::with('units', 'project', 'store_warehouses')->where('company_id', $companyId)->take(2)->get();
        $collection = AssetsResource::collection($labours);
        return collect($collection);
    }
    public function headings(): array
    {
        return [
            '#',
            'Code',
            'Asset/Equipments/Machinery',
            'Specification',
            'Unit',
            // 'Opening Qty',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $startRow = 2; // Specify the starting row (e.g., skip the header).

                $row_count = $this->row_count;
                $column_count = $this->column_count;

                foreach ($this->selects as $select) {
                    $drop_column = $select['columns_name'];
                    $options = $select['options'];

                    // Set dropdown list for the first data row.
                    $validation = $event->sheet->getCell("{$drop_column}2")->getDataValidation();
                    $this->configureDataValidation($validation, $options);

                    // Clone validation to remaining rows.
                    for ($i = 3; $i <= $row_count; $i++) {
                        $event->sheet->getCell("{$drop_column}{$i}")->setDataValidation(clone $validation);
                    }
                }

                // Set columns to autosize.
                for ($i = 1; $i <= $column_count; $i++) {
                    $column = Coordinate::stringFromColumnIndex($i);
                    $event->sheet->getColumnDimension($column)->setAutoSize(true);
                }

                // Apply text wrapping to a specific column (e.g., column F).
                $this->applyTextWrapping($event, 'H', $startRow);
            },
        ];
    }

    private function configureDataValidation($validation, $options)
    {
        $validation->setType(DataValidation::TYPE_LIST);
        $validation->setErrorStyle(DataValidation::STYLE_INFORMATION);
        $validation->setAllowBlank(false);
        $validation->setShowInputMessage(true);
        $validation->setShowErrorMessage(true);
        $validation->setShowDropDown(true);
        $validation->setErrorTitle('Input error');
        $validation->setError('Value is not in the list.');
        $validation->setPromptTitle('Pick from list');
        $validation->setPrompt('Please pick a value from the drop-down list.');
        $validation->setFormula1(sprintf('"%s"', implode(',', $options)));
    }

    private function applyTextWrapping($event, $column, $startRow, $endRow = null)
    {
        $endRow = $endRow ?? $event->sheet->getDelegate()->getHighestRow();

        $event->sheet->getDelegate()->getColumnDimension('H')->setWidth(50);
        for ($row = $startRow; $row <= $endRow; $row++) {
            $cell = $column . $row;
            $event->sheet->getDelegate()->getStyle($cell)->getAlignment()->setWrapText(true);
        }
    }
}
