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

        .header {
            margin: 10px;
            padding: 5px;
            padding-bottom: 10px;
        }

        .grnTbl thead tbody {
            padding: 5px;
            border: 0px;
        }
    </style>
</head>

<body>
    <h1>Work Status Completed </h1>

    <div class="header">
        <div class="date">Date:{{ $datas['headDetails']['start_date'] ?? '' }}</div>
        <div class="project">Projects:{{ $datas['headDetails']['project']->project_name ?? '' }}</div>
        @if ($datas['headDetails']['subproject']->name)

        <div class="top_element">Suv-Project:{{ $datas['headDetails']['subproject']->name ?? '' }}</div>
        @endif
    </div>
    <table border="1" class="grnTbl">
        <thead>
            <th>Sl No.</th>
            <th>DPR Date</th>
            <th>Activities </th>
            <th>Quantity</th>
            <th>Completion</th>
            <th>Vendor </th>
            <th>Remaining Quantity</th>
            <th>Total Quantity</th>
            <th>Remarks</th>
            <th>Prepared By </th>
        </thead>
        <tbody>
            @if (!empty($datas['completed']) && count($datas['completed']) > 0)
                @foreach ($datas['completed'] as $activities)
                    @forelse ($activities as $key => $activity)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $activity->dpr->date }}</td>
                            <td>{{ $activity->activities->activities }}</td>
                            <td>{{ $activity['qty'] }}</td>
                            <td>{{ number_format($activity['completion'], 2) }}</td>
                            <td>{{ $activity?->vendors?->name !== null && $activity->vendors->name !== 'NULL' ? $activity->vendors->name : ' ' }}</td>
                            <td>{{ number_format($activity['remaining_qty'], 2) }}</td>
                            <td>{{ number_format($activity['total_qty'], 2) }}</td>
                            <td>{{ $activity?->remarkes !== null && $activity->remarkes !== 'NULL'? $activity->remarkes : ' ' }}</td>
                            <td>{{ $activity?->dpr?->users?->name !== null && $activity->dpr->users->name !== 'NULL' ? $activity->dpr->users->name : ' ' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <p>No Data Found.</p>
                        </tr>
                    @endforelse
                @endforeach
            @endif
        </tbody>
    </table>
</body>

</html>
