@extends('Company.layouts.app')
@section('project-permission-active', 'active')
@section('title', __('Project Permission'))
@push('styles')
<style>

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
                                                        <table class="mb-0 table" id="dataTable">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Project</th>
                                                                    {{-- <th>Sub-Project</th> --}}
                                                                    <th>Assigned User</th>
                                                                    <th>Designation</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="datatable_body">
                                                                @foreach ($datas as $key => $data)
                                                                    {{-- @foreach ($projectdatas as $key => $data) --}}
                                                                    <tr>
                                                                        {{-- @dd($data); --}}
                                                                        <td>{{ $key + 1 }}</td>
                                                                        <td>{{ $data?->project?->project_name ?? '' }}
                                                                        </td>
                                                                    <tr>

                                                                        {{-- <td>{{ $data?->subprojects?->name ?? '' }}</td> --}}
                                                                        <td>{{ $data?->user?->name ?? '' }}</td>
                                                                        <td>{{ $data?->user?->companyUserRole?->name ?? '' }}
                                                                        </td>
                                                                        <td>
                                                                            {{-- <a
                                                                                href="{{ route('company.projectPermission.edit', $data->id) }}"><i
                                                                                    class="fa fa-edit"
                                                                                    style="cursor: pointer;"
                                                                                    title="Edit"></i></a> --}}
                                                                            <a class="deleteData text-danger"
                                                                                data-uuid="{{ $data->id }}"
                                                                                data-model="company"
                                                                                data-table="company_project_permissions"
                                                                                href="javascript:void(0)"><i
                                                                                    class="fa fa-trash-alt"
                                                                                    style="cursor: pointer;" title="Remove">
                                                                                </i></a>
                                                                        </td>
                                                                    </tr>
                                                                    </tr>
                                                                    {{-- @endforeach --}}
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
