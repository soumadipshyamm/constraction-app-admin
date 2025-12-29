@extends('Company.layouts.app')
@section('resourcesUsageFromDPR-active', 'active')
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
                        <div>Resources Usage From DPR
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

                                        @php
                                            if (isset($datas)) {
                                                $projectName = $datas->first()->project->project_name;
                                                $subprojectName = $datas->first()->subproject->name;
                                                $fromDate = $headerDetails['fromDate'];
                                                $toDate = $headerDetails['toDate'];
                                            }
                                        @endphp

                                        <div class="status_tab">
                                            <form id="filter-inventory-stock-details"
                                                class="filter-form filter-inventory-stock-details">
                                                <ul class="nav nav-pills mb-3" id="materialpills-tab" role="tablist">
                                                    <li class="nav-item" role="presentation">
                                                        <button class="nav-link active" id="pills-material-tab"
                                                            data-bs-toggle="pill" data-bs-target="#pills-material"
                                                            type="button" role="tab" aria-controls="pills-material"
                                                            data-name="material" aria-selected="true">Date</button>
                                                    </li>
                                                    <li class="nav-item" role="presentation">
                                                        <button class="nav-link" id="pills-machine-tab"
                                                            data-bs-toggle="pill" data-bs-target="#pills-machine"
                                                            type="button" role="tab" aria-controls="pills-machine"
                                                            data-name="machine" aria-selected="false">Details Day
                                                            wise</button>
                                                    </li>
                                                </ul>
                                            </form>

                                            <div class="tab-content" id="pills-tabContent">
                                                <div class="tab-pane fade show active" id="pills-material" role="tabpanel"
                                                    aria-labelledby="pills-material-tab">
                                                    <div class="processdetails_box">
                                                        <div class="process_filter">
                                                            <form id="resources-usage-from-dpr-date" class="filter-form"
                                                                {{-- action="{{ route('company.report.resourcesUsageFromDPR') }}" --}} method="POST">
                                                                @csrf
                                                                <div class="tabcin_head">
                                                                    <div class="d-flex justify-content-between">
                                                                        <div class="singletabcin_head">
                                                                            <label for="">Project <span
                                                                                    class="text-danger">*</span></label>
                                                                            <select class="form-control from_project"
                                                                                value="{{ old('from_project') }}"
                                                                                name="from_project" id="from_project">
                                                                                <option>---select project---</option>
                                                                                {{ getProject('$data->project_id') }}
                                                                            </select>
                                                                            @if ($errors->has('project'))
                                                                                <div class="error">
                                                                                    {{ $errors->first('project') }}</div>
                                                                            @endif
                                                                        </div>

                                                                        <div class="singletabcin_head">
                                                                            <label for="">Sub Project </label>
                                                                            <select
                                                                                class="form-control mySelect22 from_subproject"
                                                                                value="{{ old('from_subproject') }}"
                                                                                name="from_subproject" id="from_subproject">
                                                                                <option value="">----Select
                                                                                    SubProject----
                                                                                </option>
                                                                            </select>
                                                                            @if ($errors->has('subproject'))
                                                                                <div class="error">
                                                                                    {{ $errors->first('subproject') }}</div>
                                                                            @endif
                                                                        </div>

                                                                        <div class="singletabcin_head">
                                                                            <label for="date">Select From Date:</label>
                                                                            <input type="date" class="form-control "
                                                                                id="dateInput" name="dateInput">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <div class="process_table">
                                                            <div class="table-responsive" id="resourcesDprDateMaterials">

                                                            </div>
                                                        </div>
                                                        <br>
                                                        <br>
                                                        <div class="process_table">
                                                            <div class="table-responsive" id="resourcesDprDateLabours">
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <br>
                                                        <div class="process_table">
                                                            <div class="table-responsive" id="resourcesDprDateAssets">

                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- ********************************************************************************************* --}}
                                                <div class="tab-pane fade" id="pills-machine" role="tabpanel"
                                                    aria-labelledby="pills-machine-tab">
                                                    <div class="processdetails_box">
                                                        <div class="process_filter">
                                                            <form id="resources-usage-from-dpr-days" class="filter-form"
                                                                {{-- action="{{ route('company.report.resourcesUsageFromDPR') }}" --}} method="POST">
                                                                @csrf
                                                                <div class="tabcin_head">
                                                                    <div class="d-flex justify-content-between">
                                                                        <div class="singletabcin_head">
                                                                            <label for="">Project <span
                                                                                    class="text-danger">*</span></label>
                                                                            <select class="form-control from_project"
                                                                                value="{{ old('from_project') }}"
                                                                                name="from_projects" id="from_projects">
                                                                                <option>---select project---</option>
                                                                                {{ getProject('$data->project_id') }}
                                                                            </select>
                                                                            @if ($errors->has('project'))
                                                                                <div class="error">
                                                                                    {{ $errors->first('project') }}</div>
                                                                            @endif
                                                                        </div>

                                                                        <div class="singletabcin_head">
                                                                            <label for="">Sub Project </label>
                                                                            <select
                                                                                class="form-control mySelect22 from_subproject"
                                                                                value="{{ old('from_subprojects') }}"
                                                                                name="from_subprojects"
                                                                                id="from_subprojects">
                                                                                <option value="">----Select
                                                                                    SubProject----</option>
                                                                            </select>
                                                                            @if ($errors->has('subproject'))
                                                                                <div class="error">
                                                                                    {{ $errors->first('subproject') }}
                                                                                </div>
                                                                            @endif
                                                                        </div>

                                                                        <div class="singletabcin_head">
                                                                            <label for="date">Select From Date:</label>
                                                                            <input type="date" class="form-control "
                                                                                id="from_date" name="from_date">
                                                                        </div>

                                                                        <div class="singletabcin_head">
                                                                            <label for="date">Select To Date:</label>
                                                                            <input type="date" class="form-control "
                                                                                id="to_date" name="to_date">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <div class="process_table mb-3">
                                                            <h6 class="font-weight-bold">Materials</h6>
                                                            <div class="table-responsive"
                                                                id="resourcesUsageFromDprDaysMaterials">
                                                            </div>
                                                        </div>
                                                        <div class="process_table mb-3">
                                                            <h6 class="font-weight-bold">Labour</h6>
                                                            <div class="table-responsive"
                                                                id="resourcesUsageFromDprDaysLabours">
                                                            </div>
                                                        </div>
                                                        <div class="process_table mb-3">
                                                            <h6 class="font-weight-bold">Equipments/Machinery</h6>
                                                            <div class="table-responsive"
                                                                id="resourcesUsageFromDprDaysAssets">
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

                // Get today's date
                let today = new Date();

                // Format the date to YYYY-MM-DD (required by <input type="date">)
                let dd = String(today.getDate()).padStart(2, '0');
                let mm = String(today.getMonth() + 1).padStart(2, '0'); // January is 0!
                let yyyy = today.getFullYear();

                let formattedDate = yyyy + '-' + mm + '-' + dd;

                // Set the value of the input field
                document.getElementById('dateInput').value = formattedDate;


                $('.from_project').on('change focus', function() {
                    var projectId = $(this).val();
                    if (projectId) {
                        updateSubprojectsDropdown(projectId);
                    } else {
                        // Select the first project option if none is selected
                        var firstProjectId = $('.from_project option:eq(1)').val();
                        $('.from_project option:eq(1)').prop('selected', true);
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
                $('#resources-usage-from-dpr-date').on('change focus', function() {
                    project = $('#from_project').val();
                    subproject = $('#from_subproject').val();
                    date = $('#dateInput').val();
                    filterName = 'date';
                    // alert('filter-form-work-process');
                    console.log(project + '/' + subproject + '/' + date);

                    $.ajax({
                        url: baseUrl + `ajax/get-resources-usage-from-dpr-date`,
                        type: "post",
                        data: {
                            project: project,
                            subproject: subproject,
                            date: date,
                            filterName: filterName
                        },
                        success: function(response) {
                            // console.log("------", response);
                            //alert(JSON.stringify(response));
                            resourcesDprDateMaterials(response.material);
                            resourcesDprDateLabours(response.labour);
                            resourcesDprDateAssets(response.assets);
                        },
                        error: function(error) {
                            console.log("------", error);

                        }
                    });
                });

                // ****************************************************************************************
                function resourcesDprDateMaterials(data) {
                    let tableBody = $('#resourcesDprDateMaterials');
                    tableBody.empty();

                    let tableHtml = `<table class="table table-bordered dataTable" id="resourcesDprDateMaterialsTable">
                            <thead>
                                <th scope="col">Code </th>
                                <th scope="col">Materials </th>
                                <th scope="col">Specification</th>
                                <th scope="col">Unit</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Rate</th>
                                <th scope="col">Amount</th>
                            </thead>
                            <tbody>`;

                    if (data && data.length > 0) {
                        // Populate table rows with data
                        data.forEach(function(stock) {
                            tableHtml += `
                        <tr>
                            <td>${valueChecking(stock.code)}</td>
                            <td>${valueChecking(stock.name)}</td>
                            <td>${valueChecking(stock.specification )}</td>
                            <td>${valueChecking(stock.unit)}</td>
                            <td>${valueChecking(stock.qty)}</td>
                            <td>${valueChecking(stock.qty)}</td>
                            <td>${valueChecking(stock.qty)}</td>
                        </tr>`
                        });
                        // tableHtml += `
                //    <td>${data.total}</td>`

                    }

                    tableHtml += '</tbody></table>';
                    tableBody.html(tableHtml);

                    initializeDataTable('#resourcesDprDateMaterialsTable');
                }

                function resourcesDprDateLabours(data) {
                    let tableBody = $('#resourcesDprDateLabours');
                    tableBody.empty();

                    let tableHtml = `<table class="table table-bordered dataTable" id="resourcesDprDateLaboursTable">
                            <thead>
                                <th scope="col">Code</th>
                                <th scope="col">Labour Details </th>
                                <th scope="col">Unit</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">OT Quantity</th>
                                <th scope="col">Rate</th>
                                <th scope="col">Amount</th>
                            </thead>
                            <tbody>`;

                    if (data && data.length > 0) {
                        // Populate table rows with data
                        data.forEach(function(stock) {
                            tableHtml += `
                        <tr>
                            <td>${valueChecking(stock.id)}</td>
                            <td>${valueChecking(stock.name)}</td>
                            <td>${valueChecking(stock.unit)}</td>
                            <td>${valueChecking(stock.qty )}</td>
                            <td>${valueChecking(stock.ot_qtu)}</td>
                            <td>${valueChecking(stock.rate)}</td>
                            <td>${valueChecking(stock.amount)}</td>
                        </tr>`
                        });
                        // tableHtml += `
                //     <tr> <td>${data.total}</td></tr>`
                    } else {
                        console.error("No data found to populate the table.");
                    }

                    tableHtml += '</tbody></table>';
                    tableBody.html(tableHtml);

                    initializeDataTable('#resourcesDprDateLaboursTable');
                }

                function resourcesDprDateAssets(data) {
                    let tableBody = $('#resourcesDprDateAssets');
                    tableBody.empty();

                    let tableHtml = `<table class="table table-bordered dataTable" id="resourcesDprDateAssetsTable">
                            <thead>
                                <th scope="col">Code </th>
                                <th scope="col">Machinery Names  </th>
                                <th scope="col">Specification</th>
                                <th scope="col">Unit</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Rate</th>
                                <th scope="col">Amount</th>
                            </thead>
                            <tbody>`;

                    if (data && data.length > 0) {
                        // Populate table rows with data
                        data.forEach(function(stock) {
                            tableHtml += `
                        <tr>
                            <td>${valueChecking(stock.code)}</td>
                            <td>${valueChecking(stock.name)}</td>
                            <td>${valueChecking(stock.specification )}</td>
                            <td>${valueChecking(stock.unit)}</td>
                            <td>${valueChecking(stock.qty)}</td>
                            <td>${valueChecking(stock.rate)}</td>
                            <td>${valueChecking(stock.amount)}</td>
                        </tr>`
                        });
                        // tableHtml += `
                //     <tr> <td>${data.total}</td></tr>`

                    }

                    tableHtml += '</tbody></table>';
                    tableBody.html(tableHtml);

                    initializeDataTable('#resourcesDprDateAssetsTable');
                }


                // ****************************************************************************************
                // ****************************************************************************************
                $('#resources-usage-from-dpr-days').on('change focus', function() {
                    project = $('#from_projects').val();
                    subproject = $('#from_subprojects').val();
                    from_date = $('#from_date').val();
                    to_date = $('#to_date').val();
                    filterName = 'days';

                    // alert(project + '/' + subproject + '/' + from_date + '/' + to_date);
                    // console.log(project + '/' + subproject + '/' + from_date + '/' + to_date);

                    $.ajax({
                        url: baseUrl + `ajax/get-resources-usage-from-dpr-days`,
                        type: "post",
                        data: {
                            project: project,
                            subproject: subproject,
                            from_date: from_date,
                            to_date: to_date,
                            filterName: filterName
                        },
                        success: function(response) {
                            resourcesUsageFromDprDaysMaterials(response.material);
                            resourcesUsageFromDprDaysLabours(response.labour);
                            resourcesUsageFromDprDaysAssets(response.assets);
                            // console.log("------", response);
                            // alert(JSON.stringify(response));
                        },
                        error: function(error) {
                            console.log("------", error);
                        }
                    });
                });

                // ****************************************************************************************
                // ****************************************************************************************

                function resourcesUsageFromDprDaysMaterials(data) {
                    let tableBody = $('#resourcesUsageFromDprDaysMaterials');
                    tableBody.empty();

                    let tableHtml = `<table class="table table-bordered dataTable" id="resourcesUsageFromDprDaysMaterialsTable">
                            <thead>
                                <th scope="col">Date</th>
                                <th scope="col">Code</th>
                                <th scope="col">Materials </th>
                                <th scope="col">Specification</th>
                                <th scope="col">Unit</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Rate</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Work Details</th>
                                <th scope="col">Entered By</th>
                                <th scope="col">Remarks</th>
                            </thead>
                            <tbody>`;

                    if (data && data.length > 0) {
                        // Populate table rows with data
                        data.forEach(function(stock) {
                            tableHtml += `
                                <tr>
                                    <td>${valueChecking(stock.date)}</td>
                                    <td>${valueChecking(stock.code)}</td>
                                    <td>${valueChecking(stock.name)}</td>
                                    <td>${valueChecking(stock.specification)}</td>
                                    <td>${valueChecking(stock.unit)}</td>
                                    <td>${valueChecking(stock.qty )}</td>
                                    <td>${valueChecking(stock.rate )}</td>
                                    <td>${valueChecking(stock.amount )}</td>
                                    <td>${valueChecking(stock.work_details )}</td>
                                    <td>${valueChecking(stock.entered_by )}</td>
                                    <td>${valueChecking(stock.remarks )}</td>
                                </tr>`;

                        });
                        // tableHtml += `
                //    <td>${data.total}</td>`
                    }

                    tableHtml += '</tbody></table>';
                    tableBody.html(tableHtml);
                    initializeDataTable('#resourcesUsageFromDprDaysMaterialsTable');
                }

                function resourcesUsageFromDprDaysLabours(data) {
                    let tableBody = $('#resourcesUsageFromDprDaysLabours');
                    tableBody.empty();

                    let tableHtml = `<table class="table table-bordered dataTable" id="resourcesUsageFromDprDaysLaboursTable">
                            <thead>
                                <th scope="col">Date</th>
                                <th scope="col">Code</th>
                                <th scope="col">Labour Details </th>
                                <th scope="col">Unit</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">OT Quantity</th>
                                <th scope="col">Rate</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Work Details</th>
                                <th scope="col">Entered By</th>
                                <th scope="col">Remarks</th>
                                <th scope="col">Labour Contracor</th>
                            </thead>
                            <tbody>`;

                    if (data && data.length > 0) {
                        // Populate table rows with data
                        data.forEach(function(stock) {
                            tableHtml += `
                            <tr>
                                <td>${valueChecking(stock.date)}</td>
                                <td>${valueChecking(stock.id )}</td>
                                <td>${valueChecking(stock.name )}</td>
                                <td>${valueChecking(stock.unit )}</td>
                                <td>${valueChecking(stock.qty)}</td> <!-- Default to 0 if null -->
                                <td>${valueChecking(stock.ot_qtu)}</td> <!-- Default to 0 if null -->
                                <td>${valueChecking(stock.rate)}</td> <!-- Default to 0 if null -->
                                <td>${valueChecking(stock.amount)}</td> <!-- Default to 0 if null -->
                                <td>${valueChecking(stock.work_details )}</td>
                                <td>${valueChecking(stock.entered_by )}</td>
                                <td>${valueChecking(stock.remarks )}</td>
                                <td>${valueChecking(stock.labour_contracor )}</td>
                            </tr>`;

                        });
                        // tableHtml += `
                //     <tr> <td>${data.total}</td></tr>`

                    }

                    tableHtml += '</tbody></table>';
                    tableBody.html(tableHtml);
                    initializeDataTable('#resourcesUsageFromDprDaysLaboursTable');

                }

                function resourcesUsageFromDprDaysAssets(data) {
                    let tableBody = $('#resourcesUsageFromDprDaysAssets');
                    tableBody.empty();

                    let tableHtml = `<table class="table table-bordered dataTable" id="resourcesUsageFromDprDaysAssetsTable">
                            <thead>
                                <th scope="col">Date</th>
                                <th scope="col">Code</th>
                                <th scope="col">Machinery Names  </th>
                                <th scope="col">Specification</th>
                                <th scope="col">Unit</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Rate</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Work Details</th>
                                <th scope="col">Entered By</th>
                                <th scope="col">Remarks</th>
                                <th scope="col">Contracor Supplier</th>
                            </thead>
                            <tbody>`;

                    if (data && data.length > 0) {
                        // Populate table rows with data
                        data.forEach(function(stock) {
                            tableHtml += `
                            <tr>
                                <td>${valueChecking(stock.date )}</td>
                                <td>${valueChecking(stock.code )}</td>
                                <td>${valueChecking(stock.name )}</td>
                                <td>${valueChecking(stock.specification )}</td>
                                <td>${valueChecking(stock.unit )}</td>
                                <td>${valueChecking(stock.qty)}</td> <!-- Default to 0 if null -->
                                <td>${valueChecking(stock.rate)}</td> <!-- Default to 0 if null -->
                                <td>${valueChecking(stock.amount)}</td> <!-- Default to 0 if null -->
                                <td>${valueChecking(stock.work_details )}</td>
                                <td>${valueChecking(stock.entered_by )}</td>
                                <td>${valueChecking(stock.remarks )}</td>
                                <td>${valueChecking(stock.contracor_supplier )}</td>
                            </tr>`;
                        });
                        // tableHtml += `
                //     <tr> <td>${data.total}</td></tr>`
                    }

                    tableHtml += '</tbody></table>';
                    tableBody.html(tableHtml);
                    initializeDataTable('#resourcesUsageFromDprDaysAssetsTable');

                }
            });
        </script>
    @endpush
