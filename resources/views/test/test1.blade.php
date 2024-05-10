@extends('Company.layouts.app')
@section('project-active', 'active')
@section('title', __('Project'))
@push('styles')
@endpush
@section('content')
@php
$count=5;
@endphp
@for ($i = 0; $i < $count; $i++) <li class="branch">
    <p class="hierarchy_con">
    <h5>test</h5>
    <span class="hierar_action">
        <a class="text-success addModal" data-hierarchy-id="" data-id="encryptedID" href=""> <i class="fa-solid fa-plus"></i></a>
    </span>
    </p>
    <ul>
        <h6>child</h6>
    </ul>
    </li>

    @endfor @endsection
    @push('scripts')
    @endpush