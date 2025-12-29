@extends('Company.layouts.app')
@section(' labourStrength-active', 'active')
@section('title', __('Labour Strength'))
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
                        <div> Labour Strength
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
                                    <form id="form-work-labour-strength" class="filter-form" {{--
                                            action="{{ route('company.report.workProgressDetails') }}" --}}
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
                                                <div class="singletabcin_head">
                                                    <label for="date">Select Contractor:</label>
                                                    <select class="form-control mySelect22 from_subproject"
                                                        value="{{ old('from_subproject') }}" name="from_subproject"
                                                        id="from_subproject">
                                                        <option value="">----Select Contractor----</option>
                                                    </select>
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
                                            // $toDate = $headerDetails['toDate'];
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
                                                                        <td>{{ isset($data->qty) && (int) $data->qty != 0 ?
                                                                            abs((int) $data->totalQtyInHistory / (int)
                                                                            $data->qty) : '' }}
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
            {{--
            </div> --}}
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
                $('.from_subproject').empty().append('<option value="">----Select SubProject----</option>');
            }
        });

        function updateSubprojectsDropdown(projectId) {
            $.ajax({
                url: baseUrl + 'company/activities/subprojects/' + projectId,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    var $subproject = $('.from_subproject');
                    $subproject.empty().append('<option value="">----Select SubProject----</option>');
                    if (data && Array.isArray(data)) {
                        data.forEach(function(item) {
                            if (item.sub_project && Array.isArray(item.sub_project)) {
                                item.sub_project.forEach(function(sub) {
                                    $subproject.append('<option value="' + sub.id + '">' + sub
                                        .name + '</option>');
                                });
                            }
                        });
                    }
                },
                error: function() {
                    $('.from_subproject').empty().append('<option value="">----Select SubProject----</option>');
                }
            });
        }

        // // ****************************************************************************************
        $(document).on('change', '#form-work-labour-strength', function() {
            // alert('sdfghj');
            var project = $('#from_project').val();
            var subproject = $('#from_subproject').val();
            var date_from = $('#from_date').val();
            // var date_to = $('#to_date').val();
            // alert(project + '/' +
            // subproject + '/' +
            // date_from);
            $.ajax({
                url: baseUrl + `ajax/get-report-labour-strength`,
                type: "POST",
                data: {
                    project: project,
                    subproject: subproject,
                    date_from: date_from,
                    // date_to: date_to
                },
                success: function(response) {
                    console.log(response);
                    formLabourStrengthDetails(response.vendorWiseLabour, response.headerDetails);
                    console.log("json.stringify(response)", JSON.stringify(response));

                    function formLabourStrengthDetails(data, headerDetails) {
                        let tableBody = $('#formWorkProgressDetails');
                        tableBody.empty();

                        let tableHtml = `
                                        <table class="table table-bordered" id="formLabourStrengthDetailsTable">
                                            <thead>
                                                <tr>
                                                    <th>Sl.no</th>
                                                    <th>Vendor</th>
                                                    <th>Labour Category</th>
                                                    <th>Labour Name</th>
                                                    <th>Qty</th>
                                                    <th>OT Qty</th>
                                                    <th>Date</th>
                                                    <th>Activity</th>
                                                </tr>
                                            </thead>
                                            <tbody>`;

                        let slNo = 1;
                        if (data && data.length > 0) {
                            data.forEach(function(vendorItem) {
                                let vendorName = vendorItem.vendor ? vendorItem.vendor.name :
                                    'Inhouse';
                                if (vendorItem.labour_details && vendorItem.labour_details
                                    .length > 0) {
                                    vendorItem.labour_details.forEach(function(labourDetail) {
                                        let labour = labourDetail.labour || {};
                                        tableHtml += `
                                                        <tr>
                                                            <td>${slNo++}</td>
                                                            <td>${vendorName}</td>
                                                            <td>${labour.category || ''}</td>
                                                            <td>${labour.name || ''}</td>
                                                            <td>${labourDetail.qty || 0}</td>
                                                            <td>${labourDetail.ot_qty || 0}</td>
                                                            <td>${labourDetail.date || ''}</td>
                                                            <td>${labourDetail.activity || ''}</td>
                                                        </tr>`;
                                    });
                                }
                            });
                        } else {
                            tableHtml +=
                                `<tr><td colspan="8" class="text-center">No data found to populate the table.</td></tr>`;
                        }

                        tableHtml += `
                                            </tbody>
                                        </table>`;

                        tableBody.html(tableHtml);

                        // Initialize DataTable with export options
                        $('#formLabourStrengthDetailsTable').DataTable({
                            destroy: true,
                            paging: true,
                            searching: true,
                            ordering: true,
                            info: true,
                            lengthChange: true,
                            pageLength: 10,
                            dom: 'Bfrtip',
                            buttons: [
                                'copy', 'csv', 'excel', 'pdf', 'print'
                            ]
                        });
                    }
                }
            });
        });


        // ****************************************************************************************
        // ****************************************************************************************
        // ****************************************************************************************
        // ****************************************************************************************
        // ****************************************************************************************
        // ****************************************************************************************


        // });
    </script>
@endpush
