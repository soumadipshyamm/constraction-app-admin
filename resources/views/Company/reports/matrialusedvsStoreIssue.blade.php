@extends('Company.layouts.app')
@section('matrialusedVsStoreIssue-active', 'active')
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
                        <div>Matrial Used Vs Store Issue</div>
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
                                        <form id="matrial-used-vs-store-issue" class="filter-form" {{-- action="{{ route('company.report.workProgressDetails') }}"  --}}
                                            method="POST">
                                            @csrf
                                            <div class="tabcin_head">
                                                <div class="d-flex justify-content-between">
                                                    <div class="singletabcin_head singletabcin_head_msi ">
                                                        <label for="">Project <span
                                                                class="text-danger">*</span></label>
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

                                                    <div class="singletabcin_head singletabcin_head_msi ">
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
                                                    <div class="singletabcin_head singletabcin_head_msi ">
                                                        <label for="">Stores </label>
                                                        <select class="form-control mySelect22 from_store"
                                                            value="{{ old('from_store') }}" name="from_store"
                                                            id="from_store">
                                                            <option value="">----Select Stores----</option>
                                                            {{-- {{ getStoreWarehouses('') }} --}}
                                                            {{-- {{ getStoreWarehouseByProject() }} --}}
                                                        </select>
                                                        @if ($errors->has('store'))
                                                            <div class="error">{{ $errors->first('store') }}</div>
                                                        @endif
                                                    </div>

                                                    <div class="singletabcin_head singletabcin_head_msi ">
                                                        <label for="date">Select From Date:</label>
                                                        <input type="date" class="form-control " id="from_date"
                                                            name="from_date">
                                                    </div>

                                                    <div class="singletabcin_head singletabcin_head_msi ">
                                                        <label for="date">Select To Date:</label>
                                                        <input type="date" class="form-control " id="to_date"
                                                            name="to_date">
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
                                                        <div class="table-responsive" id="matrialUsedStoreIssue">

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
                    updateStoresDropdown(projectId); // New line to update stores
                } else {
                    // Select the first project option if none is selected
                    var firstProjectId = $('#from_project option:eq(1)').val();
                    $('#from_project option:eq(1)').prop('selected', true);
                    updateSubprojectsDropdown(firstProjectId);
                    updateStoresDropdown(firstProjectId); // New line to update stores
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



            function updateStoresDropdown(projectId) { // New function to update stores
                $.get(baseUrl + 'company/activities/projectsstore/' + projectId, function(data) {
                    $('.from_store').empty();
                    $('.from_store').append(
                        '<option value="">----Select Stores----</option>'); // Reset the stores dropdown
                    $.each(data, function(key, value) {
                        $('.from_store').append('<option value="' + value.id + '">' + value.name +
                            '</option>');
                    });
                });
            }
            // ****************************************************************************************
            $(document).on('change', '#matrial-used-vs-store-issue', function() {
                // alert('sdfghj');
                var project = $('#from_project').val();
                var subproject = $('#from_subproject').val();
                var store = $('#from_store').val();
                var date_from = $('#from_date').val();
                var date_to = $('#to_date').val();

                $.ajax({
                    url: baseUrl + `ajax/get-matrial-used-vs-store-issue`,
                    type: "POST",
                    data: {
                        project: project,
                        subproject: subproject,
                        store: store,
                        from_date: date_from,
                        to_date: date_to
                    },
                    success: function(response) {
                        console.log(response);
                        matrialUsedStoreIssue(response.material);
                        // alert("json.stringify(response)")
                    },
                    error: function(error) {
                        alert(error);
                    }
                });
            });

            function matrialUsedStoreIssue(data) {
                console.log(data);
                let tableBody = $('#matrialUsedStoreIssue');
                tableBody.empty();
                let tableHtml = `<table class="table table-bordered dataTable" id="matrialUsedStoreIssueTable">
                            <thead>
                                <th scope="col">Code </th>
                                <th scope="col">Machinery Names  </th>
                                <th scope="col">Specification</th>
                                <th scope="col">Unit</th>
                                <th scope="col">Issue Qty</th>
                                <th scope="col">DPR Qty</th>
                                <th scope="col">Variation</th>
                            </thead>
                            <tbody>`;
                if (data && data.length > 0) {
                    // Populate table rows with data
                    data.forEach(function(stock) {
                        tableHtml += `
                            <tr>
                                <td>${valueChecking(stock.code || ' ')}</td>
                                <td>${valueChecking(stock.name || ' ')}</td>
                                <td>${valueChecking(stock.specification || ' ')}</td>
                                <td>${valueChecking(stock.unit || ' ')}</td>
                                <td>${valueChecking(stock.issue_qty || 0)}</td>
                                <td>${valueChecking(stock.dpr_qty || 0)}</td>
                                <td>${valueChecking(stock.variation || ' ')}</td>
                            </tr>`;
                    });
                }
                tableHtml += '</tbody></table>';
                tableBody.html(tableHtml);
                initializeDataTable('#matrialUsedStoreIssueTable');
                // ****************************************************************************************
            };
        });
    </script>
@endpush
