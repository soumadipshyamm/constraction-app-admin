@extends('Company.layouts.app')
@section('storeWarehouse-active', 'active')
@section('title', __('Store/Warehouse'))
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
                    <h5 class="card-title">Add Your Store/Warehouse Details</h5>
                </div>
                <form method="POST" action="{{ route('company.storeWarehouse.add') }}"
                    data-url="{{ route('company.storeWarehouse.add') }}" class="formSubmit fileUpload"
                    enctype="multipart/form-data" id="UserForm">
                    @csrf
                    <input type="hidden" name="uuid" id="uuid" value="{{ $data->uuid ?? '' }}">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="">Name</label>
                                <input type="text" class="form-control" value="{{ old('name', $data->name ?? '') }}"
                                    name="name" id="name" placeholder=" Enter Stores/Ware House Name">
                                @if ($errors->has('name'))
                                    <div class="error">{{ $errors->first('name') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="location" class="">Location</label>
                                <input type="text" class="form-control" name="location"
                                    value="{{ old('location', $data->location ?? '') }}" id="location"
                                    placeholder="Enter Location">
                                @if ($errors->has('location'))
                                    <div class="error">{{ $errors->first('location') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="tag_company">Tag Project </label>
                            <select class="form-control" value="{{ old('tag_project') }}" name="tag_project"
                                id="multiple-select-field" data-placeholder="Choose anything" multiple>
                                <option value=""> select project</option>
                                {{ getProject($data->projects_id ?? '') }}
                            </select>
                            @if ($errors->has('tag_project'))
                                <div class="error">{{ $errors->first('tag_project') }}</div>
                            @endif
                        </div>
                    </div>
            </div>
            <!-- company tag-buttom -->

            <div class="col-md-12">
                <div class="dashboard-button">
                    {{-- <button type="submit" class=" btn btn-primary">Cancel</button> --}}
                    <a href="{{ route('company.storeWarehouse.list') }}" class="mt-2 btn btn-secondary">&lt;
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
