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

        .td-line-break {
            max-width: 40px;
            word-wrap: break-word;
        }
    </style>
</head>

<body>
    <h1>Issue Return Details</h1>
    <div class="date">
        Date:{{ $datas['topHeadDetails']['dateform'] ?? '' }} To {{ $datas['topHeadDetails']['dateto'] ?? '' }}
    </div>
    <div class="projects">
        <div class="priject">Projects:{{ $datas['topHeadDetails']['project'] ?? '' }}</div>

        <div class="store">Store:{{ $datas['topHeadDetails']['subproject'] ?? '' }}</div>
    </div>
    {{-- @dd($datas) --}}
    @foreach ($datas['vessd']['inv_issue_lists'] ?? [] as $tkey => $invIssueType)
        @php
            $tagTypeId = $datas['vessd']['tag_id'][$tkey] ?? null;
            $issueTag = $tagTypeId ? issueTagFinder($tagTypeId, $invIssueType) : null;
        @endphp
        <h3>Issue Return from
            :{{ findInvIssueList($invIssueType)?->name ?? '' }}:
            {{ $issueTag?->name ?? '' }}
        </h3>
        <table border="1">
            <thead>
                <th>SN No.</th>
                <th>Return No</th>
                <th>Date</th>
                <th>Code</th>
                <th>Type</th>
                <th>Materials/Machine</th>
                <th>Specification</th>
                <th>Unit</th>
                <th>Return Qty</th>
                <th>Entry By</th>
            </thead>
            <tbody>
                @foreach ($datas['activityDetails'] ?? [] as $value)
                    @foreach ($value ?? [] as $key => $activityD)
                        @foreach ($activityD ?? [] as $key => $invRetGood)
                            @if ($invRetGood && $invRetGood->inv_issue_lists_id == $invIssueType && $invRetGood->tag_id == $tagTypeId)
                                @foreach ($invRetGood->invReturnDetails ?? [] as $data)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td class="td-line-break">{{ $data->invReturnGood->return_no != null ? $data->invReturnGood->return_no : '---' }}</td>
                                        <td class="td-line-break">{{ $data->invReturnGood->date != null ? $data->invReturnGood->date : '---' }}</td>
                                        <td class="td-line-break">
                                            {{ $data?->invReturnGood?->type == 'materials' ? $data?->materials?->code != null ? $data?->materials?->code : '---' : $data?->assets?->code != null ? $data?->assets?->code : '---' }}
                                        </td>
                                        <td class="td-line-break">{{ $data?->invReturnGood?->type != null ? $data?->invReturnGood?->type : '---' }}</td>
                                        <td class="td-line-break">
                                            {{ $data?->invReturnGood?->type == 'materials' ? $data?->materials?->name != null ? $data?->materials?->name : '---' : $data?->assets?->name != null ? $data?->assets?->name : '---' }}
                                        </td>
                                        <td class="td-line-break">
                                            {{ $data?->invReturnGood?->type == 'materials' ? $data?->materials?->specification != null ? $data?->materials?->specification : '---' : $data?->assets?->specification != null ? check_null($data?->assets?->specification) : '---' }}
                                        </td>
                                        <td class="td-line-break">
                                            {{ $data?->invReturnGood?->type == 'materials' ? $data?->materials?->units?->unit != null ? $data?->materials?->units?->unit : '---' : $data?->assets?->units?->unit != null ? $data?->assets?->units?->unit : '---' }}
                                        </td>
                                        <td>{{ $data?->return_qty != null ? number_format($data?->return_qty, 2) : '---' }}</td>
                                        <td class="td-line-break">
                                            {{ $data->invReturnGood?->invReturn?->users?->name != null ? $data->invReturnGood?->invReturn?->users?->name : '---' }}
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        @endforeach
                    @endforeach
                @endforeach
            </tbody>
        </table>
    @endforeach

</body>

</html>
