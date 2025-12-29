@extends('Company.layouts.app')
@section('materials-active', 'active')
@section('title', __('Materials'))
@push('styles')
@endpush
@section('content')
    <div class="app-main__outer">
        <div class="app-main__inner card">
            <!-- dashboard body -->
            <div class="dashboard_body">
                <div class="breadcrumbs">
                    <ul>
                        <li> <a href="#">Master</a></li>
                        <li> <a href="#">Materials</a></li>
                        <!-- <li> <a href="#">Project</a></li> -->
                    </ul>
                </div>
                <div class="materials_tab">
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pills-materials-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-materials" type="button" role="tab"
                                aria-controls="pills-materials" aria-selected="true">Materials List</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-bulkupload-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-bulkupload" type="button" role="tab"
                                aria-controls="pills-bulkupload" aria-selected="false">Bulk Upload of Material</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-openingstock-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-openingstock" type="button" role="tab"
                                aria-controls="pills-openingstock" aria-selected="false">Opening Stock</button>
                        </li>
                    </ul>
                    <!-- **********************************Materials List********************************************************************** -->
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-materials" role="tabpanel"
                            aria-labelledby="pills-materials-tab">
                            <div class="projecttable_box copybulk_head">

                                <div class="projecttbh_right">
                                    <a href="{{ route('company.materials.add') }}" class="ads-btn">
                                        <span><i class="fa-solid fa-plus"></i></span>Create new
                                    </a>
                                    <a href="{{ route('company.materials.export') }}" class="ads-btn">
                                        <span> <i class="fa fa-download" aria-hidden="true"
                                                title="Download Materials Data in Excel"></i></span>
                                    </a>
                                </div>
                                <div class="comp-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="main-card mb-3 card">
                                                <div class="card-body">
                                                    <h5 class="card-title">List Materials Details</h5>
                                                    <div class="table-responsive">
                                                        <table class="mb-0 table dataTable">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Class</th>
                                                                    <th>Code</th>
                                                                    <th>Name</th>
                                                                    <th>Specification</th>
                                                                    <th>Unit</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="datatable_body">
                                                                @if ($datas)
                                                                    @forelse($datas as $key => $data)
                                                                        <tr>
                                                                            <td>
                                                                                <p>#{{ $key + 1 }}</p>
                                                                            </td>
                                                                            <td>
                                                                                <p>{{ $data->class }}</p>
                                                                            </td>
                                                                            <td>
                                                                                <p>{{ $data->code }}</p>
                                                                            </td>
                                                                            <td>
                                                                                <p>{{ $data->name }}</p>
                                                                            </td>
                                                                            <td class="whitespace_no">
                                                                                <p>{{ $data->specification }}</p>
                                                                            </td>
                                                                            <td>
                                                                                <p>{{ $data->units->unit ?? '' }}</p>
                                                                            </td>
                                                                            <td>
                                                                                <a
                                                                                    href="{{ route('company.materials.edit', $data->uuid) }}"><i
                                                                                        class="fa fa-edit"
                                                                                        style="cursor: pointer;"
                                                                                        title="Edit"></i></a>

                                                                                <a class="deleteData text-danger"
                                                                                    data-uuid="{{ $data->uuid }}"
                                                                                    data-table="materials"
                                                                                    data-model="company"
                                                                                    href="javascript:void(0)"><i
                                                                                        class="fa fa-trash-alt"
                                                                                        style="cursor: pointer;"
                                                                                        title="Remove">
                                                                                    </i></a>
                                                                            </td>
                                                                        </tr>
                                                                    @empty
                                                                        <p>!No Data Found</p>
                                                                    @endforelse
                                                                @endif
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="handsontable"></div>
                            </div>
                        </div>

                        <!-- **************************Bulk Upload of Material************************************************************* -->
                        <div class="tab-pane fade" id="pills-bulkupload" role="tabpanel"
                            aria-labelledby="pills-bulkupload-tab">
                            <div class="projecttable_box copybulk_head">
                                <div class="tablesec-head blukup_head">
                                    <div class="row">
                                        <div class="col-md-7">
                                            <div class="excel_btnbox">
                                                <a href="{{ route('company.materials.export') }}"
                                                    class="excelbtn"><span><img
                                                            src="{{ asset('company_assets/images/excel.png') }}"
                                                            class="img-fluid" alt="excel"></span>Export Materials
                                                    Data</a>
                                            </div>
                                            <!-- <div class="excel_btnbox">
                                                                                            <a href="{{ route('company.materials.demoExport') }}"
                                                                                                class="excelbtn"><span><img
                                                                                                        src="{{ asset('company_assets/images/excel.png') }}"
                                                                                                        class="img-fluid" alt="excel"></span>Demo Import Materials
                                                                                                Data</a>
                                                                                        </div> -->

                                            <div class="excel_btnbox">
                                                <a class="excelbtn" data-bs-toggle="collapse" href="#collapseExample"
                                                    role="button" aria-expanded="false"
                                                    aria-controls="collapseExample"><span><img
                                                            src="{{ asset('company_assets/images/excel.png') }}"
                                                            class="img-fluid" alt="excel"></span>Import Materials
                                                    Data</a>
                                            </div>
                                            <div class="collapse" id="collapseExample">
                                                <form action="{{ route('company.materials.import') }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf

                                                    <div class="card card-body">
                                                        <input type="file" name="file" class="form-control"
                                                            required>
                                                        <br>
                                                        <div>
                                                            <button class="btn btn-success">Import Data</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="handsontable"></div>
                            </div>
                        </div>
                        <!-- ***************************Opening Stock************************************************************* -->
                        <div class="tab-pane fade" id="pills-openingstock" role="tabpanel"
                            aria-labelledby="pills-openingstock-tab">
                            <div class="projecttable_box copybulk_head">
                                <!-- <div class="comp-top"> -->
                                <div class="materials_tab">
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="home-tab" data-bs-toggle="tab"
                                                data-bs-target="#home" type="button" role="tab"
                                                aria-controls="home" aria-selected="true">Bulk Upload Opening
                                                Materials</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="profile-tab" data-bs-toggle="tab"
                                                data-bs-target="#profile" type="button" role="tab"
                                                aria-controls="profile" aria-selected="false">Available Opening
                                                Stock</button>
                                        </li>
                                    </ul>

                                    <!-- ************************************************************************************** -->
                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade show active" id="home" role="tabpanel"
                                            aria-labelledby="home-tab">
                                            <div class="tablesec-head blukup_head">
                                                <div class="row">
                                                    <div class="col-md-7">
                                                        <div class="excel_btnbox">
                                                            <a href="{{ route('company.materials.exportOpeningStock') }}"
                                                                class="excelbtn"><span><img
                                                                        src="{{ asset('company_assets/images/excel.png') }}"
                                                                        class="img-fluid" alt="excel"></span>Export
                                                                Materials Data</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr>
                                                <form action="{{ route('company.materials.importOpeningStock') }}"
                                                    method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="form-row">
                                                        <div class="col-md-4">
                                                            <div class="position-relative form-group">
                                                                <label for="class" class="">Project</label>
                                                                <select class="form-control upload-matrilas-project"
                                                                    value="{{ old('project') }}" name="project"
                                                                    id="project">
                                                                    <option value="">----Select Project----</option>
                                                                    {{ getProject('') }}
                                                                </select>
                                                                @if ($errors->has('project'))
                                                                    <div class="error">{{ $errors->first('project') }}
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="position-relative form-group">
                                                                <label for="warehouses"
                                                                    class="">Store/Warehouses</label>
                                                                <select class="form-control upload-matrilas-project-store"
                                                                    value="{{ old('warehouses') }}" name="warehouses"
                                                                    id="warehouses">
                                                                    <option value="">----Select Store/Warehouses----
                                                                    </option>
                                                                    {{ getStoreWarehouses('') }}
                                                                </select>
                                                                @if ($errors->has('warehouses'))
                                                                    <div class="error">{{ $errors->first('warehouses') }}
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="position-relative form-group">
                                                                <label for="opeing_stock_date" class="">Opening
                                                                    Date</label>
                                                                <input type="date" class="form-control"
                                                                    value="{{ old('opeing_stock_date') }}"
                                                                    name="opeing_stock_date" id="opeing_stock_date">
                                                                @if ($errors->has('opeing_stock_date'))
                                                                    <div class="error">
                                                                        {{ $errors->first('opeing_stock_date') }}
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card card-body">
                                                        <input type="file" name="file" class="form-control"
                                                            required>
                                                        <br>
                                                        <div>
                                                            <button class="btn btn-success">Import
                                                                Data</button>
                                                        </div>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                        <!-- ************************************************************************************** -->

                                        <div class="tab-pane fade" id="profile" role="tabpanel"
                                            aria-labelledby="profile-tab">
                                            <div class="projecttable_box copybulk_head">

                                                <div class="form-row" id="searchingProjectStore">
                                                    <div class="col-md-4">
                                                        <div class="position-relative form-group">
                                                            <label for="class" class="">Projectsss</label>
                                                            <select class="form-control" value="{{ old('project') }}"
                                                                name="project" id="openigProject">
                                                                <option value="">----Select Project----</option>
                                                                {{ getProject('') }}
                                                            </select>
                                                            @if ($errors->has('project'))
                                                                <div class="error">{{ $errors->first('project') }}</div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="position-relative form-group">
                                                            <label for="warehouses"
                                                                class="">Store/Warehouses</label>
                                                            <select class="form-control" value="{{ old('warehouses') }}"
                                                                name="warehouses" id="openigWarehouses">
                                                                <option value="">----Select Store/Warehouses----
                                                                </option>
                                                                {{-- {{ getStoreWarehouses('') }} --}}
                                                            </select>
                                                            @if ($errors->has('warehouses'))
                                                                <div class="error">{{ $errors->first('warehouses') }}
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="openingStockView" id="openingStockView">
                                                    @include('Company.materials.include.opening-stock-list')
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $('#searchingProjectStore').on('change', function() {
                let project = $("select[id='openigProject']").val();
                let store = $("select[id='openigWarehouses']").val();
                updateSubprojectsDropdownStocks(project, '#openigWarehouses')
                $.ajax({
                    type: "GET",
                    url: "{{ route('company.materials.list') }}",
                    // url: baseUrl + "ajax/get-material-opening-stock/",
                    // type: "POST",
                    // headers: {
                    //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    // },
                    data: {
                        project: project,
                        store: store
                    },
                    success: function(response) {
                        console.log(response);
                        $("#openingStockView").html(response);
                    },
                });

            });


            $('.upload-matrilas-project').on('change', function() {
                let project = $("select[id='project']").val();
                updateSubprojectsDropdownStocks(project, '#warehouses');

            });
        });

        function updateSubprojectsDropdownStocks(projectId, $id) {
            $.get(baseUrl + 'company/activities/storeprojects/' + projectId, function(data) {
                $($id).empty();
                $.each(data, function(key, value) {
                    console.log(value);
                    $.each(value.store_warehouse, function(subkey, subvalue) {
                        console.log(subvalue);
                        // alert(subvalue.name)
                        $($id).append('<option value="' + subvalue.id + '">' +
                            subvalue.name + '</option>');
                    });
                });
            });
        }
    </script>
@endpush

{{--
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
} --}}
