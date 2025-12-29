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
            $datas->invIssueGoods->first()->inv_issue_lists_id,
            (int) $datas->invIssueGoods->first()->tag_id,
        );
    @endphp
    {{-- @dd($tyuop->name) --}}
    <h1>Issues</h1>
    <div class="date">
        Date:{{ $datas->date ?? '' }}
    </div>
    <div class="">
        <div class="priject"> Projects:{{ $datas?->projects?->project_name ?? '' }}</div>
        <div class=""> Stores: @foreach ($datas->InvIssueStore as $key => $value)
                {{ $value->name }},
            @endforeach
        </div>
        <div class=""> Location:@foreach ($datas->InvIssueStore as $key => $value)
                {{ $value->location }},
            @endforeach
        </div>
        <div class="">Issue No:{{ $datas->invIssueGoods->first()->issue_no ?? '' }}</div>
        {{-- <div class=""> Issue Type:</div> --}}
        {{-- @dd( $datas?->invIssueGoods) --}}
        {{-- <div class="">Issue To:{{ $datas?->invIssueGoods->first()->invIssueList->name ?? '' }}</div> --}}
    </div>
    <br>
    <br>
    {{-- *************************************Assets**************************************************************** --}}
    <div class="col-md-12">
        <h3>{{ $datas->invIssueGoods->first()->type == 'materials' ? 'Material' : 'Assets' }}</h3>
        <table border="1">
            <thead>
                <tr>
                    <th>Sl No.</th>
                    <th>Code</th>
                    <th>Name</th>
                    <th>Specification</th>
                    <th>Units</th>
                    <th>Issue Qty</th>
                    <th>Acivities</th>
                </tr>
            </thead>
            <tbody>
                @if (!empty($datas->invIssueGoods))
                    {{-- @dd($datas->invIssueGoods->toArray()) --}}
                    @foreach ($datas->invIssueGoods as $index => $issueGood)
                        @foreach ($issueGood->invIssueDetails as $detail)
                            @if ($detail['issue_qty'] !== null && $detail['issue_qty'] !== 0)
                                @php
                                    $detailType = $detail->materials_id
                                        ? ($detail['materials'] !== null && $detail['materials'] !== 'NULL'
                                            ? $detail['materials']
                                            : ' ')
                                        : $detail['assets'];
                                @endphp
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td class="td-line-break">{{ $detailType['code'] ?? ' ' }}</td>
                                    <td class="td-line-break">{{ $detailType['name'] ?? ' ' }}</td>
                                    <td class="td-line-break">
                                        {{ $detailType['specification'] !== null && $detailType['specification'] !== 'NULL' ? $detailType['specification'] : ' ' }}
                                    </td>
                                    <td class="td-line-break">{{ $detailType['units']['unit'] ?? ' ' }}</td>
                                    <td class="td-line-break">
                                        {{ $detail['issue_qty'] !== null && $detail['issue_qty'] !== 'NULL' ? number_format($detail['issue_qty'], 2) : ' ' }}
                                    </td>
                                    @if (isset($detail['activites']['activities']))
                                        <td class="td-line-break">
                                            {{ $detail['activites']['activities'] !== null && $detail['activites']['activities'] !== 'NULL' ? $detail['activites']['activities'] : ' ' }}
                                        </td>
                                    @else
                                        <td class="td-line-break"> </td>
                                    @endif
                                </tr>
                            @endif
                        @endforeach
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</body>

</html>
