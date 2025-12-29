@extends('Company.layouts.app')
@section(' labourContractor-active', 'active')
@section('title', __('Labour Contractor'))
@push('styles')
@endpush
@section('content')
    <div class="app-main__outer">
        <div class="app-main__inner">
            <div class="app-page-title">
                <div class="page-title-wrapper">
                    <div class="page-title-heading">
                        <div class="page-title-icon">
                            <i class="pe-7s-car icon-gradient bg-mean-fruit">
                            </i>
                        </div>
                        <div> Labour Contractor
                        </div>
                    </div>
                    <div class="page-title-actions">
                    </div>
                </div>
            </div>
            {{-- <div class="row"> --}}
            <div class="row">
                <div class="col-md-12">
                    <div class="main_wrapper">
                        <div class="main_card mb-3">
                            <div class="card_content">
                                <div class="tab-content" id="nav-tabContent">
                                    <form id="form-work-progress-details" class="filter-form" {{-- action="{{ route('company.report.workProgressDetails') }}"  --}}
                                        method="POST">
                                        @csrf
                                        <div class="tabcin_head">
                                            <div class="d-flex justify-content-between">
                                                <div class="singletabcin_head">
                                                    <label for="">Project <span class="text-danger">*</span></label>
                                                    <select class="form-control from_project"
                                                        value="{{ old('from_project') }}" name="from_project"
                                                        id="from_project">
                                                        <option>---select project---</option>
                                                        {{ getProject('$data->project_id') }}
                                                    </select>
                                                    @if ($errors->has('project'))
                                                        <div class="error">{{ $errors->first('project') }}</div>
                                                    @endif
                                                </div>

                                                <div class="singletabcin_head">
                                                    <label for="">Sub Project </label>
                                                    <select class="form-control mySelect22 from_subproject"
                                                        value="{{ old('from_subproject') }}" name="from_subproject"
                                                        id="from_subproject">
                                                        <option value="">----Select SubProject----</option>
                                                    </select>
                                                    @if ($errors->has('subproject'))
                                                        <div class="error">{{ $errors->first('subproject') }}</div>
                                                    @endif
                                                </div>

                                                <div class="singletabcin_head">
                                                    <label for="date">Select From Date:</label>
                                                    <input type="date" class="form-control " id="from_date"
                                                        name="from_date">
                                                </div>

                                                <div class="singletabcin_head">
                                                    <label for="date">Select To Date:</label>
                                                    <input type="date" class="form-control " id="to_date"
                                                        name="to_date">
                                                </div>

                                                {{-- <div class="single_filterbox filter_btn">
                                                        <button class="view_btn">Search Now</button>
                                                    </div> --}}

                                            </div>
                                        </div>
                                    </form>
                                    @if (!empty($datas))
                                        @php
                                            $projectName = $datas->first()->project->project_name;
                                            $subprojectName = $datas->first()->subproject->name;
                                            $fromDate = $headerDetails['fromDate'];
                                            $toDate = $headerDetails['toDate'];

                                        @endphp
                                    @endif
                                    <div class="status_tab">
                                        <div class="tab-content" id="pills-tabContent">
                                            <div class="processdetails_box">

                                                <div class="process_table">
                                                    <div class="table-responsive" id="formWorkProgressDetails">
                                                        {{-- <table class="table table-bordered "
                                                                id="workProgessDetailsDataTable">
                                                                <thead>
                                                                    <th scope="col">Sl.no</th>
                                                                    <th scope="col">Activities </th>
                                                                    <th scope="col">Unit </th>
                                                                    <th scope="col"> Estimate Qty</th>
                                                                    <th scope="col">Est Rate</th>
                                                                    <th scope="col">Est.Amount</th>
                                                                    <th scope="col">Completed Qty</th>
                                                                    <th scope="col">Est. Amount for Completion</th>
                                                                    <th scope="col">% Completion</th>
                                                                    <th scope="col">Balance qty</th>
                                                                </thead>
                                                                <tbody id="stockMaterial-tab">
                                                                    @if (isset($datas))
                                                                        @foreach ($datas as $key => $data)
                                                                            <tr>
                                                                                <td>{{ $key + 1 }}</td>
                                                                                <td>{{ $data->activities ?? '' }}</td>
                                                                                <td>{{ $data->units->unit ?? '' }}</td>
                                                                                <td>{{ $data->qty }}</td>
                                                                                <td>{{ $data->rate }}</td>
                                                                                <td>{{ $data->qty * $data->rate }}</td>
                                                                                <td>{{ $data->totalQtyInHistory }}</td>
                                                                                <td>{{ $data->totalQtyInHistory * $data->rate }}
                                                                                </td>
                                                                                <td>{{ isset($data->qty) && (int) $data->qty != 0 ? abs((int) $data->totalQtyInHistory / (int) $data->qty) : '' }}
                                                                                </td>

                                                                                <td>{{ $data->qty - $data->totalQtyInHistory }}
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                    @endif
                                                                </tbody>
                                                            </table> --}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- </div> --}}
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        // $(document).ready(function($e) {
        $('#from_project').change(function() {
            var projectId = $(this).val();
            if (projectId) {
                updateSubprojectsDropdown(projectId);
            } else {
                var firstProjectId = $('#from_project').val();
                updateSubprojectsDropdown(firstProjectId);
            }
        });

        function updateSubprojectsDropdown(projectId) {
            $.get(baseUrl + 'company/activities/subprojects/' + projectId, function(data) {
                $('.from_subproject').empty();
                $.each(data, function(key, value) {
                    $.each(value.sub_project, function(subkey, subvalue) {
                        $('.from_subproject').append('<option value="' +
                            subvalue.id + '">' + subvalue.name +
                            '</option>'
                        );
                    });
                });
            });
        }

        // // ****************************************************************************************
        $(document).on('change', '#form-work-progress-details', function() {
            // alert('sdfghj');
            var project = $('#from_project').val();
            var subproject = $('#from_subproject').val();
            var date_from = $('#from_date').val();
            var date_to = $('#to_date').val();
            // alert(project + '/' +
            //     subproject + '/' +
            //     date_from + '/' +
            //     date_to);
            $.ajax({
                url: baseUrl + `ajax/get-form-work-progress-details`,
                type: "POST",
                data: {
                    project: project,
                    subproject: subproject,
                    date_from: date_from,
                    date_to: date_to
                },
                success: function(response) {
                    console.log(response);
                    formWorkProgressDetails(response.activites, response.headerDetails)
                    // alert("json.stringify(response)")

                },
                error: function(error) {
                    // alert(error);
                    console.error("No data found to populate the table." + error);

                }
            });
        });

        function formWorkProgressDetails(data, headerDetails) {
            let tableBody = $('#formWorkProgressDetails');
            tableBody.empty();
            let tableHtml = `
                <table class="table table-bordered" id="formWorkProgressDetailsTable">
                        <thead>
                            <tr>
                                <th>Sl.no</th>
                                <th>Activities</th>
                                <th>Unit</th>
                                <th>Estimate Qty</th>
                                <th>Est Rate</th>
                                <th>Est. Amount</th>
                                <th>Completed Qty</th>
                                <th>Est. Amount for Completion</th>
                                <th>% Completion</th>
                                <th>Balance qty</th>
                            </tr>
                        </thead>
                        <tbody>`;

            if (data && data.length > 0) {
                data.forEach(function(stock) {
                    tableHtml += `
            <tr>
                <td>${stock.sl_no}</td>
                <td>${stock.activities}</td>
                <td>${stock.unit}</td>
                <td>${stock.est_qty}</td>
                <td>${stock.est_rate}</td>
                <td>${stock.est_amount}</td>
                <td>${stock.completed_qty}</td>
                <td>${stock.est_amount_completion}</td>
                <td>${stock.completion}</td>
                <td>${stock.balance_qty}</td>
            </tr>`;
                });
            } else {
                console.error("No data found to populate the table.");
            }

            tableHtml += `

        </tbody>
    </table>`;

            // Append the HTML to tableBody
            tableBody.html(tableHtml);

            // Initialize DataTable with export options
            $('#formWorkProgressDetailsTable').DataTable({
                destroy: true, // Destroy existing table if it exists
                paging: true,
                searching: true,
                ordering: true,
                info: true,
                lengthChange: true,
                pageLength: 10,
                dom: 'Bfrtip', // Include buttons in the DOM
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });

            // let tableHtml = `<table class="table table-bordered " id="formWorkProgressDetailsTable">
        //                 <tr>
        //                     <td>Project${headerDetails.projectId}</td>
        //                     <td>${headerDetails.logo}</td>
        //                 </tr>
        //                 <tr>
        //                     <td>Sub-project${ headerDetails.subProjectId }</td>
        //                     <td>${ headerDetails.fromDate } - ${ headerDetails.toDate }</td>
        //                 </tr>
        //                 <tr>
        //                 <td  colspan="2">
        //                 <table>
        //                 <thead>
        //                     <th scope="col">Sl.no</th>
        //                     <th scope="col">Activities </th>
        //                     <th scope="col">Unit </th>
        //                     <th scope="col"> Estimate Qty</th>
        //                     <th scope="col">Est Rate</th>
        //                     <th scope="col">Est.Amount</th>
        //                     <th scope="col">Completed Qty</th>
        //                     <th scope="col">Est. Amount for Completion</th>
        //                     <th scope="col">% Completion</th>
        //                     <th scope="col">Balance qty</th>
        //                 </thead>
        //                 <tbody>`;

            // if (data && data.length > 0) {
            //                     data.forEach(function(stock) {
            //         tableHtml += `
        //             <tr>
        //                 <td>${stock.sl_no}</td>
        //                 <td>${stock.activities }</td>
        //                 <td>${stock.unit}</td>
        //                 <td>${stock.est_qty}</td>
        //                 <td>${stock.est_rate}</td>
        //                 <td>${stock.est_amount}</td>
        //                 <td>${stock.completed_qty}</td>
        //                 <td>${stock.est_amount_completion}</td>
        //                 <td>${stock.completion}</td>
        //                 <td>${stock.est_amount_completion}</td>
        //             </tr>`
            //     });

            // } else {
            //     console.error("No data found to populate the table.");
            // }

            // tableHtml += '</tbody></table></td></tr></table>';
            // tableBody.html(tableHtml);

            // $('#formWorkProgressDetailsTable').DataTable({
            //     destroy: true,
            //     paging: true,
            //     searching: true,
            //     ordering: true,
            //     info: true,
            //     lengthChange: true,
            //     pageLength: 10,
            //     dom: 'Bfrtip', // Include buttons in the DOM
            //     buttons: [
            //         'copy', 'csv', 'excel', 'pdf', 'print'
            //     ]
            // });

        };


        // ****************************************************************************************
        // ****************************************************************************************
        // ****************************************************************************************
        // ****************************************************************************************
        // ****************************************************************************************
        // ****************************************************************************************


        // });
    </script>
@endpush
