@extends('Company.layouts.app')
@section('teams-active','active')
@section('title',__('Teams'))
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
                    <div>Manage Teams Details
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
                        <h5 class="card-title">Add Your Teams Details</h5>
                        <form method="POST" action="{{ route('company.teams.add') }}"
                            data-url="{{ route('company.teams.add') }}" class="formSubmit fileUpload"
                            enctype="multipart/form-data" id="UserForm">
                            @csrf
                            <input type="hidden" name="uuid" id="uuid" value="{{ $data->uuid??'' }}">
                            <div class="form-row">
                                <div class="col-md-6">
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
                                <div class="col-md-6">
                                    <div class="position-relative form-group">
                                        <label for="designation" class="">Designation</label>
                                        <input type="text" class="form-control" name="designation"
                                            value="{{ old('designation',$data->designation??'') }}" id="designation"
                                            placeholder="Enter Planned Start Date">
                                        @if($errors->has('designation'))
                                        <div class="error">{{ $errors->first('designation') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="position-relative form-group">
                                        <label for="aadhar_no" class="">Aadhar No</label>
                                        <input type="text" class="form-control"
                                            value="{{ old('aadhar_no',$data->aadhar_no??'') }}" name="aadhar_no"
                                            id="aadhar_no" placeholder=" Enter Your Project aadhar_no">
                                        @if($errors->has('aadhar_no'))
                                        <div class="error">{{ $errors->first('aadhar_no') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="position-relative form-group">
                                        <label for="pan_no" class="">PAN No</label>
                                        <input type="text" class="form-control" name="pan_no"
                                            value="{{ old('pan_no',$data->pan_no??'') }}" id="pan_no"
                                            placeholder="Enter Planned Start Date">
                                        @if($errors->has('pan_no'))
                                        <div class="error">{{ $errors->first('pan_no') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <hr>
                            <h5 class="card-title">Contact Details</h5>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="position-relative form-group">
                                        <label for="email" class="">Email</label>
                                        <input type="email" class="form-control"
                                            value="{{ old('email',$data?->email??'') }}" name="email" id="email"
                                            placeholder=" Enter Your Client Name">
                                        @if($errors->has('email'))
                                        <div class="error">{{ $errors->first('email') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="position-relative form-group">
                                        <label for="phone" class="">Mobile No</label>
                                        <input type="text" class="form-control"
                                            value="{{ old('phone',$data?->phone??'') }}" name="phone" id="phone"
                                            placeholder=" Enter Your Client Name" max="10">
                                        @if($errors->has('phone'))
                                        <div class="error">{{ $errors->first('phone') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="position-relative form-group">
                                        <label for="address" class="">Address</label>
                                        <textarea name="address" id="address" class="form-control"
                                            value="{{ old('address',$data?->client?->address??'') }}"
                                            placeholder=" Enter Client Address">{{ old('address',$data?->address??'') }}</textarea>
                                        @if($errors->has('address'))
                                        <div class="error">{{ $errors->first('address') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="position-relative form-group">
                                        <label for="profile_role" class="">Assign Role</label>
                                        <select class="form-control" value="{{ old('profile_role',$data?->profile_role??'') }}"
                                            name="profile_role" id="profile_role">
                                            <option value="">---Select Profile Role---</option>
                                            {{ getProfileRole('') }}
                                        </select>
                                        @if($errors->has('profile_role'))
                                        <div class="error">{{ $errors->first('profile_role') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="position-relative form-group">
                                        <label for="reporting_person" class="">Reporting to</label>
                                        <select class="form-control"
                                            value="{{ old('reporting_person',$data?->reporting_person??'') }}"
                                            name="reporting_person" id="reporting_person">
                                            <option value="">---Select Reporting Person---</option>
                                            {{ getTeams('') }}
                                        </select>
                                        @if($errors->has('reporting_person'))
                                        <div class="error">{{ $errors->first('reporting_person') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="position-relative form-group">
                                        <label for="img" class="">Upload Photo</label>
                                        <input type="file" class="form-control" value="{{ old('img',$data?->img??'') }}"
                                            name="img" id="img">
                                        @if($errors->has('img'))
                                        <div class="error">{{ $errors->first('img') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <button class="mt-2 btn btn-primary">Submit</button>
                            <a href="{{ route('company.teams.list') }}" class="mt-2 btn btn-secondary">&lt; Back</a>
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
