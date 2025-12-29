@extends('Company.layouts.app')
@section('profileDesignation-active', 'active')
@section('title', __('Profile Designation'))
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
                    <div>Manage Profile Designation Details
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
                        <h5 class="card-title">Add Role/ Designation </h5>
                        <form method="POST" action="{{ route('company.profileDesignation.add') }}"
                            data-url="{{ route('company.profileDesignation.add') }}" class="formSubmit fileUpload"
                            enctype="multipart/form-data" id="UserForm">
                            @csrf
                            <input type="hidden" name="uuid" id="uuid" value="{{ $data->uuid ?? '' }}">
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="position-relative form-group">
                                        <label for="name" class="">Name</label>
                                        <input type="text" class="form-control"
                                            value="{{ old('name', $data->name ?? '') }}" name="name" id="name"
                                            placeholder=" Enter Role/Designation">
                                        @if ($errors->has('name'))
                                        <div class="error">{{ $errors->first('name') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <button class="mt-2 btn btn-primary">Submit</button>
                            <a href="{{ route('company.profileDesignation.list') }}" class="mt-2 btn btn-secondary">&lt;
                                Back</a>
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
