@extends('Company.layouts.app')
@section('company-user-active','active')
@section('title',__('Company User'))
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
                    <div>Manage Users
                        <div class="page-title-subheading">Add New User
                        </div>
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
                        <h5 class="card-title">Add New Company User</h5>
                        <form method="POST" action="{{ route('company.userManagment.add') }}"
                            data-url="{{ route('company.userManagment.add') }}" class="formSubmit fileUpload"
                            enctype="multipart/form-data" id="UserForm">
                            @csrf
                            <input type="hidden" name="uuid" id="uuid" value="{{ $data->uuid??'' }}">
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="position-relative form-group">
                                        <label for="Name" class="">Select an User Type</label>
                                        <select name="company_user_role" id="company_user_role"
                                            class="mb-2 form-control">
                                            <option value="">Select user type-</option>
                                            {{ getCompanyRole(
                                            old('company_user_role',$data->companyUserRole[0]->id??'')) }}
                                        </select>
                                        @if($errors->has('company_user_role'))
                                        <div class="error">{{ $errors->first('company_user_role') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="position-relative form-group">
                                        <label for="name" class="">Name</label>
                                        <input name="name" id="name" placeholder="Enter User Name" type="text"
                                            class="form-control" value="{{ old('name',$data->name??'') }}">
                                        @if($errors->has('name'))
                                        <div class="error">{{ $errors->first('name') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="position-relative form-group">
                                        <label for="email" class="">Email</label>
                                        <input name="email" id="email" placeholder="Enter Udmin Email.." type="email"
                                            class="form-control" value="{{ old('email',$data->email??'') }}">
                                        @if($errors->has('email'))
                                        <div class="error">{{ $errors->first('email') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>


                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="position-relative form-group">
                                        <label for="password" class="">Password</label>
                                        <input name="password" id="password" placeholder="Enter Password.."
                                            type="password" class="form-control" value="{{ old('password') }}">
                                        @if($errors->has('password'))
                                        <div class="error">{{ $errors->first('password') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="position-relative form-group">
                                        <label for="password_confirmation" class="">password_confirmation</label>
                                        <input name="password_confirmation" id="password_confirmation"
                                            placeholder="Enter password_confirmation.." type="password"
                                            class="form-control" value="{{ old('password_confirmation') }}">
                                        @if($errors->has('password_confirmation'))
                                        <div class="error">{{ $errors->first('password_confirmation') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="position-relative form-group">
                                        <label for="phone" class="">Mobile Number</label>
                                        <input name="phone" id="phone" type="text" class="form-control"
                                            placeholder="Enter Mobile Number"
                                            value="{{ old('phone',$data->phone??'') }}">
                                        @if($errors->has('phone'))
                                        <div class="error">{{ $errors->first('phone') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="position-relative form-group">
                                        <label for="address" class="">Address</label>
                                        <input name="address" id="address" type="text" class="form-control"
                                            placeholder="Enter Address......"
                                            value="{{ old('address',$data->address??'') }}">
                                        @if($errors->has('address'))
                                        <div class="error">{{ $errors->first('address') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="position-relative form-group">
                                        <label for="country" class="">Country</label>
                                        <input name="country" id="country" type="text" class="form-control"
                                            placeholder="Enter Country... "
                                            value="{{ old('country',$data->country??'') }}">
                                        @if($errors->has('country'))
                                        <div class="error">{{ $errors->first('country') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="position-relative form-group">
                                        <label for="city" class="">City</label>
                                        <input name="city" id="city" type="text" class="form-control"
                                            placeholder="Enter City Name...." value="{{ old('city',$data->city??'') }}">
                                        @if($errors->has('city'))
                                        <div class="error">{{ $errors->first('city') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="position-relative form-group">
                                        <label for="dob" class="">Date of Birth</label>
                                        <input name="dob" id="dob" type="date" class="form-control"
                                            placeholder="Enter dob... " value="{{ old('dob',$data->dob??'') }}">
                                        @if($errors->has('dob'))
                                        <div class="error">{{ $errors->first('dob') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="position-relative form-group">
                                        <label for="designation" class="">Designation</label>
                                        <input name="designation" id="designation" type="text" class="form-control"
                                            placeholder="Enter Country Name...."
                                            value="{{ old('designation',$data->designation??'') }}">
                                        @if($errors->has('designation'))
                                        <div class="error">{{ $errors->first('designation') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-12">
                                    <div class="position-relative form-group">
                                        <label for="profileImages" class="">Profile Images</label>
                                        <input type="file" name="profileImages" id="profileImages"
                                            placeholder="Enter profileImages....." class="form-control"
                                            value="{{ old('profileImages',$data->profileImages??'') }}">
                                        @if($errors->has('profileImages'))
                                        <div class="error">{{ $errors->first('profileImages') }}</div>
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
@endpush