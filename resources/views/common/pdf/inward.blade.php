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
    {{-- @dd($datas?->invInwardGood->first()->invInwardEntryTypes->name) --}}
    {{-- @dd($datas) --}}
    <h1>Inward</h1>
    <div class="date">
        Date:{{ $datas->date ?? '' }}
    </div>
    <div class="">
        <div class="priject"> Projects:{{ $datas->projects->project_name ?? '' }}</div>
        <div class=""> Stores: @foreach ($datas->InvInwardStore as $key => $value)
                {{ $value->name }},
            @endforeach
        </div>
        <div class=""> Location:@foreach ($datas->InvInwardStore as $key => $value)
                {{ $value->location }},
            @endforeach
        </div>
        <div class=""> Supplier:{{ $datas?->invInwardGood->first()->vendors?->name ?? '' }}</div>
        <div class=""> Entry Type:{{ $datas?->invInwardGood->first()->invInwardEntryTypes->name ?? '' }}</div>
        <div class=""> GRN/MRN no:{{ $datas->invInwardGood->first()->grn_no ?? '' }}</div>
        <div class=""> Supplier Delivery Ref No:{{ $datas->invInwardGood->first()->delivery_ref_copy_no ?? '' }}
        </div>
        <div class=""> Supplier delivery Ref
            date:{{ $datas->invInwardGood->first()->delivery_ref_copy_date ?? '' }}</div>
    </div>
    <br>
    <br>
    {{-- @dd($datas->invInwardGood->first()) --}}
    {{-- *************************************Assets**************************************************************** --}}
    <div class="col-md-12">
        <h3>Assets/Material</h3>
        <table border="1">
            <thead>
                <th>slno.</th>
                <th>code</th>
                <th>name</th>
                <th>specification</th>
                <th>type</th>
                <th>units</th>
                <th>recipt_qty</th>
                <th>reject_qty</th>
                <th>accept_qty</th>
                <th>price</th>
                <th>amount</th>
                {{-- <th>remarkes</th> --}}
            </thead>
            <tbody>
                @php
                    $ertyujk = [];
                @endphp
                @foreach ($datas->invInwardGood as $key => $val)
                    @if (count($val->InvInwardGoodDetails) > 0)
                        @foreach ($val->InvInwardGoodDetails as $key => $vals)
                            <tr>
                                {{-- @dd($vals->recipt_qty); --}}
                                @php
                                    $typess = '';
                                    if ($val->type == 'machines') {
                                        $typess = $vals->assets;
                                    } else {
                                        $typess = $vals->materials;
                                    }
                                @endphp
                                <td>{{ $key + 1 }}</td>
                                <td class="td-line-break">
                                    {{ check_null($typess->code) ? $typess->code : ' ' }}</td>
                                <td class="td-line-break">
                                    {{ check_null($typess->name) ? $typess->name : ' ' }}</td>
                                <td class="td-line-break">
                                    {{ $typess->specification !== null || $typess->specification !== 'NULL' ? $typess->specification : ' ' }}
                                </td>
                                <td class="td-line-break">
                                    {{ check_null($vals->type) ? $vals->type : ' ' }}</td>
                                <td>{{ $typess->units->unit !== null || $typess->units->unit !== 'NULL' ? $typess->units->unit : ' ' }}
                                </td>
                                <td>{{ $vals->recipt_qty !== null || $vals->recipt_qty !== 'NULL' ? number_format((float) $vals->recipt_qty, 2, '.', '') : ' ' }}
                                </td>
                                <td>{{ $vals->reject_qty !== null || $vals->reject_qty !== 'NULL' ? number_format((float) $vals->reject_qty, 2, '.', '') : ' ' }}
                                </td>
                                <td>{{ $vals->accept_qty !== null || $vals->accept_qty !== 'NULL' ? number_format((float) $vals->accept_qty, 2, '.', '') : ' ' }}
                                </td>
                                <td>{{ $vals->price !== null || $vals->price !== 'NULL' ? number_format((float) $vals->price, 2, '.', '') : ' ' }}
                                </td>
                                <td>{{ $vals->accept_qty !== null || $vals->accept_qty !== 'NULL' ? number_format((float) $vals->accept_qty * (float) $vals->price, 2, '.', '') : ' ' }}
                                </td>
                                {{-- <td class="td-line-break">{{ $vals->remarkes !== null || $vals->remarkes !== 'NULL' ? $vals->remarkes : ' ' }}</td> --}}
                            </tr>
                        @endforeach
                    @endif
                @endforeach
                {{-- @dd($ertyujk); --}}
            </tbody>
        </table>
    </div>
</body>

</html>
