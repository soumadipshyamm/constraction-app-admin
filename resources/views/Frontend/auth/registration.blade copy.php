@extends('Frontend.layouts.app')
@section('registration-active', 'active')
@section('title', __('Registration'))
@push('styles')
    <style>
        h3 .companyRegHeading {
            text-align: center;
            padding: 10px;
            font-size: 25px;
        }

        .error {
            color: red;
        }
    </style>
@endpush
@section('content')
    <div class="sign-up-banner">
        <img src="{{ asset('assets/images/signup-banner.png') }}" class="img-fluid" alt="">
        <div class="inner-banner-content">
            <h1>
                Registration
            </h1>
        </div>
    </div>
    <section class="sign-up">
        <div class="container">
            <div class="log-in-content">
                <form method="POST" action="{{ route('company.registration') }}"
                    data-url="{{ route('company.registration') }}" class="formSubmit fileUpload"
                    enctype="multipart/form-data" id="User Form">
                    @csrf
                    <div class="row">
                        <h3 style="text-align: center;padding-bottom: 15px;">Company Details</h3>
                        <hr>
                        <div class="col-md-6">
                            <label for="registration_name">Company Name*</label>
                            <input type="text" class="form-control" name="registration_name" id="registration_name"
                                placeholder="Enter Company Name*" value="{{ old('registration_name') }}" required>
                            @if ($errors->has('registration_name'))
                                <div class="error">{{ $errors->first('registration_name') }}</div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <label for="company_registration_no">Company Registration No</label>
                            <input type="text" class="form-control" name="company_registration_no"
                                id="company_registration_no" placeholder="Enter Company Registration No"
                                value="{{ old('company_registration_no') }}" required>
                            @if ($errors->has('company_registration_no'))
                                <div class="error">{{ $errors->first('company_registration_no') }}</div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <label for="company_address">Company Address*</label>
                            <input type="text" class="form-control" name="company_address" id="company_address"
                                placeholder="Enter Company Address*" value="{{ old('company_address') }}" required>
                            @if ($errors->has('company_address'))
                                <div class="error">{{ $errors->first('company_address') }}</div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <label for="company_phone">Company Phone Number*</label>
                            <input type="text" class="form-control" name="company_phone" id="company_phone"
                                placeholder="Enter Company Phone Number*" value="{{ old('company_phone') }}" required>
                            @if ($errors->has('company_phone'))
                                <div class="error">{{ $errors->first('company_phone') }}</div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <label for="website_link">Company Website Link</label>
                            <input type="text" class="form-control" name="website_link" id="website_link"
                                placeholder="Enter Company Website Link">
                        </div>
                    </div>
                    <h3 style="text-align: center;padding-bottom: 15px;">User  Details</h3>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="name">Contact Person Name*</label>
                            <input type="text" class="form-control" name="name" id="name"
                                placeholder="Contact Person Name*" value="{{ old('name') }}" required>
                            @if ($errors->has('name'))
                                <div class="error">{{ $errors->first('name') }}</div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <label for="phone">Contact Person Phone Number*</label>
                            <input type="number" class="form-control" name="phone" id="phone"
                                placeholder="Contact Person Phone Number*" value="{{ old('phone') }}" required>
                            @if ($errors->has('phone'))
                                <div class="error">{{ $errors->first('phone') }}</div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <label for="email">Email Id*</label>
                            <input type="email" class="form-control" name="email" id="email"
                                aria-describedby="emailHelp" placeholder="Enter email Id*" value="{{ old('email') }}"
                                required>
                            @if ($errors->has('email'))
                                <div class="error">{{ $errors->first('email') }}</div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <label for="password">Password*</label>
                            <input type="password" class="form-control" name="password" id="password"
                                placeholder="Enter Password*" required>
                            @if ($errors->has('password'))
                                <div class="error">{{ $errors->first('password') }}</div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <label for="password_confirmation">Confirm Password*</label>
                            <input type="password" class="form-control" name="password_confirmation"
                                id="password_confirmation" placeholder="Confirm Password*" required>
                            @if ($errors->has('password_confirmation'))
                                <div class="error">{{ $errors->first('password_confirmation') }}</div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <label for="country">Country*</label>
                            <select class="form-control" name="country" id="country" required>
                                <option value=""> ---Select Country---</option>
                                {{ getCountries($countryId ?? '') }}
                            </select>
                            @if ($errors->has('country'))
                                <div class="error">{{ $errors->first('country') }}</div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <label for="states">States*</label>
                            <select class="form-control" name="states" id="states" required>
                                <option value=""> ---Select States---</option>
                            </select>
                            @if ($errors->has('states'))
                                <div class="error">{{ $errors->first('states') }}</div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <label for="city">Cities*</label>
                            <select class="form-control" name="city" id="city" required>
                                <option value=""> ---Select Cities---</option>
                            </select>
                            @if ($errors->has('city'))
                                <div class="error">{{ $errors->first('city') }}</div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <label for="dob">Date Of Birth*</label>
                            <input type="date" class="form-control" name="dob" id="dob" required>
                            @if ($errors->has('dob'))
                                <div class="error">{{ $errors->first('dob') }}</div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <label for="designation">Designation</label>
                            <input type="text" class="form-control" name="designation" id="designation"
                                placeholder="Enter Designation">
                        </div>
                        <div class="col-md-6">
                            <label for="profile_images">Profile Photo</label>
                            <div class="file-upload-cutom-box">
                                <input type="file" name="profile_images" id="profile_images" class="f-input"
                                    accept="image/*">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="termCondition" id="termCondition"
                                    required>
                                @if ($errors->has('termCondition'))
                                    <div class="error">{{ $errors->first('termCondition') }}</div>
                                @endif
                                <label class="form-check-label" for="termCondition">View our terms and conditions</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-primary">Register Now</button>
                        </div>
                    </div>
                </form>
                <h5 class="already-accnt">Already have an Account? <a href="{{ route('company.login') }}">Log In</a>
                </h5>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script>
        var baseUrl = APP_URL + "/";
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
