<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        h1, h3, h5 {
            text-align: center;
            margin: 5px 0;
        }
        .projects {
            width: 100%;
            padding: 5px;
            margin: 10px 0;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }
        .priject, .subpriject, .address {
            flex: 1;
            min-width: 200px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 12px;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }
        .td-line-break {
            max-width: 80px;
            word-wrap: break-word;
        }
        .images {
            margin: 15px 0;
        }
        .images img {
            margin: 5px;
            border: 1px solid #ccc;
        }
    </style>
</head>
<body>

@foreach ($datas as $value)
    <h1>Daily Progress Report</h1>
    <div class="date"><strong>Date:</strong> {{ blank_if_null($value->date) }}</div>

    <div class="projects">
        <div class="priject"><strong>Project:</strong> {{ blank_if_null($value?->projects?->project_name) }}</div>
        @if ($value?->subProjects?->name)

        <div class="subpriject"><strong>Sub-Project:</strong> {{ blank_if_null($value?->subProjects?->name) }}</div>
        @endif
        <div class="address"><strong>Address:</strong> {{ blank_if_null($value?->projects?->address) }}</div>
    </div>

    <!-- Activities -->
    <h3>Activities</h3>
    <table>
        <thead>
            <tr>
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
            </tr>
        </thead>
        <tbody>
            @if(isset($value->activities) && count($value->activities))
                @foreach ($value->activities as $key => $activity)
                    @php
                        $usageData = totalActivitiesUsage($activity->activities_id);
                        $usage = is_array($usageData) ? $usageData : (method_exists($usageData, 'toArray') ? $usageData->toArray() : $usageData->jsonSerialize());
                        $percent = $usage['originalQty'] != 0
                            ? number_format(($activity->qty / $usage['originalQty']) * 100, 2)
                            : ' ';
                        $cummQty = abs($usage['originalQty'] - $usage['remainingQty']);
                    @endphp
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ blank_if_null($activity?->activities?->activities) }}</td>
                        <td>{{ blank_if_null($activity?->activities?->units?->unit) }}</td>
                        <td>{{ blank_if_null($activity->qty) }}</td>
                        <td>{{ $percent }}</td>
                        <td>{{ blank_if_null($cummQty) }}</td>
                        <td>{{ blank_if_null($usage['originalQty']) }}</td>
                        <td>{{ blank_if_null($usage['remainingQty']) }}</td>
                        <td>{{ blank_if_null($activity?->vendors?->name) }}</td>
                        <td class="td-line-break">{{ blank_if_null($activity->remarkes) }}</td>
                    </tr>
                @endforeach
            @else
                <tr><td colspan="10" style="text-align: center;">No activities recorded.</td></tr>
            @endif
        </tbody>
    </table>

    <!-- Assets -->
    <h3>Assets</h3>
    <table>
        <thead>
            <tr>
                <th>Sr.No</th>
                <th>Code</th>
                <th>Machinery Name</th>
                <th>Unit</th>
                <th>Specification</th>
                <th>Quantity</th>
                <th>Contractor</th>
                <th>Work Details</th>
                <th>Rate/Unit</th>
                <th>Remarks</th>
            </tr>
        </thead>
        <tbody>
            @if(isset($value->assets))
                @foreach ($value->assets as $key => $asset)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td class="td-line-break">{{ blank_if_null($asset?->assets?->code) }}</td>
                        <td>{{ blank_if_null($asset?->assets?->name) }}</td>
                        <td>{{ blank_if_null($asset?->assets?->units?->unit) }}</td>
                        <td class="td-line-break">{{ blank_if_null($asset?->assets?->specification) }}</td>
                        <td>{{ blank_if_null($asset->qty) }}</td>
                        <td>{{ blank_if_null($asset?->vendors?->name) }}</td>
                        <td>{{ blank_if_null($asset?->activities?->activities) }}</td>
                        <td>{{ blank_if_null($asset->rate_per_unit) }}</td>
                        <td class="td-line-break">{{ blank_if_null($asset->remarkes) }}</td>
                    </tr>
                @endforeach
            @else
                <tr><td colspan="10" style="text-align: center;">No assets used.</td></tr>
            @endif
        </tbody>
    </table>

    <!-- Material -->
    <h3>Material</h3>
    <table>
        <thead>
            <tr>
                <th>Sr.No</th>
                <th>Code</th>
                <th>Material Name</th>
                <th>Unit</th>
                <th>Specification</th>
                <th>Quantity</th>
                <th>Work Details</th>
                <th>Contractor</th>
                <th>Rate/Unit</th>
                <th>Remarks</th>
            </tr>
        </thead>
        <tbody>
            @if(isset($value->material))
                @foreach ($value->material as $key => $materialData)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td class="td-line-break">{{ blank_if_null($materialData?->materials?->code) }}</td>
                        <td>{{ blank_if_null($materialData?->materials?->name) }}</td>
                        <td>{{ blank_if_null($materialData?->materials?->units?->unit) }}</td>
                        <td class="td-line-break">{{ blank_if_null($materialData?->materials?->specification) }}</td>
                        <td>{{ blank_if_null($materialData->qty) }}</td>
                        <td>{{ blank_if_null($materialData?->activities?->activities) }}</td>
                        <td>{{ blank_if_null($materialData?->vendors?->name) }}</td>
                        <td>{{ blank_if_null($materialData->rate_per_unit) }}</td>
                        <td class="td-line-break">{{ blank_if_null($materialData->remarkes) }}</td>
                    </tr>
                @endforeach
            @else
                <tr><td colspan="10" style="text-align: center;">No materials used.</td></tr>
            @endif
        </tbody>
    </table>

    <!-- Labour -->
    <h3>Labour</h3>
    <table>
        <thead>
            <tr>
                <th>Sr.No</th>
                <th>Code</th>
                <th>Labour Details</th>
                <th>Unit</th>
                <th>Quantity</th>
                <th>OT Quantity</th>
                <th>Contractor</th>
                <th>Work Details</th>
                <th>Rate/Unit</th>
                <th>Remarks</th>
            </tr>
        </thead>
        <tbody>
            @if(isset($value->labour))
                @foreach ($value->labour as $key => $labourData)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td class="td-line-break">{{ blank_if_null($labourData?->labours?->gst_no) }}</td>
                        <td>{{ blank_if_null($labourData?->labours?->name) }}</td>
                        <td>{{ blank_if_null($labourData?->labours?->units?->unit) }}</td>
                        <td>{{ blank_if_null($labourData->qty) }}</td>
                        <td>{{ blank_if_null($labourData->ot_qty) }}</td>
                        <td>{{ blank_if_null($labourData?->vendors?->name) }}</td>
                        <td>{{ blank_if_null($labourData?->activities?->activities) }}</td>
                        <td>{{ blank_if_null($labourData->rate_per_unit) }}</td>
                        <td class="td-line-break">{{ blank_if_null($labourData->remarkes) }}</td>
                    </tr>
                @endforeach
            @else
                <tr><td colspan="10" style="text-align: center;">No labour data.</td></tr>
            @endif
        </tbody>
    </table>

    <!-- Hinderances -->
    <h3>Hinderances</h3>
    <table>
        <thead>
            <tr>
                <th>Sr.No</th>
                <th>Remarks</th>
                <th>Date</th>
                <th>Details</th>
                <th>Team Members</th>
            </tr>
        </thead>
        <tbody>
            @if(isset($value->historie))
                @foreach ($value->historie as $key => $hinderance)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ blank_if_null($hinderance->remarks) }}</td>
                        <td>{{ blank_if_null($hinderance->date) }}</td>
                        <td>{{ blank_if_null($hinderance->details) }}</td>
                        <td>{{ blank_if_null($hinderance?->companyUsers?->name) }}</td>
                    </tr>
                @endforeach
            @else
                <tr><td colspan="5" style="text-align: center;">No hinderances reported.</td></tr>
            @endif
        </tbody>
    </table>

    <!-- Safety -->
    <h3>Safety</h3>
    <table>
        <thead>
            <tr>
                <th>Sr.No</th>
                <th>Remarks</th>
                <th>Date</th>
                <th>Problem Details</th>
                <th>Team Members</th>
            </tr>
        </thead>
        <tbody>
            @if(isset($value->safetie))
                @foreach ($value->safetie as $key => $safety)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ blank_if_null($safety->remarks) }}</td>
                        <td>{{ blank_if_null($safety->date) }}</td>
                        <td>{{ blank_if_null($safety->name) }}</td>
                        <td>{{ blank_if_null($safety?->companyUsers?->name) }}</td>
                    </tr>
                @endforeach
            @else
                <tr><td colspan="5" style="text-align: center;">No safety issues reported.</td></tr>
            @endif
        </tbody>
    </table>

    <!-- Attached Photos -->
    <h3>Attached Photos</h3>

    <!-- Safety Photos -->
    <h4>Safety Photos</h4>
    <div class="images">
        @if(isset($value->safetie))
            @foreach ($value->safetie as $safety)
                @if($safety->img)
                    <img src="{{ url('/upload/' . $safety->img) }}" alt="Safety Image" width="200" height="200">
                @endif
            @endforeach
        @endif
    </div>

    <!-- Hinderance Photos -->
    <h4>Hinderances Photos</h4>
    <div class="images">
        @if(isset($value->historie))
            @foreach ($value->historie as $hinderance)
                @if($hinderance->img)
                    <img src="{{ url('/upload/' . $hinderance->img) }}" alt="Hinderance Image" width="200" height="200">
                @endif
            @endforeach
        @endif
    </div>

    <!-- Activity Photos -->
    <h4>Activity Photos</h4>
    <div class="images">
        @if(isset($value->activities))
            @foreach ($value->activities as $activity)
                @if($activity->img)
                    <img src="{{ url('/upload/' . $activity->img) }}" alt="Activity Image" width="200" height="200">
                @endif
            @endforeach
        @endif
    </div>

    <br><br>
@endforeach

</body>
</html>
