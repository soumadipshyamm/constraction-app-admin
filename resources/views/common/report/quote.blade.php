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
    <h1>Request for Quote (RFQ)</h1>
    <div class="date">
        Date:{{ $datas->created_at->format('Y-m-d') ?? '' }}
    </div>
    <div class="projects">
        <div class="priject"> Projects:{{ $datas->projects->project_name ?? '' }}</div>
        <div class="subpriject"> Sub-Projects:{{ $datas->subProjects->name ?? '' }}</div>
        <div class="location">Location:{{ $datas->subProjects->name ?? '' }}</div>
        <div class="prno"> PR no :</div>
        <div class="reqno"> Req No: </div>
    </div>
    <table border="1">
        <thead>
            <th>Sr.No</th>
            <th>Code</th>
            <th>Materials</th>
            <th> Specification</th>
            <th> Unit</th>
            <th> Required qty</th>
            <th> Required date</th>
            <th> Quote Rate</th>
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
    <div>Requested By :</div>
    {{-- <div class="req-approved">
        <div class="requested">Requested by :</div>
        <div class="approved">Approved by :</div>
    </div> --}}
    {{-- @dd('lkjhg'); --}}
</body>

</html>
