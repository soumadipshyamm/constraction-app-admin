@extends('Frontend.layouts.app')
@section('free-user-active', 'active')
@section('title', __('Login User'))
@push('styles')
    <style>
        .error {
            color: red;
        }
    </style>
@endpush
@section('content')
    <section class="log-in">
        <div class="row no-gutters  justify-content-end">
            <div class="col-sm-12 col-md-5">
                <div class="log-in-content">
                    <h4>Sorry</h4>
                    <p>Access to this feature is available only to paid users.</p>
                    <a href="{{ route('user.subscription') }}">subscription</a>
                </div>
            </div>
            <div class=" col-sm-12 col-md-7">
                <div class="lapto-image">
                    <img src="{{ asset('assets/images/login-image.png') }}" alt="">
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
@endpush
