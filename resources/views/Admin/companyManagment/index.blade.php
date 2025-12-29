@extends('Admin.layouts.app')
@section('company-active', 'active')
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
                            <i class="pe-7s-tools icon-gradient bg-happy-itmeo">
                            </i>
                        </div>
                        <div>List Company Details
                        </div>
                    </div>
                    <div class="page-title-actions">
                        @if (checkAdminPermissions('admin-company', auth()->user()->admin_role_id, auth()->user()->id, 'add'))
                            <a href="{{ route('admin.companyManagment.add') }}" class="btn-shadow btn btn-info"><i
                                    class="fa fa-plus-circle" aria-hidden="true">
                                    Add New Company</i></a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <h5 class="card-title">List Company Details</h5>
                            <div class="table-responsive">
                                <table class="mb-0 table ">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            {{-- <th>Logo</th> --}}
                                            <th>Company Name</th>
                                            <th>Company Registration No</th>
                                            <th>Company Address</th>
                                            <th>Company Phone</th>

                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- @dd($datas->toArray()); --}}
                                        @if ($datas)
                                            @forelse($datas as $key => $data)
                                                <tr>
                                                    <td>
                                                        <p>#{{ $key + 1 }}</p>
                                                    </td>
                                                    <td>
                                                        <p>{{ $data->name }}</p>
                                                    </td>
                                                    {{-- <td>
                                            <img src="{{ asset('profile_image/'.$data->profile_images) }}"
                                        width="100px"
                                        height="100px">
                                        </td> --}}
                                                    <td>
                                                        <p>{{ $data->registration_no }}</p>
                                                    </td>
                                                    <td>
                                                        <p>{{ $data->address }}</p>
                                                    </td>
                                                    <td>
                                                        <p>{{ $data->phone }}</p>
                                                    </td>

                                                    <td>
                                                        @if (checkAdminPermissions('admin-company', auth()->user()->admin_role_id, auth()->user()->id, 'edit'))
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox"
                                                                    class="custom-control-input statusChange"
                                                                    id="switch{{ $data->uuid }}"
                                                                    data-uuid="{{ $data->uuid }}"
                                                                    data-message="{{ $data->is_active ? 'deactive' : 'active' }}"
                                                                    data-table="company_managments" name="example"
                                                                    {{ $data->is_active == 1 ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="switch{{ $data->uuid }}"></label>
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if (checkAdminPermissions('admin-company', auth()->user()->admin_role_id, auth()->user()->id, 'edit'))
                                                            <a
                                                                href="{{ route('admin.companyManagment.edit', $data->uuid) }}"><i
                                                                    class="fa fa-edit" style="cursor: pointer;"
                                                                    title="Edit"></i></a>
                                                        @endif

                                                        <a
                                                            href="{{ route('admin.companyManagment.preview', $data->uuid) }}"><i
                                                                class="fa fa-eye" style="cursor: pointer;"
                                                                title="Edit"></i></a>
                                                        @if (checkAdminPermissions('admin-company', auth()->user()->admin_role_id, auth()->user()->id, 'delete'))
                                                            {{-- <a
                                                href="{{ route('admin.companyManagment.passwordUpdate',$data->uuid) }}"><i class="fa fa-lock" aria-hidden="true" title="password update"></i>
                                            --}}
                                                            {{-- </a> --}}

                                                            <a class="deleteData text-danger"
                                                                data-uuid="{{ $data->uuid }}"
                                                                data-table="company_managments" href="javascript:void(0)"><i
                                                                    class="fa fa-trash-alt" style="cursor: pointer;"
                                                                    title="Remove">
                                                                </i></a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @empty
                                                <p>!No Data Found</p>
                                            @endforelse
                                        @endif
                                    </tbody>

                                </table>

                                <div class="pagination-wrapper">
                                    {!! $datas->links() !!}
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
@endpush
