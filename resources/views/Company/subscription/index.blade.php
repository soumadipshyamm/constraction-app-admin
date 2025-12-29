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
            <div class="subscrip_box ">
                <div class="content container">
                    <div class="row" style="display: flex;justify-content: space-around;">
                        @if ($isFetch)
                            @foreach ($isFetch as $key => $value)
                                @php
                                    $isSubscriptionTrial = isSubscriptionTrial($value->id);
                                    $checkSubscribePackage = checkMySubscribePackage($value->id);
                                    $checkFreeSubscribePackage = checkFreeSubscribePackage($value);
                                    // $today = Carbon::now()->format('Y-m-d');
                                    switch ($key) {
                                        case 0:
                                            $img = 'https://i.postimg.cc/2jcfMcf4/hot-air-balloon.png';
                                            $color = 'bg-primary';
                                            break;
                                        case 1:
                                            $img = 'https://i.postimg.cc/DzrTN72Z/airplane.png';
                                            $color = 'bg-success';
                                            break;
                                        case 2:
                                            $img = 'https://i.postimg.cc/wvFd6FRY/startup.png';
                                            $color = 'bg-info';
                                            break;
                                        case 3:
                                            $img = 'https://i.postimg.cc/N0cRfW5v/ship-removebg-preview.png';
                                            $color = 'bg-secondary';
                                            break;
                                        default:
                                            $img = 'https://i.postimg.cc/2jcfMcf4/hot-air-balloon.png';
                                            $color = '#ff7445';
                                            break;
                                    }
                                @endphp
                                <div class="col-md-4" style="padding-top: 40px;">
                                    <div class="basic box">
                                        <h2 class="title {{ $color }} text-white">{{ $value->title }}</h2>
                                        <div class="view">

                                            <div class="icon">
                                                <img src="{{ $img }}" alt="hot-air-balloon">
                                            </div>
                                            <div class="cost">
                                                @if ($value->amount_inr == 0)
                                                    <p></p>
                                                @else
                                                    <p class="amount">₹
                                                        {{ $value->amount_inr ?? 0 }}/${{ $value->amount_usd ?? 0 }}
                                                    </p>
                                                    <p class="detail">
                                                        {{ $value->duration ?? 0 }}/{{ $value->payment_mode ?? '----' }}</p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="description">
                                            {!! $value->details ?? '' !!}
                                        </div>
                                        {{-- @dd($checkSubscribePackage, $isSubscriptionTrial) --}}

                                        <div class="button">
                                            @if ($value->free_subscription != 1)
                                                @if ($checkSubscribePackage)
                                                    @if ($isSubscriptionTrial)
                                                        <span style="color: orange; font-weight: bold;">Your trial package
                                                            will be expire in
                                                            {{ $isSubscriptionTrial }}
                                                            days.</span>
                                                    @else
                                                        @php
                                                            $today = \Carbon\Carbon::now();
                                                            // Extract subscription details
                                                            $is_subscribed = $checkSubscribePackage->is_subscribed;
                                                            $from_date = $checkSubscribePackage->from_date;
                                                            $to_date = $checkSubscribePackage->to_date;
                                                            // Parse the start and end dates
                                                            $startDate = \Carbon\Carbon::parse($from_date);
                                                            $endDate = \Carbon\Carbon::parse($to_date);
                                                            // Calculate the difference in days between the end date and today
                                                            $daysDifference = $endDate->diffInDays($today);
                                                            // $daysDifference = $endDate->diffInDays($today);
                                                        @endphp
                                                        @if ($endDate->lessThan($today) || $daysDifference == 0)
                                                            <button>
                                                                <a
                                                                    href="{{ route('company.subscription.add', $value->uuid) }}">
                                                                    SUBSCRIBE
                                                                </a>
                                                            </button>
                                                        @else
                                                            <span style="color: orange; font-weight: bold; ">
                                                                <p>Your Subscription Package will expire in
                                                                    {{ $daysDifference }}
                                                                    days.</p>
                                                            </span>

                                                        @endif
                                                    @endif
                                                @else
                                                    <button>
                                                        <a href="{{ route('company.subscription.add', $value->uuid) }}">
                                                            START FREE ({{ $value->trial_period }} DAYS TRIAL)
                                                        </a>
                                                    </button>
                                                @endif
                                            @else
                                                @if ($checkSubscribePackage)
                                                    @if ($isSubscriptionTrial)
                                                        <span>Your trial package will be expire in
                                                            {{ $isSubscriptionTrial }}
                                                            days.</span>
                                                    @endif
                                                @else
                                                    @if ($checkFreeSubscribePackage?->is_use_free_subscription == 0)
                                                        <button>
                                                            <a
                                                                href="{{ route('company.subscription.add', $value->uuid) }}">
                                                                START FREE ({{ $value->trial_period }} DAYS TRIAL)
                                                            </a>
                                                        </button>
                                                    @else
                                                        <span style="color: rgb(255, 0, 0); font-weight: bold;">You are
                                                            already
                                                            on a
                                                            trial for this subscription.</span>
                                                    @endif
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
@endpush
