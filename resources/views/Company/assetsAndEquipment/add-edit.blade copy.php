@extends('Company.layouts.app')
@section('assets-active','active')
@section('title',__('Assets'))
@push('styles')
<style>
    .error {
        color: red;
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
                    <div>Manage Asset/Equipments/Machinery Details
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
                        <h5 class="card-title">Add Your Asset/Equipments/Machinery Details</h5>
                        <form method="POST" action="{{ route('admin.assets.add') }}"
                            data-url="{{ route('admin.assets.add') }}" class="formSubmit fileUpload"
                            enctype="multipart/form-data" id="UserForm">
                            @csrf
                            <input type="hidden" name="uuid" id="uuid" value="{{ $data->uuid??'' }}">
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="position-relative form-group">
                                        <label for="name" class="">Asset/Equipments/Machinery </label>
                                        <input type="text" class="form-control"
                                            value="{{ old('name',$data->name??'') }}" name="name" id="name"
                                            placeholder=" Enter Your Asset/Equipments/Machinery Name">
                                        @if($errors->has('name'))
                                        <div class="error">{{ $errors->first('name') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="position-relative form-group">
                                        <label for="code" class="">Asset Code</label>
                                        <input type="text" class="form-control" name="code"
                                            value="{{ old('code',$data->code??'') }}" id="code"
                                            placeholder="Enter Planned Start Date">
                                        @if($errors->has('code'))
                                        <div class="error">{{ $errors->first('code') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="position-relative form-group">
                                        <label for="unit_id" class="">Unit Type</label>
                                        <select class="form-control" value="{{ old('unit_id',$data->unit_id??'') }}"
                                            name="unit_id" id="unit_id">
                                            <option value="">----Select Unit----</option>
                                            {{ getUnits('') }}
                                        </select>
                                        @if($errors->has('unit_id'))
                                        <div class="error">{{ $errors->first('unit_id') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="position-relative form-group">
                                        <label for="quantity" class="">Quantity</label>
                                        <input type="number" class="form-control" name="quantity"
                                            value="{{ old('quantity',$data->quantity??'') }}" id="quantity"
                                            placeholder="Enter Planned Start Date">
                                        @if($errors->has('quantity'))
                                        <div class="error">{{ $errors->first('quantity') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="position-relative form-group">
                                        <label for="specification" class="">Asset Specification</label>
                                        <textarea name="specification" id="specification" class="form-control"
                                            value="{{ old('specification',$data?->client?->specification??'') }}"
                                            placeholder=" Enter Asset specification">{{ old('specification',$data?->specification??'') }}</textarea>
                                        @if($errors->has('specification'))
                                        <div class="error">{{ $errors->first('specification') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <button class="mt-2 btn btn-primary">Submit</button>
                            <a href="{{ route('admin.teams.list') }}" class="mt-2 btn btn-secondary">&lt; Back</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')

@endpush
{{-- name
code
specification
unit_id
quantity --}}
