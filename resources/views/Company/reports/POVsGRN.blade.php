@extends('Company.layouts.app')
@section('workProgressDetails-active', 'active')
@section('title', __('Dashboard'))
@push('styles')
    {{-- <!-- date range picker -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" /> --}}

    {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- Bootstrap Datepicker CSS -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <!-- Bootstrap Datepicker JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script> --}}
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
                        <div>Work Progress Details
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
                                        <form id="form-work-progress-details" class="filter-form"
                                            action="{{ route('company.report.workProgressDetails') }}" method="POST">
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

                                                    <div class="single_filterbox filter_btn">
                                                        <button class="view_btn">Search Now</button>
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
                                                    <div class="process_filter">
                                                        <div class="single_filterbox">
                                                            <label for="">Project -</label>
                                                            <strong>{{ $projectName ?? '' }}</strong>
                                                        </div>

                                                        <div class="single_filterbox">
                                                            <label for="">Sub-Project -</label>
                                                            <strong>{{ $subprojectName ?? '' }}</strong>
                                                        </div>

                                                        <div class="single_filterbox">
                                                            <label for="">Date </label>
                                                            <strong>{{ $fromDate ?? '' }}--{{ $toDate ?? '' }}</strong>
                                                        </div>

                                                    </div>
                                                    <div class="process_table">
                                                        <div class="table-responsive" id="stockMaterialTable">
                                                            <table class="table table-bordered "
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
                                                            </table>
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
            $('#workProgessDetailsDataTable').DataTable({
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
            // $(document).on('change', '#form-work-progress-details', function() {
            //     // alert('sdfghj');
            //     var project = $('#from_project').val();
            //     var subproject = $('#from_subproject').val();
            //     var date_from = $('#from_date').val();
            //     var date_to = $('#to_date').val();
            //     alert(project + '/' +
            //         subproject + '/' +
            //         date_from + '/' +
            //         date_to);
            //     $.ajax({
            //         url: "{{ route('company.report.workProgressDetails') }}",
            //         type: "POST",
            //         data: {
            //             project: project,
            //             subproject: subproject,
            //             date_from: date_from,
            //             date_to: date_to
            //         },
            //         success: function(response) {
            //             // console.log(response);
            //             // alert("json.stringify(response)")
            //             // $('.comp-body').show()
            //             // $("#constGroup").html(response);
            //         },
            //         error: function(error) {
            //             alert(error);
            //         }
            //     });
            // });


            // extend: 'excelHtml5',
            // text: 'Export to Excel',
            // customize: function(xlsx) {
            //     var sheet = xlsx.xl.worksheets['sheet1.xml'];

            //     // Example: Customize header row
            //     $('c[r=A1] t', sheet).text('Project');
            //     $('c[r=B1] t', sheet).text('Subproject');
            //     $('c[r=C1] t', sheet).text('Date');

            //     $('c[r=D1] t', sheet).text('Name');
            //     $('c[r=E1] t', sheet).text('Position');
            //     $('c[r=F1] t', sheet).text('Office');
            //     $('c[r=G1] t', sheet).text('Age');
            //     $('c[r=H1] t', sheet).text('Start date');
            //     $('c[r=I1] t', sheet).text('Salary');

            //     // Example: Set background color for the header row
            //     $('row:first c', sheet).attr('s', '42');
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
