@extends('Admin.layouts.app')
@section('site-page-active','active')
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
{{--
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"> --}}

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
                    <div>Manage Pages Details
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
                        <h5 class="card-title">Add Your Pages Details</h5>
                        <form method="POST" action="{{ route('admin.pageManagment.add') }}"
                            data-url="{{ route('admin.pageManagment.add') }}" class="formSubmit fileUpload"
                            enctype="multipart/form-data" id="UserForm">
                            @csrf
                            <input type="hidden" name="uuid" id="uuid" value="{{ $data->uuid??'' }}">
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="position-relative form-group">
                                        <label for="" class="">Page Name</label>
                                        <input type="text" class="form-control" name="page_name" id="page_name"
                                            class="form-control" value="{{ old('page_name',$data->page_name??'') }}"
                                            @if(!empty($data)) {{
                                            $data->page_name!=['about','product','contact-us']?'readonly':'' }}

                                        @endif
                                        >
                                        @if($errors->has('page_name'))
                                        <div class="error">{{ $errors->first('page_name') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="position-relative form-group">
                                        <label for="page_title" class="">Page Title</label>
                                        <input type="text" class="form-control" name="page_title"
                                            value="{{ old('page_title',$data->page_title??'') }}" id="page_title"
                                            placeholder="Page Title">
                                        @if($errors->has('page_title'))
                                        <div class="error">{{ $errors->first('page_title') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-12">
                                    <div class="position-relative form-group">
                                        <div class="form-group">
                                            <label>Description</label>
                                            <textarea class="form-control" id="page_contented"
                                                value="{{ old('page_contented',$data->page_contented??'') }}"
                                                name="page_contented">{!! $data->page_contented??'' !!}</textarea>
                                            @if($errors->has('page_contented'))
                                            <div class="error">{{ $errors->first('page_contented') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="col-md-6">
                                <div class="position-relative form-group">
                                    <label for="page_banner" class="">Upload Banner Image</label>
                                    <input type="file" class="form-control" name="page_banner"
                                        value="{{ old('page_banner',$data->page_banner??'') }}" id="page_banner"
                                        accept="image/*">
                                    @if($errors->has('page_banner'))
                                    <div class="error">{{ $errors->first('page_banner') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col display_picture">
                                <div class="form-group">
                                    <div class="uploadimage">
                                        <h4>
                                            <i class="fa mr-2">
                                                <img src="{{ asset('page_banner/') }}" alt="" width="75" height="75"
                                                    id="display_picture"></i>Current Image
                                        </h4>
                                    </div>
                                </div>
                            </div> --}}


                            <button class="mt-2 btn btn-primary">Submit</button>
                            <a href="{{ route('admin.pageManagment.list') }}" class="mt-2 btn btn-secondary">&lt;
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
    CKEDITOR.replace('page_contented', {
          filebrowserUploadUrl: "{{route('admin.pageManagment.uploadFile', ['_token' => csrf_token() ])}}",
          filebrowserUploadMethod: 'form'
      });
</script>
@endpush
