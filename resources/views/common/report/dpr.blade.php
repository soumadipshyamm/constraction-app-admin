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
            <div class="priject"> Projects:{{ $value->projects->project_name ?? '' }}</div>
            <div class="subpriject"> Sub-Projects:{{ $value->subProjects->name ?? '' }}</div>
        </div>
        <h3>Activities</h3>
        <table border="1">
            <thead>
                <th>Sr.No</th>
                <th>Work Details</th>
                <th>Unit</th>
                <th>Qty</th>
                <th>%</th>
                <th>Qty</th>
                <th>%</th>
                <th>Balance Qty</th>
                <th>Contractor</th>
                <th>Remarks</th>
            </thead>
            <tbody>

                @foreach ($value->activities as $key => $activity)
                    <tr>
                        <td>{{ $activity->activities->activities ?? '' }}</td>
                        <td>{{ $activity->qty ?? '' }}</td>
                        <td>{{ $activity->total_qty ?? '' }}</td>
                        <td>{{ $activity->remaining_qty ?? '' }}</td>
                        <td>{{ $activity->completion ?? '' }}</td>
                        <td>{{ $activity->vendors->name ?? '' }}</td>
                        <td>{{ $activity->remarkes ?? '' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <br><br>
        {{-- *************************************Assets**************************************************************** --}}
        <h3>Assets</h3>
        <table border="1">
            <thead>
                <th>Code</th>
                <th>Machinery Names </th>
                <th>Specification</th>
                <th>Unit</th>
                <th>Quantity</th>
                <th>Contractor</th>
                <th>Work details </th>
                <th>Rate/Unit</th>
                <th>Remarks</th>
            </thead>
            <tbody>

                @foreach ($value->assets as $key => $asset)
                    <tr>
                        <td>{{ $asset->assets->name ?? '' }}</td>
                        <td>{{ $asset->qty ?? '' }}</td>
                        <td>{{ $asset->activities->activities ?? '' }}</td>
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
                <th>Code</th>
                <th>Materials Names</th>
                <th>Specification </th>
                <th>Unit</th>
                <th>Quantity Used</th>
                <th>Work details</th>
                <th>Remarks</th>
            </thead>
            <tbody>

                @foreach ($value->material as $key => $materialData)
                    <tr>
                        <td>{{ $materialData->materials->name ?? '' }}</td>
                        <td>{{ $materialData->activities->activities ?? '' }}</td>
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

                @foreach ($value->labour as $key => $labourData)
                    <tr>
                        <td>{{ $labourData->vendors->name ?? '' }}</td>
                        <td>{{ $labourData->labours->name ?? '' }}</td>
                        <td>{{ $labourData->activities->activities ?? '' }}</td>
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
                <th>Hinderances Details</th>
                <th>Concern Team Members</th>
                <th>Concern Team Members</th>
            </thead>
            <tbody>

                @foreach ($value->historie as $key => $historieData)
                    <tr>
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
                <th>Safety Problem Details</th>
                <th>Concern Team Members</th>
                <th>Concern Team Members</th>
            </thead>
            <tbody>

                @foreach ($value->safetie as $key => $safetieData)
                    <tr>
                        <td>{{ $safetieData->name ?? '' }}</td>
                        <td>{{ $safetieData->date ?? '' }}</td>
                        <td>{{ $safetieData->details ?? '' }}</td>
                        <td>{{ $safetieData->remarks ?? '' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach
    {{-- @dd('lkijuhygt') --}}
</body>

</html>
