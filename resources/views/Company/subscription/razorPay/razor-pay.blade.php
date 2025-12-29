@extends('Company.layouts.app')

@section('subscription-active', 'active')
@section('title', __('subscription'))

@push('styles')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <style>
        .error {
            color: red;
        }

        .subscribe-now button {
            padding: 5px
        }
    </style>
@endpush


@section('content')
    <!-- mobile toggle menu -->
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
            <form method="POST" action="{{ route('company.subscription.subscriptionadd') }}" class="fileUpload"
                enctype="multipart/form-data" id="razorpay-form">
                @csrf

                @php
                    // dd($fetchSubscriptionCompany, $fetchSubscription);
                    $inr = 0.18 * $fetchSubscription?->amount_inr;
                    $usd = 0.18 * $fetchSubscription?->amount_usd;
                    $totalPriceinr = 0;
                    $totalPriceusd = 0;

                    if ($fetchSubscriptionCompany?->is_trial == 1 && $fetchSubscription?->trial_period >= 0) {
                        $totalPriceinr = $fetchSubscription->amount_inr + $inr;
                        $totalPriceusd = $fetchSubscription->amount_usd + $usd;
                    }
                    
                    $razorPayAmount = $totalPriceinr * 100;
                    //   dd($fetchSubscriptionCompany, $fetchSubscription,$totalPriceinr);
                @endphp
                <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
                <input type="hidden" name="razorpay_order_id" id="razorpay_order_id">
                <input type="hidden" name="razorpay_signature" id="razorpay_signature">
                <input type="hidden" name="uuid" id="uuid" value="{{ $fetchSubscription->uuid ?? '' }}">
                <div class="form-row">
                    <div class="pricingplan_sec basic">
                        <h3 class="title">{{ $fetchSubscription->title }}</h3>
                        <h5>Trial : <span>{{ $fetchSubscription->trial_period }} Days</span></h5>
                        <h5>Subscription : <span>{{ $fetchSubscription->duration }} /
                                {{ $fetchSubscription->payment_mode }}</span></h5>
                        <div class="planprice_box">
                            <div class="single_paymbox">
                                <h6>Paid</h6>
                                <h6><span>&#x20b9;</span> {{ $fetchSubscription->amount_inr }} / <span>&#x24;</span>
                                    {{ $fetchSubscription->amount_usd }}</h6>
                            </div>
                            <div class="single_paymbox">
                                <h6>Total GST (18%)</h6>
                                <h6><span>&#x20b9;</span> {{ $inr }} / <span>&#x24;</span> {{ $usd }}
                                </h6>
                            </div>

                            <div class="single_paymbox totalpay_box">
                                <h6>Total Price : </h6>
                                <h6><span>&#x20b9;</span> {{ $totalPriceinr }} / <span>&#x24;</span> {{ $totalPriceusd }}
                                </h6>
                            </div>
                            @if ($totalPriceinr == 0)
                                <div class="card-body text-center subscribe-now">
                                    <button type="button" id="free-subscribe" class="btn btn-primary">Subscribe
                                        Now</button>
                                </div>
                            @else
                                <div class="card-body text-center">
                                    <button type="button" id="razorpay-button" class="btn btn-primary">Pay Now</button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    @if ($totalPriceinr == 0)
        {{-- @if ($fetchSubscription->free_subscription == 1) --}}
        <script>
            document.getElementById('free-subscribe').onclick = function(e) {
                e.preventDefault();
                document.getElementById('razorpay-form').submit();
            };
        </script>
    @else
        <script>
            const options = {
                key: "rzp_test_SkPV10mNu9JnN7", // Enter the Key ID generated from Razorpay Dashboard
                amount: "{{ $razorPayAmount }}", // Amount is in currency subunits. Default currency is INR. Hence, 50000 = ₹500
                currency: "INR",
                name: "Laravel Razorpay App",
                description: "Test Transaction",
                image: "https://yourdomain.com/logo.png", // optional
                order_id: "{{ $rpay->id }}",
                handler: function(response) {
                    document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
                    document.getElementById('razorpay_order_id').value = response.razorpay_order_id;
                    document.getElementById('razorpay_signature').value = response.razorpay_signature;
                    document.getElementById('razorpay-form').submit();
                },
                prefill: {
                    name: "John Doe",
                    email: "john@example.com"
                },
                theme: {
                    color: "#F37254"
                }
            };

            const rzp1 = new Razorpay(options);
            document.getElementById('razorpay-button').onclick = function(e) {
                rzp1.open();
                e.preventDefault();
            };
        </script>
    @endif
@endsection
@push('scripts')
@endpush
