@extends('Admin.layouts.app')
@section('company-active','active')
@section('company-collapse','mm-collapse mm-show')
@section('title',__('Admin Companies'))
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
                            <input type="hidden" name="uuid" id="uuid" value="{{ $data->uuid??'' }}">
                            <input type="hidden" name="cid" id="cid" value="{{$data->companyuser[0]->uuid??'' }}">
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="position-relative form-group">
                                        <label for="registration_name" class="">Registration Name</label>
                                        <input type="text" class="form-control"
                                            value="{{ old('registration_name',$data->name??'') }}"
                                            name="registration_name" id="registration_name"
                                            placeholder="Registration Name">
                                        @if($errors->has('registration_name'))
                                        <div class="error">{{ $errors->first('registration_name') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="position-relative form-group">
                                        <label for="company_registration_no" class="">Company Registration No</label>
                                        <input type="text" class="form-control" name="company_registration_no"
                                            value="{{ old('company_registration_no',$data->registration_no??'') }}"
                                            id="company_registration_no" placeholder="Company Registration No">
                                        @if($errors->has('company_registration_no'))
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
                                            class="form-control" value="{{ old('company_address',$data->address??'') }}"
                                            placeholder=" Enter company Address">
                                        @if($errors->has('company_address'))
                                        <div class="error">{{ $errors->first('company_address') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="position-relative form-group">
                                        <label for="company_phone" class="">Contact Person Phone</label>
                                        <input type="text" class="form-control"
                                            value="{{ old('company_phone',$data->phone??'') }}" name="company_phone"
                                            id="company_phone" placeholder="Contact Person Phone Number">
                                        @if($errors->has('company_phone'))
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
                                            value="{{ old('website_link',$data->website_link??'') }}"
                                            name="website_link" id="website_link" placeholder="Company Website Link">
                                        @if($errors->has('website_link'))
                                        <div class="error">{{ $errors->first('website_link') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <h5>Contact Person Details</h5>
                            <hr>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="position-relative form-group">
                                        <label for="user_name" class="">Contact Person Name</label>
                                        <input type="text" class="form-control" name="user_name"
                                            value="{{ old('user_name',$data->companyuser[0]->name??'') }}" id="user_name"
                                            placeholder="Contact Person Name">
                                        @if($errors->has('user_name'))
                                        <div class="error">{{ $errors->first('user_name') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="position-relative form-group">
                                        <label for="phone" class="">Contact Person Phone</label>
                                        <input type="text" class="form-control"
                                            value="{{ old('phone',$data->companyuser[0]->phone??'') }}" name="phone" id="phone"
                                            placeholder="Contact Person Phone Number">
                                        @if($errors->has('phone'))
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
                                            value="{{ old('email',$data->companyuser[0]->email??'') }}" name="email" id="email"
                                            placeholder="Enter Email" {{ !empty($data)??$data->companyuser[0]?->email?'readonly':'' }}>
                                        @if($errors->has('email'))
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
                                        @if($errors->has('password'))
                                        <div class="error">{{ $errors->first('password') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="position-relative form-group">
                                        <label for="country" class="">Country</label>
                                        <input type="text" class="form-control"
                                            value="{{ old('country',$data->companyuser[0]->country??'') }}" name="country" id="country"
                                            placeholder="Enter Country Name">
                                        @if($errors->has('country'))
                                        <div class="error">{{ $errors->first('country') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="position-relative form-group">
                                        <label for="city" class="">City</label>
                                        <input type="text" class="form-control" name="city"
                                            value="{{ old('city',$data->companyuser[0]->city??'') }}" id="city"
                                            placeholder="Enter City Name">
                                        @if($errors->has('city'))
                                        <div class="error">{{ $errors->first('city') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="position-relative form-group">
                                        <label for="dob" class="">Date Of Birth</label>
                                        <input type="date" class="form-control" value="{{ old('dob',$data->companyuser[0]->dob??'') }}"
                                            name="dob" id="dob" placeholder="Enter dob Name">
                                        @if($errors->has('dob'))
                                        <div class="error">{{ $errors->first('dob') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="position-relative form-group">
                                        <label for="designation" class="">Designation</label>
                                        <input type="text" class="form-control" name="designation"
                                            value="{{ old('designation',$data->companyuser[0]->designation??'') }}" id="designation"
                                            placeholder="Enter Designation Name">
                                        @if($errors->has('designation'))
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
                                            value="{{ old('profile_images',$data->profile_images??'') }}"
                                            id="profile_images" accept="image/*">
                                        @if($errors->has('profile_images'))
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

@endpush

{{--  array:1 [▼ // app\Http\Controllers\Admin\CompanyManagmentController.php:136
 0 => array:17 [▼
   "id" => 4
   "uuid" => "91d0276f-0dd5-49b8-8e69-296e012b4b9c"
   "name" => "ABC PVT. LTD."
   "registration_no" => "1234DERTY"
   "phone" => "08972344111"
   "address" => "aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa"
   "website_link" => null
   "country" => null
   "country_name" => null
   "state" => null
   "city" => null
   "profile_images" => null
   "is_active" => 1
   "created_at" => "2023-08-21T14:25:49.000000Z"
   "updated_at" => "2023-08-21T15:33:26.000000Z"
   "deleted_at" => null
   "companyuser" => array:1 [▼
     0 => array:20 [▼
       "id" => 8
       "uuid" => "64a51596-c294-403d-a739-43efdb1d553d"
       "name" => "admin"
       "email" => "abaawwcd@abc.com"
       "password" => "$2y$10$RhQAOyl5Ws9vDAuEd6JJnu/K32y/HIY0Jk49ND.h/ypRUdreM4JXm"
       "phone" => "08972344111"
       "alternet_phone" => null
       "address" => null
       "designation" => "hs"
       "dob" => "2023-08-20"
       "country" => "India"
       "state" => null
       "city" => "select"
       "profile_images" => "169262794941.png"
       "company_role_id" => 1
       "is_active" => 1
       "created_at" => "2023-08-21T14:25:49.000000Z"
       "updated_at" => "2023-08-21T14:25:49.000000Z"
       "deleted_at" => null
       "pivot" => array:2 [▼
         "company_id" => 4
         "company_user_id" => 8
       ] --}}
{{--

       "_token" => "Klr6wpvO7GTSGclF0ymRtgyNKFeKX2MOC0OiJM0C"
       "uuid" => "91d0276f-0dd5-49b8-8e69-296e012b4b9c"
       "cid" => "64a51596-c294-403d-a739-43efdb1d553d"
       "registration_name" => "ABC PVT. LTD."
       "company_registration_no" => "1234DERTY"
       "company_address" => "aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa"
       "company_phone" => "08972344111"
       "website_link" => null
       "user_name" => "admin"
       "phone" => "08972344111"
       "email" => "abaawwcd@abc.com"
       "password" => null
       "country" => "India"
       "city" => "select"
       "dob" => "2023-08-20"
       "designation" => "hs"

       --}}
