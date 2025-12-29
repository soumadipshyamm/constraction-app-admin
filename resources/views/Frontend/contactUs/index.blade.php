@extends('Frontend.layouts.app')
@section('product-active', 'active')
@section('title', __('Product'))
@push('styles')
@endpush
@section('content')
    <!-- breadcumb -->
    <section class="breadcumb">
        {{-- <div class="breadcumb-img"> --}}
        {{-- @dd($banners); --}}
        {{-- <img src="{{ asset('page_banner/'.$banners?->banner??'') }}" alt=""> --}}
        <img src="{{ asset('page_banner/' . $banners?->banner ?? '') }}" alt="" class="img-fluid">
        {{-- {!! $banners?->contented ?? '' !!} --}}
        <div class="inner-banner-content">
            <h2>Contact Us</h2>
        </div>
        </div>
    </section>
    <!-- contact Us -->
    <section class="contact-us">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-12">
                    <div class="contact-us-left">
                        <h2>Get in Touch</h2>
                        <ul>
                            @php
                                $contactDetails = contactDetails();
                            @endphp
                            {{-- @dd($contactDetails); --}}
                            @if (isset($contactDetails?->ph_no))
                                <li><a href="tel:{{ $contactDetails?->ph_no ?? '' }}"><span class="icon"><i
                                                class="fa fa-phone" aria-hidden="true"></i></span>Call us <br>
                                        <span class="details">+{{ $contactDetails?->ph_no ?? '' }}</span> </a></li>
                            @endif
                            <li><a href="mailto: {{ $contactDetails?->email ?? '' }}"><span class="icon"><i
                                            class="fa fa-envelope" aria-hidden="true"></i></span>Mail Us <br>
                                    <span class="details"> {{ $contactDetails?->email ?? '' }}</span></a></li>
                            @if (isset($contactDetails?->address))
                                <li><a><span class="icon"><i class="fa fa-map-marker" aria-hidden="true"></i></span>Visit
                                        Us
                                        <br>
                                        <span class="details"> {{ $contactDetails?->address ?? '' }}</span>
                                    </a></li>
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <div class="contact-us-right">
                        <h3>Fill the Form Below</h3>
                        <form method="POST" action="{{ route('contactUs') }}" class="formSubmit fileUpload"
                            enctype="multipart/form-data" id="UserForm">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-12">
                                    <label for="name">Name</label>
                                    <div class="form-group">
                                        <input type="text" name="name" id="name" class="form-control"
                                            placeholder="Your Name">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-12">
                                    <label for="name">Email</label>
                                    <div class="form-group">
                                        <input type="email" name="email" id="email" class="form-control"
                                            placeholder="Your Email">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-12">
                                    <label for="name">Phone</label>
                                    <div class="form-group">
                                        <input type="number" name="phone" id="phone" class="form-control"
                                            placeholder="Your Phone">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-12">
                                    <label for="name">Subject</label>
                                    <div class="form-group">
                                        <input type="text" name="subject" id="subject" class=" form-control"
                                            placeholder="Enter Subject"></span>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12 col-12">
                                    <label for="name">Message</label>
                                    <div class="form-group">
                                        <textarea cols="40" rows="3" name="message" id="message" class=" form-control mb-2"
                                            placeholder="Enter Your Message"></textarea>
                                    </div>
                                </div>

                                <div class="col-md-10 col-sm-10 col-10 sbtn">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary form-control m-5">Submit
                                            Now</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- map -->
    <section class="map">
        <div class=" col-12 pt-5">
            <iframe src="{{ $contactDetails?->map_loc ?? 'https://maps.app.goo.gl/r4ym9PoHpj4kKNNU6' }}"
                {{-- src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3684.14126976648!2d88.42939135063494!3d22.573819085109513!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3a0275afcc956fd3%3A0x710c287cd8886aed!2sEn-32%20Shyam%20Tower%2C%2031%2C%20EN%20Block%2C%20Sector%20V%2C%20Bidhannagar%2C%20Kolkata%2C%20West%20Bengal%20700091!5e0!3m2!1sen!2sin!4v1656067604791!5m2!1sen!2sin" --}} width="100%" height="600" style="border:0;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </section>
@endsection
@push('scripts')
@endpush
