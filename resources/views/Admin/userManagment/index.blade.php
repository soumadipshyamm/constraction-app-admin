@extends('Admin.layouts.app')
@section('user-active','active')
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
                        <i class="pe-7s-user icon-gradient bg-happy-itmeo">
                        </i>
                    </div>
                    <div>Manage Users
                        <div class="page-title-subheading">Manage all admin user accounts
                        </div>
                    </div>
                </div>
                <div class="page-title-actions">
                    @if(checkAdminPermissions('admin-user',auth()->user()->admin_role_id,auth()->user()->id,'add'))

                    <a href="{{ route('admin.userManagment.add') }}" type="button" class="btn-shadow btn btn-info">
                        Add User
                    </a>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        {{-- <h5 class="card-title"></h5> --}}

                        <form id="filter_form" action="{{ route('admin.userManagment.list') }}" method="GET"
                            class="form-inline">
                            <div class="row">
                                <div class="col-md-8"></div>
                                <input type="hidden" name="page" value="1" id="filter_page">
                                <div class="mb-2 mr-sm-2 mb-sm-0 position-relative form-group">
                                    <label for="search_keyword" class="mr-sm-2">Search By</label>
                                    <input name="search_keyword" id="search_keyword"
                                        placeholder="Name / Email / Phone Number" type="text" class="form-control">
                                </div>
                                <div class="mb-2 mr-sm-2 mb-sm-0 position-relative form-group">
                                    <label for="user_type" class="mr-sm-2">User Type</label>
                                    <select name="user_type" id="user_type" class="form-control">
                                        <option value="">Select an User type</option>
                                        {{ getRole('') }}
                                    </select>
                                </div>
                            </div>
                            <button class="mt-2 btn btn-primary">Search</button>
                        </form>
                        {{-- <div class="divider"></div> --}}
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">List Users</h5>
                        <div class="table-responsive table-scrollable" id="load_content">
                            @include('Admin.userManagment.include.user-list')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection()
@push('scripts')

@endpush
