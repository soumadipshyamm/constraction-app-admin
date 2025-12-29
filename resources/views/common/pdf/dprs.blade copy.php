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

        .projects {
            width: 100%;
            height: 50px;
            margin: 1px;
            padding-top: 10px;
        }

        .priject {
            width: 50%;
            float: left;
        }

        .subpriject {
            width: 50%;
            float: left;
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
    {{-- @dd($datas) --}}

    @foreach ($datas as $key => $value)
        {{-- @dd($value) --}}
        <h1>Daily Progress Report</h1>
        <div class="date">
            Date:{{ $value->date ?? '' }}
        </div>
        <div class="projects">
            <div class="priject"> Projects:{{ $value->projects->project_name ?? '' }}</div>
            <div class="subpriject"> Sub-Projects:{{ $value->subProjects->name ?? '' }}</div>
            <div class="address"> Address: {{ $value?->projects?->address ?? '' }}</div>

        </div>
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
                @if (isset($value->activities))
                    @foreach ($value->activities as $key => $activity)
                        @php
                            $asdfgh = totalActivitiesUsage($activity?->activities_id);
                        @endphp
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $activity?->activities?->activities ?? ' ' }}</td>
                            <td>{{ $activity?->activities?->units->unit ?? ' ' }}</td>
                            <td>{{ $activity?->qty ?? ' ' }}</td>
                            {{-- <td>{{ number_format(($activity?->qty / $asdfgh['originalQty']) * 100, 2) ?? ' ' }}</td> --}}
                            <td>
                                {{ $asdfgh['originalQty'] != 0 ? number_format(($activity?->qty / $asdfgh['originalQty']) * 100, 2) : ' ' }}
                            </td>
                            <td>{{ $asdfgh['originalQty'] - $asdfgh['remainingQty'] ?? ' ' }}</td>
                            <td>{{ $asdfgh['originalQty'] ?? ' ' }}</td>
                            <td>{{ $asdfgh['remainingQty'] ?? ' ' }}</td>
                            <td>{{ $activity?->vendors?->name ?? ' ' }}</td>
                            <td class="td-line-break">{{ $activity?->remarkes ?? ' ' }}</td>
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
                            <td class="td-line-break">{{ $asset->assets->code ?? ' ' }}</td>
                            <td>{{ $asset->assets->name ?? ' ' }}</td>
                            <td>{{ $asset->assets->units->unit ?? ' ' }}</td>
                            <td class="td-line-break">{{ $asset->assets->specification ?? ' ' }}</td>
                            <td>{{ $asset->qty ?? ' ' }}</td>
                            <td>{{ $asset->vendors->name ?? ' ' }}</td>
                            <td>{{ $asset->activities->activities ?? ' ' }}</td>
                            <td>{{ $asset->rate_per_unit ?? ' ' }}</td>
                            <td class="td-line-break">{{ $asset->remarkes ?? ' ' }}</td>
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
                            <td class="td-line-break">{{ $materialData?->materials?->code ?? ' ' }}</td>
                            <td>{{ $materialData?->materials?->name ?? ' ' }}</td>
                            <td>{{ $materialData?->materials?->units?->unit ?? ' ' }}</td>
                            <td class="td-line-break">
                                {{ $materialData?->materials?->specification !== null ? $materialData?->materials?->specification : ' ' }}
                            </td>
                            <td>{{ $materialData?->qty ?? ' ' }}</td>
                            <td>{{ $materialData?->materials?->vendors?->name ?? ' ' }}</td>
                            <td>{{ $materialData?->activities?->activities ?? ' ' }}</td>
                            <td>{{ $materialData?->rate_per_unit ?? ' ' }}</td>
                            <td class="td-line-break">{{ $materialData?->remarkes ?? ' ' }}</td>
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
                            <td class="td-line-break">{{ $labourData->labours->gst_no ?? ' ' }}</td>
                            <td>{{ $labourData->labours->name ?? ' ' }}</td>
                            <td>{{ $labourData->labours->units->unit ?? ' ' }}</td>
                            <td>{{ $labourData->qty ?? ' ' }}</td>
                            <td>{{ $labourData->ot_qty ?? ' ' }}</td>
                            <td>{{ $labourData->vendors->name ?? ' ' }}</td>
                            <td>{{ $labourData->activities->activities ?? ' ' }}</td>
                            <td>{{ $labourData->rate_per_unit ?? ' ' }}</td>
                            <td class="td-line-break">{{ $labourData->remarkes ?? ' ' }}</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
        <br><br>
        {{-- ********************************************Historie********************************************************* --}}
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
                @if (isset($value->historie))
                    @foreach ($value->historie as $key => $historieData)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $historieData->remarks ?? ' ' }}</td>
                            <td>{{ $historieData->date ?? ' ' }}</td>
                            <td>{{ $historieData->details ?? ' ' }}</td>
                            <td>{{ $historieData?->companyUsers?->name ?? ' ' }}</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
        <br><br>
        {{-- ********************************************Safetie********************************************************* --}}
        <h3>safety</h3>
        <table border="1">
            <thead>
                <th>Sr.No</th>
                <th>Remarks</th>
                <th>Date</th>
                <th>Safety Problem Details</th>
                <th>Team Members</th>
                {{-- <th>Remarks</th> --}}
            </thead>
            <tbody>
                @if (isset($value->safetie))
                    @foreach ($value->safetie as $key => $safetieData)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $safetieData->remarks ?? ' ' }}</td>
                            <td>{{ $safetieData->date ?? ' ' }}</td>
                            <td>{{ $safetieData->name ?? ' ' }}</td>
                            <td>{{ $safetieData?->companyUsers?->name ?? ' ' }}</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    @endforeach
    <br><br>
    {{-- ********************************************Safetie********************************************************* --}}
    @php
        $url = url('/');
    @endphp
    <h3>safety</h3>
    @if (isset($value->safetie))
        @foreach ($value->safetie as $key => $safetieData)
            <img src="{{ $url . '/upload/' . $safetieData->img }}" alt="" width="200px" height="200px">
        @endforeach
    @endif
    <br><br>
    <h3>Hinderances</h3>
    @if (isset($value->historie))
        @foreach ($value->historie as $key => $historieData)
            <img src="{{ $url . '/upload/' . $historieData->img }}" alt="" width="200px" height="200px">
        @endforeach
    @endif
    <br><br>
    <h3>Activities</h3>
    @if (isset($value->historie))
        @foreach ($value->activities as $key => $activity)
            <img src="{{ $url . '/upload/' . $activity->img }}" alt="" width="200px" height="200px">
        @endforeach
    @endif
</body>

</html>
