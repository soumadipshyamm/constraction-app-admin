@extends('Company.layouts.app')
@section('company-active', 'active')
@section('title', __('Companies'))
@push('styles')
    <style>
        .error {
            color: red;
        }

        .image-preview {
            width: 50px;
            height: 15px;
        }
    </style>
@endpush
@section('content')

    <div class="app-main__outer">

        <div class="app-main__inner card">

            <!-- dashboard body -->
            <div class="dashboard_body">
                <!-- company details -->
                <div class="company-details">
                    <h5>Add Your Company Details</h5>
                </div>
                <form method="POST" action="{{ route('company.companies.add') }}"
                    data-url="{{ route('company.companies.add') }}" class="formSubmit fileUpload" enctype="multipart/form-data"
                    id="UserForm">
                    @csrf
                    <input type="hidden" name="uuid" id="uuid" value="{{ $data->uuid ?? '' }}">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="registration_name" class="form-label">Registration Name</label>
                                <input type="text" class="form-control"
                                    value="{{ old('registration_name', $data->registration_name ?? '') }}"
                                    name="registration_name" id="registration_name" placeholder="Type Your Company Name">
                                @if ($errors->has('registration_name'))
                                    <div class="error">{{ $errors->first('registration_name') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="company_registration_no" class="form-label">Company Registration No</label>
                                <input type="text" class="form-control" name="company_registration_no"
                                    value="{{ old('company_registration_no', $data->company_registration_no ?? '') }}"
                                    id="company_registration_no" placeholder="Company Registration No">
                                @if ($errors->has('company_registration_no'))
                                    <div class="error">{{ $errors->first('company_registration_no') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="registered_address" class="form-label">Registered Address</label>
                                <input type="text" name="registered_address" id="registered_address" class="form-control"
                                    value="{{ old('registered_address', $data->registered_address ?? '') }}"
                                    placeholder=" Add Your Company Address">
                                @if ($errors->has('registered_address'))
                                    <div class="error">{{ $errors->first('registered_address') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="upload-btn-wrapper">
                                <label for="exampleInputPassword1" class="form-label">Upload Your Company Logo
                                    -</label>
                                <button class="btn"><i class="fa fa-upload" aria-hidden="true"></i></button>
                                <input class="image-upload" type="file" name="img"
                                    value="{{ old('img', $data->img ?? '') }}" id="img" accept="image/*">
                                @if ($errors->has('img'))
                                    <div class="error">{{ $errors->first('img') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="image-preview" style=" width: 180px; height: 15px;">
                        </div>
                        @if (isset($data->logo))
                            <div class="col display_picture">
                                <div class="form-group">
                                    <div class="uploadimage">
                                        <h6>
                                            <i class="fa mr-2" aria-hidden="true">
                                                <img src="{{ asset('logo/' . $data->logo) }}" alt="" width="80"
                                                    height="80" id="display_picture"></i>Current Image
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        @endif


                        <div class="col-md-12">
                            <div class="dashboard-button">
                                <a href="{{ route('company.companies.list') }}" class=" btn btn-primary">Cancel</a>
                                {{-- <button type="submit" class=" btn btn-primary">Cancel</button> --}}
                                <button type="submit" class="active btn btn-primary">Create</button>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
    @endsection @push('scripts')
@endpush
