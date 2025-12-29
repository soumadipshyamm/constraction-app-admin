@extends('Company.layouts.app')
@section('role-active', 'active')
@section('title', __('Role Management'))
@push('styles')
<style>
.permission-group {
    border: 1px solid #eee;
    padding: 15px;
    margin-bottom: 15px;
    border-radius: 5px;
}
.permission-group:hover {
    background: #f8f9fa;
}
.select-all-wrapper {
    margin-bottom: 10px;
    padding-bottom: 5px;
    border-bottom: 1px solid #eee;
}
</style>
@endpush
@section('content')
    <div class="app-main__outer">
        <div class="app-main__inner">
            <div class="app-page-title">
                <div class="page-title-wrapper">
                    <div class="page-title-heading">
                        <div class="page-title-icon">
                            <i class="pe-7s-tools icon-gradient bg-happy-itmeo"></i>
                        </div>
                        <div>User Permissions
                            <div class="page-title-subheading">Manage User Permissions</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <h5 class="card-title mb-4">User Permissions</h5>
                            <form method="POST" action="{{ route('company.userManagment.addUserPermission') }}"
                                data-url="{{ route('admin.userManagment.addUserPermission') }}"
                                class="formSubmit fileUpload" enctype="multipart/form-data" id="UserForm">
                                @csrf
                                <input type="hidden" name="updateId" value="{{ $id }}">

                                <div class="row">
                                    @forelse ($menus as $value)
                                        <div class="col-md-4 mb-4">
                                            <div class="permission-group">
                                                <label class="text-uppercase fw-bold mb-3">{{ $value->name }}</label>

                                                @if (in_array($value->slug, ['dashboard', 'user-management', 'pr-manage', 'web', 'app', 'subscription', 'work-progress-reports', 'inventory-reports', 'master']))
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="view_{{ $value->id }}"
                                                            name="permission[{{ $value->id }}][view]"
                                                            value="view"
                                                            {{ isset($tempArr[$value->id]) && in_array('view', $tempArr[$value->id]) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="view_{{ $value->id }}">View</label>
                                                    </div>
                                                @else
                                                    <div class="select-all-wrapper">
                                                        <div class="form-check">
                                                            <input class="form-check-input select-all-permissions"
                                                                type="checkbox"
                                                                id="select_all_{{ $value->id }}"
                                                                data-menu-id="{{ $value->id }}"
                                                                {{ isset($tempArr[$value->id]) && count($tempArr[$value->id]) === 4 ? 'checked' : '' }}>
                                                            <label class="form-check-label fw-bold" for="select_all_{{ $value->id }}">
                                                                Select All
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <div class="permission-options">
                                                        <div class="form-check">
                                                            <input class="form-check-input permission-checkbox"
                                                                type="checkbox"
                                                                id="add_{{ $value->id }}"
                                                                name="permission[{{ $value->id }}][add]"
                                                                value="add"
                                                                data-menu-id="{{ $value->id }}"
                                                                {{ isset($tempArr[$value->id]) && in_array('add', $tempArr[$value->id]) ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="add_{{ $value->id }}">Add</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input permission-checkbox"
                                                                type="checkbox"
                                                                id="view_{{ $value->id }}"
                                                                name="permission[{{ $value->id }}][view]"
                                                                value="view"
                                                                data-menu-id="{{ $value->id }}"
                                                                {{ isset($tempArr[$value->id]) && in_array('view', $tempArr[$value->id]) ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="view_{{ $value->id }}">View</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input permission-checkbox"
                                                                type="checkbox"
                                                                id="edit_{{ $value->id }}"
                                                                name="permission[{{ $value->id }}][edit]"
                                                                value="edit"
                                                                data-menu-id="{{ $value->id }}"
                                                                {{ isset($tempArr[$value->id]) && in_array('edit', $tempArr[$value->id]) ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="edit_{{ $value->id }}">Edit</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input permission-checkbox"
                                                                type="checkbox"
                                                                id="delete_{{ $value->id }}"
                                                                name="permission[{{ $value->id }}][delete]"
                                                                value="delete"
                                                                data-menu-id="{{ $value->id }}"
                                                                {{ isset($tempArr[$value->id]) && in_array('delete', $tempArr[$value->id]) ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="delete_{{ $value->id }}">Delete</label>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @empty
                                        <div class="col-12">
                                            <p class="text-center">No permissions found</p>
                                        </div>
                                    @endforelse
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary px-4">Update Permissions</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Handle "Select All" checkbox
    $('.select-all-permissions').change(function() {
        var menuId = $(this).data('menu-id');
        var isChecked = $(this).prop('checked');

        // Find all permission checkboxes for this menu and set their state
        $('input.permission-checkbox[data-menu-id="' + menuId + '"]').prop('checked', isChecked);
    });

    // Handle individual permission checkboxes
    $('.permission-checkbox').change(function() {
        var menuId = $(this).data('menu-id');
        var totalCheckboxes = $('input.permission-checkbox[data-menu-id="' + menuId + '"]').length;
        var checkedCheckboxes = $('input.permission-checkbox[data-menu-id="' + menuId + '"]:checked').length;

        // Update "Select All" checkbox state
        $('#select_all_' + menuId).prop('checked', totalCheckboxes === checkedCheckboxes);
    });
});
</script>
@endpush
