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
            padding-bottom: 5px;
        }

        .date {
            width: 100%;
            margin: 1px;
            padding-top: 16px;
        }

        .req-approved {
            width: 100%;
            height: 80px;
            margin: 1px;
            padding-top: 16px;
        }

        .priject {
            width: 50%;
            float: left;
        }

        .subpriject {
            width: 50%;
            float: left;
        }

        .td-line-break {
            max-width: 40px;
            word-wrap: break-word;
        }

        table {
            width: 100%
        }
    </style>
</head>

<body>

    <h1>Purchase Request </h1>
    <div class="projects">
        <div class="priject"> Projects:{{ $datas->first()->projects->project_name ?? '' }}</div>
        @if ($datas->first()->subprojects->name)
            <div class="subpriject"> Sub-Projects:{{ $datas->first()->subprojects->name ?? '' }}</div>
        @endif
    </div>

    @foreach ($datas as $prkey => $prvalue)
        <div class="date">
            Date:{{ $prvalue->date ?? '' }}
        </div>
        <div class="requestno">
            Req No:{{ $prvalue->request_id ?? '' }}
        </div>
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

                @foreach ($prvalue->materialRequest as $key => $value)
                    <tr class="activity-head">
                        <td>{{ $key + 1 }}</td>
                        <td class="td-line-break">{{ $value->materials->code != null ? $value->materials->code : '---' }}
                        </td>
                        <td>{{ $value->materials->name != null ? $value->materials->name : '---' }}</td>
                        <td>{{ $value->materials->specification != null ? check_null($value->materials->specification) : '---' }}
                        </td>
                        <td>{{ $value->materials->units->unit != null ? $value->materials->units->unit : '---' }}</td>
                        <td>{{ $value->qty != null ? number_format($value->qty, 2) : '---' }}</td>
                        <td>{{ $value->date != null ? $value->date : '---' }}</td>
                        <td>{{ $value->activites?->activities != null ? $value->activites?->activities : '---' }}</td>
                        <td>{{ $value->remarks != null ? $value->remarks : '---' }}</td>
                        <td>{{ $value->materials->inventorys->total_qty != null ? number_format($value->materials->inventorys->total_qty, 2) : '---' }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach
    <div class="req-approved">
        <div class="requested">Requested by :</div>
        <div class="approved">Approved by :</div>
    </div>
</body>

</html>
