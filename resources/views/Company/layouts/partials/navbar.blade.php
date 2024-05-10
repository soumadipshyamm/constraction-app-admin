<!-- dashboard section -->
<section class="top-bar">
    <!-- logo sec -->
    <div class="logo-sec">
        <div class="container-fluid">
            <div class="logos_box">
                <div class="logo-box">
                    <img src="{{ asset('company_assets/images/logo.svg') }}" class="img-fluid" alt="">
                    {{-- <div class="dropdown">
                        <button class="btn btn_company dropdown-toggle" type="button" id="dropdownMenuButton1"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Company A
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            <li><a class="dropdown-item" href="#">Action</a></li>
                            <li><a class="dropdown-item" href="#">Another action</a></li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                        </ul>
                    </div> --}}
                </div>

                <div class="profile_box">
                    {{-- <a href="#" class="ads-btn">Ads</a> --}}
                    <div class="profilel_box">
                        <div class="widget-content p-0">
                            <div class="widget-content-wrapper">

                                <div class="widget-content-left widget_profile">
                                    <div class="btn-group">
                                        <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                            class="p-0 btn prol_img">
                                            <img class="rounded-circle"
                                                src="{{ asset('company_assets/images/user.png') }}" alt="">
                                            <h6 class="widget-heading">
                                                {{-- @dd(
                                                    auth()->guard('company')->user()->uuid
                                                ); --}}
                                                {{ auth()->guard('company')->user()->name }}
                                            </h6>
                                            <i class="fa fa-angle-down ml-2 opacity-8" aria-hidden="true"></i>
                                        </a>
                                        <div tabindex="-1" role="menu" aria-hidden="true"
                                            class="dropdown-menu dropdown-menu-right" x-placement="bottom-end"
                                            style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-174px, 47px, 0px);">

                                            <a class="dropdown-item " tabindex="0"
                                                href="{{ route('company.profile',auth()->guard('company')->user()->uuid) }}">User
                                                Account</a>

                                            <a class="dropdown-item editPassword" tabindex="0"
                                                data-uuid="{{ auth()->guard('company')->user()->uuid }}"
                                                href="{{ route('company.passwordUpdate',auth()->guard('company')->user()->uuid) }}">Password
                                                Update</a>

                                            <a href="{{ route('company.logout') }}" class="dropdown-item"> <span>
                                                    <img src="{{ asset('company_assets/images/side-icon/logout.svg') }}"
                                                        class="img-fluid" alt="">
                                                </span>Logout</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-content-notification">
                                    <a href="#">
                                        <img src="{{ asset('company_assets/images/side-icon/noti-icon.svg') }}"
                                            class="img-fluid" alt="">
                                    </a>
                                    <span class="noti_no">5</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- trial sec -->
    <div class="trial-box">
        <div class="trail_con">
            <h6>Your free trial will expires in 30 days.</h6>
            <a href="#" class="subs-btn">Buy Subscription</a>
        </div>
    </div>
</section>
