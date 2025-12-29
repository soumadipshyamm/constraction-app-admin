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
    </style>
</head>

<body>

    {{-- @php
    $tyuop = issueTagFinder(
        $datas->invIssueGoods->first()->inv_issue_lists_id,
        (int) $datas->invIssueGoods->first()->tag_id,
    );
@endphp --}}
    {{-- @dd($datas) --}}
    {{-- @foreach ($datas as $key => $value) --}}
    {{-- @dd($datas?->first()?->invIssueGood?->tag_id) --}}
    @php
        $invIdsss = $datas?->first()?->invIssueGood?->inv_issue_lists_id;
        $issueBy = issueTagFinder((int) $datas?->first()?->invIssueGood?->tag_id, $invIdsss);
        $type = findInvIssueList($invIdsss);
    @endphp
    <h1>Issue Slip</h1>
    <div class="date">
        Date:{{ $datas?->first()?->InvIssueGood?->date ?? '' }}
    </div>
    <div class="projects">
        <div class="priject">
            Projects:{{ $datas?->first()?->InvIssueGood?->invIssue?->projects?->project_name != null ? $datas?->first()?->InvIssueGood?->invIssue?->projects?->project_name : '---' }}
        </div>
        <div class="store">
            Store:{{ $datas?->first()?->InvIssueGood?->invIssue?->InvIssueStore?->first()?->name != null ? $datas?->first()?->InvIssueGood?->invIssue?->InvIssueStore?->first()?->name : '---' }}
        </div>
        {{-- <div class="issue_to">Issue to :</div> --}}
        <div class="issue_note_no :">Issue Note no :
            {{ $datas?->first()?->InvIssueGood?->issue_no != null ? $datas?->first()?->InvIssueGood?->issue_no : '---' }}
        </div>
        <div class="">Issue To:{{ $type?->name != null ? $type?->name : '---' }}</div>
        <div>Issue
            By:{{ ($issueBy?->name != null ? $issueBy?->name : $issueBy?->project_name != null) ? $issueBy?->project_name : '---' }}
        </div>

    </div>
    {{-- <h3>Issue Return from : :</h3> --}}
    <table border="1">
        <thead>
            <th>Sr.No</th>
            <th>Code</th>
            <th>Type</th>
            <th>Materials/Machine</th>
            <th>Specification</th>
            <th>Unit</th>
            <th>Issue Qty</th>
            <th>Acivities</th>
        </thead>
        <tbody>
            @if ($datas)
                @foreach ($datas as $key => $data)
                    <tr>
                        {{-- @dd($data) --}}
                        <td>{{ $key + 1 }}</td>
                        <td>{{ ($data->type == 'materials' ? ($data?->materials?->code != null ? $data?->materials?->code : '---') : $data?->assets?->code != null) ? $data?->assets?->code : '---' }}
                        </td>
                        <td>{{ $data->type ?? '' }}</td>
                        <td>{{ $data->type == 'materials' ? $data?->materials?->name : $data?->assets?->name ?? '' }}
                        </td>
                        <td>{{ ($data->type == 'materials' ? ($data?->materials?->specification !== null && $data?->materials?->specification !== 'NULL' ? check_null($data?->materials?->specification) : ' ') : $data?->assets?->specification !== null && $data?->assets?->specification !== 'NULL') ? check_null($data?->assets?->specification) : ' ' }}
                        </td>
                        <td>{{ ($data->type == 'materials' ? ($data?->materials?->units?->unit != null ? $data?->materials?->units?->unit : '---') : $data?->assets?->units?->unit != null) ? $data?->assets?->units?->unit : '---' }}
                        </td>
                        <td>{{ $data?->issue_qty ?? 0.0 }}</td>
                        <td>{{ $data?->activites?->activite != null ? $data?->activites?->activite : '---' }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="8" style="text-align: center;">No data available</td>
                </tr>
            @endif
        </tbody>
    </table>
    <div>
        <h5>Issued By :</h5>
    </div>
    {{-- @endforeach --}}
    {{-- @dd('lkijuhygt') --}}
</body>

</html>
