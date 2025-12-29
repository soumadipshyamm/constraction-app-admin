<?php

namespace App\Exports\Activites;

use App\Models\Company\Assets;
use App\Models\Company\Activities;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Events\AfterSheet;
use App\Http\Resources\Export\ActivitesExportResources;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;


class ActivitesExportc implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    protected $projects;       // Selected project ID
    protected $subprojects;    // Selected subproject ID
    protected $units;          // Dropdown options for units
    protected $rowCount;       // Number of rows to apply formatting rules

    public function __construct($projects, $subprojects)
    {
        $this->projects = $projects;           // Assign selected project
        $this->subprojects = $subprojects;     // Assign selected subproject
        $this->units = getUnit();              // Fetch unit options dynamically
        $this->rowCount = 100;                 // Set maximum rows for the sheet
    }

    /**
     * Collect the data to be exported.
     */
    public function collection()
    {
        $authCompanyId = Auth::guard('company')->user()->id; // Get authenticated company user
        $companyId = searchCompanyId($authCompanyId);        // Search for the actual company ID

        $activities = Activities::with('units', 'project', 'subproject') // Fetch related models
            ->where('company_id', $companyId);

        // Filter by project if selected
        if (!empty($this->projects)) {
            $activities->where('project_id', $this->projects);

            // Further filter by subproject if selected
            if (!empty($this->subprojects)) {
                $activities->where('subproject_id', $this->subprojects);
            }
        }
        // dd($activities->get()->toArray());
        // Fetch the activities and add serial numbers (#) to the data
        $data = ActivitesExportResources::collection($activities->get());
        return collect($data->map(function ($item, $index) {
            $item['#'] = $index + 1; // Add serial number starting from 1
            return $item;
        }));
    }

    /**
     * Define the column headings for the export.
     */
    public function headings(): array
    {
        return [
            '#',          // A - Serial number
            'UUID',       // B - Hidden
            'Project',    // C - Hidden
            'Subproject', // D - Hidden
            'Type',       // E
            'SL No',      // F
            'Activities', // G
            'Units',      // H
            'Qty',        // I
            'Rate',       // J
            'Amount',     // K
            'Start Date(dd-mm-yyyy)', // L
            'End Date(dd-mm-yyyy)',   // M
            'Unit uuid',   // N-Hidden
        ];
    }

    /**
     * Register events for formatting and applying rules to the sheet.
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Hide columns B, C, and D
                $this->hideColumns($event, ['B', 'C', 'D', 'N']);

                // Apply dropdown validation for "Type" (E) and "Units" (H)
                $this->applyDropdownValidation($event, 'E', ['heading', 'activities']);
                $this->applyDropdownValidation($event, 'H', $this->units);

                // Apply formula for Amount (K = I * J)
                $this->applyCalculationFormula($event, 'K', 'I', 'J');

                // Apply date format for Start Date (L) and End Date (M)
                $this->applyDateFormat($event, 'L');
                $this->applyDateFormat($event, 'M');

                // Apply auto-sizing for all columns
                $this->autoSizeColumns($event, 13); // Total 13 columns
            },
        ];
    }

    /**
     * Hide specified columns.
     */
    private function hideColumns($event, $columns)
    {
        foreach ($columns as $column) {
            $event->sheet->getDelegate()->getColumnDimension($column)->setVisible(false);
        }
    }

    /**
     * Apply dropdown validation to a column.
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
     * Apply calculation formula (e.g., K = I * J) to a column.
     */
    private function applyCalculationFormula($event, $resultColumn, $qtyColumn, $rateColumn)
    {
        for ($row = 2; $row <= $this->rowCount; $row++) {
            $qtyCell = "{$qtyColumn}{$row}";
            $rateCell = "{$rateColumn}{$row}";
            $resultCell = "{$resultColumn}{$row}";

            // Set the formula for the cell
            $event->sheet->getDelegate()
                ->setCellValue($resultCell, "={$qtyCell}*{$rateCell}");
        }
    }

    /**
     * Apply date format to a column.
     */
    private function applyDateFormat($event, $column)
    {
        for ($row = 2; $row <= $this->rowCount; $row++) {
            $cell = "{$column}{$row}";
            $event->sheet->getDelegate()->getStyle($cell)->getNumberFormat()
                ->setFormatCode('dd-mm-yyyy');
        }
    }

    /**
     * Auto-size all columns up to the given column count.
     */
    private function autoSizeColumns($event, $columnCount)
    {
        for ($i = 1; $i <= $columnCount; $i++) {
            $column = Coordinate::stringFromColumnIndex($i);
            $event->sheet->getColumnDimension($column)->setAutoSize(true);
        }
    }
}
