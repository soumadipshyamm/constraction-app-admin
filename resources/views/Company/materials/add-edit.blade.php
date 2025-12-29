@extends('Company.layouts.app')
@section('materials-active', 'active')
@section('title', __('Materials'))
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
                    <h5>Add Materials Details</h5>
                </div>
                <form method="POST" action="{{ route('company.materials.add') }}"
                    data-url="{{ route('company.materials.add') }}" class="formSubmit fileUpload" enctype="multipart/form-data"
                    id="UserForm">
                    @csrf
                    <input type="hidden" name="uuid" id="uuid" value="{{ $data->uuid ?? '' }}">

                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="position-relative form-group">
                                <label for="class" class="">Materials Class </label>
                                <select class="form-control" value="{{ $data->class ?? '' }}" name="class" id="class">
                                    <option value="">----Select Materials Class----</option>
                                    <option value="A" {{ isset($data->class) && $data->class == 'A' ? 'selected' : '' }}>Class A </option>
                                    <option value="B" {{ isset($data->class) && $data->class == 'B' ? 'selected' : '' }}>Class B </option>
                                    <option value="C" {{ isset($data->class) && $data->class == 'C' ? 'selected' : '' }}>Class C </option>
                                </select>
                                @if ($errors->has('class'))
                                    <div class="error">{{ $errors->first('class') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="position-relative form-group">
                                <label for="name" class="">Materials Name</label>
                                <input name="name" id="name" class="form-control"
                                    value="{{ old('name', !empty($data) ? $data->name : '') }}"
                                    placeholder=" Enter Materials Name">
                                @if ($errors->has('name'))
                                    <div class="error">{{ $errors->first('name') }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-row">

                        <div class="col-md-6">
                            <div class="position-relative form-group">
                                <label for="specification" class="">Specification</label>
                                <input name="specification" id="specification" class="form-control"
                                    value="{{ old('specification', !empty($data) ? $data->Specification : '') }}"
                                    placeholder=" Enter specification">
                                @if ($errors->has('specification'))
                                    <div class="error">{{ $errors->first('specification') }}</div>
                                @endif
                            </div>
                        </div>
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
                    </div>
                    <button class="mt-2 btn btn-primary">Submit</button>
                    <a href="{{ route('company.materials.list') }}" class="mt-2 btn btn-secondary">&lt;
                        Back</a>
                </form>
            </div>

        </div>
    </div>

@endsection
@push('scripts')
@endpush
