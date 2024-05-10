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
                            data-bs-target="#pills-materials" type="button" role="tab" aria-controls="pills-materials"
                            aria-selected="true">Materials List</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-bulkupload-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-bulkupload" type="button" role="tab" aria-controls="pills-bulkupload"
                            aria-selected="false">Bulk Upload of Material</button>
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
                                                                <th>Class of Materials</th>
                                                                <th>Materials Code</th>
                                                                <th>Materials Name</th>
                                                                <th>Specification</th>
                                                                <th>Unit</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="datatable_body">
                                                            @if($datas)
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
                                                                <td>
                                                                    <p>{{ $data->specification }}</p>
                                                                </td>
                                                                <td>
                                                                    <p>{{ $data->units->unit??'' }}</p>
                                                                </td>

                                                                <td>
                                                                    <a
                                                                        href="{{ route('company.materials.edit',$data->uuid) }}"><i
                                                                            class="fa fa-edit" style="cursor: pointer;"
                                                                            title="Edit"></i></a>

                                                                    <a class="deleteData text-danger"
                                                                        data-uuid="{{ $data->uuid }}"
                                                                        data-table="materials" data-model="company"
                                                                        href="javascript:void(0)"><i
                                                                            class="fa fa-trash-alt"
                                                                            style="cursor: pointer;" title="Remove">
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
                                                        class="img-fluid" alt="excel"></span>Export Materials Data</a>
                                        </div>
                                        <div class="excel_btnbox">
                                            <a href="{{ route('company.materials.demoExport') }}"
                                                class="excelbtn"><span><img
                                                        src="{{ asset('company_assets/images/excel.png') }}"
                                                        class="img-fluid" alt="excel"></span>Demo Import Materials
                                                Data</a>
                                        </div>

                                        <div class="excel_btnbox">
                                            <a class="excelbtn" data-bs-toggle="collapse" href="#collapseExample"
                                                role="button" aria-expanded="false"
                                                aria-controls="collapseExample"><span><img
                                                        src="{{ asset('company_assets/images/excel.png') }}"
                                                        class="img-fluid" alt="excel"></span>Import Materials Data</a>
                                        </div>
                                        <div class="collapse" id="collapseExample">
                                            <form action="{{ route('company.materials.import') }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf

                                                <div class="card card-body">
                                                    <input type="file" name="file" class="form-control" required>
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
                                <!-- <div class="projecttbh_right"> -->
                                <ul class="nav nav-pills " id="pills-tab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="btn btn-secondary" id="pills-bulkupload-tab"
                                            data-bs-toggle="pill" data-bs-target="#pills-opening-stock-bulkupload"
                                            type="button" role="tab" aria-controls="pills-bulkupload"
                                            aria-selected="true"><span><i class="fa-solid fa-plus"></i></span>Bulk
                                            Upload </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="btn btn-secondary" id="pills-bulkupload-tab"
                                            data-bs-toggle="pill" data-bs-target="#pills-opening-stock-materials"
                                            type="button" role="tab" aria-controls="pills-bulkupload"
                                            aria-selected="false"><span><i class="fa-solid fa-plus"></i></span>View
                                            Available Opeing
                                            Stock</button>
                                    </li>
                                </ul>
                                <!-- </div> -->
                                <!-- ******************************************************************************************************************* -->
                                <div class="tab-content" id="pills-tabContent">
                                    <div class="tab-pane fade" id="pills-opening-stock-bulkupload" role="tabpanel"
                                        aria-labelledby="pills-bulkupload-tab">
                                        <div class="projecttable_box copybulk_head">
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
                                                            <select class="form-control" value="{{ old('project') }}"
                                                                name="project" id="project">
                                                                <option value="">----Select Project----</option>
                                                                {{ getProject('') }}
                                                            </select>
                                                            @if($errors->has('project'))
                                                            <div class="error">{{ $errors->first('project') }}</div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="position-relative form-group">
                                                            <label for="warehouses" class="">Store/Warehouses</label>
                                                            <select class="form-control" value="{{ old('warehouses') }}"
                                                                name="warehouses" id="warehouses">
                                                                <option value="">----Select Store/Warehouses----
                                                                </option>
                                                                {{getStoreWarehouses('')}}
                                                            </select>
                                                            @if($errors->has('warehouses'))
                                                            <div class="error">{{ $errors->first('warehouses') }}</div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="position-relative form-group">
                                                            <label for="opeing_stock_date" class="">Opening Date</label>
                                                            <input type="date" class="form-control"
                                                                value="{{ old('opeing_stock_date') }}"
                                                                name="opeing_stock_date" id="opeing_stock_date">
                                                            @if($errors->has('opeing_stock_date'))
                                                            <div class="error">{{ $errors->first('opeing_stock_date') }}
                                                            </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card card-body">
                                                    <input type="file" name="file" class="form-control" required>
                                                    <br>
                                                    <div>
                                                        <button class="btn btn-success">Import
                                                            Data</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <!-- ******************************************************************************************************************* -->
                                    <div class="tab-pane fade" id="pills-opening-stock-materials" role="tabpanel"
                                        aria-labelledby="pills-bulkupload-tab">
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
                                                        @if($errors->has('project'))
                                                        <div class="error">{{ $errors->first('project') }}</div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="position-relative form-group">
                                                        <label for="warehouses" class="">Store/Warehouses</label>
                                                        <select class="form-control" value="{{ old('warehouses') }}"
                                                            name="warehouses" id="openigWarehouses">
                                                            <option value="">----Select Store/Warehouses----
                                                            </option>
                                                            {{getStoreWarehouses('')}}
                                                        </select>
                                                        @if($errors->has('warehouses'))
                                                        <div class="error">{{ $errors->first('warehouses') }}</div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="projecttable_box openingStockView" id="openingStockView">
                                            @include('Company.materials.include.opening-stock-list')
                                        </div>

                                        <!-- ******************************************************************************************************************* -->
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
        // alert(project + '/' + store);
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
});
</script>

@endpush