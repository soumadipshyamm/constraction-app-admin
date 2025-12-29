@extends('Company.layouts.app')
@section('purch-request-active', 'active')
@section('title', __('Purch Request Details'))
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
                        <li> <a href="#">Purch Request Details</a></li>
                    </ul>
                </div>
                @php
                    $bgcolor = $datas?->status == 1 ? 'text-success' : ($datas?->status == 2 ? 'text-danger' : '');
                @endphp
                <div class="materials_tab">
                    <!-- **********************************Asset List********************************************************************** -->
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-materials" role="tabpanel"
                            aria-labelledby="pills-materials-tab">
                            <div class="projecttable_box copybulk_head">
                                <div class="page-title-actions">
                                    <a href="{{ route('company.pr.list') }}" class="mt-2 btn btn-secondary">&lt;
                                        Back</a>
                                </div>
                                <div class="comp-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="main-card mb-3 card">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                                        <h5 class="card-title mb-0">Purch Request Details</h5>
                                                        <div class="{{ $bgcolor }} font-weight-bold">
                                                            @if ($datas?->status == 0)
                                                                <div class="d-flex gap-2">
                                                                    <a href="javascript:void(0)"
                                                                        class="updateStatus btn btn-primary"
                                                                        data-uuid="{{ $datas?->uuid }}"
                                                                        data-table='material_requests' data-model='company'
                                                                        data-title='pr_status' data-message='Approved'
                                                                        data-status="1"
                                                                        aria-label="Approve Request">Approved</a>

                                                                    <a href="javascript:void(0)"
                                                                        class="updateStatus btn btn-danger"
                                                                        data-uuid="{{ $datas?->uuid }}"
                                                                        data-table='material_requests' data-model='company'
                                                                        data-title='pr_status' data-message='Rejected'
                                                                        data-status="2" aria-label="Reject Request">Rejected</a>
                                                                </div>
                                                            @else
                                                                <span class="badge {{ $datas?->status == 1 ? 'bg-success' : 'bg-danger' }}">
                                                                    {{ $datas?->status == 1 ? 'Approved' : 'Rejected' }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="table-responsive">
                                                        <table class="mb-0 table" id="dataTable">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Material</th>
                                                                    <th>Activitie</th>
                                                                    <th>QTY</th>
                                                                    <th>Date</th>
                                                                    <th>Remarks</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="datatable_body">
                                                                @if ($datas?->materialRequest !== null)
                                                                    @foreach ($datas?->materialRequest as $key => $data)
                                                                        <tr>
                                                                            <td>{{ $key + 1 }}</td>
                                                                            <td>{{ $data?->materials?->name ?? '---' }}</td>
                                                                            <td>{{ $data?->activites?->activities ?? '---' }}
                                                                            </td>
                                                                            <td>{{ $data?->qty ?? '---' }}</td>
                                                                            <td>{{ $data?->date ?? '---' }}</td>
                                                                            <td>{{ $data?->remarks ?? '---' }}</td>
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
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
@endpush
