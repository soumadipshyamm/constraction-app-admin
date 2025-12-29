@extends('Company.layouts.app')
@section('StoreWarehouse-active','active')
@section('title',__('Store/Warehouse'))
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
                    <div>Manage Store/Warehouse Details
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
                        <h5 class="card-title">Add Your Store/Warehouse Details</h5>
                        <form method="POST" action="{{ route('company.storeWarehouse.add') }}"
                            data-url="{{ route('company.storeWarehouse.add') }}" class="formSubmit fileUpload"
                            enctype="multipart/form-data" id="UserForm">
                            @csrf
                            <input type="hidden" name="uuid" id="uuid" value="{{ $data->uuid??'' }}">
                            <div class="form-row">
                                <div class="col-md-4">
                                    <div class="position-relative form-group">
                                        <label for="name" class="">Name</label>
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
                                        <label for="location" class="">Location</label>
                                        <input type="text" class="form-control" name="location"
                                            value="{{ old('location',$data->location??'') }}" id="location"
                                            placeholder="Enter Planned Start Date">
                                        @if($errors->has('location'))
                                        <div class="error">{{ $errors->first('location') }}</div>
                                        @endif
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

                            </div>
                            <button class="mt-2 btn btn-primary">Submit</button>
                            <a href="{{ route('company.storeWarehouse.list') }}" class="mt-2 btn btn-secondary">&lt; Back</a>
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
