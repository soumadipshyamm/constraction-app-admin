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
    </style>
</head>

<body>
    @foreach ($datas as $key => $value)
        <h1>Daily Progress Report</h1>
        <div class="date">
            Date:{{ $value->date ?? '' }}
        </div>
        <div class="projects">
            <div class="priject"> Projects:{{ $value?->projects?->project_name ?? '' }}</div>
            <div class="subpriject"> Sub-Projects:{{ $value?->subProjects?->name ?? '' }}</div>
            <div class="address"> Address: {{ $value?->projects?->address ?? '' }}</div>
        </div>
        <h3>Activities</h3>
        <table border="1">
            <thead>
                <th>Sr.No</th>
                <th>Activities</th>
                <th>Unit</th>
                <th>Total Qty</th>
                <th>%</th>
                <th>Completion Qty</th>
                <th>%</th>
                <th>Balance Qty</th>
                <th>Contractor</th>
                <th>Remarks</th>
            </thead>
            <tbody>
                @if (isset($value->activities))
                    @foreach ($value->activities as $key => $activity)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $activity->activities->activities ?? 'N/A' }}</td>
                            <td>{{ $activity->qty ?? 'N/A' }}</td>
                            <td>{{ $activity->total_qty ?? 'N/A' }}</td>
                            <td>{{ $activity->remaining_qty ?? 'N/A' }}</td>
                            <td>{{ $activity->completion ?? 'N/A' }}</td>
                            <td>{{ $activity->completion ?? 'N/A' }}</td>
                            <td>{{ $activity->vendors->name ?? 'N/A' }}</td>
                            <td>{{ $activity->remarkes ?? 'N/A' }}</td>
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
                <th>Specification</th>
                <th>Unit</th>
                <th>Quantity</th>
                {{-- <th>Activities</th> --}}
                <th>Contractor</th>
                {{-- <th>Work details </th> --}}
                <th>Rate/Unit</th>
                <th>Remarks</th>
            </thead>
            <tbody>
                @foreach ($value->assets as $key => $asset)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td class="td-line-break">{{ $asset->assets->code ?? '' }}</td>
                        <td>{{ $asset->assets->name ?? '' }}</td>
                        <td class="td-line-break">{{ $asset->assets->specification ?? '' }}</td>
                        <td>{{ $asset->units?->unit ?? '' }}</td>
                        <td>{{ $asset->qty ?? '' }}</td>
                        {{-- <td>{{ $asset->activities->activities ?? '' }}</td> --}}
                        <td>{{ $asset->vendors->name ?? '' }}</td>
                        <td>{{ $asset->rate_per_unit ?? '' }}</td>
                        <td>{{ $asset->remarkes ?? '' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <br><br>
        {{-- **************************************Material*************************************************************** --}}
        <h3>Material</h3>
        <table border="1">
            <thead>
                <th>Sr.No</th>
                <th>Code</th>
                <th>Materials Names</th>
                <th>Specification </th>
                <th>Unit</th>
                {{-- <th>Activities</th> --}}
                <th>Quantity Used</th>
                {{-- <th>Work details</th> --}}
                <th>Remarks</th>
            </thead>
            <tbody>
                {{-- <tr>
                <td class="activity-head" colspan="11"></td>
            </tr> --}}
                @foreach ($value->material as $key => $materialData)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $materialData->materials->code ?? '' }}</td>
                        <td>{{ $materialData->materials->name ?? '' }}</td>
                        <td>{{ $materialData->materials->specification ?? '' }}</td>
                        <td>{{ $materialData->units?->unit ?? '' }}</td>
                        {{-- <td>{{ $materialData->activities->activities ?? '' }}</td> --}}
                        <td>{{ $materialData->qty ?? '' }}</td>
                        <td>{{ $materialData->remarkes ?? '' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <br><br>
        {{-- ********************************************Labour********************************************************* --}}
        <h3>Labour</h3>
        <table border="1">
            <thead>
                <th>Sr.No</th>
                <th>Labour Details</th>
                <th>Labour Contractor</th>
                <th>Unit</th>
                {{-- <th>Activities</th> --}}
                <th>Quantity</th>
                <th>OT Quantity</th>
                <th>Rate/Unit</th>
                <th>Remarks</th>
            </thead>
            <tbody>
                @foreach ($value->labour as $key => $labourData)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $labourData->labours->name ?? '' }}</td>
                        <td>{{ $labourData->vendors->name ?? '' }}</td>
                        <td>{{ $labourData?->units?->unit ?? '' }}</td>
                        {{-- <td>{{ $labourData->activities->activities ?? '' }}</td> --}}
                        <td>{{ $labourData->qty ?? '' }}</td>
                        <td>{{ $labourData->ot_qty ?? '' }}</td>
                        <td>{{ $labourData->rate_per_unit ?? '' }}</td>
                        <td>{{ $labourData->remarkes ?? '' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <br><br>
        {{-- ********************************************Historie********************************************************* --}}
        <h3>Hinderances</h3>
        <table border="1">
            <thead>
                <th>Sr.No</th>
                <th>Concern Team Members</th>
                <th>Date</th>
                <th>Hinderances Details</th>
                <th>Remarks</th>
            </thead>
            <tbody>
                {{-- <tr>
                <td class="activity-head" colspan="7">Historie</td>
            </tr> --}}
                @foreach ($value->historie as $key => $historieData)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $historieData->name ?? '' }}</td>
                        <td>{{ $historieData->date ?? '' }}</td>
                        <td>{{ $historieData->details ?? '' }}</td>
                        <td>{{ $historieData->remarks ?? '' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <br><br>
        {{-- ********************************************Safetie********************************************************* --}}
        <h3>Safetie</h3>
        <table border="1">
            <thead>
                <th>Sr.No</th>
                <th>Team Name</th>
                <th>Date</th>
                <th>Safety Problem Details</th>
                <th>Remarks</th>
            </thead>
            <tbody>
                {{-- <tr>
                <td class="activity-head" colspan="4"></td>
            </tr> --}}
                @foreach ($value->safetie as $key => $safetieData)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $safetieData->name ?? '' }}</td>
                        <td>{{ $safetieData->date ?? '' }}</td>
                        <td>{{ $safetieData->details ?? '' }}</td>
                        <td>{{ $safetieData->remarks ?? '' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div>
            @php
                $url = url('/');
            @endphp
            <h5>Attached Photos :</h5>
            <div>
                <h6>Safety</h6>
                <div>
                    @if (isset($value->safetie))
                        @foreach ($value->safetie as $key => $safetieData)
                            <img src="{{ $url . '/upload/' . $safetieData->img }}" alt="" width="100px"
                                height="100px">
                        @endforeach
                    @endif
                </div>
            </div>
            <div>
                <h6>Hinderances</h6>
                <div>
                    @if (isset($value->historie))
                        @foreach ($value->historie as $key => $historieData)
                            <img src="{{ $url . '/upload/' . $historieData->img }}" alt="" width="100px"
                                height="100px">
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    @endforeach
</body>

</html>
