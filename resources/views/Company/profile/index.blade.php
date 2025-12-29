@extends('Company.layouts.app')
@section('profile-active', 'active')
@section('title', __('Dashboard'))
@push('styles')
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
                        <div>Update Profile</div>
                    </div>
                    <div class="page-title-actions">
                    </div>
                </div>
            </div>

            {{-- <div class="tab-content">
                <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <h5 class="card-title">Update User Profile</h5>
                            <form method="POST" action="{{ route('company.profile') }}"
                                data-url="{{ route('company.profile') }}" class="formSubmit fileUpload"
                                enctype="multipart/form-data" id="UserForm">
                                @csrf
                                <input type="hidden" name="uuid" id="uuid" value="{{ $data->uuid ?? '' }}">
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="position-relative form-group">
                                            <label for="first_name" class="">Name</label>
                                            <input name="first_name" id="first_name" placeholder="Enter Your Name.."
                                                type="text" class="form-control"
                                                value="{{ old('code', $data->first_name ?? '') }}">
                                            @if ($errors->has('first_name'))
                                                <div class="error">{{ $errors->first('first_name') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="position-relative form-group">
                                            <label for="email" class="">Email</label>
                                            <input class="form-control" value="{{ old('code', $data->email ?? '') }}"
                                                readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="position-relative form-group">
                                            <label for="mobile_number" class="">Phone Number</label>
                                            <input name="mobile_number" id="mobile_number"
                                                placeholder="Enter Your Phone Number.." type="text" class="form-control"
                                                value="{{ old('code', $data->mobile_number ?? '') }}">
                                            @if ($errors->has('mobile_number'))
                                                <div class="error">{{ $errors->first('mobile_number') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="position-relative form-group">
                                            <label for="address" class="">Address</label>
                                            <input name="address" id="address" placeholder="Enter Yoiur Address.."
                                                type="text" class="form-control"
                                                value="{{ old('code', $data->address ?? '') }}">
                                            @if ($errors->has('address'))
                                                <div class="error">{{ $errors->first('address') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="position-relative form-group">
                                            <label for="profile_image" class="">Profile Image</label>
                                            <input name="profile_image" id="profile_image"
                                                placeholder="Upload Profile Image.." type="file" class="form-control"
                                                value="{{ old('code', $data->profile_image ?? '') }}">
                                            @if ($errors->has('profile_image'))
                                                <div class="error">{{ $errors->first('profile_image') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @if (!empty($data->profile_image))
                                    <div class="col display_picture">
                                        <div class="form-group">
                                            <div class="uploadimage">
                                                <h4>
                                                    <i class="fa mr-2">
                                                        <img src="{{ asset('profile_image/' . $data->profile_image) }}"
                                                            alt="" width="75" height="75"
                                                            id="display_picture"></i>Current Image
                                                </h4>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <button class="mt-2 btn btn-primary">Submit</button>
                                <a href="{{ route('company.home') }}" class="mt-2 btn btn-secondary">&lt; Back</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div> --}}

            <div class="tab-content">
                <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <h5 class="card-title">Update Company Details</h5>
                            <form method="POST" action="{{ route('company.updateProfile') }}"
                                data-url="{{ route('company.updateProfile') }}" class="formSubmit fileUpload"
                                enctype="multipart/form-data" id="UserForm">
                                @csrf
                                <input type="hidden" name="uuid" id="uuid" value="{{ $data->uuid ?? '' }}">
                                {{-- @dd($data->companyusers) --}}
                                <input type="hidden" name="cid" id="cid"
                                    value="{{ $data->companyusers->uuid ?? '' }}">
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

                                <h5>Update Contact Person Details</h5>
                                <hr>
                                {{-- @dd($data->companyUsers->name) --}}
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="position-relative form-group">
                                            <label for="user_name" class="">Contact Person Name</label>
                                            <input type="text" class="form-control" name="user_name"
                                                value="{{ $data?->companyUsers?->name ?? '' }}" id="user_name"
                                                placeholder="Contact Person Name">
                                            @if ($errors->has('user_name'))
                                                <div class="error">{{ $errors->first('user_name') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="position-relative form-group">
                                            <label for="phone" class="">Contact Person Phone</label>
                                            <input type="text" class="form-control"
                                                value="{{ $data?->companyUsers?->phone ?? '' }}" name="phone"
                                                id="phone" placeholder="Contact Person Phone Number">
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
                                                value="{{ $data?->companyUsers?->email ?? '' }}" name="email"
                                                id="email" placeholder="Enter Email"
                                                {{ !empty($data) ?? $data->companyuser?->email ? 'readonly' : '' }}>
                                            @if ($errors->has('email'))
                                                <div class="error">{{ $errors->first('email') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-6">
                                        <div class="position-relative form-group">
                                            <label for="password" class="">Password</label>
                                            <input type="password" class="form-control" name="password"
                                                value="{{ old('password') }}" id="password"
                                                placeholder="Enter Password">
                                            @if ($errors->has('password'))
                                                <div class="error">{{ $errors->first('password') }}</div>
                                            @endif
                                        </div>
                                    </div> --}}
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="position-relative form-group">
                                            <label for="country" class="">Country</label>
                                            <input type="text" class="form-control"
                                                value="{{ $data?->companyUsers?->country ?? '' }}" name="country"
                                                id="country" placeholder="Enter Country Name">
                                            @if ($errors->has('country'))
                                                <div class="error">{{ $errors->first('country') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="position-relative form-group">
                                            <label for="city" class="">City</label>
                                            <input type="text" class="form-control" name="city"
                                                value="{{ $data?->companyUsers?->city ?? '' }}" id="city"
                                                placeholder="Enter City Name">
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
                                                value="{{ $data?->companyUsers?->dob ?? '' }}" name="dob"
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
                                                value="{{ $data?->companyUsers?->designation ?? '' }}" id="designation"
                                                placeholder="Enter Designation Name">
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
                                <a href="{{ route('company.home') }}" class="mt-2 btn btn-secondary">&lt;
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
@endpush
