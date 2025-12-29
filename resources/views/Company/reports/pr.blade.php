@extends('Company.layouts.app')
@section('workProgressDetails-active', 'active')
@section('title', __('Dashboard'))
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
                        <div>Indent (Purchase Request)
                        </div>
                    </div>
                    <div class="page-title-actions">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="row">
                    <div class="col-md-12">
                        <div class="main_wrapper">
                            <div class="main_card mb-3">
                                <div class="card_content">
                                    <div class="tab-content" id="nav-tabContent">
                                        <div id="form-inventory-pr" class="filter-form">
                                            @csrf
                                            <div class="tabcin_head">
                                                <div class="d-flex justify-content-between">
                                                    <div class="singletabcin_head">
                                                        <label for="">Project <span
                                                                class="text-danger">*</span></label>
                                                        <select class="form-control from_project"
                                                            value="{{ old('from_project') }}" name="from_project"
                                                            id="from_project">
                                                            <option value="">---select project---</option>
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
                                                    <div class="singletabcin_head">
                                                        <label for="indent_no">Indent No:</label>
                                                        <input type="text" class="form-control " id="indent_no"
                                                            name="indent_no" placeholder=" Enter Indent No.">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @php
                                            if (isset($datas)) {
                                                $projectName = $datas->first()->project->project_name;
                                                $subprojectName = $datas->first()->subproject->name;
                                                $fromDate = $headerDetails['fromDate'];
                                                $toDate = $headerDetails['toDate'];
                                            }
                                        @endphp
                                        <div class="status_tab">
                                            <div class="tab-content" id="pills-tabContent">
                                                <div class="processdetails_box">
                                                    <div class="process_table">
                                                        <div class="table-responsive" id="formInventorypr">

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
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function($e) {
            $('#from_project').change(function() {
                var projectId = $(this).val();
                if (projectId) {
                    updateSubprojectsDropdown(projectId);
                } else {
                    // Select the first project option if none is selected
                    var firstProjectId = $('#from_project option:eq(1)').val();
                    $('#from_project option:eq(1)').prop('selected', true);
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
        });
        // ****************************************************************************************
        $(document).on('change', '#form-inventory-pr', function() {
            var project = $('#from_project').val();
            var subproject = $('#from_subproject').val();
            var date_from = $('#from_date').val();
            var date_to = $('#to_date').val();
            var indent_no = $('#indent_no').val();

            $.ajax({
                url: baseUrl + `ajax/get-inventory-pr`,
                type: "POST",
                data: {
                    project: project,
                    subproject: subproject,
                    date_from: date_from,
                    date_to: date_to,
                    indent_no: indent_no
                },
                success: function(response) {
                    console.log(response);
                    formInventorypr(response.material);
                    // alert("json.stringify(response)")
                },
                error: function(error) {
                    // alert(error);
                }
            });
        });

        function formInventorypr(data) {
            let tableBody = $('#formInventorypr');
            tableBody.empty();

            let tableHtml = `<table class="table table-bordered dataTable" id="formInventoryprTable">
                            <thead>
                                <th scope="col">Sr.No</th>
                                <th scope="col">Code </th>
                                <th scope="col">Materials</th>
                                <th scope="col">Specification</th>
                                <th scope="col">Unit</th>
                                <th scope="col">Required qty</th>
                                <th scope="col">Required date</th>
                                <th scope="col">Required for Activities</th>
                                <th scope="col">Remarks</th>
                                <th scope="col">Current Stock</th>
                            </thead>
                            <tbody>`;

            if (data && data.length > 0) {
                // Populate table rows with data
                data.forEach(function(stock) {
                    tableHtml += `
                       <tr>
                    <td>${stock.sl_no || ' '}</td>
                    <td>${stock.code || ' '}</td>
                    <td>${stock.name || ' '}</td>
                    <td>${stock.specification || ' '}</td>
                    <td>${stock.unit || ' '}</td>
                    <td>${stock.totalRequiredQty || 0}</td>
                    <td>${stock.totalRequiredDate || ' '}</td>
                    <td>${stock.requiredforActivities || ' '}</td>
                    <td>${stock.remarks || ' '}</td>
                    <td>${stock.currentStock || 0}</td>
                </tr>`;
                });

            }

            // else {
            //     tableHtml += `
        //            <tr> <td>No data available in table</td>
        //     </tr>`;
            // }

            tableHtml += '</tbody></table>';
            tableBody.html(tableHtml);


            $('#formInventoryprTable').DataTable({
                destroy: true,
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

        };
    </script>
@endpush
