@extends('Frontend.layouts.app')
@section('Home-active','active')
@section('title',__('Home'))
@push('styles')
@endpush

@section('content')
<!-- banner -->

{{-- @foreach($datas as $key => $data) --}}
{{-- @if($datas[0]->slug=='banner-section')
<div class="banner">
    <img src="{{ asset('page_banner/'.$datas[0]->img??'') }}" alt="">
    <div class="banner-content">
        <h1>{{ $datas[0]->content_title??'' }}</h1>
        <p>{!! $datas[0]->content??'' !!}</p>
        <ul class="banner-btn">
            <li><a href="">Request a demo</a></li>
            <li><a href="">See Pricing Plans</a></li>
        </ul>
    </div>
    <a class="chat" href=""><i class="fa fa-commenting" aria-hidden="true"></i></a>
</div>
@endif --}}


<div class="banner">
    <img src="{{ asset('page_banner/'.$banners?->banner??'') }}" alt="">
    {{-- {!! $banners?->contented??'' !!} --}}
    <div class="banner-content">
        {{-- <h1>{{ $datas[0]->content_title??'' }}</h1>
        <p>{!! $datas[0]->content??'' !!}</p> --}}
        <ul class="banner-btn">
            <li><a href="">Request a demo</a></li>
            <li><a href="">See Pricing Plans</a></li>
        </ul>
    </div>
    <a class="chat" href=""><i class="fa fa-commenting" aria-hidden="true"></i></a>
</div>


{{-- @dd( $datas[0]->slug ); --}}
{{-- @if($datas[1]->slug=='section-one')
<section class="common">
    <div class="row no-gutters align-items-end">
        <div class="col col-md-6">
            <img src="{{ asset('page_banner/'.$datas[1]->img) }}" alt="" width="409px" height="382px">
        </div>
        <div class="col col-md-6">
            <div class="common_sec_contnt">
                <h5>{{ $datas[1]->block_title }}</h5>
                <h2>{{ $datas[1]->content_title }}</h2>
                <p>{!! $datas[1]->content !!}</p>
                <a href="">Learn More</a>
            </div>
        </div>
    </div>
</section>
@endif --}}
{{-- {!! $datas[1]->content !!} --}}


<!-- welcome to koncite -->
{{-- section Two --}}
{{-- {!! $datas[2]->content !!} --}}
{{-- <section class="content-only-card">
    <div class="row no-gutters">
        <div class="col-sm-3 col-md-3">
            <div class="sec-card">
                <h3>Business Owners</h3>
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                    Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,</p>
                <img src="assets/images/ribon.svg" alt="">
            </div>
        </div>

        <div class="col-sm-3 col-md-3">
            <div class="sec-card">
                <h3>Project & Planning managers</h3>
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                    Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,</p>
            </div>
        </div>

        <div class="col-sm-3 col-md-3">
            <div class="sec-card">
                <h3>Procurement & Purchase managers</h3>
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                    Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,</p>
            </div>
        </div>

        <div class="col-sm-3 col-md-3">
            <div class="sec-card">
                <h3>Site Engineers & Supervisors</h3>
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                    Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,</p>
            </div>
        </div>
    </div>

</section> --}}



<!-- common  -->
{{-- section-three --}}
{{-- {!! $datas[3]->content !!} --}}
{{-- <section class="common common-even">
    <div class="row no-gutters  justify-content-end">

        <div class="col col-md-6">
            <div class="common_sec_contnt">
                <h5>WE PROVIDE</h5>
                <h2>Drive Quality Assurance</h2>
                <p>
                    sed diam voluptua vero eos Loripsum dolor stit
                    amet coadipscing elitr, rumy tinvidunt ut labore
                    Loripsum dolor stit amet, coadipscing elitr rsed diano eirmod tinvidunt ut
                    labore et dolore magna aliquyam erat sed diam voluptua vero eos.
                </p>
                <a href="">See Pricing Plans</a>
            </div>
        </div>


        <div class="col col-md-6">
            <img src="assets/images/two.png" alt="">
        </div>


    </div>
</section> --}}



{{-- <section class="common bg-new">
    <div class="row no-gutters align-items-end">
        <div class="col col-md-6">
            <img src="assets/images/three.png" alt="">
        </div>

        <div class="col col-md-6">
            <div class="common_sec_contnt">
                <h5>CHECK YOUR</h5>
                <h2>Track Progress & Resources</h2>
                <p>
                    sed diam voluptua vero eos Loripsum dolor
                    stit amet coadipscing elitr, rumy tinvidunt
                    ut labore Loripsum dolor stit amet, coadipscing
                    elitr rsed diano eirmod tinvidunt ut
                    labore et dolore magna aliquyam erat sed diam voluptua vero eos.
                </p>
                <a href="">Schedule a demo</a>
            </div>
        </div>
    </div>
</section> --}}
{{-- {!! $datas[4]->content !!} --}}

<section class="counter">

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
</section>
{{-- {!! $datas[5]->content !!} --}}

<section class="testimonial">
    <div class="container">
        <h3 class="sec-title">TESTMONIAL</h3>
        <p class="sub-title">What our customer are Saying about us</p>
        <div class="owl-carousel owl-them testimonial-slide">
            <div class="item">
                <div class="testimonial-card">
                    <div class="autor-info">
                        <div class="img"><img src="assets/images/p-1.png" alt=""></div>
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

                    <img src="assets/images/quote.svg" alt="" class="qut">
                </div>
            </div>

            <div class="item">
                <div class="testimonial-card">
                    <div class="autor-info">
                        <div class="img"><img src="assets/images/p-2.png" alt=""></div>
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

                    <img src="assets/images/quote.svg" alt="" class="qut">
                </div>
            </div>
        </div>
    </div>
</section>
{{-- {!! $datas[6]->content !!} --}}


<section class="next-step box_arrow arrow-top">
    <div class="container">

        <h3>Take the next step</h3>
        <ul>
            <li><a href="">SCHEDULE A DEMO</a></li>
            <li><a href="">VIEW PRICING</a></li>
        </ul>
    </div>
</section>


<section class="latest-blogs">
    <div class="container">
        <h3 class="sec-title">BLOG</h3>
        <p class="sub-title">Our latest New & Blog</p>
        <div class="owl-carousel owl-them blogs-slide">
            <div class="item">
                <div class="product-card">
                    <div class="img">
                        <img src="assets/images/pr-1.png" alt="">
                    </div>

                    <h3>Lorem Ipsumsid</h3>
                    <p>
                        Lorem Ipsumsid umpri ngand industry orem Ipsum.
                    </p>
                    <a href="">
                        <img src="assets/images/right-arrow.svg" alt="">
                    </a>
                </div>
            </div>

            <div class="item">
                <div class="product-card">
                    <div class="img">
                        <img src="assets/images/pr-2.png" alt="">
                    </div>

                    <h3>Lorem Ipsumsid</h3>
                    <p>
                        Lorem Ipsumsid umpri ngand industry orem Ipsum.
                    </p>
                    <a href="">
                        <img src="assets/images/right-arrow.svg" alt="">
                    </a>
                </div>
            </div>

            <div class="item">
                <div class="product-card">
                    <div class="img">
                        <img src="assets/images/pr-3.png" alt="">
                    </div>

                    <h3>Lorem Ipsumsid</h3>
                    <p>
                        Lorem Ipsumsid umpri ngand industry orem Ipsum.
                    </p>
                    <a href="">
                        <img src="assets/images/right-arrow.svg" alt="">
                    </a>
                </div>
            </div>
            <div class="item">
                <div class="product-card">
                    <div class="img">
                        <img src="assets/images/pr-1.png" alt="">
                    </div>

                    <h3>Lorem Ipsumsid</h3>
                    <p>
                        Lorem Ipsumsid umpri ngand industry orem Ipsum.
                    </p>
                    <a href="">
                        <img src="assets/images/right-arrow.svg" alt="">
                    </a>
                </div>
            </div>

            <div class="item">
                <div class="product-card">
                    <div class="img">
                        <img src="assets/images/pr-2.png" alt="">
                    </div>

                    <h3>Lorem Ipsumsid</h3>
                    <p>
                        Lorem Ipsumsid umpri ngand industry orem Ipsum.
                    </p>
                    <a href="">
                        <img src="assets/images/right-arrow.svg" alt="">
                    </a>
                </div>
            </div>

            <div class="item">
                <div class="product-card">
                    <div class="img">
                        <img src="assets/images/pr-3.png" alt="">
                    </div>

                    <h3>Lorem Ipsumsid</h3>
                    <p>
                        Lorem Ipsumsid umpri ngand industry orem Ipsum.
                    </p>
                    <a href="">
                        <img src="assets/images/right-arrow.svg" alt="">
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
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
$(window).scroll(function () {
    var oTop = $(".counter-box").offset().top - window.innerHeight;
    if (counted == 0 && $(window).scrollTop() > oTop) {
        $(".count").each(function () {
            var $this = $(this),
                countTo = $this.attr("data-count");
            $({
                countNum: $this.text(),
            }).animate(
                {
                    countNum: countTo,
                },

                {
                    duration: 3000,
                    easing: "swing",
                    step: function () {
                        $this.text(Math.floor(this.countNum));
                    },
                    complete: function () {
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
