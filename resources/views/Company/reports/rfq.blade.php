@extends('Company.layouts.app')
@section('rfq-active', 'active')
@section('title', __('RFQ'))
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
                        <div>Request for Quote (RFQ)</div>
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
                                        <form id="form-inventory-rfq-details" class="filter-form" {{-- action="{{ route('company.report.workProgressDetails') }}"  --}}
                                            method="POST">
                                            @csrf
                                            <div class="tabcin_head">
                                                <div class="d-flex justify-content-between">
                                                    <div class="singletabcin_head_rfq">
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

                                                    <div class="singletabcin_head_rfq">
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

                                                    <div class="singletabcin_head_rfq">
                                                        <label for="date">Select From Date:</label>
                                                        <input type="date" class="form-control " id="from_date"
                                                            name="from_date">
                                                    </div>
                                                    <div class="singletabcin_head_rfq">
                                                        <label for="date">Select To Date:</label>
                                                        <input type="date" class="form-control " id="to_date"
                                                            name="to_date">
                                                    </div>
                                                    <div class="singletabcin_head_rfq">
                                                        <label for="date">prepared_by:</label>
                                                        {{-- <input type="text" class="form-control " id="prepared_by "
                                                            name="prepared_by"> --}}

                                                        <select name="prepared_by" id="prepared_by" class="form-control ">
                                                            <option value="">---select user---</option>
                                                            {{ getCompanyUserList('') }}
                                                        </select>
                                                    </div>
                                                    <div class="singletabcin_head_rfq">
                                                        <label for="date">RFQ No:</label>
                                                        <input type="text" class="form-control " id="rfq_no"
                                                            name="rfq_no">
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
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
                                                        <div class="table-responsive" id="formInventoryRfqDetails">

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

            // ****************************************************************************************

            $(document).on('change', '#form-inventory-rfq-details', function() {
                // alert('sdfghj');
                var project = $('#from_project').val();
                var subproject = $('#from_subproject').val();
                var date_from = $('#from_date').val();
                var date_to = $('#to_date').val();
                var prepared_by = $('#prepared_by').val();
                var rfq_no = $('#rfq_no').val();
                // alert(project + '/' +
                //     subproject + '/' +
                //     date_from + '/' +
                //     date_to);
                $.ajax({
                    url: baseUrl + `ajax/get-inventory-rfq`,
                    type: "POST",
                    data: {
                        project: project,
                        subproject: subproject,
                        date_from: date_from,
                        date_to: date_to,
                        prepared_by: prepared_by,
                        rfq_no: rfq_no
                    },
                    success: function(response) {
                        console.log(response);
                        formInventoryRfqDetails(response.material);
                        // alert(json.stringify(response))
                    },
                    error: function(error) {
                        console.log(error);
                        // alert(error);
                    }
                });
            });


            function formInventoryRfqDetails(data) {
                let tableBody = $('#formInventoryRfqDetails');
                tableBody.empty();
                let tableHtml = `  <table class="table table-bordered "id="formInventoryRfqDetailsTable">
                                    <thead>
                                        <th scope="col">Sl.no</th>
                                        <th scope="col">Code</th>
                                        <th scope="col">Materials Names </th>
                                        <th scope="col">Specification </th>
                                        <th scope="col"> Unit</th>
                                        <th scope="col">Request Quantity </th>
                                        <th scope="col">Request Date</th>
                                        <th scope="col">Price</th>
                                    </thead>
                                    <tbody>`;
                if (data && data.length > 0) {
                    // Populate table rows with data
                    data.forEach(function(stock) {
                        tableHtml += `
                <tr>
                    <td>${valueChecking(stock.sl_no)}</td>
                    <td>${valueChecking(stock.code )}</td>
                    <td>${valueChecking(stock.name)}</td>
                    <td>${valueChecking(stock.specification)}</td>
                    <td>${valueChecking(stock.unit)}</td>
                    <td>${valueChecking(stock.required_qty)}</td>
                    <td>${valueChecking(stock.required_date)}</td>
                    <td>${valueChecking(stock.quote_rate)}</td>
                </tr>`
                    });
                } else {
                    console.error("No data found to populate the table.");
                }
                tableHtml += '</tbody></table>';
                tableBody.html(tableHtml);
                initializeDataTable('#formInventoryRfqDetailsTable');
            };

            //     "material": [
            // {
            //     "id": 5,
            //     "code": null,
            //     "name": null,
            //     "specification": null,
            //     "unit": "kgs",
            //     "required_qty": 0,
            //     "required_date": 0,
            //     "quote_rate": 0
            // }

            // ****************************************************************************************
            // ****************************************************************************************
            // ****************************************************************************************
            // ****************************************************************************************
            // ****************************************************************************************
            // ****************************************************************************************


        });
    </script>
@endpush
