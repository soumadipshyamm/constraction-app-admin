@extends('Admin.layouts.app')
@section('site-page-active','active')
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
                    <div>List Pages Details
                    </div>
                </div>
                <div class="page-title-actions">
                    @if(checkAdminPermissions('admin-management-site-engineering',auth()->user()->admin_role_id,auth()->user()->id,'add'))
                    <a href="{{ route('admin.pageManagment.add') }}" class="btn-shadow btn btn-info"><i
                            class="fa fa-plus-circle" aria-hidden="true">
                            Add New Page</i></a>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <h5 class="card-title">List Page Details</h5>
                        <div class="table-responsive">
                            <table class="mb-0 table dataTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        {{-- <th>Banner</th> --}}
                                        <th>Page Name</th>
                                        <th>Page Title</th>
                                        {{-- <th>Page Contented</th> --}}
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
                                        {{-- <td>
                                            <img src="{{ asset('page_banner/'.$data->page_banner) }}" width="100px"
                                                height="100px">
                                        </td> --}}
                                        <td>
                                            <p>{{ $data->page_name }}</p>
                                        </td>
                                        <td>
                                            <p>{{ $data->page_title }}</p>
                                        </td>
                                        {{-- <td class="brk_line">
                                            <p>{!! $data->page_contented !!}</p>
                                        </td> --}}
                                        <td>
                                            @if(checkAdminPermissions('admin-management-site-engineering',auth()->user()->admin_role_id,auth()->user()->id,'edit'))
                                            @if($data->slug!='about' && $data->slug!='contact-us' &&
                                            $data->slug!='product')

                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input statusChange"
                                                    id="switch{{ $data->uuid }}" data-uuid="{{ $data->uuid }}"
                                                    data-message="{{ $data->is_active ? 'deactive' : 'active' }}"
                                                    data-table="page_managments" name="example" {{ $data->is_active == 1
                                                ?
                                                'checked' : '' }}>
                                                <label class="custom-control-label"
                                                    for="switch{{ $data->uuid }}"></label>
                                            </div>
                                            @endif
                                            @endif
                                        </td>
                                        <td>
                                            @if(checkAdminPermissions('admin-management-site-engineering',auth()->user()->admin_role_id,auth()->user()->id,'edit'))

                                            <a href="{{ route('admin.pageManagment.edit',$data->uuid) }}"><i
                                                    class="fa fa-edit" style="cursor: pointer;" title="Edit"></i></a>

                                            @if($data->slug!='about' && $data->slug!='contact-us' &&
                                            $data->slug!='product')
                                            <a class="deleteData text-danger" data-uuid="{{ $data->uuid }}"
                                                data-table="page_managments" href="javascript:void(0)"><i
                                                    class="fa fa-trash-alt" style="cursor: pointer;" title="Remove">
                                                </i></a>
                                            @endif
                                            @endif
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
