<?php

namespace App\Exports\Assets;

use App\Models\Company\Unit;
use App\Models\Company\Assets;
use App\Models\Company\OpeningStock;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\AssetsResource;
use App\Http\Resources\Export\AssetesExportResources;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use App\Http\Resources\OpeningStockResource;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use Maatwebsite\Excel\Concerns\WithMapping; // Add this for row mapping


class ExportAssets implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    protected $units;
    protected $rowCount;

    public function __construct()
    {
        $this->units = getUnit(); // Fetch available units dynamically
        $this->rowCount = 100;   // Apply dropdown for 100 rows or dynamically based on collection size
    }

    /**
     * Fetch the data collection to be exported.
     */
    public function collection()
    {
        $authCompany = Auth::guard('company')->user()->id;
        $companyId = searchCompanyId($authCompany);

        // Fetch data and pass it through the resource
        $assets = Assets::with('units', 'project', 'store_warehouses')
            ->where('company_id', $companyId)
            ->get();

        return AssetesExportResources::collection($assets); // Use resource to transform data
    }

    /**
     * Return the headings for the exported file.
     */
    public function headings(): array
    {
        return [
            '#',                    // A - Serial Number
            'UUID',                 // B - Hidden column
            'ID',                   // C - Hidden column
            'Code',                 // D
            'Asset/Equipments/Machinery', // E
            'Unit',                 // F - Dropdown
            'Specification',        // G
        ];
    }


    // public function map($row): array
    // {
    //     static $serialNumber = 0; // Initialize serial number
    //     $serialNumber++;          // Increment for each row

    //     return [
    //         $serialNumber,               // Column A: Serial Number
    //         $row['uuid'],                // Column B: UUID
    //         $row['id'],                  // Column C: ID (Hidden)
    //         $row['code'],                // Column D: Code
    //         $row['name'],                // Column E: Asset/Equipments Name
    //         $row['unit'] ?? '',       // Column F: Unit Name or 'N/A'
    //         $row['specification'],       // Column G: Specification
    //     ];
    // }
    /**
     * Register the events to manipulate the spreadsheet after it's created.
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Apply dropdown validation to column F for 'Unit'
                $this->applyDropdownValidation($event, 'F', $this->units, $this->rowCount);

                // Hide the UUID column (B)
                $sheet->getColumnDimension('B')->setVisible(false);

                // Hide the ID column (C)
                $sheet->getColumnDimension('C')->setVisible(false);
            },
        ];
    }

    /**
     * Apply dropdown validation to a specific column and range.
     */
    private function applyDropdownValidation($event, $column, $options, $rowCount)
    {
        $sheet = $event->sheet->getDelegate();
        for ($row = 2; $row <= $rowCount + 1; $row++) {
            $cell = "{$column}{$row}"; // Target column for dropdown
            $validation = $sheet->getCell($cell)->getDataValidation();

            // Configure validation for the dropdown
            $validation->setType(DataValidation::TYPE_LIST);
            $validation->setErrorStyle(DataValidation::STYLE_STOP);
            $validation->setAllowBlank(false);
            $validation->setShowDropDown(true);
            $validation->setFormula1(sprintf('"%s"', implode(',', $options)));
        }
    }


}
