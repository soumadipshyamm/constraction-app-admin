@extends('Company.layouts.app')
@section('assets-active','active')
@section('title',__('Assets'))
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
                    <div>List Asset/Equipments/Machinery Details
                    </div>
                </div>
                <div class="page-title-actions">
                    <a href="{{ route('admin.assets.add') }}" class="btn-shadow btn btn-info"><i
                            class="fa fa-plus-circle" aria-hidden="true">Add New Assets</i></a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <h5 class="card-title">List Asset/Equipments/Machinery Details</h5>
                        <div class="table-responsive">
                            <table class="mb-0 table dataTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Code</th>
                                        <th>Specification</th>
                                        <th>Units</th>
                                        <th>Quantity</th>
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
                                            <p>{{ $data->code }}</p>
                                        </td>
                                        <td>
                                            <p>{{ $data->specification }}</p>
                                        </td>
                                        <td>
                                            <p>{{ $data->units->unit }}</p>
                                        </td>
                                        <td>
                                            <p>{{ $data->quantity }}</p>
                                        </td>

                                        <td>
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input statusChange"
                                                    id="switch{{ $data->uuid }}" data-uuid="{{ $data->uuid }}"
                                                    data-message="{{ $data->is_active ? 'deactive' : 'active' }}"
                                                    data-table="assets" name="example" {{ $data->is_active == 1 ?
                                                'checked' : '' }}>
                                                <label class="custom-control-label"
                                                    for="switch{{ $data->uuid }}"></label>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.assets.edit',$data->uuid) }}"><i
                                                    class="fa fa-edit" style="cursor: pointer;" title="Edit"></i></a>
                                            <a class="deleteData text-danger" data-uuid="{{ $data->uuid }}"
                                                data-table="assets" href="javascript:void(0)"><i
                                                    class="fa fa-trash-alt" style="cursor: pointer;" title="Remove">
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
{{-- name
designation
aadhar_no
pan_no
email
phone
address
role --}}
