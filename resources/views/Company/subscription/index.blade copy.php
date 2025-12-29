@extends('Company.layouts.app')
@section('subscription-active', 'active')
@section('title', __('Subscription'))
@push('styles')
@endpush

@section('content')
    <div class="app-main__outer">
        <div class="app-main__inner">
            <div class="app-page-title">
                <div class="page-title-wrapper">
                    <div class="page-title-heading">
                        <div class="page-title-icon">
                            <i class="pe-7s-tools icon-gradient bg-happy-itmeo">
                            </i>
                        </div>
                        <div>Subscription
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <h5 class="card-header">Subscription Package</h5>
                            <div class="row row-cols-1 row-cols-md-2 g-4">
                                @if ($isFetch)
                                    @foreach ($isFetch as $key => $value)
                                        <div class="col">
                                            <div class="card border-light mb-3" style="max-width: 18rem;">
                                                {{-- <img src="..." class="card-img-top" alt="..."> --}}
                                                <div class="card-header">{{ $value->title }}</div>
                                                <div class="card-body">
                                                        {{-- <p class="card-text">Payment Mode : {{ $value->payment_mode }}</p> --}}
                                                    <p class="card-text">Amount :
                                                        {{ $value->amount_inr }}/{{ $value->amount_usd }}</p>
                                                    <p class="card-text">Duration : {{ $value->duration }}/{{ $value->payment_mode }}</p>
                                                    <hr>
                                                    @if ($value->free_subscription != 1)
                                                        <a href="{{ route('company.subscription.add', $value->uuid) }}"
                                                            class="btn btn-outline-primary">Subscription</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            {{-- @if ($isFetch)
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
                                            @if ($value->free_subscription != 1)
                                                <div>
                                                    <a href="{{ route('company.subscription.add', $value->uuid) }}"
                                                        class="btn btn-outline-primary">Subscription</a>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                @endif --}}
                            {{-- </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
@endpush
