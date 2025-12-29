@extends('Frontend.layouts.app')
@section('subscription-active', 'active')
@section('title', __('Subscription'))
@push('styles')
@endpush
<style>
    /* ====================================
    Substructure Page
======================================= */

    /*.subscrip_box .content {
    display: flex;
    justify-content: space-between;
    width: 1200px;
    margin: 100px;
  }
  */

    .subscrip_box {
        padding: 4%;
        height: 860px;
    }

    .subscrip_box .box {
        display: flex;
        flex-direction: column;
        height: 690px;
        width: 400px;
        border-radius: 20px;
        margin-left: 10px;
        margin-right: 10px;

        background: #fff;
        box-shadow: 0 1rem 2rem rgba(0, 0, 0, 20%);
    }

    .subscrip_box .title {
        width: 100%;
        padding: 10px 0;
        font-size: 1.2em;
        font-weight: lighter;
        text-align: center;
        border-top-left-radius: 20px;
        border-top-right-radius: 20px;

        color: #f5f5f4;
    }

    .subscrip_box .basic .title {
        background: #c35a74;
    }

    .subscrip_box .standard .title {
        background: #307baa;
    }

    .subscrip_box .business .title {
        background: #53bab5;
    }

    .subscrip_box .view {
        display: block;
        width: 100%;
        padding: 30px 0 20px;

        background: #f5f5f4;
    }

    .subscrip_box .icon {
        display: flex;
        justify-content: center;
    }

    .subscrip_box .icon img {
        width: 100px;
    }

    .subscrip_box .cost {
        display: flex;
        justify-content: center;
        flex-direction: row;
        margin-top: 10px;
    }

    .subscrip_box .amount {
        font-size: 1.8em;
        font-weight: bolder;
    }

    .subscrip_box .detail {
        margin: auto 0 auto 5px;
        width: 70px;
        font-size: 0.7em;
        font-weight: bold;
        line-height: 15px;
        color: #7d7c7c;
    }

    .subscrip_box .description {
        margin: 30px auto;
        font-size: 0.8em;
        color: #7d7c7c;
    }

    .subscrip_box ul {
        list-style: none;
    }

    .subscrip_box li {
        margin-top: 10px;
    }

    .subscrip_box li::before {
        content: "";
        background-image: url("https://i.postimg.cc/ht7g996V/check.png");
        background-position: center;
        background-size: cover;
        opacity: 0.5;

        display: inline-block;
        width: 10px;
        height: 10px;
        margin-right: 10px;
    }

    .subscrip_box .button {
        margin: 0 auto 30px;
    }

    .subscrip_box button {
        height: 38px;
        width: 217px;
        font-size: 0.7em;
        font-weight: bold;
        letter-spacing: 0.5px;
        color: #7d7c7c;
        border: 2px solid #7d7c7c;
        border-radius: 50px;

        background: transparent;
    }

    .subscrip_box button:hover {
        color: #f5f5f4;
        transition: 0.5s;
        border: none;

        background: #ff7445;
    }

    /* Responsiveness:Start */
    @media screen and (max-width: 970px) {
        .subscrip_box .content {
            display: flex;
            align-items: center;
            flex-direction: column;
            margin: 50px auto;
        }

        .subscrip_box .standard,
        .subscrip_box .business {
            margin-top: 25px;
        }
    }

    /* Responsiveness:End */
    /*================================
        Payment Box
==================================*/
    .pricingplan_sec {
        width: 50%;
        margin: 4% auto;
        background: #fff;
        box-shadow: 4px 6px 15px 3px #33333345;
        border-radius: 9px;
        padding: 3%;
    }

    .pricingplan_sec h3 {
        font-weight: 600;
        color: #000;
        margin-bottom: 15px;
    }

    .pricingplan_sec.basic .title {
        color: #c35a74;
    }

    .pricingplan_sec.standard .title {
        color: #307baa;
    }

    .pricingplan_sec.business .title {
        color: #53bab5;
    }

    .pricingplan_sec h5 {
        color: #494949;
        padding-bottom: 10px;
        font-weight: 500;
        font-size: 16px;
    }

    .pricingplan_sec h5 span {
        font-size: 20px;
        font-weight: 600;
    }

    .planprice_box {
        border-top: 1px solid #d5d5d5;
        padding: 16px 10px;
    }

    .single_paymbox {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 15px;
        border-bottom: 1px solid #d5d5d5;
        padding-bottom: 10px;
    }

    .single_paymbox h6 {
        font-size: 16px;
        color: #797979;
    }

    .single_paymbox h6:first-child {
        font-weight: 600;
        font-size: 18px;
    }

    .single_paymbox.totalpay_box h6 {
        color: #000;
    }

    /*================================
        Thanku Page
================================*/
    .thanku_page {
        width: 50%;
        margin: 4% auto;
        background: #fff;
        box-shadow: 4px 6px 15px 3px #33333345;
        border-radius: 9px;
        padding: 3%;
    }

    .thnku_img img {
        width: 370px;
    }

    .thanku_page {
        text-align: center;
    }

    h3.thanku_txt {
        font-size: 35px;
        font-weight: 600;
        color: #000;
    }

    .thanku_page h4 {
        font-size: 25px;
        line-height: 42px;
        font-weight: 400;
        color: #333;
    }

    /* ------------------------------ */
</style>

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
                <div class="content container ">

                    <div class="row" style="display: flex; justify-content: space-around;">
                        @if ($isFetch)
                            @foreach ($isFetch as $key => $value)
                                @php
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
                                            {{-- <ul>
                                                @foreach ($value->subscriptionPackageOption as $key => $subdata)
                                                    <li>{{ $subdata->value }} - {{ $subdata->is_subscription }}
                                                    </li>
                                                @endforeach
                                            </ul> --}}
                                        </div>
                                        @if ($value->free_subscription != 1)
                                            <div class="button">
                                                <button>
                                                    <a href="{{ route('company.subscription.add', $value->uuid) }}">
                                                        @if ($value->trial_period)
                                                            START FREE ({{ $value->trial_period }} DAYS TRIAL)
                                                        @else
                                                            SUBSCRIBE
                                                        @endif
                                                    </a>
                                                </button>
                                            </div>
                                        @else
                                            <div class="button">
                                                <button>
                                                    <a href="{{ route('company.subscription.add', $value->uuid) }}">
                                                        {{-- TRY PRODUCT FOR FREE (LIMITED PERIOD) --}}
                                                        @if ($value->trial_period)
                                                            START FREE ({{ $value->trial_period }} DAYS TRIAL)
                                                        @else
                                                            SUBSCRIBE
                                                        @endif
                                                    </a>
                                                </button>
                                            </div>
                                        @endif
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
