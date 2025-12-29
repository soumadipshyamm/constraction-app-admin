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
    <h1>Labour Contractor Labour details date wise</h1>
    <div class="date">
        <p>Date From:{{ $datas['topHeadDetails']['dateform'] }}</p>
        <p>Date To:{{ $datas['topHeadDetails']['dateto'] }}</p>
    </div>
    <div class="projects">
        <div class="priject"> Projects:{{ $datas['topHeadDetails']['project'] }}</div>
        @if ($datas['topHeadDetails']['subproject'])
            <div class="subpriject"> Sub-Projects:{{ $datas['topHeadDetails']['subproject'] }}</div>
        @endif

    </div>
    @foreach ($datas['vessd'] as $ree)
        @php
            $total = 0;
            $amount = 0;
        @endphp
        {{-- @dd(findVendor($ree)->name) --}}
        <div style="margin-top: 10px">
            <div>Labour Contractor Name : {{ findVendor($ree)->name }}</div>
            <table border="1">
                <thead>
                    <th>Date</th>
                    <th>Labour Category</th>
                    <th>Labour Name </th>
                    <th> Unit</th>
                    <th> Quantity</th>
                    <th> OT </th>
                    <th> Total</th>
                    <th> Rate</th>
                    <th> Amount</th>
                </thead>
                <tbody>
                    @foreach ($datas['fetchData'] as $key => $value)
                        {{-- @dd( $value) --}}
                        @if ($ree == $value->vendors_id)
                            @php
                                $total = $total + ($value->qty + $value->ot_qty);
                                $amount = $amount + ($value->qty + $value->ot_qty) * $value->rate_per_unit;
                            @endphp
                            <tr>
                                <td>{{ $value->dpr->name != null ? $value->dpr->name : '---' }}</td>
                                <td>{{ $value->labours->category != null ? $value->labours->category : '---' }}</td>
                                <td>{{ $value->labours->name != null ? $value->labours->name : '---' }}</td>
                                <td>{{ $value->labours->units->unit != null ? $value->labours->units->unit : '---' }}
                                </td>
                                <td>{{ $value->qty != null ? abs($value->qty) : '---' }}</td>
                                <td>{{ $value->ot_qty != null ? abs($value->ot_qty) : '---' }}</td>
                                <td>{{ $value->qty + $value->ot_qty != null ? $value->qty + $value->ot_qty : '---' }}
                                </td>
                                <td>{{ $value->rate_per_unit != null ? $value->rate_per_unit : '---' }}</td>
                                <td>{{ ($value->qty + $value->ot_qty) * $value->rate_per_unit !== null ? number_format(($value->qty + $value->ot_qty) * $value->rate_per_unit, 2) : '---' }}
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
            <div><span>Total : {{ number_format($total, 2) ?? '' }}</span> <span>Amount:
                    {{ number_format($amount, 2) ?? '' }}</span></div>
        </div>
    @endforeach
</body>

</html>
