@extends('Company.layouts.app')
@section('vendor-active', 'active')
@section('title', __('Preview Vendor'))
@push('styles')
@endpush

@section('content')
    <div class="app-main__outer">
        <div class="app-main__inner">
            <div class="app-page-title">
                <div class="page-title-wrapper">
                    <div class="page-title-heading">
                        <div class="page-title-icon">
                            <i class="pe-7s-tools icon-gradient bg-happy-itmeo">
                            </i>
                        </div>
                        <div>List Preview Vendor Details
                        </div>
                    </div>
                    <div class="page-title-actions">
                        <a href="{{ route('company.vendor.list') }}" class="mt-2 btn btn-secondary">&lt; Back</a>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <h5 class="card-title">List Vendor Details</h5>
                            <div class="table-responsive">
                                <table class="mb-0 table ">
                                    <tbody>
                                        {{-- @dd($datas->name) --}}
                                        @if ($datas)
                                            <tr>
                                                <td><strong>Vendor Details</strong></td>
                                            </tr>
                                            <tr>
                                                <td>Name</td>
                                                <td>{{ $datas->name }}</td>
                                            </tr>
                                            <tr>
                                                <td>Gst No</td>
                                                <td>{{ $datas->gst_no }}</td>
                                            </tr>
                                            <tr>
                                                <td>Address</td>
                                                <td>{{ $datas->address }}</td>
                                            </tr>
                                            <tr>
                                                <td>Type</td>
                                                <td>{{ $datas->type }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Contact Person</strong></td>
                                            </tr>
                                            <tr>
                                                <td>Contact Person Name</td>
                                                <td>{{ $datas->contact_person_name }}</td>
                                            </tr>
                                            <tr>
                                                <td>Contact Person Phone</td>
                                                <td>{{ $datas->contact_person_name }}</td>
                                            </tr>
                                            <tr>
                                                <td>Contact Person Email</td>
                                                <td>{{ $datas->email }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Additional Fields</strong></td>
                                            </tr>
                                            {{-- @dd($datas->additional_fields); --}}
                                            @php
                                                $addd_filed = json_decode($datas->additional_fields);
                                            @endphp
                                            {{-- @dd($addd_filed); --}}
                                            @if ($addd_filed)
                                                @foreach ($addd_filed as $key => $value)
                                                    {{-- @php
                                                        print_r($value->name);
                                                    @endphp --}}
                                                    <tr>
                                                        <td>{{ $value->name }}</td>
                                                        <td>{{ $value->value }}</td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
@endpush
