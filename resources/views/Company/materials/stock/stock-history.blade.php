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
                </ul>
            </div>
            <div class="materials_tab">
                <div class="tab-content" id="pills-tabContent">
                    <div class="projecttable_box copybulk_head">
                        <a href="{{ route('company.materials.list') }}" class="mt-2 btn btn-secondary">&lt;
                            Back</a>
                        <div class="comp-body">
                            <div class="row">

                                <div class="col-lg-12">
                                    <div class="main-card mb-3 card">
                                        <div class="card-body">
                                            <h5 class="card-title">List Labour Details</h5>
                                            <div class="table-responsive">
                                                <table class="mb-0 table dataTable">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>In-stock</th>
                                                            <th>Add-tock</th>
                                                            <th>Less-Stock</th>
                                                            <th>Materials Name</th>
                                                            <th>Materials Code</th>
                                                            <th>Type</th>
                                                            <th>Action</th>
                                                            <!-- <th>Unit</th>
                                                            <th>Quantity</th> -->
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if($datas)
                                                        @forelse($datas as $key => $data)
                                                        <tr>
                                                            <td>
                                                                <p>#{{ $key + 1 }}</p>
                                                            </td>
                                                            <td>
                                                                <p>{{ $data->instock }}</p>
                                                            </td>
                                                            <td>
                                                                <p>{{ $data->addstock }}</p>
                                                            </td>
                                                            <td>
                                                                <p>{{ $data->lessstock }}</p>
                                                            </td>
                                                            <td>
                                                                <p>{{ $data->materials->name??'' }}</p>
                                                            </td>
                                                            <td>
                                                                <p>{{ $data->code }}</p>
                                                            </td>
                                                            <td>
                                                                <p>{{ $data->type }}</p>
                                                            </td>
                                                            <td>
                                                                <p>{{ $data->action}}</p>
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
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')

@endpush
