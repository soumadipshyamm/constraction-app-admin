@extends('Company.layouts.app')
@section('subscription-active', 'active')
@section('title', __('Subscription'))
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
                    <div>Subscription
                    </div>
                </div>
                {{-- <div class="page-title-actions">
                        <a href="{{ route('company.teams.add') }}" class="btn-shadow btn btn-info"><i class="fa fa-plus-circle" aria-hidden="true">Add New Teams</i></a>
            </div> --}}
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <h5 class="card-title">Subscription Package</h5>
                    <div class="table-responsive">
                        {{-- <table class="mb-0 table dataTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>name</th>
                                            <th>designation</th>
                                            <th>aadhar_no</th>
                                            <th>pan_no</th>
                                            <th>email</th>
                                            <th>phone</th>
                                            <th>address</th>
                                            <th>Profile Role</th>
                                            <th>Reporting Person </th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                </table> --}}
                        <H1>Working Progress........</H1>
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