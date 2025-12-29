@extends('Company.layouts.app')
@section('subscription-active', 'active')
@section('title', __('subscription'))
@push('styles')
    <style>
        .error {
            color: red;
        }
    </style>
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
            <form method="POST" action="{{ route('company.subscription.subscriptionadd') }}"
               class=" fileUpload"
                enctype="multipart/form-data" id="UserForm">
                @csrf
                @php
                    $inr = 0.18 * $fetchSubscription->amount_inr;
                    $totalPriceinr = $fetchSubscription->amount_inr + $inr;
                    $usd = 0.18 * $fetchSubscription->amount_usd;
                    $totalPriceusd = $fetchSubscription->amount_usd + $usd;
                @endphp
                  <input type="hidden" name="uuid" id="uuid"
                  value="{{ $fetchSubscription->uuid ?? '' }}">
              <div class="form-row">
                <div class="pricingplan_sec basic">
                    <h3 class="title">{{ $fetchSubscription->title }}</h3>
                    <h5>Trial : <span>{{ $fetchSubscription->trial_period }} Days</span></h5>
                    <h5>Subscription : <span> {{ $fetchSubscription->duration }} /
                            {{ $fetchSubscription->payment_mode }}</span></h5>
                    <div class="planprice_box">
                        <div class="single_paymbox">
                            <h6>Paid</h6>
                            <h6><span>&#x20b9;</span> {{ $fetchSubscription->amount_inr }} / <span>&#x24;</span>
                                {{ $fetchSubscription->amount_usd }}</h6>
                        </div>
                        <div class="single_paymbox">
                            <h6>Total GST (18%)</h6>
                            <h6><span>&#x20b9;</span> {{ $inr }} / <span>&#x24;</span> {{ $usd }}</h6>
                        </div>
                        <div class="single_paymbox totalpay_box">
                            <h6>Total Price : </h6>
                            <h6><span>&#x20b9;</span> {{ $totalPriceinr }} / <span>&#x24;</span> {{ $totalPriceusd }}</h6>
                        </div>
                        <div class="button">
                            <button type="submit">PAY NOW</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('scripts')
    <script></script>
@endpush

{{--
"payment_mode" => "month"
"amount_inr" => 1000.0
"amount_usd" => 500.0
"duration" => 1
"trial_period" => 30 --}}
