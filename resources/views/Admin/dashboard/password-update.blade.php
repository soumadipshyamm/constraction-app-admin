@extends('Admin.layouts.app')
@section('password-update-active','active')
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
                    <div>Update Password</div>
                </div>
                <div class="page-title-actions">
                </div>
            </div>
        </div>
        <div class="tab-content">
            <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <h5 class="card-title">Update User Password</h5>
                        <form method="POST" action="{{ route('admin.passwordUpdate') }}"
                            data-url="{{ route('admin.passwordUpdate') }}" class="formSubmit fileUpload"
                            enctype="multipart/form-data" id="UserForm">
                            @csrf
                            <input type="hidden" name="uuid" id="uuid" value="{{ $data->uuid??'' }}">

                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="position-relative form-group">
                                        <label for="old_password" class="">Old Password</label>
                                        <input name="old_password" id="old_password" placeholder="Enter Old Password.."
                                            type="password" class="form-control" value="">
                                        @if($errors->has('old_password'))
                                        <div class="error">{{ $errors->first('old_password') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="position-relative form-group">
                                        <label for="new_password" class="">New Password</label>
                                        <input name="new_password" id="new_password" placeholder="Enter New Password.."
                                            type="password" class="form-control" value="">
                                        @if($errors->has('new_password'))
                                        <div class="error">{{ $errors->first('new_password') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="position-relative form-group">
                                        <label for="confirm_password" class="">Confiram Password</label>
                                        <input name="confirm_password" id="confirm_password"
                                            placeholder="Enter Confiram Password.." type="password" class="form-control"
                                            value="">
                                        @if($errors->has('confirm_password'))
                                        <div class="error">{{ $errors->first('confirm_password') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            {{--
                    </div> --}}
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
