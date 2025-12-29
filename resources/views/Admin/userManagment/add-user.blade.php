@extends('Admin.layouts.app')
@section('admin-user-active', 'active')
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
                            <h5 class="card-title">Add New Admin User</h5>
                            <form method="POST" action="{{ route('admin.userManagment.add') }}"
                                data-url="{{ route('admin.userManagment.add') }}" class="formSubmit fileUpload"
                                enctype="multipart/form-data" id="UserForm">
                                @csrf
                                <input type="hidden" name="uuid" id="uuid" value="{{ $data->uuid ?? '' }}">

                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="position-relative form-group">
                                            <label for="Name" class="">Select an User Type</label>
                                            <select name="admin_user_role" id="admin_user_role" class="mb-2 form-control">
                                                <option value="">Select user type-</option>
                                                {{ getRole(old('admin_role_id', $data->admin_role_id ?? '')) }}
                                            </select>
                                            @if ($errors->has('admin_user_role'))
                                                <div class="error">{{ $errors->first('admin_user_role') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="position-relative form-group">
                                            <label for="first_name" class="">Name</label>
                                            <input name="first_name" id="first_name" placeholder="Enter User Name"
                                                type="text" class="form-control"
                                                value="{{ old('first_name', $data->first_name ?? '') }}">
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
                                            <input name="email" id="email" placeholder="Enter Udmin Email.."
                                                type="email" class="form-control"
                                                value="{{ old('email', $data->email ?? '') }}">
                                            @if ($errors->has('email'))
                                                <div class="error">{{ $errors->first('email') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="position-relative form-group">
                                            <label for="password" class="">Password</label>
                                            <input name="password" id="password" placeholder="Enter Password.."
                                                type="password" class="form-control"
                                                value="{{ old('password', $data->password ?? '') }}">
                                            @if ($errors->has('password'))
                                                <div class="error">{{ $errors->first('password') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    {{--  <div class="col-md-6">
                                    <div class="position-relative form-group">
                                        <label for="Profile" class="">Profile Image</label>
                                        <input name="image" id="image" type="file" class="form-control"
                                            value="{{ old('image',$data->image??'') }}">
                                        @if ($errors->has('image'))
                                        <div class="error">{{ $errors->first('image') }}</div>
                                        @endif
                                    </div>
                                </div> --}}
                                    <div class="col-md-6">
                                        <div class="position-relative form-group">
                                            <label for="mobile_number" class="">Mobile Number</label>
                                            <input name="mobile_number" id="mobile_number" type="text"
                                                class="form-control" placeholder="Enter Mobile Number"
                                                value="{{ old('mobile_number', $data->mobile_number ?? '') }}">
                                            @if ($errors->has('mobile_number'))
                                                <div class="error">{{ $errors->first('mobile_number') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="position-relative form-group">
                                            <label for="exampleAddress" class="">Address</label>
                                            <input name="address" id="address" placeholder="Enter Address....."
                                                type="text" class="form-control"
                                                value="{{ old('address', $data->address ?? '') }}">
                                            @if ($errors->has('address'))
                                                <div class="error">{{ $errors->first('address') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="position-relative form-group">
                                            <label for="city" class="">City</label>
                                            <input name="city" id="city" type="text" class="form-control"
                                                placeholder="Enter City... " value="{{ old('city', $data->city ?? '') }}">
                                            @if ($errors->has('city'))
                                                <div class="error">{{ $errors->first('city') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="position-relative form-group">
                                            <label for="state" class="">State</label>
                                            <input name="state" id="state" type="text" class="form-control"
                                                placeholder="Enter State...."
                                                value="{{ old('state', $data->state ?? '') }}">
                                            @if ($errors->has('state'))
                                                <div class="error">{{ $errors->first('state') }}</div>
                                            @endif
                                        </div>
                                    </div>

                                </div>
                                <button class="mt-2 btn btn-primary">Submit</button>
                                <button class="mt-2 btn btn-secondary">&lt; Back</button>
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
