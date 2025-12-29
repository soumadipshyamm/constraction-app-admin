@extends('Admin.layouts.app')
@section('contact-details-active', 'active')
@section('title', __('contact-details'))
@push('styles')
@endpush
@section('content')
<div class="app-main__outer">
    <div class="app-main__inner">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-user icon-gradient bg-happy-itmeo">
                        </i>
                    </div>
                    <div>Manage Contact Details
                        <div class="page-title-subheading">Contact Details
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        {{-- @dd($datas->toArray()); --}}
                        <h5 class="card-title">Contact Details</h5>
                        <form method="POST" action="{{ route('admin.setting.contactDetails') }}" class="formSubmit fileUpload" enctype="multipart/form-data" id="UserForm">
                            @csrf
                            <input type="hidden" name="uuid" value="{{ $datas->id ?? ' ' }}">
                            <div class="form-row subscriptionPackage">
                                <div class="col-md-4">
                                    <label for="ph_no" class="">Phone Number</label>
                                </div>
                                <div class="col-md-6">
                                    <div class="position-r1elative form-group">
                                        <input class="form-control" name="ph_no" id="ph_no" value="{{ old('ph_no', $datas->ph_no ?? ' ') }}">
                                        @if ($errors->has('ph_no'))
                                        <div class="error">
                                            {{ $errors->first('ph_no') }}
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-row subscriptionPackage">
                                <div class="col-md-4">
                                    <label for="email" class="">Email ID</label>
                                </div>
                                <div class="col-md-6">
                                    <div class="position-r1elative form-group">
                                        <input class="form-control" name="email" id="email" value="{{ old('email', $datas->email ?? '') }}">
                                        @if ($errors->has('email'))
                                        <div class="error">
                                            {{ $errors->first('email') }}
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-row subscriptionPackage">
                                <div class="col-md-4">
                                    <label for="address" class="">Address</label>
                                </div>
                                <div class="col-md-6">
                                    <div class="position-r1elative form-group">
                                        <input class="form-control" name="address" id="address" value="{{ old('address', $datas->address ?? '') }}">
                                        @if ($errors->has('address'))
                                        <div class="error">
                                            {{ $errors->first('address') }}
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-row subscriptionPackage">
                                <div class="col-md-4">
                                    <label for="map_loc" class="">Map Location</label>
                                </div>
                                <div class="col-md-6">
                                    <div class="position-r1elative form-group">
                                        <input class="form-control" name="map_loc" id="map_loc" value="{{ old('map_loc', $datas->map_loc ?? '') }}">
                                        @if ($errors->has('map_loc'))
                                        <div class="error">
                                            {{ $errors->first('map_loc') }}
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            {{-- ******************************Social Media********************************************************* --}}

                            <div class="form-row subscriptionPackage">
                                <div class="col-md-4">
                                    <label for="facebook_link" class="">Facebook Link</label>
                                </div>
                                <div class="col-md-6">
                                    <div class="position-r1elative form-group">
                                        <input class="form-control" name="facebook_link" id="facebook_link" value="{{ old('facebook_link', $datas->facebook_link ?? '') }}">
                                        @if ($errors->has('facebook_link'))
                                        <div class="error">
                                            {{ $errors->first('facebook_link') }}
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-row subscriptionPackage">
                                <div class="col-md-4">
                                    <label for="instagram_link" class="">Instagram Link</label>
                                </div>
                                <div class="col-md-6">
                                    <div class="position-r1elative form-group">
                                        <input class="form-control" name="instagram_link" id="instagram_link" value="{{ old('instagram_link', $datas->instagram_link ?? '') }}">
                                        @if ($errors->has('instagram_link'))
                                        <div class="error">
                                            {{ $errors->first('instagram_link') }}
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-row subscriptionPackage">
                                <div class="col-md-4">
                                    <label for="twitter_link" class="">Twitter Link</label>
                                </div>
                                <div class="col-md-6">
                                    <div class="position-r1elative form-group">
                                        <input class="form-control" name="twitter_link" id="twitter_link" value="{{ old('twitter_link', $datas->twitter_link ?? '') }}">
                                        @if ($errors->has('twitter_link'))
                                        <div class="error">
                                            {{ $errors->first('twitter_link') }}
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-row subscriptionPackage">
                                <div class="col-md-4">
                                    <label for="linkedin_link" class="">Linkedin Link</label>
                                </div>
                                <div class="col-md-6">
                                    <div class="position-r1elative form-group">
                                        <input class="form-control" name="linkedin_link" id="linkedin_link" value="{{ old('linkedin_link', $datas->linkedin_link ?? '') }}">
                                        @if ($errors->has('linkedin_link'))
                                        <div class="error">
                                            {{ $errors->first('linkedin_link') }}
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-row subscriptionPackage">
                                <div class="col-md-4">
                                    <label for="description" class="">Short Description</label>
                                </div>
                                <div class="col-md-6">
                                    <div class="position-r1elative form-group">
                                        <textarea class="form-control" name="description" id="description" value="{{ old('description', $datas->description ?? '') }}">{{ $datas->description ?? '' }}</textarea>
                                        @if ($errors->has('description'))
                                        <div class="error">
                                            {{ $errors->first('description') }}
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="form-row subscriptionPackage">
                                <div class="col-md-4">
                                    <label for="logo" class="">Logo Update</label>
                                </div>
                                <div class="col-md-6">
                                    <div class="position-r1elative form-group">
                                        <input type="file" class="form-control" name="logo" id="logo" value="{{ old('logo', $datas->logo ?? '') }}">
                                        @if ($errors->has('logo'))
                                        <div class="error">
                                            {{ $errors->first('logo') }}
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <button class="mt-2 btn btn-primary" type="submit">Update</button>
                            </div>
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