@extends('Company.layouts.app')
@section('labour-active','active')
@section('title',__('Labour'))
@push('styles')
<style>
    .error {
        color: red;
    }
</style>
@endpush
@section('content')
{{-- <div class="app-main__outer">
    <div class="app-main__inner">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-add-user text-success">
                        </i>
                    </div>
                    <div>Manage Labour Details
                    </div>
                </div>
                <div class="page-title-actions">
                </div>
            </div>
        </div> --}}


<div class="app-main__outer">

    <div class="app-main__inner card">

        <!-- dashboard body -->
        <div class="dashboard_body">
            <!-- company details -->
            <div class="company-details">
                <h5>Add New Labour</h5>
            </div>
            <form method="POST" action="{{ route('company.labour.add') }}" data-url="{{ route('company.labour.add') }}" class="formSubmit fileUpload" enctype="multipart/form-data" id="UserForm">
                @csrf
                <input type="hidden" name="uuid" id="uuid" value="{{ $data->uuid??'' }}">
                <div class="form-row">
                    <div class="col-md-4">
                        <div class="position-relative form-group">
                            <label for="name" class="">Labour Name</label>
                            <input type="text" class="form-control" value="{{ old('name',$data->name??'') }}" name="name" id="name" placeholder=" Enter Your Labour Name">
                            @if($errors->has('name'))
                            <div class="error">{{ $errors->first('name') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="position-relative form-group">
                            <label for="category" class="">Category</label>
                            {{-- <input type="text" class="form-control"
                                        value="{{ old('category',$data->category??'') }}" name="category" id="category"
                            placeholder="Enter Category Name"> --}}
                            <select name="category" id="category" class="form-control">
                                <option value="">---Select Category---</option>
                                <option value="skilled">Skilled</option>
                                <option value="semiskilled">Semi Skilled</option>
                                <option value="unskilled">Unskilled</option>
                            </select>
                            @if($errors->has('category'))
                            <div class="error">{{ $errors->first('category') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="position-relative form-group">
                            <label for="unit_id" class="">Unit Type</label>
                            <select class="form-control" value="{{ old('unit_id') }}" name="unit_id" id="unit_id">
                                <!-- <option value="nos">Nos</option> -->
                                {{ getUnits($data->unit_id??'') }}
                            </select>
                            @if($errors->has('unit_id'))
                            <div class="error">{{ $errors->first('unit_id') }}</div>
                            @endif
                        </div>
                    </div>
                </div>
                <button class="mt-2 btn btn-primary">Submit</button>
                <a href="{{ route('company.labour.list') }}" class="mt-2 btn btn-secondary">&lt; Back</a>
            </form>
        </div>
    </div>
</div>
</div>
{{--
</div>
</div> --}}
@endsection
@push('s
cripts')

@endpush