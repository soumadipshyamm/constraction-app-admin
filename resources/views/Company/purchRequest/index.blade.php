@extends('Company.layouts.app')
@section('purch-request-active', 'active')
@section('title', __('Purch Request'))
@push('styles')
@endpush
@section('content')
    <div class="app-main__outer">
        <div class="app-main__inner card">
            <!-- dashboard body -->
            <div class="dashboard_body">
                <div class="breadcrumbs">
                    <ul>
                        <li> <a href="#">Master</a></li>
                        <li> <a href="#">Purch Request</a></li>
                        <!-- <li> <a href="#">Project</a></li> -->
                    </ul>
                </div>
                <div class="materials_tab">
                    <!-- **********************************Asset List********************************************************************** -->
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-materials" role="tabpanel"
                            aria-labelledby="pills-materials-tab">
                            <div class="projecttable_box copybulk_head">
                                <div class="comp-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="main-card mb-3 card">
                                                <div class="card-body">
                                                    <h5 class="card-title">Purch Request</h5>
                                                    <div class="table-responsive">
                                                        <table class="mb-0 table" id="dataTable">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Request No</th>
                                                                    <th>User Name</th>
                                                                    <th>Project</th>
                                                                    <th>Sub-Project</th>
                                                                    <th>Date</th>
                                                                    <th>Status</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="datatable_body">
                                                                @foreach ($datas as $key => $data)
                                                                    @php
                                                                        $bgcolor =
                                                                            $data?->status == 1
                                                                                ? 'text-success'
                                                                                : ($data?->status == 2
                                                                                    ? 'text-danger'
                                                                                    : '');
                                                                    @endphp
                                                                    <tr>
                                                                        <td>{{ $key + 1 }}</td>
                                                                        <td><a
                                                                                href="{{ route('company.pr.details', $data?->uuid) }}">{{ $data?->request_id ?? '---' }}</a>
                                                                        </td>
                                                                        <td>{{ $data?->users?->name ?? '' }}</td>
                                                                        <td>{{ $data?->projects?->project_name ?? '' }}</td>
                                                                        <td>{{ $data?->subprojects?->name ?? '' }}</td>
                                                                        <td>{{ $data?->date ?? '' }}</td>
                                                                        <td class="{{ $bgcolor }} font-weight-bold">
                                                                            @if ($data?->status == 0)
                                                                                <div>
                                                                                    <a href="javascript:void(0)"
                                                                                        class="updateStatus btn btn-primary"
                                                                                        data-uuid="{{ $data?->uuid }}"
                                                                                        data-table='material_requests'
                                                                                        data-model='company'
                                                                                        data-title='pr_status'
                                                                                        data-message='Approved'
                                                                                        data-status="1"
                                                                                        aria-label="Approve Request">Approved</a>

                                                                                    <a href="javascript:void(0)"
                                                                                        class="updateStatus btn btn-danger"
                                                                                        data-uuid="{{ $data?->uuid }}"
                                                                                        data-table='material_requests'
                                                                                        data-model='company'
                                                                                        data-title='pr_status'
                                                                                        data-message='Rejected'
                                                                                        data-status="2"
                                                                                        aria-label="Reject Request">Rejected</a>
                                                                                </div>
                                                                            @else
                                                                                {{ $data?->status == 1 ? 'Approved' : 'Rejected' }}
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
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
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    
@endpush
