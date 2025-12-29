@extends('Admin.layouts.app')
@section('menu-managment-active','active')
@section('menu-managment-collapse','mm-collapse mm-show')
@section('title',__('Admin Pages'))
@push('styles')
<style>
    .error {
        color: red;
    }

    .ck-editor__editable {
        min-height: 250px;
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
                        <i class="pe-7s-add-user text-success">
                        </i>
                    </div>
                    <div>Manage Menu Details
                    </div>
                </div>
                <div class="page-title-actions">
                </div>
            </div>
        </div>

        <div class="tab-content">
            <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <h5 class="card-title">Add Your Menu Details</h5>
                        <form method="POST" action="{{ route('admin.menuManagment.add') }}"
                            data-url="{{ route('admin.menuManagment.add') }}" class="formSubmit fileUpload"
                            enctype="multipart/form-data" id="UserForm">
                            @csrf
                            <input type="hidden" name="uuid" id="uuid" value="{{ $data->uuid??'' }}">
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="position-relative form-group">
                                        <label for="menu_position" class="">Menu Position</label>
                                        <select name="menu_position" id="menu_position" class="mb-2 form-control">
                                            <option value="">Select menu type -</option>
                                            <option value="header">Header</option>
                                            <option value="footer">Footer</option>
                                        </select>
                                        @if($errors->has('menu_position'))
                                        <div class="error">{{ $errors->first('menu_position') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="position-relative form-group">
                                        <label for="menu_label" class="">Menu Label</label>
                                        <input type="text" class="form-control" name="menu_label"
                                            value="{{ old('menu_label',$data->lable??'') }}" id="menu_label"
                                            placeholder="Page Title">
                                        @if($errors->has('menu_label'))
                                        <div class="error">{{ $errors->first('menu_label') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="position-relative form-group">
                                        <label for="link_type" class="">Link Type</label>
                                        <select name="link_type" id="link_type" class="mb-2 form-control">
                                            <option value="">Select link type-</option>
                                            <option value="internal">Internal</option>
                                            <option value="external">External</option>
                                        </select>
                                        @if($errors->has('link_type'))
                                        <div class="error">{{ $errors->first('link_type') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-6" id="bodyAdd">
                                </div>
                            </div>
                            <button class="mt-2 btn btn-primary">Submit</button>
                            <a href="{{ route('admin.menuManagment.list') }}" class="mt-2 btn btn-secondary">&lt;
                                Back</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
{{-- <script src="https://cdn.ckeditor.com/4.19.0/standard/ckeditor.js"></script> --}}
    <script src="https://cdn.ckeditor.com/4.25.1/standard/ckeditor.js"></script>

<script>
    CKEDITOR.replace('content', {
          filebrowserUploadUrl: "{{route('admin.homePage.uploadFile', ['_token' => csrf_token() ])}}",
          filebrowserUploadMethod: 'form'
      });

      $(document).ready(function() {
        $("#link_type").change(function (e) {
            e.preventDefault();
            if($(this).val() == 'internal') {
            $('#bodyAdd').html(`<div class="position-relative form-group">
                                        <label for="block_list" class="">Block List</label>
                                        <select name="block_list" id="block_list" class="mb-2 form-control">
                                            <option value="">Select user type-</option>
                                            {{ getSiteManag('') }}
                                        </select>
                                        @if($errors->has('block_list'))
                                        <div class="error">{{ $errors->first('block_list') }}</div>
                                        @endif
                                    </div>`);
            }else{
                $('#bodyAdd').html(` <label for="block_list" class="">Url</label><input type="url" class="form-control" name="block_list" id="block_list" placeholder="Enetr Url https://...">`);
            }
        });
      });
</script>
@endpush
