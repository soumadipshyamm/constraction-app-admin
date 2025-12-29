@extends('Company.layouts.app')
@section('project-active', 'active')
@section('title', __('Project'))
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
                    <h5>Add New Project Details</h5>
                </div>
                {{-- @dd($data->toArray()); --}}
                <form method="POST" action="{{ route('company.project.add') }}" data-url="{{ route('company.project.add') }}"
                    class="formSubmit fileUpload" enctype="multipart/form-data" id="UserForm">
                    @csrf
                    <input type="hidden" name="uuid" id="uuid" value="{{ $data->uuid ?? '' }}">
                    <input type="hidden" name="clientUuid" id="clientUuid" value="{{ $data->client[0]->uuid ?? '' }}">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="project_name" class="form-label">Project Name</label>
                                <input type="text" class="form-control"
                                    value="{{ old('project_name', $data->project_name ?? '') }}" name="project_name"
                                    id="project_name" placeholder=" Enter Your Project Name">
                                @if ($errors->has('project_name'))
                                    <div class="error">{{ $errors->first('project_name') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="planned_start_date" class="">Planned Start Date</label>
                                <input type="date" class="form-control" name="planned_start_date"
                                    value="{{ old('planned_start_date', $data->planned_start_date ?? '') }}"
                                    id="planned_start_date" placeholder="Enter Planned Start Date">
                                @if ($errors->has('planned_start_date'))
                                    <div class="error">{{ $errors->first('planned_start_date') }}</div>
                                @endif
                            </div>
                        </div>
                        {{-- @dd($data); --}}
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="address"> Address</label>
                                <input type="text" name="address" id="address" class="form-control"
                                    value="{{ old('address', $data->address ?? '') }}" placeholder=" Enter  Address">
                                @if ($errors->has('address'))
                                    <div class="error">{{ $errors->first('address') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="planned_end_date" class="">Planned End Date</label>
                                <input type="date" class="form-control" name="planned_end_date"
                                    value="{{ old('planned_end_date', $data->planned_end_date ?? '') }}"
                                    id="planned_end_date" placeholder="Enter Planned Start Date">
                                @if ($errors->has('planned_end_date'))
                                    <div class="error">{{ $errors->first('planned_end_date') }}</div>
                                @endif
                            </div>
                        </div>
                        {{-- @dd($data->own_project_or_contractor); --}}
                        <div class="col-md-6">
                            <!-- <div class="form-check"> -->
                            <label for="exampleInputPassword1" class="form-label">Are you contractor for this project ?
                            </label>
                            <div class="comapny-check">
                                <input class="form-check-input clientPoint" type="radio" name="own_project_or_contractor"
                                    id="own_project_or_contractor_yes"
                                    value="{{ old('own_project_or_contractor', 'yes') }}"
                                    {{ !empty($data) ?? $data->own_project_or_contractor == 'yes' ? 'checked' : '' }}>
                                <label class="form-check-label" for="flexCheckIndeterminate">
                                    yes
                                </label>
                                <input class="form-check-input clientPoint" type="radio" name="own_project_or_contractor"
                                    id="own_project_or_contractor_yes" value="{{ old('own_project_or_contractor', 'no') }}"
                                    {{ !empty($data) ?? $data?->own_project_or_contractor == 'no' ? 'checked' : '' }}>
                                <label class="form-check-label" for="flexCheckIndeterminate">
                                    No
                                </label>
                                @if ($errors->has('own_project_or_contractor'))
                                    <div class="error">{{ $errors->first('own_project_or_contractor') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="bodyAdd" id="#bodyAdd">
                        </div>
                        <!-- company tag-buttom -->
                        <div class="col-md-3">
                            <label for="tag_company" class="company-tag "><span></span>Company Tag</label>
                            <select class="form-select" value="{{ old('tag_company') }}" name="tag_company"
                                id="multiple-select-field" data-placeholder="Choose anything" multiple>
                                <option value="">----Select---- </option>
                                {{ getCompany($data->companys->id ?? '') }}
                            </select>
                            @if ($errors->has('tag_company'))
                                <div class="error">{{ $errors->first('tag_company') }}</div>
                            @endif
                        </div>
                        {{-- {{getCompanyStaff('')}} --}}
                        {{-- {{ $data }} --}}
                        <div class="col-md-3">
                            <label for="tag_member" class="company-tag "><span></span>Project Manager Tag</label>
                            <select class="form-select" value="" name="tag_member[]" id="multiple-select-member"
                                data-placeholder="Choose anything">
                                {{-- <select class="form-select" value="" name="tag_member[]" id="multiple-select-member"
                                data-placeholder="Choose anything" multiple> --}}
                                <option value="">----Select Project Manager ---- </option>
                                {{-- {{ getProjectManager(isset($data) ? $data?->members?->pluck('id')->toArray() : '') }} --}}
                                {{-- {{ getProjectManager(isset($data) ? $data?->members?->pluck('id')->toArray() : '') }} --}}
                                {{ getCompanyUser(isset($data) ? $data?->members?->pluck('id')->toArray() : '') }}
                            </select>
                            {{-- @if ($errors->has('tag_member'))
                                <div class="error">{{ $errors->first('tag_member') }}</div>
                            @endif --}}
                        </div>
                        @if (!empty($data->uuid))
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="intermediate-check">
                                        <label for="project_completed" class="form-label">Project completed</label>
                                        <input class="form-check-input" type="checkbox" name="project_completed"
                                            id="project_completed" value="{{ old('project_completed', 'yes') }}"
                                            {{ isset($data) && $data->project_completed == 'yes' ? 'checked' : '' }}>
                                        @if ($errors->has('project_completed'))
                                            <div class="error">{{ $errors->first('project_completed') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="projectCompletDate" id="#projectCompletDate">
                            </div>
                        @endif
                        <div class="col-md-12">
                            <div class="upload-btn-wrapper">
                                <label for="exampleInputPassword1" class="form-label">Upload Your Project Logo
                                    -</label>
                                <button class="btn"><i class="fa fa-upload" aria-hidden="true"></i></button>
                                <input type="file" name="logo" id="logo" class="image-upload">
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
                                                <img src="{{ asset('logo/' . $data->logo) }}" alt=""
                                                    width="80" height="80" id="display_picture"></i>Current Image
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="col-md-12">
                            <div class="dashboard-button">
                                {{-- <button type="submit" class=" btn btn-primary">Cancel</button> --}}
                                <a href="{{ route('company.project.list') }}" class="active btn btn-primary">&lt;
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
        $(document).ready(function() {
            $('.clientPoint').on('change', function(e) {
                e.preventDefault();
                if ($(this).val() == 'yes') {
                    // alert('Project');
                    $('.bodyAdd').html(` <div class="client-name-add">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="client_company_name" class="">Client Name</label>
                                        <input type="text" class="form-control"
                                            value="{{ old('client_company_name', $data->client[0]->client_company_name ?? '') }}"
                                            name="client_company_name" id="client_company_name"
                                            placeholder=" Enter Your Client Name">
                                        @if ($errors->has('client_company_name'))
                                        <div class="error">{{ $errors->first('client_company_name') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="client_company_address" class="">Client Address</label>
                                        <input type="text" name="client_company_address" id="client_company_address"
                                            class="form-control"
                                            value="{{ old('client_company_address', $data->client[0]->client_company_address ?? '') }}"
                                            placeholder=" Enter Client Address">
                                        @if ($errors->has('client_company_address'))
                                        <div class="error">{{ $errors->first('client_company_address') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="point-contact">
                            <h5>Client Point of Contact</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="client_name" class="">Name</label>
                                        <input type="text" class="form-control"
                                            value="{{ old('client_name', $data->client[0]->client_name ?? '') }}"
                                            name="client_name" id="client_name"
                                            placeholder=" Enter Your client_pontin Name">
                                        @if ($errors->has('client_name'))
                                        <div class="error">{{ $errors->first('client_name') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="client_designation" class="">Designation</label>
                                        <input type="text" class="form-control" name="client_designation"
                                            value="{{ old('client_designation', $data->client[0]->client_designation ?? '') }}"
                                            id="client_designation" placeholder="Enter Your Designation">
                                        @if ($errors->has('client_designation'))
                                        <div class="error">{{ $errors->first('client_designation') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="client_email" class="">Email</label>
                                        <input type="email" class="form-control"
                                            value="{{ old('client_email', $data->client[0]->client_email ?? '') }}"
                                            name="client_email" id="client_email" placeholder=" Enter Your Email">
                                        @if ($errors->has('client_email'))
                                        <div class="error">{{ $errors->first('client_email') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="client_phone" class="">Phone Number</label>
                                        <input type="text" class="form-control" name="client_phone"
                                            value="{{ old('client_phone', $data->client[0]->client_phone ?? '') }}"
                                            id="client_phone" placeholder="Enter Your Phone Number">
                                        @if ($errors->has('client_phone'))
                                        <div class="error">{{ $errors->first('client_phone') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="client_mobile" class="">Mobile Number</label>
                                        <input type="text" class="form-control" name="client_mobile"
                                            value="{{ old('client_mobile', $data->client[0]->client_mobile ?? '') }}"
                                            id="client_mobile" placeholder="Enter Your Mobile Number">
                                        @if ($errors->has('client_mobile'))
                                        <div class="error">{{ $errors->first('client_mobile') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>`);
                } else {
                    $('.bodyAdd').html(` `);
                }
            });

            $('#project_completed').on('change', function(e) {
                e.preventDefault();
                if ($(this).is(":checked")) {
                    $('.projectCompletDate').html(`<div class="client-name-add">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="project_completed_date" class="">Project Completed Date</label>
                                        <input type="date" class="form-control"
                                            value="{{ old('project_completed_date') }}"
                                            name="project_completed_date" id="project_completed_date">
                                        @if ($errors->has('project_completed_date'))
                                        <div class="error">{{ $errors->first('project_completed_date') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>`);
                } else {
                    $('.projectCompletDate').html(` `);
                }
            });
        });
    </script>

    <script>
        $('#multiple-select-field').select2({
            // theme: "bootstrap-5",
            maximumSelectionLength: 1,
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder'),
            closeOnSelect: false,
        });
        $('#multiple-select-member').select2({
            // maximumSelectionLength: 1,
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder'),
            closeOnSelect: false,
        });
    </script>
@endpush
