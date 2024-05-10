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

    {{-- @dd($datas) --}}
    {{-- @foreach ($datas as $key => $value) --}}
    {{-- @dd($value->materialrequests->projects->project_name) --}}
    <h1>Material Request Report</h1>
    <div class="date">
        Date:{{ $datas->date ?? '' }}
    </div>
    <div class="projects">
        <div class="priject"> Projects:{{ $datas->projects->project_name ?? '' }}</div>
        <div class="subpriject"> Sub-Projects:{{ $datas->subprojects->name ?? '' }}</div>
        <div class="requestno"> Req No:{{ $datas->materialRequestDetails[0]->request_id ?? '' }}</div>
    </div>
    {{-- <h3>Activities</h3> --}}
    <table border="1">
        <thead>
            <th>Sr.No</th>
            <th>Code</th>
            <th>Materials</th>
            <th>Specification</th>
            <th>Unit</th>
            <th>Required qty</th>
            <th>Required date</th>
            <th>Required for Activities</th>
            <th>Remarks</th>
            <th>Current Stock</th>
        </thead>
        <tbody>
            @foreach ($datas->materialRequestDetails as $key => $value)
                {{-- @dd($value->materials->inventorys) --}}
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $value->materials->code ?? '' }}</td>
                    <td>{{ $value->materials->name ?? '' }}</td>
                    <td>{{ $value->materials->specification ?? '' }}</td>
                    <td>{{ $value->materials->units->unit ?? '' }}</td>
                    <td>{{ $value->qty ?? '' }}</td>
                    <td>{{ $value->date ?? '' }}</td>
                    <td>{{ $value->activites->activities ?? '' }}</td>
                    <td>{{ $value->remarks ?? '' }}</td>
                    <td>{{ $value->materials->inventorys->total_qty ?? '' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{-- @dd('lkjhg') --}}
</body>

</html>
