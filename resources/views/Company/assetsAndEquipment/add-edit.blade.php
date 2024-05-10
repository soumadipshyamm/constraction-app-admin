@extends('Company.layouts.app')
@section('assets-active', 'active')
@section('title', __('Assets'))
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
                    <h5>Add Asset/Equipments/Machinery Details</h5>
                </div>
                <form method="POST" action="{{ route('company.assets.add') }}" data-url="{{ route('company.assets.add') }}"
                    class="formSubmit fileUpload" enctype="multipart/form-data" id="UserForm">
                    @csrf
                    <input type="hidden" name="uuid" id="uuid" value="{{ $data->uuid ?? '' }}">
                    {{-- <div class="form-row">
                    <div class="col-md-6">
                        <div class="position-relative form-group">
                            <label for="name" class="">Project</label>
                            <select class="form-control" value="{{ old('project') }}" name="project" id="project">
                                <option value="">----Select Project----</option>
                                {{ getProject($data->project_id??'') }}
                            </select>
                            @if ($errors->has('project'))
                            <div class="error">{{ $errors->first('project') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="position-relative form-group">
                            <label for="ware_house" class="">Store/Ware House</label>
                            <select class="form-control" value="{{ old('ware_house') }}" name="ware_house"
                                id="ware_house">
                                <option value="">----Select Store/Ware House----</option>
                                {{ getStoreWarehouses($data->store_warehouses_id??'') }}
                            </select>
                            @if ($errors->has('ware_house'))
                            <div class="error">{{ $errors->first('ware_house') }}</div>
                            @endif
                        </div>
                    </div>
                </div> --}}
                    {{-- <hr> --}}
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="position-relative form-group">
                                <label for="name" class="">Asset/Equipments/Machinery </label>
                                <input type="text" class="form-control" value="{{ old('name', $data->name ?? '') }}"
                                    name="name" id="name" placeholder=" Enter Your Asset/Equipments/Machinery Name">
                                @if ($errors->has('name'))
                                    <div class="error">{{ $errors->first('name') }}</div>
                                @endif
                            </div>
                        </div>
                        <!-- <div class="col-md-6">
                                        <div class="position-relative form-group">
                                            <label for="code" class="">Asset Code</label>
                                            <input type="text" class="form-control" name="code" value="{{ old('code', $data->code ?? '') }}" id="code" placeholder="Enter Planned Start Date">
                                            @if ($errors->has('code'))
    <div class="error">{{ $errors->first('code') }}</div>
    @endif
                                        </div>
                                    </div> -->
                        <!-- </div>
                                <div class="form-row"> -->
                        <div class="col-md-6">
                            <div class="position-relative form-group">
                                <label for="unit_id" class="">Unit Type</label>
                                <select class="form-control" value="{{ old('unit_id') }}" name="unit_id" id="unit_id">
                                    <option value="">----Select Unit----</option>
                                    {{ getUnits($data->unit_id ?? '') }}
                                </select>
                                @if ($errors->has('unit_id'))
                                    <div class="error">{{ $errors->first('unit_id') }}</div>
                                @endif
                            </div>
                        </div>
                        <!-- <div class="col-md-6">
                                        <div class="position-relative form-group">
                                            <label for="quantity" class="">Quantity</label>
                                            <input type="number" class="form-control" name="quantity"
                                                value="{{ old('quantity', $data->quantity ?? '') }}" id="quantity"
                                                placeholder="Enter Quantity">
                                            @if ($errors->has('quantity'))
    <div class="error">{{ $errors->first('quantity') }}</div>
    @endif
                                        </div>
                                    </div> -->
                        <div class="col-md-6">
                            <div class="position-relative form-group">
                                <label for="specification" class="">Asset Specification</label>
                                <textarea name="specification" id="specification" class="form-control" value="{{ old('specification') }}"
                                    placeholder=" Enter Asset specification">{{ !empty($data) ? $data->specification : '' }}</textarea>
                                @if ($errors->has('specification'))
                                    <div class="error">{{ $errors->first('specification') }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <button class="mt-2 btn btn-primary">Submit</button>
                    <a href="{{ route('company.assets.list') }}" class="mt-2 btn btn-secondary">&lt;

                        Back</a>
                </form>
            </div>
        </div>
    </div>

@endsection
@push('scripts')
@endpush
