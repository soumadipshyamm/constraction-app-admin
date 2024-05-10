@extends('Company.layouts.app')
@section('dashboard-active','active')
@section('title',__('Dashboard'))
@push('styles')
@endpush

@section('content')
<div class="app-main__outer">
    <div class="app-main__inner">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-tools icon-gradient bg-happy-itmeo">
                        </i>
                    </div>
                    <div>List Store/Warehouse Details
                    </div>
                </div>
                <div class="page-title-actions">
                    <a href="{{ route('company.storeWarehouse.add') }}" class="btn-shadow btn btn-info"><i class="fa fa-plus-circle" aria-hidden="true">Add New Store/Warehouse</i></a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <h5 class="card-title">List Store/Warehouse Details</h5>
                        <div class="table-responsive">
                            <table class="mb-0 table dataTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Location</th>
                                        <th>Project Name</th>
                                        <th>Status</th>
                                        <th>Action</th>
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
                                            <p>{{ $data->name }}</p>
                                        </td>
                                        <td>
                                            <p>{{ $data->location }}</p>
                                        </td>
                                        <td>
                                            <p>{{ $data?->project?->project_name }}</p>
                                        </td>

                                        <td>
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input statusChange" id="switch{{ $data->uuid }}" data-uuid="{{ $data->uuid }}" data-message="{{ $data->is_active ? 'deactive' : 'active' }}" data-table="store_warehouses" name="example" {{ $data->is_active == 1 ?
                                                'checked' : '' }}>
                                                <label class="custom-control-label" for="switch{{ $data->uuid }}"></label>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="{{ route('company.storeWarehouse.edit',$data->uuid) }}"><i class="fa fa-edit" style="cursor: pointer;" title="Edit"></i></a>
                                            <a class="deleteData text-danger" data-uuid="{{ $data->uuid }}" data-table="store_warehouses" href="javascript:void(0)"><i class="fa fa-trash-alt" style="cursor: pointer;" title="Remove">
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
@endsection

@push('scripts')
@endpush
