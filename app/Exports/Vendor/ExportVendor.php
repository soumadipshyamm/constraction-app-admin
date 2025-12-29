<?php

namespace App\Exports\Vendor;

use App\Http\Resources\VendorResource;
use Maatwebsite\Excel\Concerns\FromCollection;
use App\Http\Resources\LaboursResource;
use App\Models\Company\Labour;
use App\Models\Company\Vendor;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use Maatwebsite\Excel\Concerns\WithStyles;



class ExportVendor implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents, WithStyles
{

    public function collection()
    {
        $authCompany = Auth::guard('company')->user()->id;
        $companyId = searchCompanyId($authCompany);

        $vendors = Vendor::where('company_id', $companyId)->get();

        return collect(VendorResource::collection($vendors)->resolve());

        // $resolved = VendorResource::collection($vendors)->resolve();

        // Add SlNo (1, 2, 3, ...) at the beginning of each item
        // $collection = collect($resolved)->map(function ($item, $index) {
        //     return array_values(array_merge(['SlNo' => $index + 1], $item));
        // });

        // return $collection;
    }

    public function headings(): array
    {
        return [
            'SlNo',
            'Uuid', // Hidden column
            'Name',
            'Type',
            'Gst No',
            'Address',
            'Contact Person Name',
            'Country Code',
            'Contact Person Phone',
            'Contact Person Email',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                // $lastRow = $sheet->getHighestRow();

                // Hide UUID column (Column B)
                $sheet->getColumnDimension('B')->setVisible(false);
                $sheet->getColumnDimension('H')->setVisible(false);
                $this->applyDropdownValidation($event, 'D',['supplier', 'contractor', 'both']);

                // Freeze header row
                $sheet->freezePane('A2');

                // Style the header row
                $sheet->getStyle('A1:I1')->applyFromArray([
                    'font' => ['bold' => true],
                    'alignment' => ['horizontal' => 'center'],
                ]);
            },
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }

    private function applyDropdownValidation($event, $column,$options)
    {
        for ($row = 2; $row <= 100; $row++) {
            $validation = $event->sheet->getCell("{$column}{$row}")->getDataValidation();
            $validation->setType(DataValidation::TYPE_LIST);
            $validation->setErrorStyle(DataValidation::STYLE_STOP);
            $validation->setAllowBlank(false);
            $validation->setShowDropDown(true);
            $validation->setFormula1(sprintf('"%s"', implode(',', $options)));
        }
    }

}

