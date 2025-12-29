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

        .projects {
            margin: 10px;
            padding: 5px;
            padding-bottom: 10px;
        }
    </style>
</head>

<body>
    <h1>GRN (MRN) </h1>
    <div class="date">
        Date:{{ $datas['fetchHeadData']['date'] ?? '' }}
    </div>
    @php
        // $entry_type = findInvEntryTypeList($datas['fetchHeadData']['inv_inward_entry_types_id']);
        // $supplierName = findEntryType($entry_type->slug, $datas['fetchHeadData']['supplier']);
    @endphp
    {{-- @dd($entry_type); --}}
    <div class="header">
        <div class="project">Projects:{{ $datas['fetchHeadData']['projects'] ?? '' }}</div>
        <div class="top_element">Store:{{ $datas['fetchHeadData']['store'] ?? '' }}</div>
        @if ($datas['fetchHeadData']['store_loc'])
            <div class="top_element">Location:{{ $datas['fetchHeadData']['store_loc'] ?? '' }}</div>
        @endif
        {{-- <div class="top_element">Entry Type:{{ $entry_type->name ?? '' }}</div> --}}
        {{-- <div class="top_element">Supplier:{{ $supplierName->name ?? '' }}</div> --}}
        <div class="top_element">Supplier Delivery Ref No:{{ $datas['fetchHeadData']['delivery_ref_copy_no'] ?? '' }}
        </div>
        <div class="top_element">Supplier delivery Ref date:{{ $datas['fetchHeadData']['delivery_ref_copy_date'] ?? '' }}
        </div>
        <div class="top_element">GRN/MRN no:{{ $datas['fetchHeadData']['grn_no'] ?? '' }}</div>
        {{-- <div class="store">Remarks:{{ $datas['fetchHeadData']['projects'] ?? '' }}</div> --}}
    </div>
    {{-- @dd($datas); --}}

    <table border="1" class="grnTbl">
        <thead>
            <th>Sr.No</th>
            <th>Code</th>
            <th>Type</th>
            <th>Materials /Machine</th>
            <th>Unit</th>
            <th>Specification</th>
            <th>Receipt Qty</th>
            <th>Reject Qty</th>
            <th>Accepted Qty</th>
            <th>Rate</th>
            <th>Amount</th>
            {{-- <th>PO Qty</th>
            <th>PO Balance</th> --}}
            <th>Remarks</th>
        </thead>
        <tbody>
            @if (isset($datas['result']) && !empty($datas['result']))

                @foreach ($datas['result'] as $key => $value)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td class="td-line-break">
                            {{ $value->type == 'materials' ? $value?->materials?->code : $value?->assets?->code }}</td>
                        <td class="td-line-break">{{ $value->type ?? '' }}</td>
                        <td class="td-line-break">
                            {{ $value->type == 'materials' ? $value?->materials?->name : $value?->assets?->name }}</td>
                        <td class="td-line-break">
                            {{ $value->type == 'materials' ? $value?->materials?->units->unit : $value?->assets?->units->unit ?? '' }}
                        </td>
                        <td class="td-line-break">
                            {{ $value->type == 'materials' ? ($value?->materials?->specification !== null ? $value?->materials?->specification : ' ') : ($value?->assets?->specification !== null ? $value?->assets?->specification : ' ') ?? '' }}
                        </td>
                        <td>{{ abs($value->recipt_qty) != null ? abs($value->recipt_qty) : ' ' }}</td>
                        <td>{{ $value->reject_qty != null ? abs($value->reject_qty) : '-----' }}</td>
                        <td>{{ $value->accept_qty != null ? abs($value->accept_qty) : '-----' }}</td>
                        <td>{{ $value->price != null ? $value->price : ' ' }}</td>
                        <td>
                            {{ $value->accept_qty * $value->price != null ? abs($value->accept_qty * $value->price) : '-----' }}
                        </td>
                        </td>
                        <td class="td-line-break">{{ $value->remarkes != null ? $value->remarkes : ' ' }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="12" style="text-align: center;">No data available</td>
                </tr>
            @endif
        </tbody>
    </table>
    <div>
        <h5>Prepared By :</h5>
    </div>
</body>

</html>
