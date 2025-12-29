@extends('Frontend.layouts.app')
@section('product-active','active')
@section('title',__('Product'))
@push('styles')
@endpush

@section('content')
{{-- @dd($datas); --}}
      <!-- breadcumb -->
      <section class="breadcumb">
        <div class="breadcumb-img">
            <img src="{{ asset('page_banner/'.$datas?->banner?->banner??'') }}" alt="" class="img-fluid"> 
           {!! $datas?->banner?->contented??'' !!}
            {{-- <img src="assets/images/about-banner.png" alt="" class="img-fluid">
              <div class="overlay"></div>
              <div class="breadcrumbs-content">
                    <p> <span><a href="#">Home </a></span> / Product</p>
                    <h2>Product</h2>
              </div>
        </div> --}}
  </section>

  <!-- product page -->
  {{-- <section class="product_sec">
        <div class="container">
              <div class="row pt_pros">
                    <div class="col-md-6">
                          <div class="products_img">
                                <img src="assets/images/pro-01.jpg" class="img-fluid" alt="">
                          </div>
                    </div>

                    <div class="col-md-6">
                          <div class="products_con">
                                <h6>Construction</h6>
                                <h2>For Construction</h2>
                                <div class="productc_features">
                                      <ul>
                                            <li><span><img src="assets/images/checked.png" class="img-fluid"
                                                              alt=""></span>Lorem ipsum dolor sit</li>
                                            <li><span><img src="assets/images/checked.png" class="img-fluid"
                                                              alt=""></span>Lorem ipsum dolor sit</li>
                                            <li><span><img src="assets/images/checked.png" class="img-fluid"
                                                              alt=""></span>Lorem ipsum dolor sit</li>
                                            <li><span><img src="assets/images/checked.png" class="img-fluid"
                                                              alt=""></span>Lorem ipsum dolor sit</li>
                                            <li><span><img src="assets/images/checked.png" class="img-fluid"
                                                              alt=""></span>Lorem ipsum dolor sit</li>
                                            <li><span><img src="assets/images/checked.png" class="img-fluid"
                                                              alt=""></span>Lorem ipsum dolor sit</li>
                                      </ul>
                                </div>
                          </div>
                    </div>

              </div>

              <div class="row pt_pros row_reverse">
                    <div class="col-md-6">
                          <div class="products_con">
                                <h6>Vendor</h6>
                                <h2>For Vendor</h2>
                                <div class="productc_features">
                                      <ul>
                                            <li><span><img src="assets/images/checked.png" class="img-fluid"
                                                              alt=""></span>Lorem ipsum dolor sit</li>
                                            <li><span><img src="assets/images/checked.png" class="img-fluid"
                                                              alt=""></span>Lorem ipsum dolor sit</li>
                                            <li><span><img src="assets/images/checked.png" class="img-fluid"
                                                              alt=""></span>Lorem ipsum dolor sit</li>
                                            <li><span><img src="assets/images/checked.png" class="img-fluid"
                                                              alt=""></span>Lorem ipsum dolor sit</li>
                                            <li><span><img src="assets/images/checked.png" class="img-fluid"
                                                              alt=""></span>Lorem ipsum dolor sit</li>
                                            <li><span><img src="assets/images/checked.png" class="img-fluid"
                                                              alt=""></span>Lorem ipsum dolor sit</li>
                                      </ul>
                                </div>
                          </div>
                    </div>

                    <div class="col-md-6">
                          <div class="products_img">
                                <img src="assets/images/pro-02.jpg" class="img-fluid" alt="">
                          </div>
                    </div>

              </div>
        </div>
  </section> --}}
  {!! $datas->page_contented??'' !!}

@endsection
@push('scripts')
@endpush
