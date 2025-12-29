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
    {{-- @foreach ($datas as $key => $value) --}}
    {{-- @dd($datas->toArray()) --}}
    @php
        $tyuop = issueTagFinder(
            $datas->invReturnsGoods->first()->inv_issue_lists_id,
            (int) $datas->invReturnsGoods->first()->tag_id,
        );
    @endphp
    {{-- @dd($tyuop->name) --}}
    <h1>Return</h1>
    <div class="date">
        Date:{{ $datas->date ?? '' }}
    </div>
    <div class="">
        <div class="priject"> Projects:{{ $datas->projects->project_name ?? '' }}</div>

        <div class=""> Stores: @foreach ($datas->InvReturnStore as $key => $value)
                {{ $value->name }},
            @endforeach
        </div>
        <div class=""> Location:@foreach ($datas->InvReturnStore as $key => $value)
                {{ $value->location }},
            @endforeach
        </div>
        <div class="">Return No:{{ $datas->invReturnsGoods->first()->return_no ?? '' }}</div>
        <div class=""> Return Type:{{ $datas?->invReturnsGoods->first()->invIssueList->name ?? '' }}</div>
        <div class="">Return To:{{ $tyuop->name ?? '' }}</div>
    </div>
    <br>
    <br>
    {{-- *************************************Assets**************************************************************** --}}
    <div class="col-md-12">
        <h3>{{ $datas->invReturnsGoods->first()->type == 'materials' ? 'Material' : 'Assets' }}</h3>
        <table border="1">
            <thead>
                <th>Slno.</th>
                <th>Code</th>
                <th>Name</th>
                <th>Specification</th>
                <th>Units</th>
                <th>Return Qty</th>
                {{-- <th>Acivities</th> --}}
            </thead>
            <tbody>
                @foreach ($datas->invReturnsGoods->first()->invReturnDetails as $key => $val)
                    <tr>
                        @php
                            $typess = '';
                            if ($val->type == 'machines') {
                                $typess = $val->assets;
                            } else {
                                $typess = $val->materials;
                            }
                        @endphp
                        <td>{{ $key + 1 }}</td>
                        <td class="td-line-break">{{ $typess->code ?? '' }}</td>
                        <td>{{ $typess->name ?? '' }}</td>
                        <td class="td-line-break">
                            {{ $typess->specification !== null && $typess->specification !== 'NULL' ? $typess->specification : ' ' }}
                        </td>
                        <td>{{ $typess->units->unit ?? '' }}</td>
                        <td>{{ number_format($val->return_qty ?? 0, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>


</html>
