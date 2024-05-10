<?php

namespace App\Exports\Activites;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class ActivitesImportFailExport implements FromCollection, WithHeadings
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return collect([$this->data]);
    }

    public function headings(): array
    {
        return [
            "#",
            "type",
            "sl_no",
            "activities",
            "unit_id",
            "qty",
            "rate",
            "amount",
            "start_date",
            "end_date",
        ];
    }
}
