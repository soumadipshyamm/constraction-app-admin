@extends('Company.layouts.app')
@section('role-active', 'active')
@section('title', __('Role Management'))
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
                        <div>Roles and Permissions
                            <div class="page-title-subheading">Manage all user roles
                            </div>
                        </div>
                    </div>
                    <div class="page-title-actions">
                        {{-- @if (checkAdminPermissions('admin-role-permissions', auth()->user()->admin_role_id, auth()->user()->id, 'add')) --}}

                        <a href="{{ route('company.roleManagment.role') }}" type="button" class="btn-shadow btn btn-info">
                            Add New Role
                        </a>
                        {{-- @endif --}}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="main-card mb-3 card">

                        <div class="card-body">
                            <h5 class="card-title">List User Roles</h5>
                            <div class="table-responsive">
                                <table class="mb-0 table" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            {{-- <th>Status</th> --}}
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($datas)
                                            @forelse ($datas as $key=>$data)
                                                <tr>
                                                    <th scope="row">{{ $key + 1 }}</th>
                                                    <td>{{ $data->name }}</td>
                                                    {{-- <td>
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input statusChange"
                                                    id="switch{{ $data->id }}" data-uuid="{{ $data->id }}" data-class="company"
                                                    data-message="{{ $data->is_active ? 'deactive' : 'active' }}"
                                                    data-table="admin_roles" name="example" {{ $data->is_active == 1 ?
                                                'checked' : '' }}>
                                                <label class="custom-control-label" for="switch{{ $data->id }}"></label>
                                            </div>
                                        </td> --}}
                                                    <td>
                                                        {{-- @if (checkAdminPermissions('admin-role-permissions', auth()->user()->admin_role_id, auth()->user()->id, 'edit')) --}}
                                                        @if ($data->slug != 'super-admin')
                                                            <a href="{{ route('company.roleManagment.edit', $data->id) }}"><i
                                                                    class="fa fa-edit" style="cursor: pointer;"
                                                                    title="Edit"> </i></a>
                                                            <a
                                                                href="{{ route('company.roleManagment.companyUserpermission', $data->id) }}"><i
                                                                    class="fa fa-cog" style="cursor: pointer;"
                                                                    title="Manage Permission"></i></a>
                                                            {{-- @endif --}}
                                                            {{-- @if (checkAdminPermissions('admin-role-permissions', auth()->user()->admin_role_id, auth()->user()->id, 'delete')) --}}
                                                            <a class="deleteData text-danger"
                                                                data-uuid="{{ $data->id }}" data-model="company"
                                                                data-id="id" data-table="company_roles"
                                                                href="javascript:void(0)"><i class="fa fa-trash-alt"
                                                                    style="cursor: pointer;" title="Remove">
                                                                </i></a>
                                                            {{-- @endif --}}
                                                        @endif
                                                    </td>
                                                </tr>
                                            @empty
                                            @endforelse
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            {{-- <div class="" style="margin-top: 20px;">
                            <nav class="" aria-label="Page navigation">
                                <ul class="pagination">
                                    <li class="page-item"><a href="javascript:void(0);" class="page-link"
                                            aria-label="Previous"><span aria-hidden="true">«</span><span
                                                class="sr-only">Previous</span></a></li>
                                    <li class="page-item"><a href="javascript:void(0);" class="page-link">1</a></li>
                                    <li class="page-item active"><a href="javascript:void(0);" class="page-link">2</a>
                                    </li>
                                    <li class="page-item"><a href="javascript:void(0);" class="page-link">3</a></li>
                                    <li class="page-item"><a href="javascript:void(0);" class="page-link">4</a></li>
                                    <li class="page-item"><a href="javascript:void(0);" class="page-link">5</a></li>
                                    <li class="page-item"><a href="javascript:void(0);" class="page-link"
                                            aria-label="Next"><span aria-hidden="true">»</span><span
                                                class="sr-only">Next</span></a></li>
                                </ul>
                            </nav>
                        </div> --}}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection()
@push('scripts')
@endpush
