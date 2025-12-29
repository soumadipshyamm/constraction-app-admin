<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        h1,
        h3,
        h5,
        h6 {
            text-align: center;
        }

        .projects {
            width: 100%;
            margin: 10px 0;
            padding: 5px;
            display: flex;
            flex-wrap: wrap;
        }

        .priject,
        .subpriject,
        .address {
            width: 33.33%;
            padding: 2px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
            font-size: 12px;
        }

        .td-line-break {
            white-space: pre-line;
        }

        img {
            margin: 5px;
        }
    </style>
</head>

<body>

    @foreach ($datas as $value)
        {{-- @dd($value) --}}

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
                    <th>Activities</th>
                    <th>Unit</th>
                    <th>Total Qty</th>
                    <th>%</th>
                    <th>Completion Qty</th>
                    <th>%</th>
                    <th>Balance Qty</th>
                    <th>Contractor</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody>
                @if (isset($value->activities) && count($value->activities))
                    @foreach ($value->activities as $key => $activity)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ blank_if_null($activity?->activities?->activities) }}</td>
                            <td>{{ blank_if_null($activity?->qty) }}</td>
                            <td>{{ blank_if_null($activity?->total_qty) }}</td>
                            <td>{{ blank_if_null($activity?->completion) }}%</td>
                            <td>{{ blank_if_null($activity?->completion) }}</td>
                            <td>{{ blank_if_null($activity?->remaining_qty) }}%</td>
                            <td>{{ blank_if_null($activity?->vendors?->name) }}</td>
                            <td>{{ blank_if_null($activity?->remarkes) }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="10" style="text-align: center;">No activities recorded.</td>
                    </tr>
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
                    <th>Specification</th>
                    <th>Unit</th>
                    <th>Quantity</th>
                    <th>Contractor</th>
                    <th>Rate/Unit</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody>
                @if (isset($value->assets) && count($value->assets))
                    @foreach ($value->assets as $key => $asset)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td class="td-line-break">{{ blank_if_null($asset?->assets?->code) }}</td>
                            <td>{{ blank_if_null($asset?->assets?->name) }}</td>
                            <td class="td-line-break">{{ blank_if_null($asset?->assets?->specification) }}</td>
                            <td>{{ blank_if_null($asset?->units?->unit) }}</td>
                            <td>{{ blank_if_null($asset?->qty) }}</td>
                            <td>{{ blank_if_null($asset?->vendors?->name) }}</td>
                            <td>{{ blank_if_null($asset?->rate_per_unit) }}</td>
                            <td>{{ blank_if_null($asset?->remarkes) }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="9" style="text-align: center;">No assets used.</td>
                    </tr>
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
                    <th>Specification</th>
                    <th>Unit</th>
                    <th>Quantity Used</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody>
                @if (isset($value->material) && count($value->material))
                    @foreach ($value->material as $key => $materialData)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ blank_if_null($materialData?->materials?->code) }}</td>
                            <td>{{ blank_if_null($materialData?->materials?->name) }}</td>
                            <td>{{ blank_if_null($materialData?->materials?->specification) }}</td>
                            <td>{{ blank_if_null($materialData?->units?->unit) }}</td>
                            <td>{{ blank_if_null($materialData?->qty) }}</td>
                            <td>{{ blank_if_null($materialData?->remarkes) }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="7" style="text-align: center;">No materials used.</td>
                    </tr>
                @endif
            </tbody>
        </table>

        <!-- Labour -->
        <h3>Labour</h3>
        <table>
            <thead>
                <tr>
                    <th>Sr.No</th>
                    <th>Labour Details</th>
                    <th>Contractor</th>
                    <th>Unit</th>
                    <th>Quantity</th>
                    <th>OT Quantity</th>
                    <th>Rate/Unit</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody>
                @if (isset($value->labour) && count($value->labour))
                    @foreach ($value->labour as $key => $labourData)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ blank_if_null($labourData?->labours?->name) }}</td>
                            <td>{{ blank_if_null($labourData?->vendors?->name) }}</td>
                            <td>{{ blank_if_null($labourData?->units?->unit) }}</td>
                            <td>{{ blank_if_null($labourData?->qty) }}</td>
                            <td>{{ blank_if_null($labourData?->ot_qty) }}</td>
                            <td>{{ blank_if_null($labourData?->rate_per_unit) }}</td>
                            <td>{{ blank_if_null($labourData?->remarkes) }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="8" style="text-align: center;">No labour data.</td>
                    </tr>
                @endif
            </tbody>
        </table>

        <!-- Hinderances -->
        <h3>Hinderances</h3>
        <table>
            <thead>
                <tr>
                    <th>Sr.No</th>
                    <th>Concern Team Member</th>
                    <th>Date</th>
                    <th>Details</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody>
                @if (isset($value->historie) && count($value->historie))
                    @foreach ($value->historie as $key => $historieData)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ blank_if_null($historieData?->name) }}</td>
                            <td>{{ blank_if_null($historieData?->date) }}</td>
                            <td>{{ blank_if_null($historieData?->details) }}</td>
                            <td>{{ blank_if_null($historieData?->remarks) }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" style="text-align: center;">No hinderances reported.</td>
                    </tr>
                @endif
            </tbody>
        </table>

        <!-- Safety -->
        <h3>Safety</h3>
        <table>
            <thead>
                <tr>
                    <th>Sr.No</th>
                    <th>Team Name</th>
                    <th>Date</th>
                    <th>Problem Details</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody>
                @if (isset($value->safetie) && count($value->safetie))
                    @foreach ($value->safetie as $key => $safetieData)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ blank_if_null($safetieData?->name) }}</td>
                            <td>{{ blank_if_null($safetieData?->date) }}</td>
                            <td>{{ blank_if_null($safetieData?->details) }}</td>
                            <td>{{ blank_if_null($safetieData?->remarks) }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" style="text-align: center;">No safety issues reported.</td>
                    </tr>
                @endif
            </tbody>
        </table>

        <!-- Photos -->
        <div>
            <h5>Attached Photos :</h5>

            <!-- Safety Photos -->
            <h6>Safety</h6>
            <div>
                @if (isset($value->safetie))
                    @foreach ($value->safetie as $safetieData)
                        @if ($safetieData->img)
                            <img src="{{ url('/upload/' . $safetieData->img) }}" alt="Safety Image" width="100"
                                height="100">
                        @endif
                    @endforeach
                @endif
            </div>

            <!-- Hinderances Photos -->
            <h6>Hinderances</h6>
            <div>
                @if (isset($value->historie))
                    @foreach ($value->historie as $historieData)
                        @if ($historieData->img)
                            <img src="{{ url('/upload/' . $historieData->img) }}" alt="Hinderance Image" width="100"
                                height="100">
                        @endif
                    @endforeach
                @endif
            </div>
        </div>

        <br><br>
    @endforeach

</body>

</html>
