@extends('Company.layouts.app')
@section('company-user-active', 'active')
@section('title', __('Company User'))
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
                        <div>Manage Users
                            <div class="page-title-subheading">Add New User
                            </div>
                        </div>
                    </div>
                    <div class="page-title-actions">
                    </div>
                </div>
            </div>


            <div class="container">
                @if (session()->has('message'))
                    <p>gsagxscsndcsdc gdmcemergfejrgfjmergvewfgvewmdngedednfve</p>
                @endif
            </div>

            <div class="tab-content">
                <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <h5 class="card-title">Add Your Teams Details</h5>
                            <form method="POST" action="{{ route('company.userManagment.add') }}"
                                data-url="{{ route('company.userManagment.add') }}" class="formSubmit fileUpload"
                                enctype="multipart/form-data" id="UserForm">
                                @csrf
                                <input type="hidden" name="uuid" id="uuid" value="{{ $data->uuid ?? '' }}">
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="position-relative form-group">
                                            <label for="name" class="">Name</label>
                                            <input type="text" class="form-control"
                                                value="{{ old('name', $data->name ?? '') }}" name="name" id="name"
                                                placeholder=" Enter Name">
                                            @if ($errors->has('name'))
                                                <div class="error">{{ $errors->first('name') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="position-relative form-group">
                                            <label for="designation" class="">Designation</label>
                                            <input type="text" class="form-control" name="designation"
                                                value="{{ old('designation', $data->designation ?? '') }}" id="designation"
                                                placeholder="Enter Designation">
                                            @if ($errors->has('designation'))
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
                                                value="{{ old('aadhar_no', $data->aadhar_no ?? '') }}" name="aadhar_no"
                                                id="aadhar_no" placeholder=" Enter Aadhar No">
                                            @if ($errors->has('aadhar_no'))
                                                <div class="error">{{ $errors->first('aadhar_no') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="position-relative form-group">
                                            <label for="pan_no" class="">PAN No</label>
                                            <input type="text" class="form-control" name="pan_no"
                                                value="{{ old('pan_no', $data->pan_no ?? '') }}" id="pan_no"
                                                placeholder="Enter PAN No">
                                            @if ($errors->has('pan_no'))
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
                                            <input type="email" class="form-control" name="email" id="email"
                                                placeholder="Enter Email" value="{{ old('email', $data->email ?? '') }}"
                                                @if (isset($data->uuid)) readonly @endif>
                                            @if ($errors->has('email'))
                                                <div class="error">{{ $errors->first('email') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="position-relative form-group">
                                            <label for="phone" class="">Mobile No</label>
                                            <input type="text" class="form-control"
                                                value="{{ old('phone', $data->phone ?? '') }}" name="phone"
                                                id="phone" placeholder=" Enter Mobile No" maxlength="10">
                                            @if ($errors->has('phone'))
                                                <div class="error">{{ $errors->first('phone') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    @if (!isset($data->uuid))
                                        <div class="col-md-6">
                                            <div class="position-relative form-group">
                                                <label for="password" class="">Password</label>
                                                <input type="password" class="form-control"
                                                    value="{{ old('password') }}" name="password" id="password"
                                                    placeholder=" Enter Password">
                                                @if ($errors->has('password'))
                                                    <div class="error">{{ $errors->first('password') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="position-relative form-group">
                                                <label for="password_confirmation" class="">Confirm Password</label>
                                                <input type="password" class="form-control"
                                                    value="{{ old('password_confirmation') }}"
                                                    name="password_confirmation" id="password_confirmation"
                                                    placeholder=" Enter Confirm Password">
                                                @if ($errors->has('password_confirmation'))
                                                    <div class="error">{{ $errors->first('password_confirmation') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                    <div class="col-md-6">
                                        <div class="position-relative form-group">
                                            <label for="address" class="">Address</label>
                                            <input type="text" name="address" id="address" class="form-control"
                                                value="{{ old('address', $data->address ?? '') }}">
                                            @if ($errors->has('address'))
                                                <div class="error">{{ $errors->first('address') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="position-relative form-group">
                                            <label for="country" class="">Country</label>
                                            <select name="country" id="country" class="form-control select_country">
                                                <option value="">Select Country</option>
                                                {{ getCountries('') }}
                                            </select>
                                            @if ($errors->has('country'))
                                                <div class="error">{{ $errors->first('country') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="position-relative form-group">
                                            <label for="states" class="">states</label>
                                            <select name="state" id="states" class="form-control select_state">
                                                <option value="">Select State</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="position-relative form-group">
                                            <label for="city" class="">City</label>
                                            <select name="city" id="city" class="form-control select_city">
                                                <option value="">Select City</option>
                                            </select>
                                            @if ($errors->has('city'))
                                                <div class="error">{{ $errors->first('city') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="position-relative form-group">
                                            <label for="dob" class="">Date of Birth</label>
                                            <input type="date" name="dob" id="dob" class="form-control"
                                                value="{{ old('dob', $data->dob ?? '') }}">
                                            @if ($errors->has('dob'))
                                                <div class="error">{{ $errors->first('dob') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="position-relative form-group">
                                            <label for="company_user_role" class="">Assign Role</label>
                                            <select class="form-control" value="{{ old('company_user_role') }}"
                                                name="company_user_role" id="company_user_role">
                                                <option value="">---Select Assign Role---</option>
                                                {{ getCompanyRole($data->companyUserRole->id ?? '') }}
                                            </select>
                                            @if ($errors->has('company_user_role'))
                                                <div class="error">{{ $errors->first('company_user_role') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    {{-- {{ getCompanyUser(isset($data) ? $data?->members?->pluck('id')->toArray() : '') }} --}}
                                    {{-- {{ getCompanyUser($data?->reporting_person ?? '') }} --}}

                                    <div class="col-md-6">
                                        <div class="position-relative form-group">
                                            <label for="reporting_person" class="">Reporting to</label>
                                            <select class="form-control" value="{{ old('reporting_person') }}"
                                                name="reporting_person" id="reporting_person">
                                                <option value="">---Select Reporting Person---</option>
                                                {{ getCompanyUser($data?->reporting_person ?? '') }}
                                            </select>
                                            @if ($errors->has('reporting_person'))
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
                                            <input type="file" class="form-control"
                                                value="{{ old('img', $data->img ?? '') }}" name="img"
                                                id="img">
                                            @if ($errors->has('img'))
                                                <div class="error">{{ $errors->first('img') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <button class="mt-2 btn btn-primary">Submit</button>
                                <a href="{{ route('company.userManagment.list') }}" class="mt-2 btn btn-secondary">&lt;
                                    Back</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection()
@push('scripts')
    <script>
        $(document).ready(function() {
            // Define the selectors once for reusability
            var $countrySelect = $('#country');
            var $stateSelect = $('#states');
            var $citySelect = $('#city');

            // Function to populate select elements
            function populateSelect($select, data) {
                $select.empty().append('<option value="">Select ' + $select.attr('name') + '</option>');
                $.each(data, function(key, value) {
                    $select.append('<option value="' + value.id + '">' + value.name + '</option>');
                });
            }
            // Country change event
            $countrySelect.change(function() {
                var countryId = $countrySelect.val();
                $.ajax({
                    url: baseUrl + `ajax/get-states`,
                    type: 'GET',
                    data: {
                        countryId: countryId
                    },
                    success: function(data) {
                        populateSelect($stateSelect, data);
                        $citySelect.empty(); // Clear city options
                    }
                });
            });

            // State change event
            $stateSelect.change(function() {
                var stateId = $stateSelect.val();
                $.ajax({
                    url: baseUrl + `ajax/get-cities`,
                    type: 'GET',
                    data: {
                        stateId: stateId
                    },
                    success: function(data) {
                        populateSelect($citySelect, data);
                    }
                });
            });
        });
    </script>
@endpush
