@extends('Company.layouts.app')
@section('subscription-active', 'active')
@section('title', __('Subscription'))
@push('styles')
@endpush

@section('content')

    <!-- mobile toogle menu -->
    <div class="app-header__mobile-menu">
        <div>
            <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
            </button>
        </div>
    </div>
    <!-- dashboard main body -->
    <div class="app-main__outer">

        <div class="app-main__inner card">
            <!-- dashboard body -->
            <div class="thanku_page">
                <div class="thnku_img">
                    <img src="{{ asset('assets/images/thanku.png') }}" class="img-fluid" alt="">
                </div>
                <h3 class="thanku_txt">
                    Thank You!
                </h3>
                {{-- <h4>Visit Again</h4> --}}
            </div>
        </div>
    </div>

@endsection

@push('scripts')
@endpush
