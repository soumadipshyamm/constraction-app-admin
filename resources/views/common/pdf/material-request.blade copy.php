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
            width: 100%;
            /* padding-right: 10px; */

        }

        td {
            max-width: 50px;
        }

        .td-line-break {
            max-width: 40px;
            word-wrap: break-word;
        }
    </style>
</head>

<body>

    {{-- @dd($datas->first()->materialrequests->date) --}}
    {{-- @foreach ($datas as $key => $value) --}}
    {{-- @dd($value->materialrequests->projects->project_name) --}}
    <h1>Material Request Report</h1>
    <div class="date">
        Date:{{ $datas?->first()->materialrequests?->date ?? '' }}
    </div>
    <div class="projects">
        <div class="priject"> Projects:{{ $datas?->first()->materialrequests?->projects?->project_name ?? '' }}</div>
        <div class="subpriject"> Sub-Projects:{{ $datas?->first()->materialrequests?->subprojects?->name ?? '' }}</div>
        <div class="requestno"> Req No:{{ $datas?->first()->materialrequests?->request_id ?? '' }}</div>
    </div>
    {{-- <h3>Activities</h3> --}}
    <div class="col-md-12">
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
                - <th>Current Stock</th>
                - <th>Remarks</th>
            </thead>
            <tbody>
                @foreach ($datas as $key => $value)
                {{-- @dd($value->materials) --}}
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td class="td-line-break">{{ $value->materials->code ?? '' }}</td>
                    <td>{{ $value->materials->name ?? '' }}</td>
                    <td class="td-line-break">{{ $value->materials->specification !== null && $value->materials->specification !== 'NULL' ? $value->materials->specification : ' ' }}</td>
                    <td>{{ $value->materials->units->unit !== null && $value->materials->units->unit !== 'NULL' ? $value->materials->units->unit : ' ' }}</td>
                    <td>{{ $value->qty !== null && $value->qty !== 'NULL' ? number_format($value->qty, 2) : ' ' }}</td>
                    <td>{{ $value->date !== null && $value->date !== 'NULL' ? $value->date : ' ' }}</td>
                    <td>{{ $value->activites->activities !== null && $value->activites->activities !== 'NULL' ? $value->activites->activities : ' ' }}</td>
                    <td>{{ $value->materials->inventorys->total_qty !== null && $value->materials->inventorys->total_qty !== 'NULL' ? number_format($value->materials->inventorys->total_qty, 2) : ' ' }}</td>
                    <td class="td-line-break">{{ $value->remarks !== null && $value->remarks !== 'NULL' ? $value->remarks : ' ' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>
