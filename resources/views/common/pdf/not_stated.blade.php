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
    <h1>Work Status Not-Staretd </h1>

    <div class="header">
        <div class="date">Date:{{ $datas['headDetails']['start_date'] ?? '' }}</div>
        <div class="project">Projects:{{ $datas['headDetails']['project']->project_name ?? '' }}</div>
        @if ($datas['headDetails']['subproject']->name )

        <div class="top_element">Suv-Project:{{ $datas['headDetails']['subproject']->name ?? '' }}</div>
        @endif
    </div>
    <table border="1" class="grnTbl">
        <thead>
            <th>Sl No.</th>
            <th>Activities </th>
            <th>Quantity</th>
            <th>Rate</th>
            <th>Amount </th>
            <th>Unit</th>
            <th>Start Date</th>
            <th>End Date</th>
        </thead>
        <tbody>
            @if (!empty($datas['notStarted']) && count($datas['notStarted']) > 0)
                @forelse($datas['notStarted'] as $key=> $activity)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $activity->activities ?? '---' }}</td>
                        <td>{{ $activity->qty ?? '---' }}</td>
                        <td>{{ $activity->rate ?? '---' }}</td>
                        <td>{{ $activity->amount ?? '---' }}</td>
                        <td>{{ $activity->units->unit ?? '---' }}</td>
                        <td>{{ $activity->start_date ?? '---' }}</td>
                        <td>{{ $activity->end_date ?? '---' }}</td>
                    </tr>
                @empty
                    <tr>
                        <p>No Data Found.</p>
                    </tr>
                @endforelse
            @endif
        </tbody>
    </table>
</body>

</html>
