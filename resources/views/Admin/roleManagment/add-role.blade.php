@extends('Admin.layouts.app')
@section('role-active','active')
@section('title',__('Role'))
@push('styles')
<style>
    .error {
        color: red;
    }
</style>
@endpush
@section('content')
<div class="app-main__outer">
    <div class="app-main__inner">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-add-user text-success">
                        </i>
                    </div>
                    <div>Manage Role
                    </div>
                </div>
                <div class="page-title-actions">
                </div>
            </div>
        </div>

        <div class="tab-content">
            <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <h5 class="card-title">Add Role</h5>
                        <form method="POST" action="{{ route('admin.roleManagment.role') }}"
                            data-url="{{ route('admin.roleManagment.role') }}" class="formSubmit fileUpload"
                            enctype="multipart/form-data" id="UserForm">
                            @csrf
                            <input type="hidden" name="uuid" id="uuid" value="{{ $data->id??'' }}">
                            <div class="col-md-4">
                                <div class="position-relative form-group">
                                    <label for="role" class="">Role</label>
                                    <input type="text" class="form-control" name="role"
                                        value="{{ old('role',$data->name??'') }}" id="role"
                                        placeholder="Enter Role">
                                    @if($errors->has('role'))
                                    <div class="error">{{ $errors->first('role') }}</div>
                                    @endif
                                </div>
                            </div>
                    </div>
                </div>
                <button class="mt-2 btn btn-primary">Submit</button>
                <a href="{{ route('admin.roleManagment.list') }}" class="mt-2 btn btn-secondary">&lt; Back</a>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
</div>
@endsection
@push('scripts')

@endpush
