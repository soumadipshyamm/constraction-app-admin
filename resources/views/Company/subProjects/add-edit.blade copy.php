@extends('Company.layouts.app')
@section('subProject-active','active')
@section('title',__('Sub-Project'))
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
                    <div>Manage Sub-Project Details
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
                        <h5 class="card-title">Add Your Sub-Project Details</h5>
                        <form method="POST" action="{{ route('company.subProject.add') }}"
                            data-url="{{ route('company.subProject.add') }}" class="formSubmit fileUpload"
                            enctype="multipart/form-data" id="UserForm">
                            @csrf
                            <input type="hidden" name="uuid" id="uuid" value="{{ $data->uuid??'' }}">
                            <div class="form-row">
                                <div class="col-md-4">
                                    <div class="position-relative form-group">
                                        <label for="name" class="">project Name</label>
                                        <input type="text" class="form-control"
                                            value="{{ old('name',$data->name??'') }}" name="name" id="name"
                                            placeholder=" Enter Your Project Name">
                                        @if($errors->has('name'))
                                        <div class="error">{{ $errors->first('name') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="position-relative form-group">
                                        <label for="start_date" class="">Planned Start Date</label>
                                        <input type="date" class="form-control" name="start_date"
                                            value="{{ old('start_date',$data->start_date??'') }}" id="start_date"
                                            placeholder="Enter Planned Start Date">
                                        @if($errors->has('start_date'))
                                        <div class="error">{{ $errors->first('start_date') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="position-relative form-group">
                                        <label for="end_date" class="">Planned End Date</label>
                                        <input type="date" class="form-control" name="end_date"
                                            value="{{ old('end_date',$data->end_date??'') }}" id="end_date"
                                            placeholder="Enter Planned Start Date">
                                        @if($errors->has('end_date'))
                                        <div class="error">{{ $errors->first('end_date') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="position-relative form-group">
                                    <label for="tag_project" class="">Tag Project</label>
                                    <select class="form-control" value="{{ old('tag_project',$data->tag_project??'') }}"
                                        name="tag_project" id="tag_project">
                                        <option value=""> select project</option>
                                        {{ getProject('') }}
                                    </select>
                                    @if($errors->has('tag_project'))
                                    <div class="error">{{ $errors->first('tag_project') }}</div>
                                    @endif
                                </div>
                            </div>
                            <button class="mt-2 btn btn-primary">Submit</button>
                            <a href="{{ route('company.subProject.list') }}" class="mt-2 btn btn-secondary">&lt; Back</a>
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
