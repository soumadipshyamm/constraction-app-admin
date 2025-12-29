@extends('Frontend.layouts.app')
@section('Home-active', 'active')
@section('title', __('Home'))
@push('styles')
@endpush

@section('content')

    <!-- banner -->
    <div class="banner">
        {{-- @dd(asset('page_banner/' . $banners?->banner ?? '')) --}}
        <img src="{{ asset('page_banner/' . $banners?->banner ?? '') }}" alt="">
        {{-- <div class="banner-content"> --}}
        {!! $banners?->contented ?? '' !!}
        {{-- <h1>
            Field management software <br> to improve quality, safety and productivity
        </h1>
        <p>Lorem Ipsumsidummy text of then printin ngand typesetti dustry orem Ipsum dustry orem Ipsum.</p>
        <ul class="banner-btn">
            <li><a href="">Sign-up </a></li>
            <li><a href="">Download App</a></li>
        </ul> --}}
        {{-- </div> --}}
        {{-- <a class="chat" href=""><i class="fa fa-commenting" aria-hidden="true"></i></a>  --}}
    </div>

    {!! $datas[1]->content !!}
    {{-- <section class="common">
    <div class="row no-gutters align-items-end">
      <div class="col col-md-6">
        <img src="assets/images/one.png" alt="">
      </div>

      <div class="col col-md-6">
        <div class="common_sec_contnt">
          <h5>WELCOME TO KONCITE</h5>
          <h2>How does it work?</h2>
          <p>
            Koncite is a software solution designed to digitize construction site operations. Once you sign up, you can access the web portal and download the app to record daily work progress and manage inventory. Gain complete visibility across multiple projects with reports and dashboards
          </p>
        </div>
      </div>
    </div>
  </section> --}}

    <!-- welcome to koncite -->
    {{-- <section class="content-only-card">
    <div class="row no-gutters">
        <div class="col-sm-3 col-md-3">
            <div class="sec-card">
                <h3>Business Owners
                (Builders/Developer/
                Contractors)
                </h3>
                <p>Get complete visibility into project status, progress, and inventory with real-time reports and dashboards. Easy to use and quick to implement—go live in just one day, with no formal training required</p>
                <img src="frontend_assets/images/ribon.svg" alt="">
            </div>
        </div>

        <div class="col-sm-3 col-md-3">
            <div class="sec-card">
                <h3>Project Planning Manager </h3>
                <p>While planning software helps with scheduling, capturing actual work progress from sites remains a challenge. Koncite enables you to record daily progress against the WBS, providing real-time data as a reliable basis for updating your planning software.</p>
            </div>
        </div>

        <div class="col-sm-3 col-md-3">
            <div class="sec-card">
                <h3>Procurement Managers & Storekeepers</h3>
                <p>Easily get PRs/Indents from sites and record daily inward, issue, and return entries. Access stock status reports, Goods Receipt Notes, Issue Slips, and real-time goods movement tracking. Gain clear insights into wastage and theft, along with other inventory reports and dashboards</p>
            </div>
        </div>

        <div class="col-sm-3 col-md-3">
            <div class="sec-card">
                <h3>Site Engineers & Supervisors  </h3>
                <p>User-friendly process: Select your project and easily log daily work progress, material consumption, machine and labour usage, safety issues, and hindrances. Share daily reports on WhatsApp and access detailed work progress reports and dashboards</p>
            </div>
        </div>
    </div>
</section> --}}
    {!! $datas[2]->content !!}



    <!-- common  -->
    {!! $datas[3]->content !!}
    {{-- <section class="common common-even">
    <div class="row no-gutters  justify-content-end">
        <div class="col col-md-6">
            <div class="common_sec_contnt">
                <h5>Get Daily Work Progress In A Click </h5>
                <p>
                    Create a daily progress report in just a minute! With an easy-to-navigate interface, simply enter details, hit 'Next,' and your report is ready to share as a PDF.
                </p>
                <p>The app comes with a predefined master list of materials, machines, labour, and activities—customize and add as needed</p>

            </div>
        </div>
        <div class="col col-md-6">
            <img src="frontend_assets/images/two.png" alt="">
        </div>
    </div>
</section> --}}


    {!! $datas[4]->content !!}
    {{-- <section class="common">
    <div class="row no-gutters align-items-end">
        <div class="col col-md-6">
            <img src="frontend_assets/images/three.png" alt="">
        </div>

        <div class="col col-md-6">
            <div class="common_sec_contnt">
                <h5>CHECK YOUR INVETORY </h5>
                <p>
                   Easily raise Indents/Purchase Requests and record goods received from suppliers or project transfers. Track movement through issue and outward entries while gaining complete visibility across project stocks for better control. Additionally, manage stock movement of assets/machines with quick, insightful reports and dashboards. Add an Inward screen and stock status report image for enhanced tracking.
                </p>
            </div>
        </div>
    </div>
</section> --}}

    {!! $datas[5]->content !!}

    {{-- <section class="next-step box_arrow arrow-top">
        <div class="container">
            <h3>Take the next step</h3>
            <ul class=" flex-container">
                <li><a href="https://koncite.com/contact-us">Contact Us</a></li>
                <li><a href="https://koncite.com/company/registration">Sign Up</a></li>
                <li><a href="https://play.google.com/store/apps/details?id=com.koncite&pcampaignid=web_share">Download App</a></li>
            </ul>
            <div class="d-flex justify-content-center price-plans pt-5">
                <ul>
                    <li><a href="https://koncite.com/list-subscription">VIEW PRICING PLANS</a></li>
                </ul>
            </div>
        </div>
    </section> --}}
    {{-- <section class="counter">

        <!-- counter box -->
        <div id="counter" class="counter-box">
            <div class="container">
                <div class="row">
                    <div class="col-md-3 col-6 counter-card">
                        <h3><span class="count percent" data-count="1542"> 0 </span></h3>
                        <p class="counter-text">Successfully Project</p>
                    </div>
                    <div class="col-md-3 col-6 counter-card">
                        <h3> <span class="count percent plus_icon" data-count="542"> 0 </span> </h3>
                        <p class="counter-text">Trusated Client</p>
                    </div>
                    <div class="col-md-3 col-6 counter-card">
                        <h3> <span class="count percent" data-count="42"> 0 </span> </h3>
                        <p class="counter-text">Industrial</p>
                    </div>
                    <div class="col-md-3 col-6 counter-card">
                        <h3> <span class="count percent" data-count="32"> 0 </span> </h3>
                        <p class="counter-text">Get Award</p>
                    </div>


                </div>
            </div>

        </div>
    </section> --}}


    {{-- <section class="testimonial">
        <div class="container">
            <h3 class="sec-title">TESTMONIAL</h3>
            <p class="sub-title">What our customer are Saying about us</p>
            <div class="owl-carousel owl-them testimonial-slide">
                <div class="item">
                    <div class="testimonial-card">
                        <div class="autor-info">
                            <div class="img"><img src="frontend_assets/images/p-1.png" alt=""></div>
                            <div class="content">
                                <h3>Resma Khanon</h3>
                                <p>Company had</p>
                            </div>
                        </div>

                        <p>
                            Lorem ipsum dolor sit consetetur sadipscing elitsed
                            diam noeirmod
                            tempor invidunt ut labore dolore magna aliquyam erat.
                        </p>

                        <img src="frontend_assets/images/quote.svg" alt="" class="qut">
                    </div>
                </div>

                <div class="item">
                    <div class="testimonial-card">
                        <div class="autor-info">
                            <div class="img"><img src="frontend_assets/images/p-2.png" alt=""></div>
                            <div class="content">
                                <h3>Rajdip smith</h3>
                                <p>Company had</p>
                            </div>
                        </div>

                        <p>
                            Lorem ipsum dolor sit consetetur sadipscing elitsed
                            diam noeirmod
                            tempor invidunt ut labore dolore magna aliquyam erat.
                        </p>

                        <img src="frontend_assets/images/quote.svg" alt="" class="qut">
                    </div>
                </div>
            </div>
        </div>
    </section> --}}

    {{-- <section class="next-step box_arrow arrow-top">
        <div class="container">
            <h3>Take the next step</h3>
            <ul class=" flex-container">
                <li><a href="">Contact Us</a></li>
                <li><a href="">Sign Up</a></li>
                <li><a href="">Download App</a></li>
            </ul>
            <div class="d-flex justify-content-center price-plans pt-5">
                <ul>
                    <li><a href="">VIEW PRICING PLANS</a></li>
                </ul>
            </div>
        </div>
    </section> --}}


    {{-- <section class="latest-blogs">
        <div class="container">
            <h3 class="sec-title">BLOG</h3>
            <p class="sub-title">Our latest New & Blog</p>
            <div class="owl-carousel owl-them blogs-slide">
                <div class="item">
                    <div class="product-card">
                        <div class="img">
                            <img src="frontend_assets/images/pr-1.png" alt="">
                        </div>

                        <h3>Lorem Ipsumsid</h3>
                        <p>
                            Lorem Ipsumsid umpri ngand industry orem Ipsum.
                        </p>
                        <a href="">
                            <img src="frontend_assets/images/right-arrow.svg" alt="">
                        </a>
                    </div>
                </div>

                <div class="item">
                    <div class="product-card">
                        <div class="img">
                            <img src="frontend_assets/images/pr-2.png" alt="">
                        </div>

                        <h3>Lorem Ipsumsid</h3>
                        <p>
                            Lorem Ipsumsid umpri ngand industry orem Ipsum.
                        </p>
                        <a href="">
                            <img src="frontend_assets/images/right-arrow.svg" alt="">
                        </a>
                    </div>
                </div>

                <div class="item">
                    <div class="product-card">
                        <div class="img">
                            <img src="frontend_assets/images/pr-3.png" alt="">
                        </div>

                        <h3>Lorem Ipsumsid</h3>
                        <p>
                            Lorem Ipsumsid umpri ngand industry orem Ipsum.
                        </p>
                        <a href="">
                            <img src="frontend_assets/images/right-arrow.svg" alt="">
                        </a>
                    </div>
                </div>
                <div class="item">
                    <div class="product-card">
                        <div class="img">
                            <img src="frontend_assets/images/pr-1.png" alt="">
                        </div>

                        <h3>Lorem Ipsumsid</h3>
                        <p>
                            Lorem Ipsumsid umpri ngand industry orem Ipsum.
                        </p>
                        <a href="">
                            <img src="frontend_assets/images/right-arrow.svg" alt="">
                        </a>
                    </div>
                </div>

                <div class="item">
                    <div class="product-card">
                        <div class="img">
                            <img src="frontend_assets/images/pr-2.png" alt="">
                        </div>

                        <h3>Lorem Ipsumsid</h3>
                        <p>
                            Lorem Ipsumsid umpri ngand industry orem Ipsum.
                        </p>
                        <a href="">
                            <img src="frontend_assets/images/right-arrow.svg" alt="">
                        </a>
                    </div>
                </div>

                <div class="item">
                    <div class="product-card">
                        <div class="img">
                            <img src="frontend_assets/images/pr-3.png" alt="">
                        </div>

                        <h3>Lorem Ipsumsid</h3>
                        <p>
                            Lorem Ipsumsid umpri ngand industry orem Ipsum.
                        </p>
                        <a href="">
                            <img src="frontend_assets/images/right-arrow.svg" alt="">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
@endsection
@push('scripts')
    <script>
        $(".testimonial-slide").owlCarousel({
            loop: true,
            margin: 50,
            autoplay: true,
            smartSpeed: 1000,
            autoplayTimeout: 3000,
            nav: false,
            dots: false,
            responsive: {
                0: {
                    items: 1,
                },
                600: {
                    items: 1,
                },
                HEAD
                1000: {
                    items: 2,
                },
            },
        });
        $(".blogs-slide").owlCarousel({
            loop: true,
            margin: 50,
            autoplay: true,
            smartSpeed: 1000,
            autoplayTimeout: 3000,
            dots: false,
            nav: true,
            navText: [
                "<img src='./assets/images/left-arrow.svg'>",
                "<img src='./assets/images/right-arro.svg'>",
            ],
            responsive: {
                0: {
                    items: 1,
                },
                600: {
                    items: 2,
                },
                1000: {
                    items: 3,
                },
            },
        });
        // counter
        var counted = 0;
        $(window).scroll(function() {
            var oTop = $(".counter-box").offset().top - window.innerHeight;
            if (counted == 0 && $(window).scrollTop() > oTop) {
                $(".count").each(function() {
                    var $this = $(this),
                        countTo = $this.attr("data-count");
                    $({
                        countNum: $this.text(),
                    }).animate({
                            countNum: countTo,
                        },

                        {
                            duration: 3000,
                            easing: "swing",
                            step: function() {
                                $this.text(Math.floor(this.countNum));
                            },
                            complete: function() {
                                $this.text(this.countNum);
                                //alert('finished');
                            },
                        }
                    );
                });
                counted = 1;
            }
        });
    </script>
@endpush
