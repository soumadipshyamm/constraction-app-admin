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
    @foreach ($datas as $key => $value)
        <h1>GRN (MRN) </h1>
        <div class="date">
            Date:{{ $value?->date ?? '' }}
        </div>
        <div class="projects">
            <div class="priject">Projects:{{ $value?->projects?->project_name ?? '' }}</div>
            <div class="store">Store:{{ $value?->subProjects?->name ?? '' }}</div>
            <div class="store">Entry Type :{{ $value?->subProjects?->name ?? '' }}</div>
            <div class="store">Supplier:{{ $value?->subProjects?->name ?? '' }}</div>
            <div class="store">Location:{{ $value?->subProjects?->name ?? '' }}</div>
            <div class="store">Supplier Delivery Ref No:{{ $value?->subProjects?->name ?? '' }}</div>
            <div class="store">Supplier delivery Ref date:{{ $value?->subProjects?->name ?? '' }}</div>
            <div class="store">GRN/MRN no:{{ $value?->subProjects?->name ?? '' }}</div>
            <div class="store">Entry Type:{{ $value?->subProjects?->name ?? '' }}</div>
            <div class="store">Remarks:{{ $value?->subProjects?->name ?? '' }}</div>
        </div>
        {{-- <h3>Issue to : :</h3> --}}
        <table border="1">
            <thead>
                <th>Sr.No</th>
                <th>Code</th>
                <th>Materials/Machine</th>
                <th>Specification</th>
                <th>Unit</th>
                <th>Receipt Qty</th>
                <th>Reject Qty</th>
                <th>Accepted Qty</th>
                <th>Rate</th>
                <th>Amount</th>
                <th>PO Qty</th>
                <th>PO Balance</th>
                <th>Remarks</th>
            </thead>
            <tbody>
                {{-- @foreach ($value?->activities as $key => $activity)
                    <tr>
                        <td>{{ $activity->activities->activities ?? '' }}</td>
                        <td>{{ $activity->qty ?? '' }}</td>
                        <td>{{ $activity->total_qty ?? '' }}</td>
                        <td>{{ $activity->remaining_qty ?? '' }}</td>
                        <td>{{ $activity->completion ?? '' }}</td>
                        <td>{{ $activity->vendors->name ?? '' }}</td>
                        <td>{{ $activity->remarkes ?? '' }}</td>
                    </tr>
                @endforeach --}}
            </tbody>
        </table>
    @endforeach
    {{-- @dd('lkijuhygt') --}}
</body>

</html>
