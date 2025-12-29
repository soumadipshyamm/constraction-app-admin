@extends('Admin.layouts.app')
@section('company-active', 'active')
@section('company-collapse', 'mm-collapse mm-show')
@section('title', __('Admin Companies'))
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
                        <div>Manage Company Details
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
                            <h5 class="card-title">Add Your Company Details</h5>
                            <form method="POST" action="{{ route('admin.companyManagment.add') }}"
                                data-url="{{ route('admin.companyManagment.add') }}" class="formSubmit fileUpload"
                                enctype="multipart/form-data" id="UserForm">
                                @csrf
                                <input type="hidden" name="uuid" id="uuid" value="{{ $data->uuid ?? '' }}">
                                <input type="hidden" name="cid" id="cid"
                                    value="{{ $data->companyUsers->uuid ?? '' }}">
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="position-relative form-group">
                                            <label for="registration_name" class="">Registration Name</label>
                                            <input type="text" class="form-control"
                                                value="{{ old('registration_name', $data->name ?? '') }}"
                                                name="registration_name" id="registration_name"
                                                placeholder="Registration Name">
                                            @if ($errors->has('registration_name'))
                                                <div class="error">{{ $errors->first('registration_name') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="position-relative form-group">
                                            <label for="company_registration_no" class="">Company Registration
                                                No</label>
                                            <input type="text" class="form-control" name="company_registration_no"
                                                value="{{ old('company_registration_no', $data->registration_no ?? '') }}"
                                                id="company_registration_no" placeholder="Company Registration No">
                                            @if ($errors->has('company_registration_no'))
                                                <div class="error">{{ $errors->first('company_registration_no') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="position-relative form-group">
                                            <label for="company_address" class="">Company Address</label>
                                            <input type="text" name="company_address" id="company_address"
                                                class="form-control"
                                                value="{{ old('company_address', $data->address ?? '') }}"
                                                placeholder=" Enter company Address">
                                            @if ($errors->has('company_address'))
                                                <div class="error">{{ $errors->first('company_address') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="position-relative form-group">
                                            <label for="company_phone" class="">Contact Person Phone</label>
                                            <input type="text" class="form-control"
                                                value="{{ old('company_phone', $data->phone ?? '') }}" name="company_phone"
                                                id="company_phone" placeholder="Contact Person Phone Number">
                                            @if ($errors->has('company_phone'))
                                                <div class="error">{{ $errors->first('company_phone') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="position-relative form-group">
                                            <label for="website_link" class="">Website Link</label>
                                            <input type="text" class="form-control"
                                                value="{{ old('website_link', $data->website_link ?? '') }}"
                                                name="website_link" id="website_link" placeholder="Company Website Link">
                                            @if ($errors->has('website_link'))
                                                <div class="error">{{ $errors->first('website_link') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                {{-- @dd($data->companyUsers) --}}
                                <h5>Contact Person Details</h5>
                                <hr>
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="position-relative form-group">
                                            <label for="user_name" class="">Contact Person Name</label>
                                            <input type="text" class="form-control" name="user_name"
                                                value="{{ old('user_name', $data->companyUsers->name ?? '') }}"
                                                id="user_name" placeholder="Contact Person Name">
                                            @if ($errors->has('user_name'))
                                                <div class="error">{{ $errors->first('user_name') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="position-relative form-group">
                                            <label for="phone" class="">Contact Person Phone</label>
                                            <input type="text" class="form-control"
                                                value="{{ old('phone', $data->companyUsers->phone ?? '') }}"
                                                name="phone" id="phone" placeholder="Contact Person Phone Number">
                                            @if ($errors->has('phone'))
                                                <div class="error">{{ $errors->first('phone') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="position-relative form-group">
                                            <label for="email" class="">Email</label>
                                            <input type="email" class="form-control"
                                                value="{{ old('email', $data->companyUsers->email ?? '') }}"
                                                name="email" id="email" placeholder="Enter Email"
                                                {{ !empty($data) ?? $data->companyUsers?->email ? 'readonly' : '' }}>
                                            @if ($errors->has('email'))
                                                <div class="error">{{ $errors->first('email') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="position-relative form-group">
                                            <label for="password" class="">Password</label>
                                            <input type="password" class="form-control" name="password"
                                                value="{{ old('password') }}" id="password"
                                                placeholder="Enter Password">
                                            @if ($errors->has('password'))
                                                <div class="error">{{ $errors->first('password') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="position-relative form-group">
                                            <label for="country" class="">Country</label>
                                            {{-- <input type="text" class="form-control"
                                                value="{{ old('country', $data->companyUsers->country ?? '') }}"
                                                name="country" id="country" placeholder="Enter Country Name"> --}}

                                            <select class="form-control" name="country" id="country"
                                                value="{{ old('country') }}" required>
                                                <option value=""> ---Select Country---</option>
                                                {{ getCountries($countryId ?? '') }}
                                            </select>
                                            @if ($errors->has('country'))
                                                <div class="error">{{ $errors->first('country') }}</div>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="position-relative form-group">
                                            <label for="city" class="">State</label>
                                            <select class="form-control" name="states" id="states"
                                                value="{{ old('states') }}" required>
                                                <option value=""> ---Select State---</option>
                                            </select>
                                            @if ($errors->has('states'))
                                                <div class="error">{{ $errors->first('states') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="position-relative form-group">
                                            <label for="city" class="">City</label>
                                            <select class="form-control" name="city" id="city"
                                                value="{{ old('city') }}" required>
                                                <option value=""> ---Select Cities---</option>
                                            </select>
                                            @if ($errors->has('city'))
                                                <div class="error">{{ $errors->first('city') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="position-relative form-group">
                                            <label for="dob" class="">Date Of Birth</label>
                                            <input type="date" class="form-control"
                                                value="{{ old('dob', $data->companyUsers->dob ?? '') }}" name="dob"
                                                id="dob" placeholder="Enter dob Name">
                                            @if ($errors->has('dob'))
                                                <div class="error">{{ $errors->first('dob') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="position-relative form-group">
                                            <label for="designation" class="">Designation</label>
                                            <input type="text" class="form-control" name="designation"
                                                value="{{ old('designation', $data->companyUsers->designation ?? '') }}"
                                                id="designation" placeholder="Enter Designation Name">
                                            @if ($errors->has('designation'))
                                                <div class="error">{{ $errors->first('designation') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="position-relative form-group">
                                            <label for="profile_images" class="">Upload Photo</label>
                                            <input type="file" class="form-control" name="profile_images"
                                                value="{{ old('profile_images', $data->profile_images ?? '') }}"
                                                id="profile_images" accept="image/*">
                                            @if ($errors->has('profile_images'))
                                                <div class="error">{{ $errors->first('profile_images') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>


                                <button class="mt-2 btn btn-primary">Submit</button>
                                <a href="{{ route('admin.companyManagment.list') }}" class="mt-2 btn btn-secondary">&lt;
                                    Back</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
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
                    url: "{{ route('ajax.getStates') }}",
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
                    url: "{{ route('ajax.getCities') }}",
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
