@extends('Admin.layouts.app')
@section('menu-managment-active','active')
@section('title',__('Pages'))
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
                    <div>List Menu Managment Details
                    </div>
                </div>
                <div class="page-title-actions">
                    <a href="{{ route('admin.menuManagment.add') }}" class="btn-shadow btn btn-info"><i
                            class="fa fa-plus-circle" aria-hidden="true">
                            Add New Menu</i></a>
                </div>
            </div>
        </div>
        {{-- {{ $datas }} --}}
        <div class="row">
            <div class="col-lg-12">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        {{-- <h5 class="card-title">List Page Details</h5> --}}
                        <div class="table-responsive">
                            <table class="mb-0 table dataTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Menu Position</th>
                                        <th>Menu Label </th>
                                        <th>Link Type </th>
                                        <th>Page Link</th>
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
                                            <p>{{ $data->position }}</p>
                                        </td>
                                        <td>
                                            <p>{{ $data->lable }}</p>
                                        </td>
                                        <td>
                                            <p>{{ $data->type }}</p>
                                        </td>
                                        @if($data->type=='internal')
                                        <td>
                                            <p>{{ getPageDetails('page_name',$data->site_page) }}</p>
                                        </td>
                                        @else
                                        <td>
                                            <p>{{ $data->site_page }}</p>
                                        </td>
                                        @endif
                                        <td>
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input statusChange"
                                                    id="switch{{ $data->uuid }}" data-uuid="{{ $data->uuid }}"
                                                    data-message="{{ $data->is_active ? 'deactive' : 'active' }}"
                                                    data-table="menu_managments" name="example" {{ $data->is_active == 1
                                                ?
                                                'checked' : '' }}>
                                                <label class="custom-control-label"
                                                    for="switch{{ $data->uuid }}"></label>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.menuManagment.edit',$data->uuid) }}"><i
                                                    class="fa fa-edit" style="cursor: pointer;" title="Edit"></i></a>
                                            <a class="deleteData text-danger" data-uuid="{{ $data->uuid }}"
                                                data-table="menu_managments" href="javascript:void(0)"><i
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
