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

    {{-- @dd($datas) --}}


    <h1>Material Request Report</h1>
    <div class="date">
        Date:{{ $datas?->date ?? '' }}
    </div>
    <div class="projects">
        <div class="priject"> Projects:{{ $datas?->projects?->project_name ?? '' }}</div>
        @if ($datas?->subprojects?->name)
            <div class="subpriject"> Sub-Projects:{{ $datas?->subprojects?->name ?? '' }}</div>
        @endif
        <div class="requestno"> Req No:{{ $datas?->request_id ?? '' }}</div>
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
                {{-- @dd($datas->materialRequest) --}}
                @foreach ($datas->materialRequest as $key => $value)
                    {{-- @dd($value->materials) --}}
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td class="td-line-break">{{ $value?->materials?->code ?? '' }}</td>
                        <td class="td-line-break">{{ $value?->materials?->name ?? '' }}</td>
                        <td class="td-line-break">
                            {{ $value?->materials?->specification !== null && $value?->materials?->specification !== 'NULL' ? $value?->materials?->specification : ' ' }}
                        </td>
                        <td>{{ $value?->materials?->units?->unit ?? '' }}</td>
                        <td>{{ $value?->qty ?? '' }}</td>
                        <td>{{ $value?->date ?? '' }}</td>
                        <td class="td-line-break">
                            {{ $value?->activites?->activities !== null && $value?->activites?->activities !== 'NULL' ? $value?->activites?->activities : ' ' }}
                        </td>
                        <td class="td-line-break">
                            {{ number_format($value?->materials?->inventorys?->total_qty ?? 0, 2) }}</td>
                        <td class="td-line-break">
                            {{ $value?->remarks !== null && $value?->remarks !== 'NULL' ? $value?->remarks : ' ' }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>
