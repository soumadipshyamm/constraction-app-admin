@extends('Frontend.layouts.app')
@section('about-active', 'active')
@section('title', __('About'))
@push('styles')
@endpush

@section('content')
    <div class="about-banner">
        <img src="{{ asset('page_banner/' . $datas?->banner?->banner) ?? '' }}" class="img-fluid" alt="">
        <div class="inner-banner-content">
            {!! $datas->banner->contented ?? '' !!}
        </div>
        {{-- <a class="chat" href=""><i class="fa fa-commenting" aria-hidden="true"></i></a> --}}
    </div>
    <div>

        {!! $datas->page_contented ?? '' !!}
    </div>

    {{-- <section class="common">
    <div class="row no-gutters align-items-end">
      <div class="col col-md-6">
        <img alt="" src="/images/about_us.png" >
      </div>
      <div class="col col-md-6">
        <div class="common_sec_contnt_about">
          <h5>ABOUT US:​​</h5>
          <p>
            With a strong background in both construction and technology, we serve as the perfect bridge between construction companies and tech solutions. Having worked with 150+ builders, developers, and infrastructure firms worldwide, we specialize in digitizing site operations. Through Koncite, we help companies streamline processes, enhance efficiency, and gain real-time visibility into their projects.
          </p>
        </div>
      </div>
    </div>
  </section>

<section class="common">
    <div class="row no-gutters align-items-end">     
      <div class="col col-md-6">
        <div class="common_sec_contnt_about">
          <h5>Founder’s Vision​​</h5>
          <p>
            We aim to digitize the entire lifecycle of construction projects for businesses of all sizes, from small enterprises to large corporations. Our goal is to drive efficiency and sustainability by reducing the carbon footprint of construction and infrastructure activities, which are among the largest contributors to global emissions
          </p>
        </div>
      </div>
      <div class="col col-md-6">
        <img alt="" src="/images/about_vission.png" >
      </div>
    </div>
  </section>

<section class="common">
    <div class="row no-gutters align-items-end">
      <div class="col col-md-6">
        <img alt="" src="/images/about_mission.png" >
      </div>
      <div class="col col-md-6">
        <div class="common_sec_contnt_about">
          <h5>Mission​​</h5>
          <p>
            Our mission is to provide an easy-to-use, budget-friendly solution that enables small and medium-sized construction companies to move beyond traditional record-keeping in books or Excel, improving project visibility and control. For large enterprises, we aim to complement existing ERP systems by offering real-time access to site operations, enhancing efficiency and decision-making
          </p>
        </div>
      </div>
    </div>
  </section> --}}

@endsection
@push('scripts')
@endpush
