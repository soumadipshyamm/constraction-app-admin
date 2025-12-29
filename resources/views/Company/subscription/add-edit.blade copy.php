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
    <div class="app-main__outer">
        <div class="app-main__inner">
            <div class="app-page-title">
                <div class="page-title-wrapper">
                    <div class="page-title-heading">
                        <div class="page-title-icon">
                            <i class="pe-7s-add-user text-success">
                            </i>
                        </div>
                        <div>Manage Units Details
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
                            <h5 class="card-title">{{ $fetchSubscription->title }}</h5>
                            <hr>
                            <form method="POST" action="{{ route('company.subscription.subscriptionadd') }}"
                                data-url="{{ route('company.subscription.subscriptionadd') }}" class="formSubmit fileUpload"
                                enctype="multipart/form-data" id="UserForm">
                                @csrf
                                <input type="hidden" name="uuid" id="uuid"
                                    value="{{ $fetchSubscription->uuid ?? '' }}">
                                <div class="form-row">
                                    <div class="col-md-4">

                                    </div>
                                    <div class="col-md-4">
                                        <h6>{{ $fetchSubscription->title }}</h6>
                                        <p>Trial:{{ $fetchSubscription->trial_period }} Days</p>
                                        <p>Subscription:{{ $fetchSubscription->duration }} /
                                            {{ $fetchSubscription->payment_mode }}
                                        </p>
                                    </div>
                                    <div class="col-md-4">
                                        <h5>₹{{ $fetchSubscription->amount_inr }} / ${{ $fetchSubscription->amount_usd }}
                                        </h5>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-row">
                                    <div class="col-md-4">

                                    </div>
                                    <div class="col-md-4">

                                    </div>
                                    <div class="col-md-4">
                                        @php
                                            $inr = 0.18 * $fetchSubscription->amount_inr;
                                            $totalPriceinr = $fetchSubscription->amount_inr + $inr;
                                            $usd = 0.18 * $fetchSubscription->amount_usd;
                                            $totalPriceusd = $fetchSubscription->amount_usd + $usd;
                                        @endphp
                                        <p>Total GST (18%) :₹{{ $inr }} / ${{ $usd }}</p>
                                        <h5>Total price: ₹{{ $totalPriceinr }} / ${{ $totalPriceusd }}</h5>
                                    </div>
                                </div>
                                <hr>
                                <button class="mt-2 btn btn-primary">Submit</button>
                                {{-- <a href="{{ route('company.units.list') }}" class="mt-2 btn btn-secondary">&lt; Back</a> --}}
                            </form>
                        </div>
                    </div>
                </div>
            </div>
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
