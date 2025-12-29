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
            @if ($isFetch)
                @foreach ($isFetch as $key => $value)
                    <div class="col-sm-12 col-md-5">
                        <div class="log-in-content">
                            <h4>{{ $value->title }}</h4>
                            <div class="col-sm-12 col-md-12  justify-content-end">
                                <div class="row">
                                    <p>payment_mode</p>
                                    <p>{{ $value->payment_mode }}</p>
                                </div>
                                <div class="row">
                                    <p>amount</p>
                                    <p>{{ $value->amount_inr }}/{{ $value->amount_usd }}</p>
                                </div>
                                <div class="row">
                                    <p>duration</p>
                                    <p>{{ $value->duration }}</p>
                                </div>
                            </div>
                        </div>
                        <div>
                            <a href="#" class="btn btn-outline-primary">Subscription</a>
                        </div>
                    </div>
                @endforeach
            @endif
            {{-- <div class=" col-sm-12 col-md-7">
                <div class="lapto-image">
                    <img src="{{ asset('assets/images/login-image.png') }}" alt="">
                </div>
            </div> --}}
        </div>
    </section>
@endsection
@push('scripts')
@endpush
