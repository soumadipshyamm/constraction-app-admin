@extends('Company.layouts.app')
@section('project-permission-active', 'active')
@section('title', __('Project Permission'))
@push('styles')
    <style>
        .table tbody tr:nth-child(odd) {
            background-color: rgba(0, 0, 0, .02);
        }

        .table tbody tr:hover {
            background-color: rgba(0, 0, 0, .04);
        }

        .table td {
            vertical-align: middle;
            border: 1px solid #dee2e6;
        }

        .table th {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
        }

        .deleteData:hover {
            opacity: 0.7;
        }
    </style>
@endpush
@section('content')
    <div class="app-main__outer">
        <div class="app-main__inner card">
            <!-- dashboard body -->
            <div class="dashboard_body">
                <div class="comp-top">
                    <a href="{{ route('company.projectPermission.approval.add') }}" class="ads-btn">
                        <span><i class="fa-solid fa-plus"></i></span>Add New
                    </a>
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
                                                    <h5 class="card-title">Project Permission</h5>
                                                    <div class="table-responsive">
                                                        <table class="mb-0 table" id="dataTables">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Project</th>
                                                                    <th>Assigned User</th>
                                                                    <th>Designation</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="datatable_body">
                                                                @php
                                                                    $currentProject = null;
                                                                    $rowIndex = 1;
                                                                @endphp

                                                                @foreach ($datas as $data)
                                                                    @if ($currentProject != $data?->project?->id)
                                                                        @php
                                                                            $currentProject = $data?->project?->id;
                                                                            $projectRowSpan = 0;

                                                                            // Count how many users are assigned to this project
                                                                            foreach ($datas as $d) {
                                                                                if (
                                                                                    $d?->project?->id == $currentProject
                                                                                ) {
                                                                                    $projectRowSpan++;
                                                                                }
                                                                            }
                                                                        @endphp
                                                                        <tr>
                                                                            <td rowspan="{{ $projectRowSpan }}">
                                                                                {{ $rowIndex }}</td>
                                                                            <td rowspan="{{ $projectRowSpan }}">
                                                                                {{ $data?->project?->project_name ?? 'N/A' }}
                                                                            </td>
                                                                            <td>{{ $data?->user?->name ?? 'N/A' }}</td>
                                                                            <td>{{ $data?->user?->companyUserRole?->name ?? 'N/A' }}
                                                                            </td>
                                                                            <td>
                                                                                <a class="deleteData text-danger"
                                                                                    data-uuid="{{ $data->id }}"
                                                                                    data-model="company"
                                                                                    data-table="company_project_permissions"
                                                                                    href="javascript:void(0)">
                                                                                    <i class="fa fa-trash-alt"
                                                                                        style="cursor: pointer;"
                                                                                        title="Remove"></i>
                                                                                </a>
                                                                            </td>
                                                                        </tr>
                                                                        @php $rowIndex++; @endphp
                                                                    @else
                                                                        <tr>
                                                                            <td>{{ $data?->user?->name ?? 'N/A' }}</td>
                                                                            <td>{{ $data?->user?->companyUserRole?->name ?? 'N/A' }}
                                                                            </td>
                                                                            <td>
                                                                                <a class="deleteData text-danger"
                                                                                    data-uuid="{{ $data->id }}"
                                                                                    data-model="company"
                                                                                    data-table="company_project_permissions"
                                                                                    href="javascript:void(0)">
                                                                                    <i class="fa fa-trash-alt"
                                                                                        style="cursor: pointer;"
                                                                                        title="Remove"></i>
                                                                                </a>
                                                                            </td>
                                                                        </tr>
                                                                    @endif
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
