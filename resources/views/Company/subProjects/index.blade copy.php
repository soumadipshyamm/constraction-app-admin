@extends('Company.layouts.app')
@section('subProject-active','active')
@section('title',__('subProject'))
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
                    <div>List Sub-Projectes Details
                    </div>
                </div>
                <div class="page-title-actions">
                    <a href="{{ route('company.subProject.add') }}" class="btn-shadow btn btn-info"><i
                            class="fa fa-plus-circle" aria-hidden="true">Add New Sub-Projecte</i></a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <h5 class="card-title">List Sub-Projectes Details</h5>
                        <div class="table-responsive">
                            <table class="mb-0 table dataTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Sub Project name</th>
                                        <th>Planned Start Date</th>
                                        <th>Planned End Date</th>
                                        <th>Project Name</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($datas)
                                    @forelse($datas as $key => $data)
                                    <tr>
                                        <td>
                                            <p>#{{ $key + 1 }}</p>
                                        </td>
                                        <td>
                                            <p>{{ $data->name }}</p>
                                        </td>
                                        <td>
                                            <p>{{ $data->start_date }}</p>
                                        </td>
                                        <td>
                                            <p>{{ $data->end_date }}</p>
                                        </td>
                                        <td>
                                            <p>{{ $data->project->project_name }}</p>
                                        </td>

                                        <td>
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input statusChange"
                                                    id="switch{{ $data->uuid }}" data-uuid="{{ $data->uuid }}"
                                                    data-message="{{ $data->is_active ? 'deactive' : 'active' }}"
                                                    data-table="sub_projects" name="example" {{ $data->is_active == 1 ?
                                                'checked' : '' }}>
                                                <label class="custom-control-label"
                                                    for="switch{{ $data->uuid }}"></label>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="{{ route('company.subProject.edit',$data->uuid) }}"><i
                                                    class="fa fa-edit" style="cursor: pointer;" title="Edit"></i></a>
                                            <a class="deleteData text-danger" data-uuid="{{ $data->uuid }}"
                                                data-table="sub_projects" href="javascript:void(0)"><i
                                                    class="fa fa-trash-alt" style="cursor: pointer;" title="Remove">
                                                </i></a>
                                        </td>
                                    </tr>
                                    @empty
                                    <p>!No Data Found</p>
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
@endsection

@push('scripts')
@endpush
{{-- "id" => 8
"uuid" => "e785b509-81a8-40d5-8368-ac0c1c84e8cd"
"project_name" => "MyProject"
"planned_start_date" => "2023-07-14"
"address" => "aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa"
"planned_end_date" => "2023-07-30"
"project_completed" => "yes"
"own_project_or_contractor" => "yes"
"companies_id" => null
"client_id" => 10
"logo" => null
"user_id" => 1
"is_active" => 1
"is_approve" => 1
"is_blocked" => 0
"created_at" => "2023-07-19T12:37:09.000000Z"
"updated_at" => "2023-07-19T12:37:09.000000Z"
"deleted_at" => null
"client" => array:16 [▼
"id" => 10
"uuid" => "18e168a8-a53a-4a8d-924d-cbdc1dc2f3f3"
"client_company_name" => "aaaaaaaaa"
"client_company_address" => "aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa"
"client_name" => "vendor 1"
"client_designation" => "ssssssss"
"client_email" => "abcd@abc.com"
"client_phone" => "08972344111"
"client_mobile" => "08972344111"
"user_id" => 1
"is_active" => 1
"is_approve" => 1
"is_blocked" => 0
"created_at" => "2023-07-19T12:37:09.000000Z"
"updated_at" => "2023-07-19T12:37:09.000000Z"
"deleted_at" => null --}}
