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

        .td-line-break {
            max-width: 40px;
            word-wrap: break-word;
        }
    </style>
</head>

<body>
    @php
        $inventory = $datas->first();
    @endphp
    {{-- @dd($datas) --}}
    <h1>Project Stock Statement </h1>
    <div class="date">
        Date:{{ $inventory?->created_at?->format('Y-m-d') ?? '' }}
    </div>
    <div class="projects">
        <div class="priject"> Projects:{{ $inventory?->projects?->project_name ?? '' }}</div>
        <div class="store"> Store:{{ $inventory?->inventoryStore?->first()?->name ?? '' }}</div>
        <div class="type"> Type:{{ $inventory?->type ?? '' }}</div>
    </div>

    <table border="1">
        <thead>
            <th>SN No.</th>
            <th>Class</th>
            <th>code</th>
            <th>Type</th>
            <th>Materials/Machine</th>
            <th> Specification</th>
            <th> Unit</th>
            <th> Total Inward</th>
            <th> Total Issue (Outward)</th>
            <th> Available Stock</th>
        </thead>
        <tbody>
            {{-- @dd($datas); --}}
            @foreach ($datas as $key => $value)
                {{-- @dd($value->toArray()); --}}
                <tr>
                    {{-- @dd($value) --}}
                    <td>{{ $key + 1 }}</td>
                    <td class="td-line-break ">
                        {{ $value->type == 'materials' ? ($value?->materials?->class != null || $value?->materials?->class != 'NULL' ? $value?->materials?->class : ' ') : $value?->assets?->class ?? '' }}
                    </td>
                    <td class="td-line-break ">
                        {{ $value->type == 'materials' ? ($value?->materials?->code != null || $value?->materials?->code != 'NULL' ? $value?->materials?->code : ' ') : $value?->assets?->code ?? '' }}
                    </td>
                    <td class="td-line-break ">
                        {{ $value?->type != null && $value?->type !== 'NULL' ? $value?->type : '' }}
                    </td>
                    <td class="td-line-break ">
                        {{ $value->type == 'materials' ? ($value?->materials?->name != null && $value?->materials?->name !== 'NULL' ? $value?->materials?->name : ' ') : $value?->assets?->name ?? '' }}
                    </td>
                    <td class="td-line-break ">
                        {{ $value->type == 'materials' ? ($value?->materials?->specification != null && $value?->materials?->specification != null ? $value?->materials?->specification : ' ') : $value?->assets?->specification ?? '' }}
                    </td>
                    <td class="td-line-break ">
                        {{ $value->type == 'materials' ? ($value?->materials?->units?->unit != null && $value?->materials?->units?->unit != 'NULL' ? $value?->materials?->units?->unit : ' ') : $value?->assets?->units?->unit ?? '' }}
                    </td>
                    {{-- <td>{{ $value->recipt_qty ?? '' }}</td> --}}
                    {{-- <td>{{  abs($value->recipt_qty - $value->total_qty) ?? '' }}</td> --}}

                    <td>{{ abs($value->totalAcceptQty) ?? '' }}</td>
                    <td>{{ abs($value->totalIssueQty) ?? '' }}</td>
                    <td>{{ abs($value->totalAvailableQty) ?? '' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
