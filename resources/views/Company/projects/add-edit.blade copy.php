@extends('Company.layouts.app')
@section('project-active','active')
@section('title',__('Project'))
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
                    <div>Manage Project Details
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
                        <h5 class="card-title">Add Your Project Details</h5>
                        <form method="POST" action="{{ route('company.project.add') }}"
                            data-url="{{ route('company.project.add') }}" class="formSubmit fileUpload"
                            enctype="multipart/form-data" id="UserForm">
                            @csrf
                            <input type="hidden" name="uuid" id="uuid" value="{{ $data->uuid??'' }}">
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="position-relative form-group">
                                        <label for="project_name" class="">project Name</label>
                                        <input type="text" class="form-control"
                                            value="{{ old('project_name',$data->project_name??'') }}"
                                            name="project_name" id="project_name"
                                            placeholder=" Enter Your Project Name">
                                        @if($errors->has('project_name'))
                                        <div class="error">{{ $errors->first('project_name') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="position-relative form-group">
                                        <label for="planned_start_date" class="">Planned Start Date</label>
                                        <input type="date" class="form-control" name="planned_start_date"
                                            value="{{ old('planned_start_date',$data->planned_start_date??'') }}"
                                            id="planned_start_date" placeholder="Enter Planned Start Date">
                                        @if($errors->has('planned_start_date'))
                                        <div class="error">{{ $errors->first('planned_start_date') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="position-relative form-group">
                                        <label for="address"> Address</label>
                                        <textarea name="address" id="address" class="form-control"
                                            value="{{ old('address',$data->address??'') }}"
                                            placeholder=" Enter  Address">{{ old('address',$data->address??'') }}</textarea>
                                        @if($errors->has('address'))
                                        <div class="error">{{ $errors->first('address') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="position-relative form-group">
                                        <label for="planned_end_date" class="">Planned End Date</label>
                                        <input type="date" class="form-control" name="planned_end_date"
                                            value="{{ old('planned_end_date',$data->planned_end_date??'') }}"
                                            id="planned_end_date" placeholder="Enter Planned Start Date">
                                        @if($errors->has('planned_end_date'))
                                        <div class="error">{{ $errors->first('planned_end_date') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="position-relative form-group">
                                        <label for="" class="">It's Your Own Project or You Are Contractor ?</label>
                                        <input type="radio" name="own_project_or_contractor"
                                            id="own_project_or_contractor_yes" class="form-control"
                                            value="{{ old('own_project_or_contractor',$data->own_project_or_contractor??'yes') }}">
                                        <label for="own_project_or_contractor_yes">YES</label>
                                        <input type="radio" name="own_project_or_contractor"
                                            id="own_project_or_contractor_no" class="form-control"
                                            value="{{ old('own_project_or_contractor',$data->own_project_or_contractor??'no') }}">
                                        <label for="own_project_or_contractor_no">NO</label>
                                        @if($errors->has('own_project_or_contractor'))
                                        <div class="error">{{ $errors->first('own_project_or_contractor') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="position-relative form-group">
                                        <label for="client_company_name" class="">Client Name</label>
                                        <input type="text" class="form-control"
                                            value="{{ old('client_company_name',$data?->client?->client_company_name??'') }}"
                                            name="client_company_name" id="client_company_name"
                                            placeholder=" Enter Your Client Name">
                                        @if($errors->has('client_company_name'))
                                        <div class="error">{{ $errors->first('client_company_name') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="position-relative form-group">
                                        <label for="client_company_address" class="">Client Address</label>
                                        <textarea name="client_company_address" id="client_company_address"
                                            class="form-control"
                                            value="{{ old('client_company_address',$data?->client?->client_company_address??'') }}"
                                            placeholder=" Enter Client Address">{{ old('client_company_address',$data?->client?->client_company_address??'') }}</textarea>
                                        @if($errors->has('client_company_address'))
                                        <div class="error">{{ $errors->first('client_company_address') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="">
                                    <h5><b>Client Point of Contact</b></h5>
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <div class="position-relative form-group">
                                                <label for="client_name" class="">Name</label>
                                                <input type="text" class="form-control"
                                                    value="{{ old('client_name',$data?->client?->client_name??'') }}"
                                                    name="client_name" id="client_name"
                                                    placeholder=" Enter Your client_pontin Name">
                                                @if($errors->has('client_name'))
                                                <div class="error">{{ $errors->first('client_name') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="position-relative form-group">
                                                <label for="client_designation" class="">Designation</label>
                                                <input type="text" class="form-control" name="client_designation"
                                                    value="{{ old('client_designation',$data?->client?->client_designation??'') }}"
                                                    id="client_designation" placeholder="Enter Your Designation">
                                                @if($errors->has('client_designation'))
                                                <div class="error">{{ $errors->first('client_designation') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <div class="position-relative form-group">
                                                <label for="client_email" class="">Email</label>
                                                <input type="email" class="form-control"
                                                    value="{{ old('client_email',$data?->client?->client_email??'') }}"
                                                    name="client_email" id="client_email"
                                                    placeholder=" Enter Your Email">
                                                @if($errors->has('client_email'))
                                                <div class="error">{{ $errors->first('client_email') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="position-relative form-group">
                                                <label for="client_phone" class="">Phone Number</label>
                                                <input type="text" class="form-control" name="client_phone"
                                                    value="{{ old('client_phone',$data?->client?->client_phone??'') }}"
                                                    id="client_phone" placeholder="Enter Your Phone Number">
                                                @if($errors->has('client_phone'))
                                                <div class="error">{{ $errors->first('client_phone') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <div class="position-relative form-group">
                                                <label for="client_mobile" class="">Mobile Number</label>
                                                <input type="text" class="form-control" name="client_mobile"
                                                    value="{{ old('client_mobile',$data?->client?->client_mobile??'') }}"
                                                    id="client_mobile" placeholder="Enter Your Mobile Number">
                                                @if($errors->has('client_mobile'))
                                                <div class="error">{{ $errors->first('client_mobile') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div>
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="position-relative form-group">
                                            <a href="#">+</a>
                                            <label for="tag_company" class="">Tag Company</label>
                                            <select class="form-control"
                                                value="{{ old('tag_company',$data->tag_company??'') }}"
                                                name="tag_company" id="tag_company">
                                                <option value=""></option>
                                                {{ getCompany($data->tag_company??'') }}
                                            </select>
                                            @if($errors->has('tag_company'))
                                            <div class="error">{{ $errors->first('tag_company') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="position-relative form-group">
                                            <label for="project_completed" class="">Project Completed</label>
                                            <input type="checkbox" name="project_completed" id="project_completed"
                                                class="form-control"
                                                value="{{ old('project_completed',$data->project_completed??'yes') }}">
                                            @if($errors->has('project_completed'))
                                            <div class="error">{{ $errors->first('project_completed') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="position-relative form-group">
                                            <label for="logo" class="">Upload Logo</label>
                                            <input type="file" class="form-control"
                                                value="{{ old('logo',$data->logo??'') }}" name="logo" id="logo"
                                                placeholder=" Enter Your Email">
                                            @if($errors->has('logo'))
                                            <div class="error">{{ $errors->first('logo') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button class="mt-2 btn btn-primary">Submit</button>
                            <a href="{{ route('company.project.list') }}" class="mt-2 btn btn-secondary">&lt; Back</a>
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
