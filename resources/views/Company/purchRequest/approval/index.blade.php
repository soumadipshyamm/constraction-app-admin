@extends('Company.layouts.app')
@section('pr-management-active', 'active')
@section('title', __('PR Management'))
@push('styles')
@endpush

@section('content')
    <div class="app-main__outer">
        <div class="app-main__inner card">
            <!-- dashboard body -->
            <div class="dashboard_body">
                <div class="comp-top">
                    <a href="{{ route('company.pr.approval.add') }}" class="ads-btn">
                        <span><i class="fa-solid fa-plus"></i></span>Add New
                    </a>
                </div>
                <div class="comp-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="main-card mb-3 card">
                                <div class="card-body">
                                    <h5 class="card-title">List PR Managmet Details</h5>
                                    <div class="table-responsive">
                                        <table class="mb-0 table" id="dataTable">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <!-- <th>#</th> -->
                                                    <th>User Name</th>
                                                    <th>Level</th>
                                                    <th>Project</th>
                                                    <th>Material Request No.</th>
                                                    {{-- <th>Unit Coversion Factor</th>
                                                    <th>Status</th>
                                                    <th>Action</th> --}}
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if ($datas)
                                                    @foreach ($datas as $key => $data)
                                                        <tr>
                                                            <td>{{ $key + 1 }}</td>
                                                            <td>{{ $data?->user?->name ?? '' }}</td>
                                                            <td>{{ $data?->leavel ?? '' }}</td>
                                                            <td>{{ $data?->materialRequest?->projects?->project_name ?? '' }}
                                                            </td>
                                                            <td><a
                                                                    {{-- href="{{ route('company.pr.details', $data?->materialRequest?->uuid) }}">{{ $data?->materialRequest?->request_id ?? '' }}</a> --}}
                                                            </td>
                                                        </tr>
                                                    @endforeach
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
        </div>
    </div>
@endsection

@push('scripts')
@endpush
