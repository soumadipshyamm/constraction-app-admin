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
    {{-- @dd($datas->toArray()); --}}
    <h1>Workdone by contractors</h1>
    <div class="date">
        {{-- Date:{{ $datas->created_at->format('Y-m-d') ?? '' }} --}}
    </div>
    <div class="projects">
        <div class="priject"> Projects:{{ $datas->projects->project_name ?? '' }}</div>
        <div class="subpriject"> Sub-Projects:{{ $datas->subProjects->name ?? '' }}</div>

    </div>
    <div>
        <div> Contractor Name : </div>

        <table border="1">
            <thead>
                <th>Date</th>
                <th>Work Details</th>
                <th>Unit</th>
                <th> Quantity</th>
                <th> %</th>
                <th> Est Rate</th>
                <th> Amount</th>
            </thead>
            <tbody>
                @foreach ($datas as $key => $value)
                    <tr>
                        {{-- <td>{{ $key }}</td>
                    <td>{{ $value->activities ?? '' }}</td>
                    <td>{{ $value->units->unit ?? '' }}</td>
                    <td>{{ $value->qty ?? '' }}</td>
                    <td>{{ $value->amount ?? '' }}</td> --}}

                    </tr>
                @endforeach
            </tbody>
        </table>
        <div>Total =</div>
    </div>
    {{-- <div class="req-approved">
        <div class="requested">Requested by :</div>
        <div class="approved">Approved by :</div>
    </div> --}}
    {{-- @dd('lkjhg'); --}}
</body>

</html>
