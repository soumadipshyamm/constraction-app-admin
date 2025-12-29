@extends('Company.layouts.app')
@section('user-active','active')
@section('title',__('Teams'))
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
                    <div>List Teams Details
                    </div>
                </div>
                <div class="page-title-actions">
                    <a href="{{ route('company.teams.add') }}" class="btn-shadow btn btn-info"><i class="fa fa-plus-circle" aria-hidden="true">Add New Teams</i></a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <h5 class="card-title">List Teams Details</h5>
                        <div class="table-responsive">
                            <table class="mb-0 table" id="dataTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>name</th>
                                        <th>designation</th>
                                        <th>aadhar_no</th>
                                        <th>pan_no</th>
                                        <th>email</th>
                                        <th>phone</th>
                                        <th>address</th>
                                        <th>Profile Role</th>
                                        <th>Reporting Person </th>
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
                                            <p>{{ $data->designation }}</p>
                                        </td>
                                        <td>
                                            <p>{{ $data->aadhar_no }}</p>
                                        </td>
                                        <td>
                                            <p>{{ $data->pan_no }}</p>
                                        </td>
                                        <td>
                                            <p>{{ $data->email }}</p>
                                        </td>
                                        <td>
                                            <p>{{ $data->phone }}</p>
                                        </td>
                                        <td>
                                            <p>{{ $data->address }}</p>
                                        </td>
                                        <td>
                                            <p>{{ $data?->profileRole?->name }}</p>
                                        </td>
                                        <td>
                                            <p>{{ $data->reporting_person  }}</p>
                                        </td>

                                        <td>
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input statusChange" id="switch{{ $data->uuid }}" data-uuid="{{ $data->uuid }}" data-message="{{ $data->is_active ? 'deactive' : 'active' }}" data-table="teams" name="example" {{ $data->is_active == 1 ?
                                                'checked' : '' }}>
                                                <label class="custom-control-label" for="switch{{ $data->uuid }}"></label>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="{{ route('company.teams.edit',$data->uuid) }}"><i class="fa fa-edit" style="cursor: pointer;" title="Edit"></i></a>
                                            <a class="deleteData text-danger" data-uuid="{{ $data->uuid }}" data-model="company" data-table="teams" href="javascript:void(0)"><i class="fa fa-trash-alt" style="cursor: pointer;" title="Remove">
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
