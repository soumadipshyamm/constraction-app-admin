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

        .activity-head {
            padding-bottom: 10px;
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

        .rfq-body {
            width: 100%;
            margin: 3px;
            padding-top: 15px;
        }


        .reqno {
            padding: 10px;
        }

        .dataImage {
            margin-top: 10px;
        }

        table {
            width: 100%
        }
    </style>
</head>
{{-- @dd($datas) --}}

<body>
    <h1>Request for Quote (RFQ)</h1>
    <div class="date">
        Date:
        {{ $datas['topHeadDetails']['dateform'] ?? '' }} To {{ $datas['topHeadDetails']['dateto'] ?? '' }}
    </div>
    <div class="projects">
        <div class="priject">
            Projects:{{ $datas['topHeadDetails']['project'] ?? '' }}
        </div>
        <div class="reqno">User Name:
            {{ $datas['topHeadDetails']['user'] ?? '---' }}</div>
    </div>
    @if (isset($datas['fetchData']) && !empty($datas['fetchData']))

        @foreach ($datas['fetchData'] as $key => $value)
            <div class="rfq-body">
                <div class="reqno">RFQ No:{{ $value->request_no ?? '---' }}</div>
                <table border="1" class="dataTable">
                    <thead>
                        <th>Sl.No.</th>
                        <th>code</th>
                        <th>name</th>
                        <th>specification</th>
                        <th>units</th>
                        <th>Required qty</th>
                        <th>Required date</th>
                        <th>Quote Rate</th>
                    </thead>
                    <tbody>
                        @foreach ($value->quotesdetails as $key => $quoteDetail)
                            @if (isset($quoteDetail))
                                @if ($quoteDetail->type == 0 && $quoteDetail->img == null)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td class="td-line-break">{{ $quoteDetail?->materials?->code ?? '' }}</td>
                                        <td>{{ $quoteDetail?->materials?->name != null ? $quoteDetail?->materials?->name : '---' }}</td>
                                        <td class="td-line-break">
                                            {{ $quoteDetail?->materials?->specification != null ? check_null($quoteDetail?->materials?->specification) : '---' }}</td>
                                        <td>{{ $quoteDetail?->materials?->units?->unit != null ? $quoteDetail?->materials?->units?->unit : '---' }}</td>
                                        <td>{{ $quoteDetail->request_qty != null ? number_format($quoteDetail->request_qty, 2) : '---' }}</td>
                                        <td>{{ $quoteDetail->date != null ? $quoteDetail->date : '---' }}</td>
                                        <td>{{ $quoteDetail->price != null ? number_format($quoteDetail->price, 2) : '---' }}</td>
                                    </tr>
                                @endif
                            @endif
                        @endforeach
                    </tbody>
                </table>
                <table border="1" class="dataImage">
                    <thead>
                        <th>Sl.No.</th>
                        <th>Image</th>
                        <th>Remarkes</th>
                    </thead>
                    <tbody>
                        @foreach ($value->quotesdetails as $key => $quoteDetail)
                            @php
                                $img = url('/upload/' . $quoteDetail->img) ?? '---';
                            @endphp
                            @if (isset($quoteDetail))
                                @if ($quoteDetail->type == 1 && $quoteDetail->img !== null)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td><img src="{{ $img }}" alt="" height="150px"
                                                width="50%">
                                        </td>
                                        <td>{{ $quoteDetail->remarkes != null ? $quoteDetail->remarkes : '---' }}</td>
                                    </tr>
                                @endif
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endforeach
    @else
        <div class="rfq-body">
            <p>No data available</p>
        </div>
    @endif
</body>

</html>
