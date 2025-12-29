@extends('Admin.layouts.app')
@section('home-page-active','active')
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
                        <form method="POST" action="{{ route('admin.homePage.add') }}"
                            data-url="{{ route('admin.homePage.add') }}" class="formSubmit fileUpload"
                            enctype="multipart/form-data" id="UserForm">
                            @csrf
                            <input type="hidden" name="uuid" id="uuid" value="{{ $data->uuid??'' }}">
                            <div class="form-row">
                                @if($data->slug!='banner-section')
                                <div class="col-md-6">
                                    <div class="position-relative form-group">
                                        <label for="block_title" class="">Block Title</label>
                                        <input type="text" class="form-control"
                                            value="{{ old('block_title',$data->block_title??'') }}" name="block_title"
                                            id="block_title" placeholder="page Name">
                                        @if($errors->has('block_title'))
                                        <div class="error">{{ $errors->first('block_title') }}</div>
                                        @endif
                                    </div>
                                </div>
                                @endif
                                <div class="col-md-6">
                                    <div class="position-relative form-group">
                                        <label for="content_title" class="">Contented Title</label>
                                        <input type="text" class="form-control" name="content_title"
                                            value="{{ old('content_title',$data->content_title??'') }}"
                                            id="content_title" placeholder="Page Title">
                                        @if($errors->has('content_title'))
                                        <div class="error">{{ $errors->first('content_title') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-12">
                                    <div class="position-relative form-group">
                                        <div class="form-group">
                                            <label>Description</label>
                                            <textarea class="form-control" id="content" name="content"
                                                value="{{ old('content',$data->content??'') }}">{!! $data->content ??'' !!}</textarea>
                                            @if($errors->has('content'))
                                            <div class="error">{{ $errors->first('content') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="position-relative form-group">
                                    <label for="img" class="">Upload Image</label>
                                    <input type="file" class="form-control" name="img"
                                        value="{{ old('img',$data->img??'') }}" id="img" placeholder="Page Title"
                                        accept="image/*">
                                    @if($errors->has('img'))
                                    <div class="error">{{ $errors->first('img') }}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="col display_picture {{ $data->img?'':'d-none' }}">
                                <div class="form-group">
                                    <div class="uploadimage">
                                        <h4>
                                            <i class="fa mr-2" >
                                                <img src="{{ asset('page_banner/'.$data->img) }}" alt="" width="75" height="75"
                                                    id="display_picture"></i>Current Image
                                        </h4>
                                    </div>
                                </div>
                            </div>
                            <button class="mt-2 btn btn-primary">Submit</button>
                            <a href="{{ route('admin.homePage.list') }}" class="mt-2 btn btn-secondary">&lt;
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
</script>
@endpush
