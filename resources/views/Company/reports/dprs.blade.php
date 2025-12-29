@extends('Company.layouts.app')
@section('dpr-active', 'active')
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
                            <i class="pe-7s-car icon-gradient bg-mean-fruit"></i>
                        </div>
                        <div>DPR</div>
                    </div>
                    <div class="page-title-actions"></div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="main_wrapper">
                        <div class="main_card mb-3">
                            <div class="card_content">
                                <div class="tab-content" id="nav-tabContent">
                                    <form id="form-work-progress-dpr-details" class="filter-form" method="POST">
                                        @csrf
                                        <div class="tabcin_head">
                                            <div class="d-flex justify-content-between">
                                                <div class="singletabcin_head">
                                                    <label for="from_project">Project <span
                                                            class="text-danger">*</span></label>
                                                    <select class="form-control from_project" name="from_project"
                                                        id="from_project">
                                                        <option>---select project---</option>
                                                        {{ getProject($data->project_id ?? (isset($pid) ? $pid : null)) }}
                                                    </select>
                                                    @if ($errors->has('project'))
                                                        <div class="error">{{ $errors->first('project') }}</div>
                                                    @endif
                                                </div>
                                                <div class="singletabcin_head">
                                                    <label for="emp_id">Employee <span
                                                            class="text-danger">*</span></label>
                                                    <select class="form-control emp_id" name="emp_id" id="emp_id">
                                                        <option>---select User Name---</option>
                                                        {{ getCompanyUserList(isset($uid) ? $uid : 'null') }}
                                                    </select>
                                                    @if ($errors->has('emp_id'))
                                                        <div class="error">{{ $errors->first('emp_id') }}</div>
                                                    @endif
                                                </div>
                                                <div class="singletabcin_head">
                                                    <label for="from_date">Select From Date:</label>
                                                    <input type="date" class="form-control" id="from_date"
                                                        name="from_date" value="{{ isset($date) ? $date : 'null' }}">
                                                </div>
                                                <div class="singletabcin_head">
                                                    <button type="button" class="submitForm" id="submitForm">Export to
                                                        PDF</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="status_tab">
                                        <div class="tab-content" id="pills-tabContent">
                                            <div class="processdetails_box">
                                                <div class="process_table">
                                                    <div class="table-responsive" id="datasactivities"></div>
                                                </div>
                                                <div class="process_table">
                                                    <div class="table-responsive" id="datasmaterial"></div>
                                                </div>
                                                <div class="process_table">
                                                    <div class="table-responsive" id="datasLabour"></div>
                                                </div>
                                                <div class="process_table">
                                                    <div class="table-responsive" id="datasassets"></div>
                                                </div>
                                                <div class="process_table">
                                                    <div class="table-responsive" id="datashistorie"></div>
                                                </div>
                                                <div class="process_table">
                                                    <div class="table-responsive" id="datasafetie"></div>
                                                </div>
                                                <div class="attached_photos">
                                                    <h4>Attached Photos :</h4>
                                                    <h5>Safety </h5>
                                                    <div id="safetieImg"></div>
                                                    <h5>Hinderances</h5>
                                                    <div id="historieImg"></div>
                                                    <h5>Activities</h5>
                                                    <div id="activitiesImg"></div>
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
        $(document).ready(function() {
            $(".attached_photos").hide();
            var project = $('#from_project').val();
            var date_from = $('#from_date').val();
            var emp_id = $('#emp_id').val();
            fetchDPRDetails(project, date_from, emp_id);
        });

        $('#from_project').change(function() {
            var projectId = $(this).val();
            if (projectId) {
                updateSubprojectsDropdown(projectId);
            } else {
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
                        $('.from_subproject').append('<option value="' + subvalue.id + '">' +
                            subvalue.name + '</option>');
                    });
                });
            });
        }

        $(document).on('click', '#submitForm', function(e) {
            e.preventDefault();
            var formData = $('#form-work-progress-dpr-details').serialize();
            var params = {};
            // alert("sssssssssssssssssssss")
            formData.split('&').forEach(function(keyValue) {
                var parts = keyValue.split('=');
                var key = decodeURIComponent(parts[0]);
                var value = decodeURIComponent(parts[1].replace(/\+/g, ' '));
                params[key] = value;
            });
            $.ajax({
                url: baseUrl + `ajax/get-form-work-progress-dpr-details-pdf`,
                type: "POST",
                data: {
                    project: params['from_project'],
                    emp_id: params['emp_id'],
                    date_from: params['from_date'],
                },
                success: function(response) {
                    console.log(response);
                    var filename = response.filename;
                    // alert(filename);
                    var downloadUrl = baseUrl + 'ajax/download-pdf/' + filename;
                    window.location.href = downloadUrl;
                },
                error: function(xhr, status, error) {
                    console.error('Failed to generate PDF:', error);
                }
            });
        });

        $(document).on('change', '#form-work-progress-dpr-details', function() {
            var project = $('#from_project').val();
            var date_from = $('#from_date').val();
            var emp_id = $('#emp_id').val();
            fetchDPRDetails(project, date_from, emp_id);
        });

        function fetchDPRDetails(project, date_from, emp_id) {
            $.ajax({
                url: baseUrl + `ajax/get-form-work-progress-dpr-details`,
                type: "POST",
                data: {
                    project: project,
                    date_from: date_from,
                    emp_id: emp_id
                },
                success: function(response) {
                    $(".attached_photos").show();
                    datasactivities(response.activities);
                    datasmaterial(response.material);
                    datasLabour(response.labour);
                    datasassets(response.assets);
                    datashistorie(response.historie);
                    datasafetie(response.safetie);
                    safetieImg(response.safetie);
                    historieImg(response.historie);
                    activityImg(response.activities);
                },
                error: function(error) {
                    console.error(error);
                }
            });
        }
        // $(document).on('change', '#form-work-progress-dpr-details', function() {
        //     var project = $('#from_project').val();
        //     var date_from = $('#from_date').val();
        //     var emp_id = $('#emp_id').val();
        //     $.ajax({
        //         url: baseUrl + `ajax/get-form-work-progress-dpr-details`,
        //         type: "POST",
        //         data: {
        //             project: project,
        //             date_from: date_from,
        //             emp_id: emp_id
        //         },
        //         success: function(response) {
        //             $(".attached_photos").show();
        //             datasactivities(response.activities);
        //             datasmaterial(response.material);
        //             datasLabour(response.labour);
        //             datasassets(response.assets);
        //             datashistorie(response.historie);
        //             datasafetie(response.safetie);
        //             safetieImg(response.safetie);
        //             historieImg(response.historie);
        //             activityImg(response.activities);
        //         },
        //         error: function(error) {
        //             console.error(error);
        //         }
        //     });
        // });

        function datasactivities(data) {
            let tableBody = $('#datasactivities');
            tableBody.empty();
            let tableHtml = `<h4>Activities</h4><table class="table table-bordered" id="datasactivitiesTable">
                                    <thead>
                                        <th scope="col">Sl.no</th>
                                        <th scope="col">Activities</th>
                                        <th scope="col">Unit</th>
                                        <th scope="col">Estimate Qty</th>
                                        <th scope="col">Est Rate</th>
                                        <th scope="col">Est.Amount</th>
                                        <th scope="col">Completed Qty</th>
                                        <th scope="col">Est. Amount for Completion</th>
                                        <th scope="col">% Completion</th>
                                        <th scope="col">Balance qty</th>
                                        <th scope="col">Remarks</th>
                                    </thead>
                                    <tbody>`;
            if (data && data.length > 0) {
                data.forEach(function(stock) {
                    tableHtml +=
                        `<tr>
                            <td>${stock.sl_no || ''}</td>
                            <td>${stock.activities || ''}</td>
                            <td>${stock.unit || ''}</td>
                            <td>${stock.est_qty || 0}</td> <!-- Default to 0 if null -->
                            <td>${stock.est_rate || 0}</td> <!-- Default to 0 if null -->
                            <td>${stock.est_amount || 0}</td> <!-- Default to 0 if null -->
                            <td>${stock.completed_qty || 0}</td> <!-- Default to 0 if null -->
                            <td>${stock.est_amount_completion || 0}</td> <!-- Default to 0 if null -->
                            <td>${stock.completion || ''}</td>
                            <td>${stock.balance_qty || 0}</td> <!-- Default to 0 if null -->
                            <td>${stock.remarks || ''}</td>
                        </tr>`;

                });
            } else {
                console.log("No data found to populate the table.");
            }
            tableHtml += '</tbody></table>';
            tableBody.html(tableHtml);
        }

        function datasmaterial(data) {
            let tableBody = $('#datasmaterial');
            tableBody.empty();
            let tableHtml = `<h4>Materials</h4><table class="table table-bordered" id="datasmaterialTable">
                                    <thead>
                                        <th scope="col">Sl.no</th>
                                        <th scope="col">Materials Names</th>
                                        <th scope="col">Specification</th>
                                        <th scope="col">Unit</th>
                                        <th scope="col">Quantity Used</th>
                                        <th scope="col">Work details</th>
                                        <th scope="col">Remarks</th>
                                    </thead>
                                    <tbody>`;
            if (data && data.length > 0) {
                data.forEach(function(stock) {
                    tableHtml += `<tr>
                        <td>${stock.sl_no || ''}</td>
                        <td>${stock.materials || ''}</td>
                        <td>${stock.specification || ''}</td>
                        <td>${stock.unit || ''}</td>
                        <td>${stock.qty_used || 0}</td> <!-- Default to 0 if null -->
                        <td>${stock.work_details || ''}</td>
                        <td>${stock.remarks || ''}</td>
                    </tr>`;

                });
            } else {
                console.log("No data found to populate the table.");
            }
            tableHtml += '</tbody></table>';
            tableBody.html(tableHtml);
        }

        function datasLabour(data) {
            let tableBody = $('#datasLabour');
            tableBody.empty();
            let tableHtml = `<h4>Labour</h4><table class="table table-bordered" id="datasLabourTable">
                                    <thead>
                                        <th scope="col">Sl.no</th>
                                        <th scope="col">Labour Details</th>
                                        <th scope="col">Unit</th>
                                        <th scope="col">Quantity</th>
                                        <th scope="col">OT Quantity</th>
                                        <th scope="col">Labour Contractor</th>
                                        <th scope="col">Rate/Unit</th>
                                        <th scope="col">Remarks</th>
                                    </thead>
                                    <tbody>`;
            if (data && data.length > 0) {
                data.forEach(function(stock) {
                    tableHtml += `<tr>
                        <td>${stock.sl_no || ''}</td>
                        <td>${stock.labour_details || ''}</td>
                        <td>${stock.unit || ''}</td>
                        <td>${stock.qty || 0}</td> <!-- Default to 0 if null -->
                        <td>${stock.ot_qty || 0}</td> <!-- Default to 0 if null -->
                        <td>${stock.labour_contractor || ''}</td>
                        <td>${stock.rate || 0}</td> <!-- Default to 0 if null -->
                        <td>${stock.remarks || ''}</td>
                    </tr>`;

                });
            } else {
                console.log("No data found to populate the table.");
            }
            tableHtml += '</tbody></table>';
            tableBody.html(tableHtml);
        }

        function datasassets(data) {
            let tableBody = $('#datasassets');
            tableBody.empty();
            let tableHtml = `<h4>Machinery</h4><table class="table table-bordered" id="datasassetsTable">
                                    <thead>
                                        <th scope="col">Sl.no</th>
                                        <th scope="col">Machinery Names</th>
                                        <th scope="col">Specification</th>
                                        <th scope="col">Unit</th>
                                        <th scope="col">Quantity</th>
                                        <th scope="col">Contractor</th>
                                        <th scope="col">Rate/Unit</th>
                                        <th scope="col">Remarks</th>
                                    </thead>
                                    <tbody>`;
            if (data && data.length > 0) {
                data.forEach(function(stock) {
                    tableHtml += `<tr>
                    <td>${stock.sl_no || ''}</td>
                    <td>${stock.machinery_names || ''}</td>
                    <td>${stock.specification || ''}</td>
                    <td>${stock.unit || ''}</td>
                    <td>${stock.quantity || 0}</td> <!-- Default to 0 if null -->
                    <td>${stock.contractor || ''}</td>
                    <td>${stock.rate || 0}</td> <!-- Default to 0 if null -->
                    <td>${stock.remarks || ''}</td>
                </tr>`;

                });
            } else {
                console.log("No data found to populate the table.");
            }
            tableHtml += '</tbody></table>';
            tableBody.html(tableHtml);
        }

        function datashistorie(data) {
            let tableBody = $('#datashistorie');
            tableBody.empty();
            let tableHtml = `<h4>Hinderances</h4><table class="table table-bordered" id="datashistorieTable">
                                <thead>
                                    <th scope="col">Sl.no</th>
                                    <th scope="col">Hinderances Title</th>
                                    <th scope="col">Concern Team Members</th>
                                    <th scope="col">Remarks</th>
                                </thead>
                                <tbody>`;
            if (data && data.length > 0) {
                data.forEach(function(stock) {
                    tableHtml += `<tr>
                        <td>${stock.sl_no || ''}</td>
                        <td>${stock.hinderances_details || ''}</td>
                        <td>${stock.concern_team_members || ''}</td>
                        <td>${stock.remarks || ''}</td>
                    </tr>`;
                });
            } else {
                console.log("No data found to populate the table.");
            }
            tableHtml += '</tbody></table>';
            tableBody.html(tableHtml);
        }

        function datasafetie(data) {
            let tableBody = $('#datasafetie');
            tableBody.empty();
            let tableHtml = `<h4>Safety</h4><table class="table table-bordered" id="datasafetieTable">
                                <thead>
                                    <th scope="col">Sl.no</th>
                                    <th scope="col">Safety Title</th>
                                    <th scope="col">Concern Team Members</th>
                                    <th scope="col">Remarks</th>
                                </thead>
                                <tbody>`;
            if (data && data.length > 0) {
                data.forEach(function(stock) {
                    tableHtml += `<tr>
                        <td>${stock.sl_no || ''}</td>
                        <td>${stock.safety_problem_details || ''}</td>
                        <td>${stock.concern_team_members || ''}</td>
                        <td>${stock.remarks || ''}</td>
                    </tr>`;
                });
            } else {
                console.log("No data found to populate the table.");
            }
            tableHtml += '</tbody></table>';
            tableBody.html(tableHtml);
        }

        function safetieImg(data) {
            let tableBody = $('#safetieImg');
            tableBody.empty();
            let tableHtml = '';
            data.forEach(function(stock) {
                $.get(`${baseUrl}check-file-exists/${stock.img}`, function(exists) {
                    if (exists) {
                        tableHtml +=
                            `<img src="${baseUrl}upload/${stock.img}" alt="" width="100px" height="100px">`;
                    } else {
                        tableHtml += `<p>Image not found</p>`;
                    }
                });
            });
            tableBody.html(tableHtml);
        }

        function historieImg(data) {
            let tableBody = $('#historieImg');
            tableBody.empty();
            let tableHtml = '';
            data.forEach(function(stock) {
                $.get(`${baseUrl}check-file-exists/${stock.img}`, function(exists) {
                    if (exists) {
                        tableHtml +=
                            `<img src="${baseUrl}upload/${stock.img}" alt="" width="100px" height="100px">`;
                    } else {
                        tableHtml += `<p>Image not found</p>`;
                    }
                });
            });
            tableBody.html(tableHtml);
        }

        function activityImg(data) {
            let tableBody = $('#activitiesImg');
            tableBody.empty();
            let tableHtml = '';
            data.forEach(function(stock) {
                $.get(`${baseUrl}check-file-exists/${stock.img}`, function(exists) {
                    if (exists) {
                        tableHtml +=
                            `<img src="${baseUrl}upload/${stock.img}" alt="" width="100px" height="100px">`;
                    } else {
                        tableHtml += `<p>Image not found</p>`;
                    }
                });
            });
            tableBody.html(tableHtml);
        }
    </script>
@endpush
