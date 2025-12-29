@extends('Company.layouts.app')
@section('subProject-active', 'active')
@section('title', __('Sub-Project'))
@push('styles')
    <style>
        .error {
            color: red;
        }
    </style>
@endpush
@section('content')
    <div class="app-main__outer">
        <div class="app-main__inner card">
            <!-- dashboard body -->
            <div class="dashboard_body">
                <!-- Project details -->
                <div class="company-details">
                    <h5>Add Your Sub-Project Details</h5>
                </div>
                {{-- @dd($data); --}}
                <form method="POST" action="{{ route('company.subProject.add') }}"
                    data-url="{{ route('company.subProject.add') }}" class="formSubmit fileUpload"
                    enctype="multipart/form-data" id="UserForm">
                    @csrf
                    <input type="hidden" name="uuid" id="uuid" value="{{ $data->uuid ?? '' }}">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="">Sub-Project Name</label>
                                <input type="text" class="form-control" value="{{ old('name', $data->name ?? '') }}"
                                    name="name" id="name" placeholder=" Enter Your Sub-Project Name">
                                @if ($errors->has('name'))
                                    <div class="error">{{ $errors->first('name') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="start_date" class="">Planned Start Date</label>
                                <input type="date" class="form-control" name="start_date"
                                    value="{{ old('start_date', $data->start_date ?? '') }}" id="start_date"
                                    placeholder="Enter Planned Start Date">
                                @if ($errors->has('start_date'))
                                    <div class="error">{{ $errors->first('start_date') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="end_date" class="">Planned End Date</label>
                                <input type="date" class="form-control" name="end_date"
                                    value="{{ old('end_date', $data->end_date ?? '') }}" id="end_date"
                                    placeholder="Enter Planned Start Date">
                                @if ($errors->has('end_date'))
                                    <div class="error">{{ $errors->first('end_date') }}</div>
                                @endif
                            </div>
                        </div>
                        <!-- company tag-buttom -->
                        <div class="col-md-6">
                            <label for="tag_company">Tag Project</label>
                            <select class="form-control" value="{{ old('tag_project') }}" name="tag_project"
                                id="multiple-select-field" data-placeholder="Choose anything" multiple>
                                <option value=""> select project</option>
                                {{ getProject($data->project[0]->id ?? '') }}
                            </select>
                            @if ($errors->has('tag_project'))
                                <div class="error">{{ $errors->first('tag_project') }}</div>
                            @endif
                        </div>
                        <div class="col-md-12">
                            <div class="dashboard-button">
                                {{-- <button type="submit" class=" btn btn-primary">Cancel</button> --}}
                                <a href="{{ route('company.subProject.list') }}" class="mt-2 btn btn-secondary">&lt;
                                    Back</a>
                                <button type="submit" class="active btn btn-primary">Create</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $('#multiple-select-field').select2({
            // theme: "bootstrap-5",
            maximumSelectionLength: 1,
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder'),
            closeOnSelect: false,
        });
    </script>
@endpush
