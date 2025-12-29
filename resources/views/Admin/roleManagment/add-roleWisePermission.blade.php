@extends('Admin.layouts.app')
@section('role-permission-active','active')
@section('title',__('Role Management'))
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
                    <div>Roles and Permissions
                        <div class="page-title-subheading">Manage all user roles
                        </div>
                    </div>
                </div>
                <div class="page-title-actions">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <h5 class="card-title">Menu Permissions for - Super Admin</h5>
                        <div>
                            <form method="POST" action="{{ route('admin.roleManagment.addPermission') }}"
                                data-url="{{ route('admin.roleManagment.addPermission') }}"
                                class="formSubmit fileUpload" enctype="multipart/form-data" id="UserForm">
                                @csrf
                                <input type="hidden" id="" name="updateId" value="{{ $id }}">
                                <div class="mb-3">
                                    <hr>
                                    <div class="row">
                                        @forelse ($menus as $value)
                                        @if($value->slug =='dashboard')
                                        <div class="col-sm-4">
                                            <label for="email" class="text-uppercase"><b>{{ $value->name }}</b></label>

                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox"
                                                    id="view_<?=$value->id?>" name="permission[<?=$value->id?>][view]"
                                                    value="view" <?=(isset($tempArr[$value->id]) && in_array('view',
                                                $tempArr[$value->id]))?'checked':''?>>
                                                <label class="form-check-label" for="view">View</label>
                                            </div>
                                        </div>
                                        @else
                                        <div class="col-sm-4">
                                            <label for="email" class="text-uppercase"><b>{{ $value->name }}</b></label>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="add_<?=$value->id?>"
                                                    name="permission[<?=$value->id?>][add]" value="add"
                                                    <?=(isset($tempArr[$value->id]) && in_array('add',
                                                $tempArr[$value->id]))?'checked':''?>>
                                                <label class="form-check-label" for="add">Add</label>
                                            </div>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox"
                                                    id="view_<?=$value->id?>" name="permission[<?=$value->id?>][view]"
                                                    value="view" <?=(isset($tempArr[$value->id]) && in_array('view',
                                                $tempArr[$value->id]))?'checked':''?>>
                                                <label class="form-check-label" for="view">View</label>
                                            </div>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox"
                                                    id="edit_<?=$value->id?>" name="permission[<?=$value->id?>][edit]"
                                                    value="edit" <?=(isset($tempArr[$value->id]) && in_array('edit',
                                                $tempArr[$value->id]))?'checked':''?>>
                                                <label class="form-check-label" for="edit">Edit</label>
                                            </div>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox"
                                                    id="delete_<?=$value->id?>"
                                                    name="permission[<?=$value->id?>][delete]" value="delete"
                                                    <?=(isset($tempArr[$value->id]) && in_array('delete',
                                                $tempArr[$value->id]))?'checked':''?>>
                                                <label class="form-check-label" for="delete">Delete</label>
                                            </div>
                                        </div>
                                        @endif
                                        @empty
                                        @endforelse
                                    </div>
                                    <div class="row">
                                        <button class="mt-2 btn btn-primary">Update</button>
                                    </div>
                                </div>
                            </form>
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
