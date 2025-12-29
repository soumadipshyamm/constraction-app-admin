<!-- resources/views/pdf/sample.blade.php -->
<!DOCTYPE html>
<html>

<head>
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

        .requestno {
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
    {{-- @dd($datas['headerDetails']); --}}
    <h1>Work Details </h1>
    <div class="date">
        Date :{{ $datas['headerDetails']['fromDate'] ?? '' }}--
        {{ $datas['headerDetails']['toDate'] ?? '' }}
    </div>
    <div class="projects">
        <div class="priject"> Projects:{{ $datas['headerDetails']['projectId'] ?? '' }}</div>
        @if ($datas['headerDetails']['subProjectId'])
            <div class="subpriject"> Sub-Projects:{{ $datas['headerDetails']['subProjectId'] ?? '' }}</div>
        @endif
    </div>
    <table border="1">
        <thead>
            <th>Sl.no</th>
            <th>Activities</th>
            <th>Unit</th>
            <th>Estimate Qty</th>
            <th>Est Rate</th>
            <th>Est. Amount</th>
            <th>Completed Qty</th>
            <th>Est. Amount for Completion</th>
            <th>% Completion</th>
            <th>Balance qty</th>
        </thead>
        <tbody>
            @foreach ($datas['activites'] as $key => $value)
                {{-- @dd($value) --}}
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $value['activities'] ?? '' }}</td>
                    <td>{{ $value['unit'] ?? '' }}</td>
                    <td>{{ number_format($value['est_qty'] ?? '0.00', 2) }}</td>
                    <td>{{ number_format($value['est_rate'] ?? '0.00', 2) }}</td>
                    <td>{{ number_format($value['est_amount'] ?? '0.00', 2) }}</td>
                    <td>{{ number_format($value['completed_qty'] ?? '0.00', 2) }}</td>
                    <td>{{ number_format($value['est_amount_completion'] ?? '0.00', 2) }}</td>
                    <td>{{ number_format($value['completion'] ?? '0.00', 2) }}</td>
                    <td>{{ number_format($value['balance_qty'] ?? '0.00', 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
