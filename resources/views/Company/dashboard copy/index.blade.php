@extends('Company.layouts.app')
@section('dashboard-active', 'active')
@section('title', __('Dashboard'))
@push('styles')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">

    <style>
        .pr-list-container {
            max-height: 400px;
            /* Set the maximum height for the container */
            overflow-y: auto;
            /* Enable vertical scrolling */
            border: 1px solid #ddd;
            /* Optional: Add a border for better visibility */
            padding: 10px;
            /* Optional: Add some padding */
            border-radius: 5px;
            /* Optional: Add rounded corners */
        }
    </style>
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
                        <div>Dashboard
                        </div>
                    </div>
                    <div class="page-title-actions">
                    </div>
                </div>
            </div>
            <div class="row">
                @if (checkCompanyPermissions(
                        'dashboard',
                        auth()->guard('company')->user()->company_role_id,
                        auth()->guard('company')->user()->id,
                        'view'))
                    @include('Company.dashboard.include.overview')
                @endif
            </div>
        </div>

        <div class="app-wrapper-footer">
            <div class="app-footer">
                <div class="app-footer__inner">
                    <div class="app-footer-left">
                    </div>
                    <div class="app-footer-right">
                        <ul class="nav">
                            <li class="nav-item">
                                <a href="javascript:void(0);" class="nav-link">
                                    <div class="badge badge-success mr-1 ml-0">
                                        <small>Copyright</small>
                                    </div>
                                    Koncite
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection()
@push('scripts')
    <script type="text/javascript" src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="https://cdn.canvasjs.com/jquery.canvasjs.min.js"></script>
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script> <!-- Include MomentJS -->
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script> <!-- Include daterangepicker -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script src="{{ asset('company_assets/js/ajax/dashboardchart.js') }}"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>

    <script>
        $(document).ready(function($e) {
            $('#from_project').change(function() {
                var projectId = $(this).val();
                if (projectId) {
                    updateSubprojectsDropdown(projectId);
                } else {
                    // Select the first project option if none is selected
                    if (!$('#from_project').val()) {
                        var firstProjectId = $('#from_project option:eq(1)').val();
                        $('#from_project option:eq(1)').prop('selected', true).trigger('change');
                    }
                    updateSubprojectsDropdown(firstProjectId);
                    // Fetch details for the first project and its first subproject and date
                    if (firstProjectId) {
                        var firstSubprojectId = $('#from_subproject option:eq(1)').val();
                        var firstDate = $('#date option:eq(1)').val();
                        fetchWorkOverview(firstProjectId, firstSubprojectId, firstDate);
                    }
                    // Initialize or update the charts
                    $("#chartContainer").CanvasJSChart(options);
                    $("#monthlychartContainer").CanvasJSChart(monthlyreport);
                }
            })
            var project = $('#from_project option:eq(1)').val();
            // Select the first project option
            $('#from_project option:eq(1)').prop('selected', true);
            updateSubprojectsDropdown(project)
            // Trigger fetch for project details
            if (project) {
                var subproject = $('#from_subproject option:eq(1)').val();
                var date = $('#date option:eq(1)').val();
                fetchWorkOverview(project, subproject, date);
            }
            // $("#chartContainer").CanvasJSChart(options);
            $("#monthlychartContainer").CanvasJSChart(monthlyreport);
            $('.dprs_data').on('click', function(e) {
                var dprsId = $(this).attr("data-id");
            });
        });
        // ***************************work-process*********************************************************
        // $(document).ready(function($e) {
        $('#nav-work-tab').on('click', function() {
            $('#filter-form-work-process').change(function(e) {
                var projectId = $('#from_project_work_process').val();
                // alert(projectId);
                if (projectId) {
                    // alert(projectId);
                    workprocessSubprojectsDropdown(projectId);
                } else {
                    // alert(projectId);
                    // Select the first project option if none is selected
                    var firstProjectId = $('#from_project_work_process option:eq(1)').val();
                    $('#from_project_work_process option:eq(1)').prop('selected', true);
                    workprocessSubprojectsDropdown(firstProjectId);
                    // Fetch details for the first project and its first subproject and date
                    if (firstProjectId) {
                        // var firstSubprojectId = $('#from_subproject_work_process option:eq(1)').val();
                        var firstDate = $('#date option:eq(1)').val();
                        fetchWorkOverview(firstProjectId, firstSubprojectId, firstDate);
                    }
                    // alert('Please select a project and subproject.1111');

                    // Initialize or update the charts
                    $("#chartContainer").CanvasJSChart(options);
                    $("#monthlychartContainer").CanvasJSChart(monthlyreport);
                }
            })
            var project = $('#from_project_work_process option:eq(1)').val();
            // Select the first project option
            $('#from_project_work_process option:eq(1)').prop('selected', true);
            workprocessSubprojectsDropdown(project)
            // Trigger fetch for project details
            if (project) {
                // var subproject = $('#from_subproject_work_process option:eq(1)').val();
                var date = $('#date option:eq(1)').val();
                fetchWorkOverview(project, subproject, date);
            }
        });
        // ************************************************************************************
        function workprocessSubprojectsDropdown(projectId) {
            // alert("workprocessSubprojectsDropdown" + projectId)
            $.get(baseUrl + 'company/activities/subprojects/' + projectId, function(data) {
                $('#from_subproject_work_process').empty();
                $.each(data, function(key, value) {
                    $.each(value.sub_project, function(subkey, subvalue) {
                        // alert(subvalue.name)
                        $('#from_subproject_work_process').append('<option value="' + subvalue.id +
                            '">' + subvalue.name + '</option>'
                        );
                    });
                });
            });
        }
        // *************************stocks***********************************************************
        $('#nav-stock-tab').click(function() {
            $('#filter-form-stocks').change(function() {
                var projectId = $('#from_project_stocks').val();
                // alert(projectId)
                if (projectId) {
                    updateSubprojectsDropdownStocks(projectId);
                } else {
                    // Select the first project option if none is selected
                    var firstProjectId = $('#from_project_stocks option:eq(1)').val();
                    $('#from_project_stocks option:eq(1)').prop('selected', true);
                    updateSubprojectsDropdownStocks(firstProjectId);
                    // Fetch details for the frst project and its first subproject and date
                    if (firstProjectId) {
                        var firstSubprojectId = $('#from_subproject_stocks option:eq(1)').val();
                        var firstDate = $('#date option:eq(1)').val();
                        fetchWorkOverviewStocks(firstProjectId, firstSubprojectId, firstDate);
                    }
                    // Initialize or update the charts
                    $("#chartContainer").CanvasJSChart(options);
                    $("#monthlychartContainer").CanvasJSChart(monthlyreport);
                }
            })

            var project = $('#from_project_stocks option:eq(1)').val();
            // Select the first project option
            $('#from_project_stocks option:eq(1)').prop('selected', true);
            updateSubprojectsDropdownStocks(project)

        });

        function updateSubprojectsDropdownStocks(projectId) {
            $.get(baseUrl + 'company/activities/storeprojects/' + projectId, function(data) {
                $('#from_subproject_stocks').empty();
                $.each(data, function(key, value) {
                    console.log(value);
                    $.each(value.store_warehouse, function(subkey, subvalue) {
                        console.log(subvalue);
                        // alert(subvalue.name)
                        $('#from_subproject_stocks').append('<option value="' + subvalue.id + '">' +
                            subvalue.name + '</option>');
                    });
                });
            });
        }
        // ************************************************************************************
        function updateSubprojectsDropdown(projectId) {
            $.get(baseUrl + 'company/activities/subprojects/' + projectId, function(data) {
                $('#from_subproject').empty();
                $.each(data, function(key, value) {
                    $.each(value.sub_project, function(subkey, subvalue) {
                        $('#from_subproject').append('<option value="' +
                            subvalue.id + '">' + subvalue.name + '</option>'
                        );
                    });
                });
            });
        }
        // ************************************************************************************
        $('#filter-form').on('change', function() {
            // Call fetchWorkOverview whenever the form changes
            var project = $('#from_project').val();
            var subproject = $('#from_subproject').val();
            var date = $('#date').val();
            fetchWorkOverview(project, subproject, date);
        });
        // ************************************************************************************
        function fetchWorkOverview(project, subproject, date) {
            // console.log(project + '/' + subproject + '/' + date);
            // alert(project + '/' + subproject + '/' + date);
            $.ajax({
                url: baseUrl + `ajax/get-work-overview`,
                type: "post",
                data: {
                    project: project,
                    subproject: subproject,
                    date: date,
                    _token: $('meta[name="csrf-token"]').attr('content') // Adding CSRF token
                },
                success: function(response) {
                    // alert("ajax.company");
                    renderWorkOverview(response, project, subproject, date);
                },
                error: function(xhr, status, error) {
                    // console.error('Error fetching data:', error);
                    // alert('Error fetching data. Please try again later.');
                }
            });
        }
        // ************************************************************************************
        function renderWorkOverview(response, project, subproject, date) {
            // Update UI with response data
            renderWorkStatusChart(response.workStatusData);
            monthwiseworkProgess(response.chartData);
            $('#estimatedCost').text(response.estimatedCost);
            $('#estimatedCostForExecutedQty').text(response.estimatedCostForExecutedQty);
            $('#balanceEstimate').text(response.balanceEstimate);
            $('#excessEstimateCost').text(response.excessEstimateCost);
            $('#totalActivites').text(response.totalActivites);
            $('#inProgress').text(response.inProgress);
            $('#notStart').text(response.notStart);
            $('#completed').text(response.completed);
            $('#totalDuration').text(response.totalDuration);
            $('#projectcompleted').text(response.projectcompleted);
            $('#remaining').text(Math.abs(response.remaining));
            // Update progress bars with data from the response
            $('#planeProgress').css('width', `${response.planeProgress}%`).attr('aria-valuenow', response.planeProgress)
                .text(`${response.planeProgress}%`);
            $('#actualProgress').css('width', `${response.actualProgress}%`).attr('aria-valuenow', response.actualProgress)
                .text(`${response.actualProgress}%`);
            $('#variation').css('width', `${response.variation}%`).attr('aria-valuenow', response.variation).text(
                `${response.variation}%`);
            $('#totalLabourCount').text(response.totalLabourCount);
            $('#dprsId').data('id', 20);
            $('#purchaseRequests').text(response.purchaseRequests);
            $('#goodsReceipt').text(response.goodsReceipt);
            $('#issueOutward').text(response.issueOutward);
            $('#materialReturn').text(response.materialReturn);
            $('#pORaised').text(response.pORaised);
            // Clear previous users data
            $('#dprusers').empty();

            if (response.fetchDpr && response.fetchDpr.length > 0) {
                const usersHtml = response.fetchDpr.map(fetchDpr => {

                    if (fetchDpr && fetchDpr.id) {
                        return `<div class="singletabdtl col-md-10"><p>${fetchDpr.dpr_no}</p>|<p>${fetchDpr.users.name}</p>
                            <a href="${generateDprDetailsUrl(project, fetchDpr.users.id, date)}"
                            id="dprs_data" class="dprs_data view_btn float-end" data-id="${fetchDpr.users.id}" target="_blank">View</a></div>`;
                    }
                    return ''; // Return empty string if user is null or doesn't have an id
                }).join('');
                $('#dprusers').append(usersHtml);
            }
            // Render DPR table
            renderDprTable(response.fetchDpr);
            // Render vendor labour list
            renderVendorLabourList(response.vendorWiseLabourListing);
        }

        function generateDprDetailsUrl(project, userId, date) {
            // alert("asdfghj");
            return `{{ route('company.report.dprDetails', ['pid' => ':project', 'uid' => ':userId', 'date' => ':date']) }}`
                .replace(':project', project)
                .replace(':userId', userId)
                .replace(':date', date);
        }

        // ************************************************************************************
        function renderDprTable(dprData) {
            var dprContainer = $('#dprConatiner');
            dprContainer.empty();
            if (dprData && dprData.length > 0) {
                var tableHtml =
                    '<table class="table table-bordered" id="dataTable"><thead><tr><th>User\'s Name</th><th>Historie Names</th><th>Safetie Names</th></tr></thead><tbody>';
                dprData.forEach(function(dpr) {
                    var userName = dpr.users && dpr.users.name ? dpr.users.name : 'Not Available';

                    var historieNames = dpr.historie && dpr.historie.length > 0 ? dpr.historie.map(function(
                        historie) {
                        return historie.details ? historie.details : 'No Name';
                    }).join(', ') : 'No Historie Data Available';
                    var safetieNames = dpr.safetie && dpr.safetie.length > 0 ? dpr.safetie.map(function(safetie) {
                        return safetie.name ? safetie.name : 'No Name';
                    }).join(', ') : 'No Safetie Data Available';
                    tableHtml += '<tr><td>' + userName + '</td><td>' + historieNames + '</td><td>' + safetieNames +
                        '</td></tr>';
                });
                tableHtml += '</tbody></table>';
                dprContainer.html(tableHtml);
                // Initialize DataTables after adding the table to the DOM
                if ($.fn.DataTable) {
                    $('#dataTable').DataTable({
                        paging: true,
                        searching: false,
                        ordering: true,
                        info: true,
                        lengthChange: true,
                        pageLength: 10,
                        dom: 'Bfrtip', // Include buttons in the DOM
                        buttons: [
                            'copy', 'csv', 'excel', 'pdf', 'print'
                        ]
                    });
                } else {
                    console.error('DataTable plugin is not loaded.');
                }
            } else {
                dprContainer.html('<p>No data available</p>');
            }
        }

        // ************************************************************************************
        function renderVendorLabourList(vendorData) {
            var vendorLabourContainer = $('#vendorLabourContainer');
            vendorLabourContainer.empty();
            if (vendorData && vendorData.length > 0) {
                var listHtml = '';
                vendorData.forEach(function(vendorItem) {
                    var vendor = vendorItem.vendor;
                    var labourCount = vendorItem.labour_count;
                    listHtml += '<div class="single_content"><p class="singcon_left">' + vendor.name + '</p><p>' +
                        labourCount + '</p></div>';
                });
                vendorLabourContainer.html(listHtml);
            } else {
                vendorLabourContainer.html('<p>No data available</p>');
            }
        }
    </script>
    {{-- // ************************************************************************************ --}}
    <script>
        let project;
        let subproject;
        let date;
        // **********************************************************************************
        $('#filter-form-work-process').on('change', function() {
            project = $('#from_project_work_process').val();
            subproject = $('#from_subproject_work_process').val();
            date = $('#date').val();
            // alert('filter-form-work-process');
            // console.log(project + '/' + subproject + '/' + date);
            // alert("filter-form-work-process" + project + '/' + subproject + '/' + date);
            // alert('filter-form-work-process');
            $.ajax({
                url: baseUrl + `ajax/get-work-process`,
                type: "post",
                data: {
                    project: project,
                    subproject: subproject,
                    date: date,
                    _token: $('meta[name="csrf-token"]').attr('content') // Adding CSRF token

                },
                success: function(response) {
                    renderWorkProcessChart(response.workProcessData);
                    console.log(response);
                    $('.estimatedCost').text(response.estimatedCost);
                    $('.estimatedCostForExecutedQty').text(response.estimatedCostForExecutedQty);
                    $('.balanceEstimate').text(response.balanceEstimate);
                    $('.excessEstimateCost').text(response.excessEstimateCost);
                },
                error: function(error) {
                    console.log('Error fetching data:', error);
                }
            });
        });
        // ************************************************************************************
        $('.filter-form-work-process-details').on('click', function(event) {
            event.preventDefault();
            const filterName = $(event.target).data('name');
            $.ajax({
                url: baseUrl + `ajax/get-work-process-activities`,
                method: 'POST',
                data: {
                    project: project,
                    subproject: subproject,
                    date: date,
                    filterName: filterName,
                    _token: $('meta[name="csrf-token"]').attr('content') // Adding CSRF tokenw
                },
                success: function(response) {
                    // console.log("----" + response);
                    // alert(JSON.stringify(response))
                    // alert(filterName)
                    switch (filterName) {
                        case 'inprogress':
                            inprogresspopulateTable(response.inProgressactivites)
                            break;
                        case 'completed':
                            completedpopulateTable(response.completedactivites)
                            break;
                        case 'notstart':
                            notStartpopulateTable(response.notStartactivites)
                            break;
                        case 'delay':
                            delaypopulateTable(response.delayactivites)
                            break;
                    }
                },
                error: function(error) {
                    console.log('Error fetching data:', error);
                }
            });
        });
        // // ************************************************************************************
        function completedpopulateTable(data) {
            let dprContainer = $('#completedActive');
            dprContainer.empty();
            // Create the table structure if it doesn't exist
            let tableHtml =
                '<table class="table table-bordered dataTable" id="completedActiveTable">' +
                '<thead><th scope="col">Sr.No </th><th scope="col">Activities </th><th scope="col">Unit </th>' +
                '<th scope="col">Estimate Qty</th><th scope="col">Est Rate</th><th scope="col">Est.Amount</th>' +
                '<th scope="col">Completed Qty</th><th scope="col">Est. Amount for Completion</th>' +
                '<th scope="col">% Completion</th><th scope="col">Excess Qty</th><th scope="col">Excess Amount</th></thead>' +
                '<tbody id="completed-tbody">'; // Ensure tbody has the correct ID
            if (data && data.length > 0) {
                data.forEach((activity, index) => {
                    const completionSum = activity.activities_history.reduce((sum, history) => sum + history
                        .completion, 0);
                    const averageCompletion = (completionSum / activity.activities_history.length).toFixed(2);
                    const percentageCompletion = ((averageCompletion / activity.qty) * 100).toFixed(2);
                    tableHtml += `
                            <tr>
                                <td scope="row">${index + 1}</td>
                                <td>${valueChecking(activity.activities)}</td>
                                <td>${valueChecking(activity.unit_id)}</td>
                                <td>${valueChecking(activity.qty)}</td>
                                <td>${valueChecking(activity.rate)}</td>
                                <td>${valueChecking(activity.amount)}</td>
                                <td>${valueChecking(completionSum)}</td>
                                <td>${valueChecking(averageCompletion)}</td>
                                <td>${valueChecking(percentageCompletion)}%</td>
                                <td></td>
                                <td></td>
                            </tr>
                        `;
                });
            } else {
                tableHtml +=
                    '<tr><td colspan="11">No data available</td></tr>';
            }
            tableHtml += '</tbody></table>';
            dprContainer.html(tableHtml);
            $('#completedActiveTable').DataTable({
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
        }
        // ************************************************************************************
        function inprogresspopulateTable(data) {
            let dprContainer = $('#inprogressActive');
            dprContainer.empty();
            let tableHtml =
                '<table class="table table-bordered dataTable "id="inprogressActiveTable"><thead><th scope="col">Sr.No </th><th scope="col">Activities </th><th scope="col">Unit </th><th scope="col">Estimate Qty</th><th scope="col">Est Rate</th><th scope="col">Est.Amount</th><th scope="col">Completed Qty</th><th scope="col">Est. Amount for Completion</th><th scope="col">% Completion</th><th scope="col">Excess Qty</th><th scope="col">Excess Amount</th></thead><tbody >';
            if (data && data.length > 0) {
                data.forEach((activity, index) => {
                    const completionSum = activity.activities_history.reduce((sum, history) => sum + history
                        .completion, 0);
                    const averageCompletion = (completionSum / activity.activities_history.length).toFixed(2);
                    const percentageCompletion = ((averageCompletion / activity.qty) * 100).toFixed(2);
                    const row = document.createElement('tr');
                    tableHtml += `<tr>
                                    <td scope="row">${index + 1}</td>
                                    <td>${activity.activities}</td>
                                    <td>${activity.unit_id}</td>
                                    <td>${activity.qty}</td>
                                    <td>${activity.rate || ''}</td>
                                    <td>${activity.amount}</td>
                                    <td>${completionSum}</td>
                                    <td>${averageCompletion}</td>
                                    <td>${percentageCompletion}%</td>
                                    <td>${activity.qty||0}</td>
                                    <td>${activity.amount||0}</td>
                                    </tr>
                                `;
                    // tbody.appendChild(row);
                });
            } else {
                tableHtml +=
                    '<tr><td colspan="11">No data available</td></tr>';
            }
            tableHtml += '</tbody></table>';
            dprContainer.html(tableHtml);
            $('#inprogressActiveTable').DataTable({
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
        }
        // ************************************************************************************
        function notStartpopulateTable(data) {
            let dprContainer = $('#notStartActiveDatas');
            dprContainer.empty();
            let tableHtml =
                '<table class="table table-bordered dataTable" id="notStartActiveTable"><thead><th scope="col">Sr.No</th><th scope="col">Activities</th><th scope="col">Unit</th><th scope="col">Estimate Qty</th><th scope="col">Est Rate</th><th scope="col">Est.Amount</th><th scope="col">Completed Qty</th><th scope="col">Est. Amount for Completion</th><th scope="col">% Completion</th><th scope="col">Excess Qty</th><th scope="col">Excess Amount</th></thead><tbody>';
            if (data && data.length > 0) {
                data.forEach((activity, index) => {
                    const completionSum = activity.activities_history.reduce((sum, history) => sum + (history
                        .completion || 0), 0); // Handle potential undefined completion
                    const averageCompletion = activity.activities_history.length ? (completionSum / activity
                        .activities_history.length) : 0; // Avoid division by zero
                    const percentageCompletion = ((averageCompletion / activity.qty) * 100).toFixed(2);

                    tableHtml += `<tr>
                                    <td scope="row">${index + 1}</td>
                                    <td>${activity.activities}</td>
                                    <td>${activity.unit_id}</td>
                                    <td>${activity.qty}</td>
                                    <td>${activity.rate || ''}</td>
                                    <td>${activity.amount}</td>
                                    <td>${completionSum}</td>
                                    <td>${averageCompletion}</td>
                                    <td>${percentageCompletion}%</td>
                                    <td></td>
                                    <td></td>
                                    </tr>`;
                });
            } else {
                tableHtml +=
                    '<tr><td colspan="11">No data available</td></tr>'; // Provide feedback when no data is available
            }
            tableHtml += '</tbody></table>';
            dprContainer.html(tableHtml);
            $('#notStartActiveTable').DataTable({
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
        }

        // ************************************************************************************
        function delaypopulateTable(data) {
            let dprContainer = $('#delayActive');
            dprContainer.empty();
            let tableHtml = `<table class="table table-bordered dataTable" id="delayActiveTable">
            <thead>
                    <th scope="col">Sr.No</th>
                    <th scope="col">Activities</th>
                    <th scope="col">Unit</th>
                    <th scope="col">Estimate Qty</th>
                    <th scope="col">% Completion</th>
                    <th scope="col">Planned Start date</th>
                    <th scope="col">Planned End Date</th>
                    <th scope="col">Actual Start</th>
                    <th scope="col">Delay Days</th>
            </thead>
            <tbody>`;
            if (data && data.length > 0) {
                data.forEach((activity, index) => {
                    const completionSum = activity.activities_history.reduce((sum, history) => sum + (history
                        .completion || 0), 0);
                    const averageCompletion = activity.activities_history.length ? (completionSum / activity
                        .activities_history.length) : 0;
                    const percentageCompletion = (averageCompletion && activity.qty) ? ((averageCompletion /
                        activity.qty) * 100).toFixed(2) : 0;
                    const actualStart = moment(activity.activities_history.created_at).format('YYYY-MM-DD');
                    const plannedStart = activity.start_date ? new Date(activity.start_date) : null;
                    const delayDays = moment(plannedStart).diff(moment(actualStart), 'days');
                    tableHtml += `
            <tr>
                <td scope="row">${index + 1}</td>
                <td>${valueChecking(activity.activities)}</td>
                <td>${valueChecking(activity.units_id)}</td>
                <td>${valueChecking(activity.qty)}</td>
                <td>${valueChecking(percentageCompletion)}%</td>
                <td>${valueChecking(activity.start_date)}</td>
                <td>${valueChecking(activity.end_date)}</td>
                <td>${valueChecking(actualStart)}</td>
                <td>${valueChecking(Math.abs(delayDays))}</td>
            </tr>`;
                });
            } else {
                tableHtml +=
                    '<tr><td colspan="11">No data available</td></tr>';
            }
            tableHtml += '</tbody></table>';
            dprContainer.html(tableHtml);
            initializeDataTable("#delayActiveTable");
        }
        // ************************************************************************************
        function renderWorkProcessChart(dataPoints) {
            var chart3 = new CanvasJS.Chart("workprogressChart", {
                animationEnabled: true,
                theme: "light1", // "light1", "light2", "dark1", "dark2"
                title: {
                    text: "Work Progress Acitivity",
                    fontFamily: "Roboto",
                },
                data: [{
                    type: "column",
                    showInLegend: true,
                    toolTipContent: "{legendText}",
                    legendMarkerColor: "grey",
                    dataPoints: dataPoints
                }]
            });
            chart3.render();
        }
        // ************************************************************************************
        // $('#nav-stock').on('click', function() {
        // $('#filter-form-stocks').on('click', function() {
        //     project = $('#from_project_stocks').val();
        //     subproject = $('#from_subproject_stocks').val();
        //     date = $('#date_stocks').val();
        //     filterName = $(event.target).data('name');
        //     // filterName = 'material';
        //     console.log(project + '/' + subproject + '/' + date + '/' + filterName);
        //     $.ajax({
        //         url: baseUrl + `ajax/get-inventory-stocks`,
        //         type: "post",
        //         data: {
        //             project: project,
        //             store: subproject,
        //             date: date,
        //             filterName: filterName,
        //             _token: $('meta[name="csrf-token"]').attr('content') // Adding CSRF tokenw
        //         },
        //         success: function(response) {
        //             switch (filterName) {
        //                 case 'material':
        //                     materialstacks(response.materialStocks)
        //                     break;
        //                 case 'machine':
        //                     machinestocks(response.machineStocks)
        //                     break;
        //             }
        //             console.log("------", response);
        //             // alert(response);
        //         },
        //         error: function(error) {
        //             // alert(error);
        //             console.log('Error fetching data:', error);
        //         }
        //     });
        // });
        // });


        function loadInventoryStocks() {
            const project = $('#from_project_stocks').val();
            const subproject = $('#from_subproject_stocks').val();
            const date = $('#date_stocks').val();
            const filterName = $('input[name="filterName"]:checked').data(
                'name'); // Assuming you have radio buttons for filter names

            console.log(project + '/' + subproject + '/' + date + '/' + filterName);

            $.ajax({
                url: baseUrl + `ajax/get-inventory-stocks`,
                type: "post",
                data: {
                    project: project,
                    store: subproject,
                    date: date,
                    filterName: filterName,
                    _token: $('meta[name="csrf-token"]').attr('content') // Adding CSRF token
                },
                success: function(response) {
                    // Clear existing tables before populating new data
                    $('#stockMaterialTable').empty();
                    $('#stockMachineTable').empty();

                    // Use a switch statement to determine which function to call
                    switch (filterName) {
                        case 'material':
                            materialstacks(response.materialStocks);
                            break;
                        case 'machine':
                            machinestocks(response.machineStocks);
                            break;
                        default:
                            console.log('No valid filter name provided');
                    }
                    console.log("------", response);
                },
                error: function(error) {
                    console.log('Error fetching data:', error);
                }
            });
        }

        // Set an interval to automatically load inventory stocks every 5 seconds (5000 milliseconds)
        // setInterval(loadInventoryStocks, 5000);

        // Initial load when the page is ready
        $('#filter-form-stocks').on('click', function() {
            loadInventoryStocks(); // Load data immediately on page load
        });
        // ************************************************************************************
        $('.filter-inventory-stock-details').on('click', function(event) {
            // event.preventDefault();store_material_tab
            project = $('#from_project_stocks').val();
            subproject = $('#from_subproject_stocks').val();
            date = $('#date_stocks').val();
            filterName = $(event.target).data('name');
            $.ajax({
                url: baseUrl + `ajax/get-inventory-stocks`,
                method: 'POST',
                data: {
                    project: project,
                    store: subproject,
                    date: date,
                    filterName: filterName,
                    _token: $('meta[name="csrf-token"]').attr('content') // Adding CSRF tokenw
                },
                success: function(response) {
                    switch (filterName) {
                        case 'material':
                            // alert(JSON.stringify(response))
                            materialstacks(response.materialStocks)
                            break;
                        case 'machine':
                            machinestocks(response.machineStocks)
                            break;
                    }
                    console.log("response.completedactivites------", response);
                },
                error: function(error) {
                    console.log('Error fetching data:', error);
                }
            });
        });
        // ************************************************************************************
        function materialstacks(data) {
            let tableBody = $('#stockMaterialTable');
            tableBody.empty(); // Clear the table body

            let tableHtml = `<table class="table table-bordered dataTable" id="stockMaterial">
                        <thead>
                            <th scope="col">Class</th>
                            <th scope="col">Code</th>
                            <th scope="col">Materials</th>
                            <th scope="col">Specification</th>
                            <th scope="col">Unit</th>
                            <th scope="col">Stock Qty</th>
                        </thead>
                        <tbody>`;

            if (data && data.length > 0) {
                data.forEach(function(stock) {
                    if (stock.materials) {
                        tableHtml += `
                <tr>
                    <td>${stock.materials.class}</td>
                    <td>${stock.materials.code}</td>
                    <td>${stock.materials.name}</td>
                    <td>${stock.materials.specification}</td>
                    <td>${stock.materials.units.unit}</td>
                    <td>${stock.total_qty}</td>
                </tr>`;
                    }
                });
            } else {
                tableHtml += '<tr><td colspan="6">No data available</td></tr>';
            }
            tableHtml += '</tbody></table>';
            tableBody.html(tableHtml);

            // Initialize DataTable
            $('#stockMaterial').DataTable({
                paging: true,
                searching: true,
                ordering: true,
                info: true,
                lengthChange: true,
                pageLength: 10,
                dom: 'Bfrtip',
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
            });
        }

        function machinestocks(data) {
            let tableBody = $('#stockMachineTable');
            tableBody.empty(); // Clear the table body

            let tableHtml = `<table class="table table-bordered dataTable" id="stockMachine">
                        <thead>
                            <th scope="col">Code</th>
                            <th scope="col">Machine/Tools (Assets)</th>
                            <th scope="col">Specification</th>
                            <th scope="col">Unit</th>
                            <th scope="col">Stock Qty</th>
                        </thead>
                        <tbody>`;

            if (data && data.length > 0) {
                data.forEach(function(stock) {
                    if (stock.assets) {
                        tableHtml += `
                <tr>
                    <td>${stock.assets.code}</td>
                    <td>${stock.assets.name}</td>
                    <td>${stock.assets.specification}</td>
                    <td>${stock.assets.units.unit}</td>
                    <td>${stock.total_qty}</td>
                </tr>`;
                    }
                });
            } else {
                tableHtml += '<tr><td colspan="5">No data available</td></tr>';
            }
            tableHtml += '</tbody></table>';
            tableBody.html(tableHtml);

            // Initialize DataTable
            $('#stockMachine').DataTable({
                paging: true,
                searching: true,
                ordering: true,
                info: true,
                lengthChange: true,
                pageLength: 10,
                dom: 'Bfrtip',
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
            });
        }
        // ************************************************************************************
        // function materialstacks(data) {
        //     let tableBody = $('#stockMaterialTable');
        //     tableBody.empty();
        //     let tableHtml = `<table class="table table-bordered dataTable" id="stockMaterial">
    //                     <thead>
    //                         <th scope="col">Class</th>
    //                         <th scope="col">Code</th>
    //                         <th scope="col">Materials</th>
    //                         <th scope="col">Specification</th>
    //                         <th scope="col">Unit</th>
    //                         <th scope="col">Stock Qty</th>
    //                     </thead>
    //                     <tbody>`;
        //     if (data && data.length > 0) {
        //         // Populate table rows with data
        //         data.forEach(function(stock) {
        //             // console.log(stock.materials.units);
        //             if (stock.materials != undefined) {
        //                 tableHtml += `
    //                 <tr>
    //                     <td>${stock?.materials?.class}</td>
    //                     <td>${stock.materials?.code}</td>
    //                     <td>${stock?.materials?.name }</td>
    //                     <td>${stock?.materials?.specification}</td>
    //                     <td>${stock?.materials?.units?.unit}</td>
    //                     <td>${stock?.total_qty}</td>
    //                 </tr>`
        //             }
        //         });
        //     } else {
        //         tableHtml +=
        //             '<tr><td colspan="11">No data available</td></tr>';
        //     }
        //     tableHtml += '</tbody></table>';
        //     tableBody.html(tableHtml);
        //     $('#stockMaterial').DataTable({
        //         paging: true,
        //         searching: true,
        //         ordering: true,
        //         info: true,
        //         lengthChange: true,
        //         pageLength: 10,
        //         dom: 'Bfrtip', // Include buttons in the DOM
        //         buttons: [
        //             'copy', 'csv', 'excel', 'pdf', 'print'
        //         ]
        //     });
        // }
        // // ************************************************************************************
        // function machinestocks(data) {
        //     let tableBody = $('#stockMachineTable');
        //     tableBody.empty();
        //     let tableHtml = `<table class="table table-bordered dataTable" id="stockMachine">
    //                     <thead>
    //                         <th scope="col">Code</th>
    //                         <th scope="col">Machine/Tools (Assets)</th>
    //                         <th scope="col">Specification</th>
    //                         <th scope="col">Unit</th>
    //                         <th scope="col">Stock Qty</th>
    //                     </thead>
    //                     <tbody id="stockMachine-tab">
    //                     `;
        //     if (data && data.length > 0) {

        //         // Populate table rows with data
        //         data.forEach(function(stock) {
        //             if (stock.assets != undefined) {

        //                 tableHtml += `
    //                 <tr>
    //                     <td>${stock?.assets?.code}</td>
    //                     <td>${stock?.assets?.name}</td>
    //                     <td>${ stock?.assets?.specification }</td>
    //                     <td>${stock?.assets?.units?.unit}</td>
    //                     <td>${stock?.total_qty}</td>
    //                 </tr>`
        //             }
        //         });
        //     } else {
        //         tableHtml += `
    //                 <tr>
    //                     <td>No data found to populate the table.</td>
    //                 </tr>`;
        //     }
        //     tableHtml += '</tbody></table>';
        //     tableBody.html(tableHtml);
        //     $('#stockMachine').DataTable({
        //         paging: true,
        //         searching: true,
        //         ordering: true,
        //         info: true,
        //         lengthChange: true,
        //         pageLength: 10,
        //         dom: 'Bfrtip', // Include buttons in the DOM
        //         buttons: [
        //             'copy', 'csv', 'excel', 'pdf', 'print'
        //         ]
        //     });
        // }
        // filter-inventory-stock-details
    </script>
    {{-- // ************************************************************************************ --}}
    <script>
        //date range picker
        $('input[name="dates"]').daterangepicker();
        $(function() {
            var start = moment().subtract(29, 'days');
            var end = moment();

            function cb(start, end) {
                $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            }
            $('#reportrange').daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                        'month').endOf('month')]
                },
            }, cb);
            cb(start, end);
        });

        function renderWorkStatusChart(dataPoints) {
            var chart = new CanvasJS.Chart("chartContainer", {
                title: {
                    text: "Work Status",
                    fontFamily: "Roboto"
                },
                data: [{
                    type: "pie",
                    showInLegend: true,
                    toolTipContent: "{legendText}",
                    dataPoints: dataPoints
                }],
                width: 600, // Set the desired width
                height: 200 // Set the desired height
            });
            chart.render();
        }

        function monthwiseworkProgess(data) {
            // Check if data is valid and contains labels and datasets
            if (!data || !data.labels || !data.datasets) {
                console.error("Invalid data format for monthwiseworkProgess");
                return; // Exit the function if data is invalid
            }

            var labels = data.labels;
            var datasets = data.datasets;

            // Create an array to hold the data for each month
            const allMonthsData = labels.map((label) => {
                // const allMonthsData = labels.map((label) => {
                // Create an object for each month with the label
                const monthData = {
                    label: label
                };
                // For each dataset, get the corresponding data point or 0 if not available
                monthData.data = datasets.map((dataset) => {
                    const index = labels.indexOf(label);
                    return index >= 0 ? parseFloat(dataset.data[index]) || 0 : 0;
                });
                return monthData;
            });

            // console.log(labels);
            // console.log(datasets);
            // console.log(allMonthsData);

            const chart2 = new CanvasJS.Chart("progressChart", {
                animationEnabled: true,
                title: {
                    text: "Months Wise Work Progress"
                },
                toolTip: {
                    shared: true,
                    content: "{name}: {y}%"
                },
                axisX: {
                    title: "Months"
                },
                axisY: {
                    title: "Progress (%)"
                },
                width: 990,
                height: 250,
                data: datasets.map((dataset, datasetIndex) => ({
                    type: "column",
                    name: dataset.label,
                    showInLegend: true,
                    dataPoints: allMonthsData.map(monthData => ({
                        label: monthData.label,
                        y: monthData.data[datasetIndex] || 0 // Ensure 0 is shown if no data
                    }))
                }))
            });
            chart2.render();
        }
    </script>

    <script>
        $(document).ready(function() {
            // When a tab is clicked, store its ID in localStorage
            $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {
                var activeTab = $(e.target).attr('data-bs-target');
                // alert(activeTab);
                localStorage.setItem('activeTab', activeTab);
            });
            // On page load, check if there is a saved active tab and show it
            var activeTab = localStorage.getItem('activeTab');
            if (activeTab) {
                // Check if the activeTab is a valid selector before showing it
                if ($('button[data-bs-target="' + activeTab + '"]').length) {
                    $('button[data-bs-target="' + activeTab + '"]').tab('show');
                }
            }
        });
    </script>
@endpush
