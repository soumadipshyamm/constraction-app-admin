@extends('Company.layouts.app')
@section('openingstock-active','active')
@section('title',__('Opening Stock'))
@push('styles')
<style>
.error {
    color: red;
}
</style>
@endpush
@section('content')
<div class="app-main__outer">
    <div class="app-main__inner card">
        <!-- dashboard body -->
        <div class="dashboard_body">
            <!-- company details -->
            <div class="company-details">
                <h5> Asset/Equipments/Machinery Details</h5>
            </div>
            <form method="POST" action="{{ route('company.openingstock.add') }}"
                data-url="{{ route('company.assets.add') }}" class="formSubmit fileUpload" enctype="multipart/form-data"
                id="UserForm">
                @csrf
                <input type="hidden" name="uuid" id="uuid" value="{{ $data->uuid??'' }}">
                <div class="form-row">
                    <div class="col-md-6">
                        <div class="position-relative form-group">
                            <label for="code" class="">Asset Code</label>
                            <input type="text" class="form-control" name="code"
                                value="{{ old('code',$data->code??'') }}" id="code" placeholder="Enter Asset Code">
                            @if($errors->has('code'))
                            <div class="error">{{ $errors->first('code') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="position-relative form-group">
                            <label for="assets" class="">Asset/Equipments/Machinery </label>
                            <input type="text" class="form-control" value="{{ old('assets',$data->assets??'') }}"
                                name="assets" id="assets" placeholder=" Enter Asset/Equipments/Machinery Name">
                            @if($errors->has('assets'))
                            <div class="error">{{ $errors->first('assets') }}</div>
                            @endif
                        </div>
                    </div>

                </div>
                <div class="form-row">
                    <div class="col-md-6">
                        <div class="position-relative form-group">
                            <label for="unit_id" class="">Unit Type</label>
                            <select class="form-control" value="{{ old('unit_id') }}" name="unit_id" id="unit_id">
                                <option value="">----Select Unit----</option>
                                {{ getUnits($data->unit_id??'') }}
                            </select>
                            @if($errors->has('unit_id'))
                            <div class="error">{{ $errors->first('unit_id') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="position-relative form-group">
                            <label for="specification" class="">Asset Specification</label>
                            <textarea name="specification" id="specification" class="form-control" rows="2"
                                value="{{ old('specification') }}"
                                placeholder=" Enter Asset specification">{{!empty($data)?$data->specification:''}}</textarea>
                            @if($errors->has('specification'))
                            <div class="error">{{ $errors->first('specification') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="position-relative form-group">
                            <label for="quantity" class="">Quantity</label>
                            <input type="number" class="form-control" name="quantity"
                                value="{{ old('quantity',$data->site_usage_unit??'') }}" id="quantity"
                                placeholder="Enter Quantity">
                            @if($errors->has('quantity'))
                            <div class="error">{{ $errors->first('quantity') }}</div>
                            @endif
                        </div>
                    </div>
                </div>

                <button class="mt-2 btn btn-primary">Submit</button>
                <a href="{{ route('company.openingstock.list') }}" class="mt-2 btn btn-secondary">&lt;
                    Back</a>
            </form>
        </div>
    </div>
</div>

@endsection
@push('scripts')

@endpush