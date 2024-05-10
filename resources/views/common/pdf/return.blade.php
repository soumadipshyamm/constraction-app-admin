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
                <th>1</th>
                <th>2</th>
                <th>3</th>
                <th>4</th>
                <th>5</th>
                <th>6</th>
                <th>7</th>
            </thead>
            <tbody>
                {{-- <tr>
                    <td class="activity-head" colspan="11">Activities</td>
                </tr> --}}
                {{-- @foreach ($value->activities as $key => $activity)
                    <tr>
                        <td>{{ $activity->activities->activities ?? '' }}</td>
                        <td>{{ $activity->qty ?? '' }}</td>
                        <td>{{ $activity->total_qty ?? '' }}</td>
                        <td>{{ $activity->remaining_qty ?? '' }}</td>
                        <td>{{ $activity->completion ?? '' }}</td>
                        <td>{{ $activity->vendors->name ?? '' }}</td>
                        <td>{{ $activity->remarkes ?? '' }}</td>
                    </tr>
                @endforeach --}}
            </tbody>
        </table>
        <br><br>
        {{-- *************************************Assets**************************************************************** --}}
        <h3>Assets</h3>
        <table border="1">
            <thead>
                <th>1</th>
                <th>2</th>
                <th>3</th>
                <th>4</th>
                <th>5</th>
                <th>6</th>
            </thead>
            <tbody>
                {{-- <tr>
                    <td class="activity-head" colspan="11">Assets</td>
                </tr> --}}
                {{-- @foreach ($value->assets as $key => $asset)
                    <tr>
                        <td>{{ $asset->assets->name ?? '' }}</td>
                        <td>{{ $asset->qty ?? '' }}</td>
                        <td>{{ $asset->activities->activities ?? '' }}</td>
                        <td>{{ $asset->vendors->name ?? '' }}</td>
                        <td>{{ $asset->rate_per_unit ?? '' }}</td>
                        <td>{{ $asset->remarkes ?? '' }}</td>
                    </tr>
                @endforeach --}}
            </tbody>
        </table>
        <br><br>
        {{-- **************************************Material*************************************************************** --}}
        <h3>Material</h3>
        <table border="1">
            <thead>
                <th>1</th>
                <th>2</th>
                <th>3</th>
                <th>4</th>
            </thead>
            <tbody>
                {{-- <tr>
                    <td class="activity-head" colspan="11"></td>
                </tr> --}}
                {{-- @foreach ($value->material as $key => $materialData)
                    <tr>
                        <td>{{ $materialData->materials->name ?? '' }}</td>
                        <td>{{ $materialData->activities->activities ?? '' }}</td>
                        <td>{{ $materialData->qty ?? '' }}</td>
                        <td>{{ $materialData->remarkes ?? '' }}</td>
                    </tr>
                @endforeach --}}
            </tbody>
        </table>
        <br><br>
        {{-- ********************************************Labour********************************************************* --}}
        <h3>Labour</h3>
        <table border="1">
            <thead>
                <th>1</th>
                <th>2</th>
                <th>3</th>
                <th>4</th>
                <th>5</th>
                <th>6</th>
                <th>7</th>
            </thead>
            <tbody>
                {{-- <tr>
                    <td class="activity-head" colspan="7">Labour</td>
                </tr> --}}
                {{-- @foreach ($value->labour as $key => $labourData)
                    <tr>
                        <td>{{ $labourData->vendors->name ?? '' }}</td>
                        <td>{{ $labourData->labours->name ?? '' }}</td>
                        <td>{{ $labourData->activities->activities ?? '' }}</td>
                        <td>{{ $labourData->qty ?? '' }}</td>
                        <td>{{ $labourData->ot_qty ?? '' }}</td>
                        <td>{{ $labourData->rate_per_unit ?? '' }}</td>
                        <td>{{ $labourData->remarkes ?? '' }}</td>
                    </tr>
                @endforeach --}}
            </tbody>
        </table>
        <br><br>
        {{-- ********************************************Historie********************************************************* --}}
        <h3>Historie</h3>
        <table border="1">
            <thead>
                <th>1</th>
                <th>2</th>
                <th>3</th>
                <th>4</th>
            </thead>
            <tbody>
                {{-- <tr>
                    <td class="activity-head" colspan="7">Historie</td>
                </tr> --}}
                {{-- @foreach ($value->historie as $key => $historieData)
                    <tr>
                        <td>{{ $historieData->name ?? '' }}</td>
                        <td>{{ $historieData->date ?? '' }}</td>
                        <td>{{ $historieData->details ?? '' }}</td>
                        <td>{{ $historieData->remarks ?? '' }}</td>
                    </tr>
                @endforeach --}}
            </tbody>
        </table>
        <br><br>
        {{-- ********************************************Safetie********************************************************* --}}
        <h3>Safetie</h3>
        <table border="1">
            <thead>
                <th>1</th>
                <th>2</th>
                <th>3</th>
                <th>4</th>
            </thead>
            <tbody>
                {{-- <tr>
                    <td class="activity-head" colspan="4"></td>
                </tr> --}}
                {{-- @foreach ($value->safetie as $key => $safetieData)
                    <tr>
                        <td>{{ $safetieData->name ?? '' }}</td>
                        <td>{{ $safetieData->date ?? '' }}</td>
                        <td>{{ $safetieData->details ?? '' }}</td>
                        <td>{{ $safetieData->remarks ?? '' }}</td>
                    </tr>
                @endforeach --}}
            </tbody>
        </table>
    @endforeach
</body>

</html>
