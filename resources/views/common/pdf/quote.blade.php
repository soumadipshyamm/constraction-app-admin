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
{{-- @dd($datas) --}}

<body>
    <h1>Request for Quote (RFQ)</h1>
    <div class="date">
        Date:{{ $datas->date ?? '' }}
    </div>
    <div class="">
        <div class="priject"> Projects:{{ $datas->projects->project_name ?? '' }}</div>
        <div class=""> RFQ
            no:{{ $datas?->request_no ?? '' }}
        </div>
    </div>
    <br>
    <br>
    <div class="col-md-12">
        {{-- <h3>Assets/Material</h3> --}}
        @if ($datas->type == '0')
            <table border="1">
                <thead>
                    <th>slno.</th>
                    <th>code</th>
                    <th>name</th>
                    <th>specification</th>
                    <th>units</th>
                    <th>Required qty</th>
                    <th>Required date</th>
                    <th>Quote Rate</th>
                </thead>
                <tbody>
                    @foreach ($datas->quotesdetails as $key => $quoteDetail)
                        @if (isset($quoteDetail))
                            @if ($quoteDetail->type == 0 && $quoteDetail->img == null)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td class="td-line-break">
                                        {{ $quoteDetail?->materials?->code ?? '' }}
                                    </td>
                                    <td>{{ $quoteDetail?->materials?->name ?? '' }}
                                    </td>
                                    <td class="td-line-break">
                                        {{ $quoteDetail?->materials?->specification !== null && $quoteDetail?->materials?->specification !== 'NULL' ? $quoteDetail?->materials?->specification : ' ' }}
                                    </td>
                                    <td>{{ $quoteDetail?->materials?->units->unit ?? '' }}
                                    </td>
                                    <td>{{ number_format($quoteDetail->request_qty ?? 0, 2) }}</td>
                                    <td>{{ $quoteDetail->date ?? 0 }}</td>
                                    <td>{{ number_format($quoteDetail->price ?? 0.0, 2) }}</td>
                                </tr>
                            @endif
                        @endif
                    @endforeach
                </tbody>
            </table>
        @endif

        @if ($datas->type == '1')
            @foreach ($datas->quotesdetails as $key => $quoteDetail)
                @php
                    $img = url('/upload/' . $quoteDetail->img) ?? '---';
                @endphp
                @if (isset($quoteDetail))
                    @if ($quoteDetail->type == 1 && $quoteDetail->img !== null)
                        <div>
                            <div><span>Image</span><img src="{{ $img }}" alt="" height="250px"
                                    width="300px"></div>
                            <h2>Remarks</h2>
                            <span>{{ isset($quoteDetail?->remarkes) ? $quoteDetail?->remarkes : '----' ?? '---' }}</span>
                        </div>
                        {{-- <table border="1">
                            <thead>
                                <th>Sl.No.</th>
                                <th>Image</th>
                                <th>Remarks</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td><img src="{{ $img }}" alt="" height="150px" width="50%">
                                    </td>
                                    <td>{{ isset($quoteDetail?->remarkes) ? $quoteDetail?->remarkes : '----' ?? '---' }}
                                    </td>
                                </tr>
                            </tbody>
                        </table> --}}
                    @endif
                @endif
            @endforeach
        @endif
    </div>
</body>

</html>
