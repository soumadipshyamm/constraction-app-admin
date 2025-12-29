@extends('Company.layouts.app')
@section('units-active', 'active')
@section('title', __('Units'))
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
                    <div>Manage Units Details
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
                        <h5 class="card-title">Add Your Unit</h5>

                        <form method="POST" action="{{ route('company.units.add') }}" data-url="{{ route('company.units.add') }}" class="formSubmit fileUpload" enctype="multipart/form-data" id="UserForm">
                            @csrf
                            <input type="hidden" name="uuid" id="uuid" value="{{ $data->uuid ?? '' }}">
                            <div class="form-row">
                                <div class="col-md-3">
                                    <div class="position-relative form-group">
                                        <label for="unit" class="">Unit Name</label>
                                        <input type="text" class="form-control" value="{{ old('unit', $data->unit ?? '') }}" name="f[0][unit]" id="unit" placeholder=" Enter unit name">
                                        @if ($errors->has('unit'))
                                        <div class="error">{{ $errors->first('unit') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="position-relative form-group">
                                        <label for="unit" class="">Unit Name</label>
                                        <select class="form-control" value="{{ old('unit_coversion') }}" name="f[0][unit_coversion]" id="unit_coversion">
                                            <option value="">----Selecte Unit----</option>
                                            {{ getUnits($data->unit_coversion ?? '') }}
                                        </select>
                                        @if ($errors->has('unit_coversion '))
                                        <div class="error">{{ $errors->first('unit_coversion ') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="position-relative form-group">
                                        <label for="unit_coversion_factor" class="">Unit Conversion Factor</label>
                                        <input type="text" class="form-control" name="f[0][unit_coversion_factor]" value="{{ old('unit_coversion_factor', $data->unit_coversion_factor ?? '') }}" id="unit_coversion_factor" placeholder="Enter Unit Coversion factor">
                                        @if ($errors->has('unit_coversion_factor '))
                                        <div class="error">{{ $errors->first('unit_coversion_factor ') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="position-relative form-group">
                                        <button type="button" name="add" id="dynamic-ar" class="btn btn-outline-primary">+Add</button>
                                    </div>
                                </div>
                            </div>
                            <!-- <strong>Additional Fields</strong> -->
                            <div class="dynamicAddRemove" id="#dynamicAddRemove">

                                <input type="hidden" value="{{ isset($data) ? $data->additional_fields : '' }}" id="additional_fields" class="additional_fields">

                            </div>
                            <button class="mt-2 btn btn-primary">Submit</button>
                            <a href="{{ route('company.units.list') }}" class="mt-2 btn btn-secondary">&lt; Back</a>
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
        var i = 1;
        var data = $('.additional_fields').val();
        var $dynamicContainer = $(".dynamicAddRemove");

        function generateFieldHtml(name, value) {
            return `
                            <div class="form-row">
                                <div class="col-md-3">
                                    <div class="position-relative form-group">
                                        <label for="unit" class="">Unit Name</label>
                                        <input type="text" class="form-control"
                                        value="{{ old('f.${i}.unit', $data->unit ?? '') }}" name="f[${i}][unit]" id="unit"
                                            placeholder=" Enter unit name" >
                                        @if ($errors->has('f.${i}.unit'))
                                        <div class="error">{{ $errors->first('f.${i}.unit') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="position-relative form-group">
                                        <label for="unit_coversion" class="">Unit Coversion</label>                                      
                                        <select class="form-control" name="f[${i}][unit_coversion]" id="unit_coversion" value="{{ old('f[${i}][unit_coversion]') }}" >
                                            <option value="">----Selecte Unit----</option>
                                            {{ getUnits($data->unit_coversion ?? '') }}
                                        </select>
                                        @if ($errors->has('unit_coversion'))
                                        <div class="error">{{ $errors->first('unit_coversion') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="position-relative form-group">
                                        <label for="unit_coversion_factor" class="">Unit Conversion Factor</label>
                                        <input type="text" class="form-control" name="f[${i}][unit_coversion_factor]"
                                            value="{{ old('f[${i}][unit_coversion_factor]', $data->unit_coversion_factor ?? '') }}"
                                            id="unit_coversion_factor" placeholder="Enter Unit Coversion factor">
                                        @if ($errors->has('unit_coversion_factor'))
                                        <div class="error">{{ $errors->first('unit_coversion_factor') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <button type="button" class="btn btn-outline-danger remove-input-field">Delete</button>
                            </div> `;
        }

        $("#dynamic-ar").on('click', function() {
            $(".dynamicAddRemove").append(generateFieldHtml('', ''));
            i++;
        });

        $(document).on('click', '.remove-input-field', function() {
            $(this).closest('.form-row').remove();
        });
    });
</script>
@endpush