@extends('Company.layouts.app')
@section('GlobalProjectStock-active', 'active')
@section('title', __('Global Projects Stock'))
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
                        <div>Global Projects Stock</div>
                    </div>
                    <div class="page-title-actions">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="main_wrapper">
                        <div class="main_card mb-3">
                            <div class="card_content">
                                <div class="tab-content" id="nav-tabContent">
                                    <form id="form-work-inventory-global-projects-stock" class="filter-form"
                                        {{-- action="{{ route('company.report.workProgressDetails') }}"  --}} method="POST">
                                        @csrf
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
                                                    <div class="table-responsive" id="formReportInventoryProjectStock">

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
        // $(document).ready(function($e) {
        // ****************************************************************************************

        $(document).ready(function() {
            // Function to handle AJAX request
            function sendAjaxRequest() {
                var type = $('.nav-link.filterformworkprocessdetails.active').data(
                    'name'); // Fetch type from active button

                // Logging for debugging
                console.log(type);

                // AJAX request
                $.ajax({
                    url: baseUrl + `ajax/get-inventory-global-project-stock`,
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
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
                                formReportInventoryProjectStockmaterial(response.assets)
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
        function formReportInventoryProjectStockmaterial(data) {
            // alert(JSON.stringify(data))
            let tableBody = $('#formReportInventoryProjectStock');
            tableBody.empty();
            let tableHtml = `<table class="table table-bordered " id="formReportInventoryProjectStockmaterialTable">
                                <thead>
                                    <th scope="col">Sl.no</th>
                                    <th scope="col"> Code </th>
                                    <th scope="col"> Name </th>
                                    <th scope="col">Specification</th>
                                    <th scope="col"> Unit</th>
                                    <th scope="col"> project</th>
                                    <th scope="col">Total Stock QTY</th>
                                </thead>
                                <tbody> `;
            if (data) {
                console.log(data);
                // Populate table rows with data
                let ii = 1;
                $.each(data, function(key, stock) {
                    console.log(stock);
                    if (stock.total_inward !== null && stock.total_inward !== '' && stock.total_inward >
                        0) {
                        tableHtml += `
                            <tr>
                                <td>${ii }</td>
                                <td>${stock.code !== null ? stock.code : ' '}</td>
                                <td>${stock.name !== null ? stock.name : ' '}</td>
                                <td>${stock.specification !== null ? stock.specification : ' '}</td>
                                <td>${stock.unit !== null ? stock.unit : ' '}</td>
                                <td>${stock.project !== null ? stock.project : ' '}</td>
                                <td>${stock.total_inward}</td>
                            </tr>`
                        ii++;
                    }
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

        // ****************************************************************************************
        // ****************************************************************************************
        // ****************************************************************************************
        // ****************************************************************************************
        // ****************************************************************************************
        // ****************************************************************************************


        // });
    </script>
@endpush
