@extends('Company.layouts.app')
@section('ProjectStockStatement-active', 'active')
@section('title', __('Project Stock Statement'))
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
                        <div>Project Stock Statement </div>
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
                                        <form id="form-report-inventory-project-stock" class="filter-form"
                                            {{-- action="{{ route('company.report.workProgressDetails') }}"  --}} method="POST">
                                            @csrf
                                            <div class="tabcin_head">
                                                <div class="d-flex justify-content-between">
                                                    <div class="singletabcin_head">
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

                                                    <div class="singletabcin_head">
                                                        <label for="">Store</label>
                                                        <select class="form-control mySelect22 from_store"
                                                            value="{{ old('from_store') }}" name="from_store"
                                                            id="from_store">
                                                            <option value="">----Select Store----</option>
                                                            {{ getStoreWarehouses('') }}
                                                        </select>
                                                        @if ($errors->has('from_store'))
                                                            <div class="error">{{ $errors->first('from_store') }}</div>
                                                        @endif
                                                    </div>

                                                    {{-- <div class="singletabcin_head">
                                                        <label for="date">Select Date:</label>
                                                        <input type="date" class="form-control " id="date"
                                                            name="date">
                                                    </div>
                                                    <div class="singletabcin_head">
                                                        <label for="search">Search:</label>
                                                        <input type="text" class="form-control " id="search"
                                                            name="search">
                                                    </div> --}}
                                                </div>
                                            </div>
                                            <div class="status_tab">
                                                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                                    <li class="nav-item" role="presentation">
                                                        <button class="nav-link  active filterformworkprocessdetails"
                                                            id="pills-completed-tab" data-bs-toggle="pill"
                                                            data-bs-target="#pills-completed" type="button" role="tab"
                                                            data-name="material" aria-controls="pills-completed"
                                                            aria-selected="false">Material<span></span></button>
                                                    </li>
                                                    <li class="nav-item" role="presentation">
                                                        <button class="nav-link  filterformworkprocessdetails"
                                                            id="pills-inprogress-tab" data-bs-toggle="pill"
                                                            data-bs-target="#pills-inprogress" type="button" role="tab"
                                                            aria-controls="pills-inprogress" data-name="assets"
                                                            aria-selected="true">Assets<span></span></button>
                                                    </li>

                                                </ul>
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
                                                        <div class="table-responsive formReportInventoryProjectStock"
                                                            id="formReportInventoryProjectStock">

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
        // $('#from_project').change(function() {
        //     var projectId = $(this).val();
        //     if (projectId) {
        //         updateSubprojectsDropdown(projectId);
        //     } else {
        //         // Select the first project option if none is selected
        //         var firstProjectId = $('#from_project option:eq(1)').val();
        //         $('#from_project option:eq(1)').prop('selected', true);
        //         updateSubprojectsDropdown(firstProjectId);

        //         // Fetch details for the first project and its first subproject and date
        //         if (firstProjectId) {
        //             var firstSubprojectId = $('#from_subproject option:eq(1)').val();
        //             var firstDate = $('#date option:eq(1)').val();
        //             fetchWorkOverview(firstProjectId, firstSubprojectId, firstDate);
        //         }

        //     }
        // });

        // function updateSubprojectsDropdown(projectId) {
        //     $.get(baseUrl + 'company/activities/subprojects/' + projectId, function(data) {
        //         $('.from_subproject').empty();
        //         $.each(data, function(key, value) {
        //             $.each(value.sub_project, function(subkey, subvalue) {
        //                 $('.from_subproject').append('<option value="' +
        //                     subvalue.id + '">' + subvalue.name +
        //                     '</option>'
        //                 );
        //             });
        //         });
        //     });
        // }

        // ****************************************************************************************

        // ****************************************************************************************

        $(document).ready(function() {
            // Function to handle AJAX request
            function sendAjaxRequest() {
                var project = $('#from_project').val();
                var store = $('#from_store').val();
                // var search = $('#search').val();
                // var date = $('#date').val();
                var type = $('.nav-link.filterformworkprocessdetails.active').data(
                    'name'); // Fetch type from active button

                // Logging for debugging
                // console.log(project, store ,type);

                // AJAX request
                $.ajax({
                    url: baseUrl + `ajax/get-inventory-project-stock`,
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        project: project,
                        store: store,
                        // search: search,
                        // date: date,
                        type: type
                    },
                    success: function(response) {
                        console.log(response);
                        // alert(type)
                        switch (type) {
                            case 'material':
                                formReportInventoryProjectStockmaterial(response.material)
                                break;
                            case 'assets':
                                formReportInventoryProjectStockassets(response.assets)
                                break;
                        }
                        // Handle response data as needed
                    },
                    error: function(error) {
                        console.error('Error:', error);
                        // alert('Error occurred while fetching data.');
                    }
                });
            }

            // Handle click on tab buttons
            $('.nav-link.filterformworkprocessdetails').on('click', function() {
                // Remove active class from all tabs and add to clicked tab
                $('.nav-link.filterformworkprocessdetails').removeClass('active');
                $(this).addClass('active');

                // Trigger AJAX request
                sendAjaxRequest();
            });

            // Initial AJAX request when form values change
            $(document).on('change', '#form-report-inventory-project-stock', function() {
                sendAjaxRequest();
            });
        });

        // ****************************************************************************************

        function safeValue(value) {
            return value !== null ? value : ' ';
        }

        function formReportInventoryProjectStockmaterial(data) {
            // alert(JSON.stringify(data))
            let tableBody = $('.formReportInventoryProjectStock');
            tableBody.empty();
            let tableHtml = `<table class="table table-bordered " id="formReportInventoryProjectStockmaterialTable">
                                    <thead>
                                        <th scope="col">Sl.no</th>
                                        <th scope="col"> Class </th>
                                        <th scope="col"> Code </th>
                                        <th scope="col"> Name </th>
                                        <th scope="col">Specification</th>
                                        <th scope="col"> Unit</th>
                                        <th scope="col">Total Inward</th>
                                        <th scope="col">Total Issue</th>
                                        <th scope="col">Available Stock</th>
                                    </thead>
                                    <tbody> `;
            if (data) {
                console.log(data);
                // Populate table rows with data
                $.each(data, function(key, stock) {
                    console.log(stock);
                    tableHtml += `
                    <tr>
                        <td>${stock.sl_no !== null ? stock.sl_no : ' '}</td>
                        <td>${stock.class !== null ? stock.class : ' '}</td>
                        <td>${stock.code !== null ? stock.code : ' '}</td>
                        <td>${stock.name !== null ? stock.name : ' '}</td>
                        <td>${stock.specification !== null ? stock.specification : ' '}</td>
                        <td>${stock.unit !== null ? stock.unit : ' '}</td>
                        <td>${stock.total_inward !== null ? stock.total_inward : ' '}</td>
                        <td>${stock.total_issue !== null ? stock.total_issue : ' '}</td>
                        <td>${stock.available_stock !== null ? stock.available_stock : ' '}</td>
                    </tr>`
                });
            } else {
                console.error("No data found to populate the table.");
            }
            tableHtml += '</tbody></table>';
            tableBody.html(tableHtml);

            $('#formReportInventoryProjectStockmaterialTable').DataTable({
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

        function formReportInventoryProjectStockassets(data) {
            // alert(JSON.stringify(data))
            let tableBody = $('.formReportInventoryProjectStock');
            tableBody.empty();
            let tableHtml = `<table class="table table-bordered " id="formReportInventoryProjectStockassetsTable">
                            <thead>
                                <th scope="col">Sl.no</th>
                                <th scope="col"> Code </th>
                                <th scope="col"> Name </th>
                                <th scope="col">Specification</th>
                                <th scope="col"> Unit</th>
                                <th scope="col">Total Inward</th>
                                <th scope="col">Total Issue</th>
                                <th scope="col">Available Stock</th>
                            </thead>
                            <tbody> `;
            if (data && data.length > 0) {
                // Populate table rows with data
                $.each(data, function(key, stock) {
                    tableHtml += `
                            <tr>
                <td>${safeValue(stock.sl_no)}</td>
                <td>${safeValue(stock.code)}</td>
                <td>${safeValue(stock.name)}</td>
                <td>${safeValue(stock.specification)}</td>
                <td>${safeValue(stock.unit)}</td>
                <td>${safeValue(stock.total_inward)}</td>
                <td>${safeValue(stock.total_issue)}</td>
                <td>${safeValue(stock.available_stock)}</td>
            </tr>`
                });
            } else {
                console.error("No data found to populate the table.");
            }
            tableHtml += '</tbody></table>';
            tableBody.html(tableHtml);
            $('#formReportInventoryProjectStockassetsTable').DataTable({
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


        $('#form-report-inventory-project-stock').change(function() {
            var projectId = $('#from_project').val();
            updateSubprojectsDropdownStocks(projectId)
        });

        function updateSubprojectsDropdownStocks(projectId) {
            $.get(baseUrl + 'company/activities/storeprojects/' + projectId, function(data) {
                $('#from_store').empty();
                $.each(data, function(key, value) {
                    console.log(value);
                    $.each(value.store_warehouse, function(subkey, subvalue) {
                        console.log(subvalue);
                        // alert(subvalue.name)
                        $('#from_store').append('<option value="' + subvalue.id + '">' +
                            subvalue.name + '</option>');
                    });
                });
            });
        };

        // ****************************************************************************************
    </script>
@endpush
