<?php

namespace App\Exports\Activites;

use App\Http\Resources\ActivitesResource;
use App\Models\Company\Activities;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class DemoActivitesExport implements FromCollection, ShouldAutoSize
{
    public function collection()
    {
        $authConpany = Auth::guard('company')->user()->id;
        $companyId = searchCompanyId($authConpany);

        return collect([
            [
                '#',
                'type',
                'sl_no',
                'activities',
                'unit_id',
                'qty',
                'rate',
                'amount',
                'start_date',
                'end_date',
            ],
            [
                '123',
                'heading',
                '1',
                'activites',
                '',
                '',
                '',
                '',
                '',
                ''
            ],
            [
                '124',
                'subheading',
                '1.1',
                'sub activites',
                '',
                '',
                '',
                '',
                '',
                ''
            ],
            [
                '125',
                'activites',
                '1.1.1',
                'Sub Activites 1.1',
                '12',
                '3',
                '4',
                '12',
                '2023-09-13',
                '2023-09-29'
            ]
        ]);
    }
}