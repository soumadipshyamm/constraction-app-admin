<!-- resources/views/pdf/sample.blade.php -->
<!DOCTYPE html>
<html>

<head>
    {{-- <title>{{ $title }}</title> --}}
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        h1 {
            text-align: center;
        }

        .activity-head {
            text-align: center;
        }

        .date {
            text-align: right;
            margin-bottom: 10px;
        }

        .projects {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .projects div {
            width: 30%;
        }


        table {
            width: 100%
        }

        .td-line-break {
            max-width: 40px;
            word-wrap: break-word;
        }
    </style>
</head>

<body>
    @php
        $url = url('/') . '/upload/';
    @endphp
    {{-- @dd($datas[0]->projects?->project_name); --}}

    <h1>Daily Progress Report</h1>
    <div class="date">
        Date:{{ $datas[0]->date ?? '' }}
    </div>
    <div class="projects">
        <div class="project"> Projects:{{ $datas[0]?->projects?->project_name ?? '' }}</div>
        @if ($datas[0]?->subProjects?->name)
            <div class="subpriject"> Sub-Projects:{{ $datas[0]?->subProjects?->name ?? '' }}</div>
        @endif
        <div class="address"> Address:{{ $datas[0]?->projects?->address ?? '' }}</div>
    </div>

    @foreach ($datas as $key => $value)
        {{-- @dd($value) --}}

        <h3>Activities</h3>
        <table border="1">
            <thead>
                <th>Sr.No</th>
                <th>Work Details</th>
                <th>Unit</th>
                <th>Qty</th>
                <th>Completion %</th>
                <th>Cumm Qty</th>
                <th>Total Qty</th>
                <th>Remaining Qty</th>
                <th>Contractor</th>
                <th>Remarks</th>
            </thead>
            <tbody>
                @if (isset($data['activities']))
                    @foreach ($data['activities'] as $key => $activity)
                        @php
                            $usage = totalActivitiesUsage($activity['activities_id']) ?? [
                                'originalQty' => 0,
                                'remainingQty' => 0,
                            ];
                            $percent =
                                $usage['originalQty'] != 0
                                    ? number_format(($activity['qty'] / $usage['originalQty']) * 100, 2)
                                    : '---';
                            $cummQty = abs($usage['originalQty'] - $usage['remainingQty']);
                        @endphp
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $activity['activities']['activities'] ?? '---' }}</td>
                            <td>{{ $activity['activities']['units']['unit'] ?? '---' }}</td>
                            <td>{{ $activity['qty'] ?? '---' }}</td>
                            <td>{{ $percent }}</td>
                            <td>{{ $cummQty }}</td>
                            <td>{{ $usage['originalQty'] ?? '---' }}</td>
                            <td>{{ $usage['remainingQty'] ?? '---' }}</td>
                            <td>{{ $activity['vendors']['name'] ?? '---' }}</td>
                            <td class="td-line-break">{{ $activity['remarkes'] ?? '---' }}</td>
                        </tr>
                    @endforeach
                @endif


            </tbody>
        </table>
        <br><br>
        {{-- *************************************Assets**************************************************************** --}}
        <h3>Assets</h3>
        <table border="1">
            <thead>
                <th>Sr.No</th>
                <th>Code</th>
                <th>Machinery Names </th>
                <th>Unit</th>
                <th>Specification</th>
                <th>Quantity</th>
                <th>Contractor</th>
                <th>Work details </th>
                <th>Rate/Unit</th>
                <th>Remarks</th>
            </thead>
            <tbody>
                @if (isset($value->assets))
                    @foreach ($value->assets as $key => $asset)
                        {{-- @dd($asset->assets) --}}
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td class="td-line-break">{{ $asset->assets->code ?? '---' }}</td>
                            <td>{{ $asset->assets->name ?? '---' }}</td>
                            <td>{{ $asset->assets->units->unit ?? '---' }}</td>
                            <td class="td-line-break">{{ $asset->assets->specification ?? '---' }}</td>
                            <td>{{ $asset->qty ?? '---' }}</td>
                            <td>{{ $asset->vendors->name ?? '---' }}</td>
                            <td>{{ $asset->activities->activities ?? '---' }}</td>
                            <td>{{ $asset->rate_per_unit ?? '---' }}</td>
                            <td class="td-line-break">{{ $asset->remarkes != null ? $asset->remarkes : '---' }}</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
        <br><br>
        {{-- **************************************Material*************************************************************** --}}
        <h3>Material</h3>
        <table border="1">
            <thead>
                <th>Sr.No</th>
                <th>Code</th>
                <th>Materials Names </th>
                <th>Unit</th>
                <th>Specification</th>
                <th>Quantity</th>
                <th>Work details </th>
                <th>Contractor</th>
                <th>Rate/Unit</th>
                <th>Remarks</th>
            </thead>
            <tbody>
                @if (isset($value->material))
                    @foreach ($value->material as $key => $materialData)
                        {{-- @dd($materialData->materials) --}}
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td class="td-line-break">{{ $materialData->materials->code ?? '---' }}</td>
                            <td>{{ $materialData->materials->name != null ? $materialData->materials->name : '---' }}
                            </td>
                            <td>{{ $materialData->materials->units->unit != null ? $materialData->materials->units->unit : '---' }}
                            </td>
                            <td class="td-line-break">
                                {{ $materialData->materials->specification != null ? $materialData->materials->specification : '---' }}
                            </td>
                            <td>{{ $materialData->qty ?? '---' }}</td>
                            <td>{{ $materialData->materials?->vendors?->name != null ? $materialData->materials?->vendors?->name : '---' }}
                            </td>
                            <td>{{ $materialData?->activities?->activities != null ? $materialData?->activities?->activities : '---' }}
                            </td>
                            <td>{{ $materialData->rate_per_unit ?? '---' }}</td>
                            <td class="td-line-break">
                                {{ $materialData->remarkes != null ? $materialData?->remarkes : '---' }}</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
        <br><br>
        {{-- ********************************************Labour********************************************************* --}}
        <h3>Labour</h3>
        <table border="1">
            <thead>
                <th>Sr.No</th>
                <th>Code</th>
                <th>Labour Details</th>
                <th>Unit</th>
                <th>Quantity</th>
                <th>OT Quantity</th>
                <th>Labour Contractor</th>
                <th>Work details </th>
                <th>Rate/Unit</th>
                <th>Remarks</th>
            </thead>
            <tbody>
                @if (isset($value->labour))
                    @foreach ($value->labour as $key => $labourData)
                        {{-- @dd($labourData) --}}
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td class="td-line-break">{{ $labourData->labours->gst_no ?? '---' }}</td>
                            <td>{{ $labourData->labours->name != null ? $labourData->labours->name : '---' }}</td>
                            <td>{{ $labourData->labours->units->unit != null ? $labourData->labours->units->unit : '---' }}
                            </td>
                            <td>{{ $labourData->qty ?? '---' }}</td>
                            <td>{{ $labourData->ot_qty != null ? $labourData->ot_qty : '---' }}</td>
                            <td>{{ $labourData->vendors?->name != null ? $labourData->vendors?->name : '---' }}</td>
                            <td>{{ $labourData->activities?->activities != null ? $labourData->activities?->activities : '---' }}
                            </td>
                            <td>{{ $labourData?->rate_per_unit != null ? $labourData?->rate_per_unit : '---' }}</td>
                            <td class="td-line-break">
                                {{ $labourData?->remarkes != null ? $labourData?->remarkes : '---' }}</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
        <br><br>
        {{-- ********************************************Hinderances********************************************************* --}}
        <h3>Hinderances</h3>
        <table border="1">
            <thead>
                <th>Sr.No</th>
                <th>Remarks</th>
                <th>Date</th>
                <th>Hinderances Details</th>
                <th>Team Members</th>
            </thead>
            <tbody>
                {{-- @dd($value->historie) --}}
                @if (isset($value->historie) && count($value->historie) > 0)
                    @foreach ($value->historie as $key => $historieData)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $historieData->remarks != null ? $historieData?->remarks : '---' }}</td>
                            <td>{{ $historieData->date != null ? $historieData->date : '---' }}</td>
                            <td>{{ $historieData->details != null ? $historieData?->details : '---' }}</td>
                            <td>{{ $historieData?->companyUsers?->name != null ? $historieData?->companyUsers?->name : '---' }}
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
        <br><br>
        {{-- ********************************************Safety********************************************************* --}}
        <h3>Safety</h3>
        <table border="1">
            <thead>
                <th>Sr.No</th>
                <th>Remarks</th>
                <th>Date</th>
                <th>Safety Problem Details</th>
                <th>Team Members</th>
            </thead>
            <tbody>
                @if (isset($value->safetie) && count($value->safetie) > 0)
                    @foreach ($value->safetie as $key => $safetieData)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $safetieData->remarks != null ? $safetieData?->remarks : '---' }}</td>
                            <td>{{ $safetieData->date != null ? $safetieData?->date : '---' }}</td>
                            <td>{{ $safetieData->name != null ? $safetieData?->name : '---' }}</td>
                            <td>{{ $safetieData?->companyUsers?->name != null ? $safetieData?->companyUsers?->name : '---' }}
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
        {{-- @endforeach --}}
        <br><br>
        {{-- ********************************************Images********************************************** --}}
        @if (isset($value->activities) && count($value->activities) > 0)
            <h3>Activities Images</h3>
            @foreach ($value->activities as $activity)
                @php
                    $imagePath = $url . $activity?->img;
                @endphp
                <img src={{ $imagePath }} alt="Activity Image" style="max-width: 80%; height: 50%;">
            @endforeach
            <br><br>
        @endif

        @if (isset($value->safetie) && count($value->safetie) > 0)
            <h3>Safety Images</h3>
            @foreach ($value->safetie as $safetieData)
                @php
                    $imagePath = $url . $safetieData?->img;
                @endphp
                <img src={{ $imagePath }} alt="Activity Image" style="max-width: 80%; height: 50%;">
            @endforeach
            <br><br>
        @endif

        @if (isset($value->historie) && count($value->historie) > 0)
            <h3>Hinderances Images</h3>
            @foreach ($value->historie as $historieData)
                @php
                    $imagePath = $url . $historieData?->img;
                @endphp
                <img src={{ $imagePath }} alt="Activity Image" style="max-width: 80%; height: 50%;">
            @endforeach
            <br><br>
        @endif
    @endforeach
    {{-- @dd('lkijuhygt') --}}
</body>

</html>
