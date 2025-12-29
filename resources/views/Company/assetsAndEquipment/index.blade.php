@extends('Company.layouts.app')
@section('assets-active', 'active')
@section('title', __('Assets'))
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
                        <li> <a href="#">Asset-Equipments-Machinery</a></li>
                        <!-- <li> <a href="#">Project</a></li> -->
                    </ul>
                </div>
                <div class="materials_tab">
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pills-materials-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-materials" type="button" role="tab"
                                aria-controls="pills-materials" aria-selected="true">Asset/Equipments/Machinery
                                List</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-bulkupload-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-bulkupload" type="button" role="tab"
                                aria-controls="pills-bulkupload" aria-selected="false">Bulk Upload of
                                Asset/Equipments/Machinery</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-openingstock-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-openingstock" type="button" role="tab"
                                aria-controls="pills-openingstock" aria-selected="false">Opening Stock</button>
                        </li>
                    </ul>
                    <!-- **********************************Asset List********************************************************************** -->
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-materials" role="tabpanel"
                            aria-labelledby="pills-materials-tab">
                            <div class="projecttable_box copybulk_head">
                                <div class="projecttbh_right">
                                    {{-- @if (Session::has('expired') && Session::get('expired') === true) --}}
                                    {{-- <a href="#" data-swal-toast-template="#my-template" class="ads-btn"
                                            id="showToastButton">
                                            <span><i class="fa-solid fa-plus"></i></span>Create new
                                        </a> --}}
                                    {{-- @else --}}
                                    <a href="{{ route('company.assets.add') }}" class="ads-btn">
                                        <span><i class="fa-solid fa-plus"></i></span>Create new
                                    </a>
                                    <a href="{{ route('company.assets.export') }}" class="ads-btn">
                                        <span> <i class="fa fa-download" aria-hidden="true"
                                                title="Download Project Data in Excel"></i></span>
                                    </a>
                                    {{-- <a href="{{ route('company.assets.export') }}" class="excelbtn"><span><img
                                                src="{{ asset('company_assets/images/excel.png') }}" class="img-fluid"
                                                alt="excel" title="Export
                                                Asset/Equipments/Machinery Master Data"></span></a> --}}

                                    {{-- @endif --}}
                                </div>

                                <div class="comp-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="main-card mb-3 card">
                                                <div class="card-body">
                                                    <h5 class="card-title">Asset/Equipments/Machinery</h5>
                                                    <div class="table-responsive">
                                                        <table class="mb-0 table" id="dataTable">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <!-- <th>Project</th> -->
                                                                    <!-- <th>Store Houses</th> -->
                                                                    <th>Name</th>
                                                                    <th>Code</th>
                                                                    <th>Specification</th>
                                                                    <th>Units</th>
                                                                    <!-- <th>Qty</th> -->
                                                                    <th>Status</th>
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
                                                                            {{-- <!-- <td>
                                                                    <p>{{ $data->project->project_name??'' }}</p>
                                                                </td>
                                                                <td>
                                                                    <p>{{ $data->store_warehouses->name??'' }}</p>
                                                                </td> --> --}}
                                                                            <td>
                                                                                <p>{{ $data->name }}</p>
                                                                            </td>
                                                                            <td>
                                                                                <p>{{ $data->code }}</p>
                                                                            </td>
                                                                            <td class="whitespace_no">
                                                                                <p>{{ $data->specification }}
                                                                                </p>
                                                                            </td>
                                                                            <td>
                                                                                <p>{{ $data->units->unit ?? '' }}</p>
                                                                            </td>
                                                                            <td>
                                                                                <div class="custom-control custom-switch">
                                                                                    <input type="checkbox"
                                                                                        class="custom-control-input statusChange"
                                                                                        id="switch{{ $data->uuid }}"
                                                                                        data-uuid="{{ $data->uuid }}"
                                                                                        data-message="{{ $data->is_active ? 'deactive' : 'active' }}"
                                                                                        data-table="assets"
                                                                                        data-model="company" name="example"
                                                                                        {{ $data->is_active == 1 ? 'checked' : '' }}>
                                                                                    <label class="custom-control-label"
                                                                                        for="switch{{ $data->uuid }}"></label>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <a
                                                                                    href="{{ route('company.assets.edit', $data->uuid) }}"><i
                                                                                        class="fa fa-edit"
                                                                                        style="cursor: pointer;"
                                                                                        title="Edit"></i></a>
                                                                                <a class="deleteData text-danger"
                                                                                    data-uuid="{{ $data->uuid }}"
                                                                                    data-table="assets" data-model="company"
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
                                                <a href="{{ route('company.assets.export') }}"
                                                    class="excelbtn"><span><img
                                                            src="{{ asset('company_assets/images/excel.png') }}"
                                                            class="img-fluid" alt="excel"></span>Export
                                                    Asset/Equipments/Machinery Master Data</a>
                                            </div>
                                            {{-- <div class="excel_btnbox">
                                                <a href="{{ route('company.assets.demoExport') }}"
                                                    class="excelbtn"><span><img
                                                            src="{{ asset('company_assets/images/excel.png') }}"
                                                            class="img-fluid" alt="excel"></span>Demo Import
                                                    Asset/Equipments/Machinery Master</a>
                                            </div> --}}
                                            <div class="excel_btnbox">
                                                <a class="excelbtn" data-bs-toggle="collapse" href="#collapseExample"
                                                    role="button" aria-expanded="false"
                                                    aria-controls="collapseExample"><span><img
                                                            src="{{ asset('company_assets/images/excel.png') }}"
                                                            class="img-fluid" alt="excel"></span>Import
                                                    Asset/Equipments/Machinery Master Data</a>
                                            </div>
                                            <div class="collapse" id="collapseExample">
                                                <form action="{{ route('company.assets.import') }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="collapse" id="collapseExample">
                                                        {{-- <div class="form-row">
                                                            <div class="col-md-4">
                                                                <div class="position-relative form-group">
                                                                    <label for="class" class="">Project</label>
                                                                    <select class="form-control"
                                                                        value="{{ old('project') }}" name="project"
                                                    id="project">
                                                    <option value="">----Select Project----
                                                    </option>
                                                    {{ getProject('') }}
                                                    </select>
                                                    @if ($errors->has('project'))
                                                    <div class="error">
                                                        {{ $errors->first('project') }}
                                                    </div>
                                                    @endif
                                                </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="position-relative form-group">
                                                <label for="warehouses" class="">Store/Warehouses</label>
                                                <select class="form-control" value="{{ old('warehouses') }}" name="warehouses" id="warehouses">
                                                    <option value="">----Select
                                                        Store/Warehouses----
                                                    </option>
                                                    {{ getStoreWarehouses('') }}
                                                </select>
                                                @if ($errors->has('warehouses'))
                                                <div class="error">
                                                    {{ $errors->first('warehouses') }}
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div> --}}
                                                        <div class="card card-body">
                                                            <input type="file" name="file" class="form-control"
                                                                required>
                                                            <br>
                                                            <div>
                                                                <button class="btn btn-success">Import Data</button>
                                                            </div>
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
                                                Stock</button>
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
                                                            <a href="{{ route('company.assets.exportOpeningStock') }}"
                                                                class="excelbtn"><span><img
                                                                        src="{{ asset('company_assets/images/excel.png') }}"
                                                                        class="img-fluid" alt="excel"></span>Export
                                                                Asset/Equipments/Machinery Data</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr>
                                                <form action="{{ route('company.assets.importOpeningStock') }}"
                                                    method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="form-row" id="searchingProjectStoress">
                                                        {{-- <div class="form-row"> --}}
                                                        <div class="col-md-4">
                                                            <div class="position-relative form-group">
                                                                <label for="class" class="">Project</label>
                                                                <select class="form-control upload-matrilas-project"
                                                                    value="{{ old('project') }}" name="project"
                                                                    id="openigProjects">
                                                                    <option value="">----Select Project----
                                                                    </option>
                                                                    {{ getProject('') }}
                                                                </select>
                                                                @if ($errors->has('project'))
                                                                    <div class="error">
                                                                        {{ $errors->first('project') }}
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="position-relative form-group">
                                                                <label for="warehouses"
                                                                    class="">Store/Warehouses</label>
                                                                <select class="form-control"
                                                                    value="{{ old('warehouses') }}" name="warehouses"
                                                                    id="openigWarehousestore">
                                                                    <option value="">----Select
                                                                        Store/Warehouses----
                                                                    </option>
                                                                    {{-- {{ getStoreWarehouses('') }} --}}
                                                                </select>
                                                                @if ($errors->has('warehouses'))
                                                                    <div class="error">
                                                                        {{ $errors->first('warehouses') }}
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        {{-- </div> --}}
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
                                                            <label for="class" class="">Project</label>
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
                                                    @include('Company.assetsAndEquipment.include.opening-stock-list')
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
    {{-- <script>
        $(document).ready(function() {
            $('#searchingProjectStore').on('change', function() {
                let project = $("select[id='openigProject']").val();
                let store = $("select[id='openigWarehouses']").val();
                // alert(project + '/' + store);
                $.ajax({
                    type: "GET",
                    url: "{{ route('company.assets.list') }}",
                    data: {
                        project: project,
                        store: store,
                    },
                    success: function(response) {
                        $("#openingStockView").html(response);
                    },
                });
            });
        });

        $(document).ready(function() {
            $('#showToastButton').click(function() {
                $.ajax({
                    url: '/show-toast',
                    type: 'GET',
                    success: function(response) {
                        if (response.status === 'success') {
                            // Display a SweetAlert Toast
                            Swal.fire({
                                title: response.message,
                                icon: 'success',
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        // Handle errors if necessary
                    }
                });
            });
        });

        $(document).ready(function() {
            $('#searchingProjectStoress').on('change', function() {
                let project = $("select[id='openigProjects']").val();
                let store = $("select[id='openigWarehousestore']").val();
                updateSubprojectsDropdownStocks(project, '#openigWarehousestore')
                $.ajax({
                    type: "GET",
                    url: "{{ route('company.materials.list') }}",
                    data: {
                        project: project,
                        store: store,
                    },
                    success: function(response) {
                        $("#openingStockView").html(response);
                    },
                });

            });


            $('.upload-matrilas-project').on('change', function() {
                let project = $("select[id='project']").val();
                updateSubprojectsDropdownStocks(project, '#openigWarehousestore');

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
    </script> --}}

    <script>
        $(document).ready(function() {
            // Function to update the subprojects dropdown based on the selected project
            function updateSubprojectsDropdownStocks(projectId, dropdownId) {
                $.get(baseUrl + 'company/activities/storeprojects/' + projectId, function(data) {
                    $(dropdownId).empty();
                    $.each(data, function(key, value) {
                        $.each(value.store_warehouse, function(subkey, subvalue) {
                            $(dropdownId).append('<option value="' + subvalue.id + '">' + subvalue.name + '</option>');
                        });
                    });
                }).fail(function() {
                    console.error('Failed to fetch store projects.');
                });
            }

            // Event handler for project store selection change
            $('#searchingProjectStore').on('change', function() {
                const project = $("select[id='openigProject']").val();
                const store = $("select[id='openigWarehouses']").val();
                updateSubprojectsDropdownStocks(project, '#openigWarehouses');

                $.ajax({
                    type: "GET",
                    url: "{{ route('company.assets.list') }}",
                    data: { project, store },
                    success: function(response) {
                        $("#openingStockView").html(response);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching assets:', error);
                    }
                });
            });

            // Event handler for showing toast notification
            $('#showToastButton').on('click', function() {
                $.ajax({
                    url: '/show-toast',
                    type: 'GET',
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire({
                                title: response.message,
                                icon: 'success',
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error showing toast:', error);
                    }
                });
            });

            // Event handler for project store selection change in another dropdown
            $('#searchingProjectStoress').on('change', function() {
                const project = $("select[id='openigProjects']").val();
                const store = $("select[id='openigWarehousestore']").val();
                updateSubprojectsDropdownStocks(project, '#openigWarehousestore');

                $.ajax({
                    type: "GET",
                    url: "{{ route('company.materials.list') }}",
                    data: { project, store },
                    success: function(response) {
                        $("#openingStockView").html(response);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching materials:', error);
                    }
                });
            });

            // Event handler for file upload change
            $('.upload-matrilas-project').on('change', function() {
                const project = $("select[id='project']").val();
                updateSubprojectsDropdownStocks(project, '#openigWarehousestore');
            });
        });
    </script>

@endpush
