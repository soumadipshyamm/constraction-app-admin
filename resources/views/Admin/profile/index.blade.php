@extends('Admin.layouts.app')
@section('profile-active','active')
@section('title',__('Dashboard'))
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
        <div class="tab-content">
            <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <h5 class="card-title">Update User Profile</h5>
                        <form method="POST" action="{{ route('admin.profile') }}"
                            data-url="{{ route('admin.profile') }}" class="formSubmit fileUpload"
                            enctype="multipart/form-data" id="UserForm">
                            @csrf
                            <input type="hidden" name="uuid" id="uuid" value="{{ $data->uuid??'' }}">

                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="position-relative form-group">
                                        <label for="first_name" class="">Name</label>
                                        <input name="first_name" id="first_name" placeholder="Enter Your Name.."
                                            type="text" class="form-control"
                                            value="{{ old('code',$data->first_name??'') }}">
                                        @if($errors->has('first_name'))
                                        <div class="error">{{ $errors->first('first_name') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="position-relative form-group">
                                        <label for="email" class="">Email</label>
                                        <input class="form-control" value="{{ old('code',$data->email??'') }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="position-relative form-group">
                                        <label for="mobile_number" class="">Phone Number</label>
                                        <input name="mobile_number" id="mobile_number"
                                            placeholder="Enter Your Phone Number.." type="text" class="form-control"
                                            value="{{ old('code',$data->mobile_number??'') }}">
                                        @if($errors->has('mobile_number'))
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
                                            value="{{ old('code',$data->address??'') }}">
                                        @if($errors->has('address'))
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
                                            value="{{ old('code',$data->profile_image??'') }}">
                                        @if($errors->has('profile_image'))
                                        <div class="error">{{ $errors->first('profile_image') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @if(!empty($data->profile_image))
                            <div class="col display_picture">
                                <div class="form-group">
                                    <div class="uploadimage">
                                        <h4>
                                            <i class="fa mr-2">
                                                <img src="{{ asset('profile_image/'.$data->profile_image) }}" alt=""
                                                    width="75" height="75" id="display_picture"></i>Current Image
                                        </h4>
                                    </div>
                                </div>
                            </div>
                            @endif
                            <button class="mt-2 btn btn-primary">Submit</button>
                            <a href="{{ route('admin.home') }}" class="mt-2 btn btn-secondary">&lt; Back</a>
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
