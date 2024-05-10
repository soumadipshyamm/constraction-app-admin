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
    {{-- @dd($datas->toArray()); --}}
    <h1>Labour Contractor Labour details date wise</h1>
    <div class="date">
        <p>Date From:</p>
        <p>Date To:</p>
    </div>
    <div class="projects">
        <div class="priject"> Projects:</div>
        <div class="subpriject"> Sub-Projects:</div>
    </div>
    <div>

        <div>Labour Contractor Name : {{ $datas[0]->vendors->name ?? '' }}</div>
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
                @foreach ($datas as $key => $value)
                    {{-- @dd($value) --}}
                    <tr>
                        <td>{{ $value->dpr->name ?? '' }}</td>
                        <td>{{ $value->labours->category ?? '' }}</td>
                        <td>{{ $value->labours->name ?? '' }}</td>
                        <td>{{ $value->labours->units->unit ?? '' }}</td>
                        <td>{{ $value->qty ?? '' }}</td>
                        <td>{{ $value->ot_qty ?? '' }}</td>
                        <td>{{ $value->qty + $value->ot_qty ?? '' }}</td>
                        <td>{{ $value->rate_per_unit ?? '' }}</td>
                        <td>{{ ($value->qty + $value->ot_qty) * $value->rate_per_unit ?? '' }}</td>


                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{-- <div class="req-approved">
        <div class="requested">Requested by :</div>
        <div class="approved">Approved by :</div>
    </div> --}}
    {{-- @dd('lkjhg'); --}}
</body>

</html>
