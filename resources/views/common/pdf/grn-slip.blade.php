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

        .header {
            margin: 10px;
            padding: 5px;
            padding-bottom: 10px;
        }

        /* .grnTbl thead tbody {
            padding: 5px;
            border: 0px;
        } */
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
        <div class="top_element">Location:{{ $datas['fetchHeadData']['store_loc'] ?? '' }}</div>
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
                            {{ $value->type == 'materials' ? check_null($value->materials->code) : check_null($value->assets->code) }}</td>
                        <td class="td-line-break">{{ check_null($value->type) ?? '' }}</td>
                        <td class="td-line-break">
                            {{ $value->type == 'materials' ? check_null($value->materials->name) : check_null($value->assets->name) }}</td>
                        <td class="td-line-break">
                            {{ $value->type == 'materials' ? check_null($value->materials->units->unit) : check_null($value->assets->units->unit) ?? '' }}
                        </td>
                        <td class="td-line-break">
                            {{ $value->type == 'materials' ? (check_null($value->materials->specification) ? $value->materials->specification : '') : (check_null($value->assets->specification) ? $value->assets->specification : '') ?? '' }}
                        </td>
                        <td>{{ abs(check_null($value->recipt_qty) ?? '') }}</td>
                        <td>{{ abs(check_null($value->reject_qty) ?? '') }}</td>
                        <td>{{ abs(check_null($value->accept_qty) ?? '') }}</td>
                        <td>{{ abs(check_null($value->price) ?? '') }}</td>
                        <td>{{ check_null($value->accept_qty) && check_null($value->price) ? abs($value->accept_qty * $value->price) : '' }}</td>
                        <td class="td-line-break">{{ check_null($value->remarkes) ? $value->remarkes : ' ' }}</td>
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
