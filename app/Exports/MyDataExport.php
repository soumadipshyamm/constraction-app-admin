<?php

namespace App\Exports;

use App\Http\Resources\Export\LabourExportResources;
use App\Http\Resources\LaboursResource;
use App\Models\Company\Labour;
use App\Models\Company\Unit;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
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



class MyDataExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    protected $units;          // Dropdown options for units
    protected $rowCount;       // Number of rows to apply formatting rules

    /**
     * Constructor: Fetch necessary data and set row count.
     */
    public function __construct()
    {
        $this->units = getUnit();  // Fetch unit options dynamically
        $this->rowCount = 100;                   // Maximum rows to format
    }

    /**
     * Collection of data to export.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // Fetch authenticated company ID
        $authCompany = Auth::guard('company')->user()->id;
        $companyId = searchCompanyId($authCompany);

        // Fetch labours for the company with the associated unit
        $labours = Labour::with('units')  // Eager load the 'unit' relationship
            ->where('company_id', $companyId)
            ->limit($this->rowCount)
            ->get();

        // Transform the data using the LabourExportResources
        return LabourExportResources::collection($labours)->map(function ($labour, $index) {
            return [
                '#'        => $index + 1,
                'Uuid'     => $labour->uuid,
                'Code'     => $labour->code,  // Assuming 'code' exists in the resource
                'Name'     => $labour->name,
                'Category' =>  $labour->category,              // Placeholder for dropdown
                'Unit'     => $labour->units ? $labour->units->unit : '',  // Get the unit name using the relationship
            ];
        });
    }

    /**
     * Headings for the Excel export.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            '#',
            'Uuid',
            'Code',
            'Name',
            'Category',
            'Unit',
        ];
    }

    /**
     * Register sheet events for advanced formatting (dropdowns, hiding columns, etc).
     *
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Hide Column B (Uuid) for cleaner display
                $sheet->getColumnDimension('B')->setVisible(false);

                // Apply dropdown for Category (Column D)
                $this->applyDropdownValidation($event, 'E', ['unskilled', 'semiskilled', 'skilled']);

                // Apply dynamic dropdown for Unit (Column E)
                $this->applyDropdownValidation($event, 'F', $this->units);

                // Auto-size columns from 1 to 13 (or desired range)
                $this->autoSizeColumns($event, 13);  // Assumed 13 columns are present
            },
        ];
    }

    /**
     * Apply dropdown validation to a column (Category, Unit, etc.).
     *
     * @param  \Maatwebsite\Excel\Events\AfterSheet $event
     * @param  string $column
     * @param  array $options
     * @return void
     */
    private function applyDropdownValidation($event, $column, $options)
    {
        for ($row = 2; $row <= $this->rowCount; $row++) {
            $validation = $event->sheet->getCell("{$column}{$row}")->getDataValidation();
            $validation->setType(DataValidation::TYPE_LIST);
            $validation->setErrorStyle(DataValidation::STYLE_STOP);
            $validation->setAllowBlank(false);
            $validation->setShowDropDown(true);
            $validation->setFormula1(sprintf('"%s"', implode(',', $options)));
        }
    }

    /**
     * Auto-size columns dynamically.
     *
     * @param  \Maatwebsite\Excel\Events\AfterSheet $event
     * @param  int $columnCount
     * @return void
     */
    private function autoSizeColumns($event, $columnCount)
    {
        for ($i = 1; $i <= $columnCount; $i++) {
            $column = Coordinate::stringFromColumnIndex($i);
            $event->sheet->getColumnDimension($column)->setAutoSize(true);
        }
    }

    /**
     * Fetch dynamic unit options (can be customized as per your needs).
     *
     * @return array
     */

}
