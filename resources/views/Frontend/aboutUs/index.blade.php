@extends('Frontend.layouts.app')
@section('about-active','active')
@section('title',__('About'))
@push('styles')
@endpush

@section('content')
<div class="about-banner">
    <img src="{{ asset('page_banner/'.$datas?->banner?->banner)??'' }}" class="img-fluid" alt="">
    <div class="inner-banner-content">
        {!! $datas->banner->contented??'' !!}
    </div>
    <a class="chat" href=""><i class="fa fa-commenting" aria-hidden="true"></i></a>
</div>

{!! $datas->page_contented??'' !!}

@endsection
@push('scripts')
@endpush