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

        .project {
            width: 50%;
            float: left;
        }

        .subproject {
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
    {{-- @dd($data) --}}
    @php
        $url = url('/') . '/upload/';
    @endphp
    @foreach ($datas as $key => $value)
        {{-- @dd($value) --}}
        <h1>Daily Progress Report</h1>
        <div class="date">
            Date: {{ $value->date ?? '' }}
        </div>
        <div class="projects">
            <div class="project"> Projects: {{ $value?->projects?->project_name ?? '' }}</div>
            <div class="subproject"> Sub-Projects: {{ $value?->subProjects?->name ?? '' }}</div>
            <div class="address"> Address: {{ $value?->projects?->address ?? '' }}</div>
        </div>
        <h6>Activities</h6>
        <table border="1">
            <thead>
                <th>Sr.No</th>
                <th>Work Details</th>
                <th>Unit</th>
                <th>Qty</th>
                <th>Completion %</th>
                <th>Cumm Qty</th>
                <th>Total Qty</th>
                <th>Remaining Qty</th>
                <th>Contractor</th>
                <th>Remarks</th>
            </thead>
            <tbody>
                @forelse ($value->activities as $key => $activity)
                    @php
                        $asdfgh = totalActivitiesUsage($activity?->activities_id);
                    @endphp
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $activity?->activities?->activities ?? '---' }}</td>
                        <td>{{ $activity?->activities?->units->unit ?? '---' }}</td>
                        <td>{{ $activity?->qty ?? '---' }}</td>
                        {{-- <td>{{ number_format(($activity?->qty / $asdfgh['originalQty']) * 100, 2) ?? '---' }}</td> --}}
                        <td>
                            {{ $asdfgh['originalQty'] != 0 ? number_format(($activity?->qty / $asdfgh['originalQty']) * 100, 2) : '---' }}
                        </td>
                        <td>{{ abs($asdfgh['originalQty'] - $asdfgh['remainingQty']) ?? '---' }}</td>
                        <td>{{ abs($asdfgh['originalQty']) ?? '---' }}</td>
                        <td>{{ abs($asdfgh['remainingQty']) ?? '---' }}</td>
                        <td>{{ $activity?->vendors?->name ?? '---' }}</td>
                        <td class="td-line-break">
                            {{ $activity?->remarks !== null && $activity->remarks !== 'NULL' ? $activity->remarks : '---' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10">No activities found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <br><br>
        {{-- *************************************Assets**************************************************************** --}}
        <h6>Assets</h6>
        <table border="1">
            <thead>
                <th>Sr.No</th>
                <th>Code</th>
                <th>Machinery Names </th>
                <th>Unit</th>
                <th>Specification</th>
                <th>Quantity</th>
                <th>Contractor</th>
                <th>Work details </th>
                <th>Rate/Unit</th>
                <th>Remarks</th>
            </thead>
            <tbody>
                @forelse ($value->assets as $key => $asset)
                    {{-- @dd($asset->assets) --}}
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td class="td-line-break">{{ $asset->assets->code ?? '---' }}</td>
                        <td>{{ $asset->assets->name ?? '---' }}</td>
                        <td>{{ $asset->assets->units->unit ?? '---' }}</td>
                        <td class="td-line-break">
                            {{ $asset->assets->specification !== null && $asset->assets->specification !== 'NULL' ? $asset->assets->specification : '---' }}
                        </td>
                        <td>{{ number_format($asset->qty ?? '0.00', 2) }}</td>
                        <td>{{ $asset->vendors->name !== null && $asset->vendors->name !== 'NULL' ? $asset->vendors->name : '---' }}
                        </td>
                        <td>{{ $asset->activities->activities !== null && $asset->activities->activities !== 'NULL' ? $asset->activities->activities : '---' }}
                        </td>
                        <td>{{ number_format($asset->rate_per_unit ?? '0.00', 2) }}</td>
                        <td class="td-line-break">
                            {{ $asset->remarks !== null && $asset->remarks !== 'NULL' ? $asset->remarks : '---' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10">No assets found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <br><br>
        {{-- **************************************Material*************************************************************** --}}
        <h6>Material</h6>
        <table border="1">
            <thead>
                <th>Sr.No</th>
                <th>Code</th>
                <th>Materials Names </th>
                <th>Unit</th>
                <th>Specification</th>
                <th>Quantity</th>
                <th>Work details </th>
                <th>Contractor</th>
                <th>Rate/Unit</th>
                <th>Remarks</th>
            </thead>
            <tbody>
                @forelse ($value->material as $key => $materialData)
                    {{-- @dd($materialData->materials) --}}
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td class="td-line-break">{{ $materialData->materials->code ?? '---' }}</td>
                        <td>{{ $materialData->materials->name ?? '---' }}</td>
                        <td>{{ $materialData->materials->units->unit !== null && $materialData->materials->units->unit !== 'NULL' ? $materialData->materials->units->unit : '---' }}
                        </td>
                        <td class="td-line-break">
                            {{ $materialData->materials->specification !== null && $materialData->materials->specification !== 'NULL' ? $materialData->materials->specification : '---' }}
                        </td>
                        <td>{{ number_format($materialData->qty ?? '0.00', 2) }}</td>
                        <td>{{ $materialData->materials?->vendors->name !== null && $materialData->materials->vendors->name !== 'NULL' ? $materialData->materials->vendors->name : '---' }}
                        </td>
                        <td>{{ $materialData?->activities?->activities !== null && $materialData->activities->activities !== 'NULL' ? $materialData->activities->activities : '---' }}
                        </td>
                        <td>{{ number_format($materialData->rate_per_unit ?? '0.00', 2) }}</td>
                        <td class="td-line-break">
                            {{ $materialData->remarks !== null && $materialData->remarks !== 'NULL' ? $materialData->remarks : '---' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10">No materials found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <br><br>
        {{-- ********************************************Labour********************************************************* --}}
        <h6>Labour</h6>
        <table border="1">
            <thead>
                <th>Sr.No</th>
                <th>Code</th>
                <th>Labour Details</th>
                <th>Unit</th>
                <th>Quantity</th>
                <th>OT Quantity</th>
                <th>Labour Contractor</th>
                <th>Work details </th>
                <th>Rate/Unit</th>
                <th>Remarks</th>
            </thead>
            <tbody>
                @forelse ($value->labour as $key => $labourData)
                    {{-- @dd($labourData) --}}
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td class="td-line-break">{{ $labourData->labours->gst_no ?? '---' }}</td>
                        <td>{{ $labourData->labours->name ?? '---' }}</td>
                        <td>{{ $labourData->labours->units->unit ?? '---' }}</td>
                        <td>{{ number_format($labourData->qty ?? '0.00', 2) }}</td>
                        <td>{{ number_format($labourData->ot_qty ?? '0.00', 2) }}</td>
                        <td>{{ $labourData->vendors->name !== null && $labourData->vendors->name !== 'NULL' ? $labourData->vendors->name : '---' }}
                        </td>
                        <td>{{ $labourData->activities->activities !== null && $labourData->activities->activities !== 'NULL' ? $labourData->activities->activities : '---' }}
                        </td>
                        <td>{{ number_format($labourData->rate_per_unit ?? '0.00', 2) }}</td>
                        <td class="td-line-break">
                            {{ $labourData->remarks !== null && $labourData->remarks !== 'NULL' ? $labourData->remarks : '---' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10">No labour found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <br><br>
        {{-- ********************************************Hinderances********************************************************* --}}
        <h6>Hinderances</h6>
        <table border="1">
            <thead>
                <th>Sr.No</th>
                <th>Remarks</th>
                <th>Date</th>
                <th>Hinderances Title</th>
                <th>Team Members</th>
            </thead>
            <tbody>
                {{-- @dd($value->historie) --}}
                @forelse ($value->historie as $key => $historieData)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $historieData->remarks !== null && $historieData->remarks !== 'NULL' ? $historieData->remarks : '---' }}
                        </td>
                        <td>{{ $historieData->date ?? '---' }}</td>
                        <td>{{ $historieData->details !== null && $historieData->details !== 'NULL' ? $historieData->details : '---' }}
                        </td>
                        <td>{{ $historieData?->companyUsers?->name !== null && $historieData->companyUsers->name !== 'NULL' ? $historieData->companyUsers->name : '---' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">No hinderances found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <br><br>
        {{-- ********************************************Safety********************************************************* --}}
        <h6>Safety</h6>
        <table border="1">
            <thead>
                <th>Sr.No</th>
                <th>Remarks</th>
                <th>Date</th>
                <th>Safety Problem Title</th>
                <th>Team Members</th>
            </thead>
            <tbody>
                @forelse ($value->safetie as $key => $safetieData)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $safetieData->remarks !== null && $safetieData->remarks !== 'NULL' ? $safetieData->remarks : '---' }}
                        </td>
                        <td>{{ $safetieData->date ?? '---' }}</td>
                        <td>{{ $safetieData->name !== null && $safetieData->name !== 'NULL' ? $safetieData->name : '---' }}
                        </td>
                        <td>{{ $safetieData?->companyUsers?->name !== null && $safetieData->companyUsers->name !== 'NULL' ? $safetieData->companyUsers->name : '---' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">No safety issues found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <br><br>
        {{-- ********************************************Images********************************************************* --}}

        @if (isset($value->activities) && count($value->activities) > 0)
            <h6>Activities Images</h6>
            @foreach ($value->activities as $activity)
                @php
                    $imagePath = $url . $activity->img;
                @endphp
                {{-- {{ $imagePath }} --}}
                @if (file_exists($imagePath))
                    <!-- Check if the image file exists -->
                    <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents($imagePath)) }}"
                        alt="Activity Image" style="max-width: 100%; height: auto;">
                @endif
            @endforeach
            <br><br>
        @endif


        @if (isset($value->safetie) && count($value->safetie) > 0)
            <h6>Safety Images</h6>
            @foreach ($value->safetie as $safetieData)
                @php
                    $imagePath = $url . $safetieData->img;
                @endphp
                {{-- {{ $imagePath }} --}}
                @if (file_exists($imagePath))
                    <!-- Check if the image file exists -->
                    <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents($imagePath)) }}"
                        alt="Safety Image" style="max-width: 100%; height: auto;">
                @endif
            @endforeach
            <br><br>
        @endif

        @if (isset($value->historie) && count($value->historie) > 0)
            <h6>Hinderances Images</h6>
            @foreach ($value->historie as $historieData)
                @php
                    $imagePath = $url . $historieData->img;
                @endphp
                {{-- {{ $imagePath }} --}}
                @if (file_exists($imagePath))
                    <!-- Check if the image file exists -->
                    <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents($imagePath)) }}"
                        alt="Hinderance Image" style="max-width: 100%; height: auto;">
                @endif
            @endforeach
            <br><br>
        @endif
    @endforeach
    {{-- @dd('lkijuhygt') --}}
</body>

</html>
