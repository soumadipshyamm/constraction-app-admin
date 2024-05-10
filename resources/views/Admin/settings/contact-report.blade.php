@extends('Admin.layouts.app')
@section('contact-report-active', 'active')
@section('title', __('Contact Report'))
@push('styles')
@endpush
@section('content')
<div class="app-main__outer">
    <div class="app-main__inner">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-user icon-gradient bg-happy-itmeo">
                        </i>
                    </div>
                    <div>Contact Report
                        <div class="page-title-subheading">Contact Report
                        </div>
                    </div>
                </div>
                {{-- <div class="page-title-actions">
                        @if (checkAdminPermissions('admin-user', auth()->user()->admin_role_id, auth()->user()->id, 'add'))
                            <a href="{{ route('admin.subscription.add') }}" type="button" class="btn-shadow btn btn-info">
                Add Settings
                </a>
                @endif
            </div> --}}
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <h5 class="card-title">Contact Report</h5>
                    <div class="table-responsive table-scrollable" id="load_content">
                        <table class="mb-0 table dataTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone No.</th>
                                    <th>Subject</th>
                                    <th>Message</th>
                                    <th>Created On</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($datas)
                                @forelse($datas as $key => $data)
                                <tr>
                                    <td>
                                        <p>#{{ $key + 1 }}</p>
                                    </td>
                                    <td>
                                        <p>{{ $data->name ?? '' }}</p>
                                    </td>
                                    <td>
                                        <p>{{ $data->email ?? '' }}</p>
                                    </td>
                                    <td>
                                        <p>{{ $data->phone ?? '' }}</p>
                                    </td>
                                    <td>
                                        <p>{{ $data->subject ?? '' }}</p>
                                    </td>
                                    <td>
                                        <p>{{ $data->message ?? '' }}</p>
                                    </td>
                                    <td>
                                        <p>{{ $data->created_at ?? '' }}</p>
                                    </td>
                                </tr>
                                @empty

                                <!-- <td colspan="7"> -->
                                <!-- <p>!No Data Found</p> -->
                                <!-- </td> -->

                                @endforelse
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
@endsection()
@push('scripts')
@endpush