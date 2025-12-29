@extends('Frontend.layouts.app')
@section('complet-active', 'active')
@section('title', __('Subscription Completed'))
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
