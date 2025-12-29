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
    {{-- @dd($datas); --}}
    <h1>Work Details </h1>
    <div class="date">
        Date:{{ $datas->created_at->format('Y-m-d') ?? '' }}
    </div>
    <div class="projects">
        <div class="priject"> Projects:{{ $datas->project->project_name ?? '' }}</div>
        <div class="subpriject"> Sub-Projects:{{ $datas->subproject->name ?? '' }}</div>
    </div>
    <table border="1">
        <thead>
            <th>Sr.No</th>
            <th>Activities</th>
            <th>Unit</th>
            <th> Estimate Qty</th>
            <th> Est Rate</th>
            <th> Est.Amount</th>
            <th> Completed Qty</th>
            <th> Est. Amount for Completion</th>
            <th> % Completion</th>
            <th> Balance qty</th>
        </thead>
        <tbody>
            <tr>
                <td>Projects:{{ $datas->project->project_name ?? '' }}</td>
                @if ($datas?->subproject?->name)
                    <td>Sub-Projects:{{ $datas->subproject->name ?? '' }}</td>
                @endif
                <td> Date:{{ $datas->created_at->format('Y-m-d') ?? '' }}</td>
            </tr>
            @foreach ($datas as $key => $value)
                <tr>
                    <td>{{ $key }}</td>
                    <td>{{ $value->activities != null || $value->activities != 'NULL' ? check_null($value->activities) : ' ' }}
                    </td>
                    <td>{{ $value->units->unit != null || $value->units->unit != 'NULL' ? $value->units->unit : ' ' }}
                    </td>
                    <td>{{ $value->qty != null || $value->qty != 'NULL' ? abs($value->qty) : ' ' }}</td>
                    <td>{{ $value->amount != null || $value->amount != 'NULL' ? abs($value->amount) : ' ' }}</td>

                </tr>
            @endforeach
        </tbody>
    </table>
    {{-- <div class="req-approved">
        <div class="requested">Requested by :</div>
        <div class="approved">Approved by :</div>
    </div> --}}
    {{-- @dd('lkjhg'); --}}
</body>

</html>
