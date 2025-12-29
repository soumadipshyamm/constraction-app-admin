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
    {{-- @dd($datas['activityDetails']); --}}
    <h1>Workdone by contractors</h1>
    <div class="date">
        Date:{{ $datas['topHeadDetails']['dateform'] }} To {{ $datas['topHeadDetails']['dateto'] ?? '' }}
    </div>
    <div class="projects">
        <div class="priject"> Projects:{{ $datas['topHeadDetails']['project'] ?? '' }}</div>
        <div class="subpriject"> Sub-Projects:{{ $datas['topHeadDetails']['subproject'] ?? '' }}</div>
    </div>
    @php
        $totalAmount = 0.0;
    @endphp
    {{-- @dd($datas['activityDetails']) --}}
    @foreach ($datas['fetchData'] as $key => $value)
        <div>

            <div> Contractor Name : {{ $value->vendors?->name }} </div>
            <table border="1">
                <thead>
                    <th>Sn No.</th>
                    <th>Date</th>
                    <th>Work Details</th>
                    <th>Unit</th>
                    <th> Quantity</th>
                    <th> %</th>
                    <th> Est Rate</th>
                    <th> Amount</th>
                    <th> Remarkes</th>
                </thead>
                <tbody>

                    @foreach ($datas['activityDetails'] as $work)
                        @foreach ($work['activities'] as $qwe)
                            @if ($value->vendors_id == $qwe->vendors_id)
                                @php
                                    $totalAmount += $qwe->activities?->amount;
                                @endphp
                                {{-- @dd($qwe) --}}
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $qwe->dpr?->date ?? '' }}</td>
                                    <td>{{ $qwe->activities?->activities != null || $qwe->activities?->activities != 'NULL' ? $qwe->activities?->activities : ' ' }}
                                    </td>
                                    <td>{{ $qwe->activities?->units?->unit != null || $qwe->activities?->units?->unit != 'NULL' ? $qwe->activities?->units?->unit : ' ' }}
                                    </td>
                                    <td>{{ $qwe->qty != null || $qwe->qty != 'NULL' ? abs($qwe->qty) : ' ' }}</td>
                                    <td>{{ number_format($qwe->completion ?? '0.00', 2) }}</td>
                                    <td>{{ $qwe->activities?->rate != null || $qwe->activities?->rate != 'NULL' ? abs($qwe->activities?->rate) : ' ' }}
                                    </td>
                                    <td>{{ $qwe->activities?->amount != null || $qwe->activities?->amount != 'NULL' ? abs($qwe->activities?->amount) : ' ' }}
                                    </td>
                                    <td>{{ $qwe->remarkes != null || $qwe->remarkes != 'NULL' ?  check_null($qwe->remarkes) : ' ' }}
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    @endforeach
                </tbody>
            </table>
            <div>Total ={{ $totalAmount ?? 0.0 }}</div>
            <br><br>
        </div>
    @endforeach
</body>

</html>
