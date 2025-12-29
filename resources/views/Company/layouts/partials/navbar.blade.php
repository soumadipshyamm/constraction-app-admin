<!-- dashboard section -->
<section class="top-bar">
    <!-- logo sec -->
    <div class="logo-sec">
        <div class="container-fluid">
            <div class="logos_box">
                <div class="logo-box">
                    <img src="{{ asset('company_assets/images/logo.svg') }}" class="img-fluid" alt="Company Logo">
                </div>
                <div class="profile_box">
                    <div class="profilel_box">
                        <div class="widget-content p-0">
                            <div class="widget-content-wrapper">
                                <div class="widget-content-left widget_profile">
                                    <div class="btn-group">
                                        <button type="button" class="btn p-0 prol_img dropdown-toggle"
                                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                            onclick="toggleDropdown(this)">
                                            <img class="rounded-circle"
                                                src="{{ asset('company_assets/images/user.png') }}" alt="User Image">
                                            <h6 class="widget-heading">
                                                {{ auth()->guard('company')->user()->name }}
                                            </h6>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end" id="userDropdown">
                                            <li>
                                                <a class="dropdown-item"
                                                    href="{{ route('company.profile', auth()->guard('company')->user()->uuid) }}">User
                                                    Account</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item editPassword"
                                                    data-uuid="{{ auth()->guard('company')->user()->uuid }}"
                                                    href="{{ route('company.passwordUpdate', auth()->guard('company')->user()->uuid) }}">Password
                                                    Update</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="{{ route('company.logout') }}">
                                                    <span>
                                                        <img src="{{ asset('company_assets/images/side-icon/logout.svg') }}"
                                                            class="img-fluid" alt="Logout Icon">
                                                    </span>Logout
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                @php
                                    $userAuth = Auth::guard('company')->user()->companyUserRole;
                                    $datas = notifyprlist();
                                    $alertnotify = alertnotifylist();
                                    $totalnotifyprlist = count($datas);
                                    $totalalertnotifylist = count($alertnotify);
                                @endphp
                                <div class="widget-content-notification">
                                    <div class="btn-group">
                                        <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                            class="p-0 btn prol_img">
                                            <img src="{{ asset('company_assets/images/side-icon/noti-icon.svg') }}"
                                                class="img-fluid" alt="Notification Icon">
                                        </a>
                                        <div tabindex="-1" role="menu" aria-hidden="true"
                                            class="dropdown-menu dropdown-menu-right">
                                            <ul class="nav nav-tabs custom-tabs" id="notificationTabs" role="tablist">
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link active btn-custom" id="pending-tab"
                                                        data-bs-toggle="tab" data-bs-target="#pending" type="button"
                                                        role="tab" aria-controls="pending"
                                                        aria-selected="true">Pending Approval</button>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link btn-custom" id="alerts-tab"
                                                        data-bs-toggle="tab" data-bs-target="#alerts" type="button"
                                                        role="tab" aria-controls="alerts"
                                                        aria-selected="false">Alerts</button>
                                                </li>
                                            </ul>
                                            <div class="tab-content" id="notificationTabsContent">
                                                <div class="tab-pane fade show active" id="pending" role="tabpanel"
                                                    aria-labelledby="pending-tab"
                                                    style="max-height: 300px; overflow-y: auto; overflow-x: hidden;">
                                                    <div class="row">
                                                        <div class="col-12 ml-3">
                                                            @foreach ($datas as $data)
                                                                @php
                                                                    $bgcolor =
                                                                        $data?->status == 1
                                                                            ? 'text-success'
                                                                            : ($data?->status == 2
                                                                                ? 'text-danger'
                                                                                : '');
                                                                @endphp
                                                                <div class="mb-3">
                                                                    <div class="{{ $bgcolor }} font-weight-bold">
                                                                        @if ($data?->status == 0)
                                                                            <strong class="mb-3">
                                                                                <span class="m-3">
                                                                                    {{ $data->projects->project_name }}
                                                                                    || {{ $data?->request_id }}
                                                                                </span>
                                                                            </strong>
                                                                            <button type="button"
                                                                                class="btn btn-outline-primary">
                                                                                <a href="{{ route('company.pr.details', $data?->uuid) }}"
                                                                                    class="text-decoration-none d-flex align-items-center"
                                                                                    target="_blank">
                                                                                    <i class="fas fa-eye me-2"></i> View
                                                                                    Details
                                                                                </a>
                                                                            </button>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="tab-pane fade" id="alerts" role="tabpanel"
                                                    aria-labelledby="alerts-tab"
                                                    style="max-height: 300px; overflow-y: auto; overflow-x: hidden;">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            @foreach ($alertnotify as $msg)
                                                                <div
                                                                    class="alert-item p-3 border-bottom alert-item-hover">
                                                                    <div class="d-flex flex-column">
                                                                        <div class="message mb-2">
                                                                            <i class="fas fa-bell me-2 alert-icon"></i>
                                                                            {{ $msg?->message ?? '' }}
                                                                        </div>
                                                                        <div
                                                                            class="meta-info d-flex gap-3 text-muted small">
                                                                            <span>
                                                                                <i class="fas fa-user alert-icon"></i>
                                                                                {{ $msg?->user?->name ?? 'N/A' }}
                                                                            </span>
                                                                            <span>
                                                                                <i
                                                                                    class="fas fa-project-diagram alert-icon"></i>
                                                                                {{ $msg?->project?->project_name ?? 'N/A' }}
                                                                            </span>
                                                                            <span>
                                                                                <i class="fas fa-clock alert-icon"></i>
                                                                                {{ $msg?->created_at->diffForHumans() ?? '' }}
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- <div class="tab-pane fade" id="alerts" role="tabpanel" aria-labelledby="alerts-tab" style="max-height: 300px; overflow-y: auto; overflow-x: hidden;">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            @foreach ($alertnotify as $msg)
                                                                <div class="alert-item p-3 border-bottom">
                                                                    <div class="d-flex flex-column">
                                                                        <div class="message mb-2">
                                                                            <i class="fas fa-bell me-2"></i>
                                                                            {{ $msg?->message ?? '' }}
                                                                        </div>
                                                                        <div class="meta-info d-flex gap-3 text-muted small">
                                                                            <span>
                                                                                <i class="fas fa-user"></i>
                                                                                {{ $msg?->user?->name ?? 'N/A' }}
                                                                            </span>
                                                                            <span>
                                                                                <i class="fas fa-project-diagram"></i>
                                                                                {{ $msg?->project?->project_name ?? 'N/A' }}
                                                                            </span>
                                                                            <span>
                                                                                <i class="fas fa-clock"></i>
                                                                                {{ $msg?->created_at->diffForHumans() ?? '' }}
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div> --}}
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @php
        $subscription = auth()->guard('company')->user()->company?->isSubscribed?->first()?->is_subscribed ?? '';
        $trialOrExpireDate = isset($subscription) ? isSubscriptionTrial($subscription) : 0;
        $checkSubscribePackage = isset($subscription) ? checkMySubscribePackage($subscription) : 0;
    @endphp
    @php
        $today = \Carbon\Carbon::now();
        $to_date = $checkSubscribePackage?->to_date;
        $endDate = \Carbon\Carbon::parse($to_date);
        $daysDifference = $endDate->diffInDays($today);
    @endphp

    @if ($userAuth && $trialOrExpireDate <= 7)
        <div class="trial-box" id="subscription-bar">
            <div class="trail_con">
                <button id="close-button"
                    style="float: right; background: none; border: none; cursor: pointer;">&times;</button>
                @if ($trialOrExpireDate !== 0)
                    <h6>Your Subscription Package will expire in
                        {{ isset($trialOrExpireDate) ? $trialOrExpireDate : '' }}
                        days.
                    </h6>
                @else
                    @if ($daysDifference <= 7)
                        @if ($today->lessThan($endDate))
                            <h6><span style="color: rgb(255, 0, 0); font-weight: bold;">Your Subscription Package
                                    will expire in
                                    {{ $daysDifference }}
                                    days.</span>
                            </h6>
                        @else
                            <h6><span style="color: rgb(255, 0, 0); font-weight: bold;">Buy Now Subscription
                                    Package
                                </span>
                            </h6>
                        @endif
                        <a href="{{ route('company.subscription.scriptionlist') }}" class="subs-btn">
                            Upgrade Plan</a>
                    @endif
                @endif
            </div>
        </div>
    @endif
</section>

{{-- <div class="trial-box">
            <div class="trail_con">
                @if ($trialOrExpireDate !== 0)
                    <h6>Your Subscription Package will expire in
                        {{ isset($trialOrExpireDate) ? $trialOrExpireDate : '' }}
                        days.
                    </h6>
                @else
                    @if ($daysDifference <= 7)
                        @if ($today->lessThan($endDate))
                            <h6><span style="color: rgb(255, 0, 0); font-weight: bold; ">Your Subscription Package
                                    will
                                    expire in
                                    {{ $daysDifference }}
                                    days.</span>
                            </h6>
                        @else
                            <h6><span style="color: rgb(255, 0, 0); font-weight: bold; ">Buy Now Subscription
                                    Package
                                </span>
                            </h6>
                        @endif
                        <a href="{{ route('company.subscription.scriptionlist') }}" class="subs-btn">
                            Upgrade Plan</a>
                    @endif
                @endif
            </div>
        </div> --}}

{{-- @if ($trialOrExpireDate <= 7)
        <div class="trial-box">
            <div class="trail_con">
                @if ($trialOrExpireDate !== 0)
                    <h6>Your Subscription Package will expire in
                        {{ isset($trialOrExpireDate) ? $trialOrExpireDate : '' }}
                        days.
                    </h6>
                @else
                    @if ($daysDifference <= 7)
                        <h6><span style="color: rgb(255, 0, 0); font-weight: bold; ">Your Subscription Package will
                                expire in
                                {{ $daysDifference }}
                                days.</span>
                        </h6>
                        <a href="{{ route('company.subscription.scriptionlist') }}" class="subs-btn">Buy
                            Subscription</a>
                    @endif
                @endif
            </div>
        </div>
    @endif --}}
