@extends('Company.layouts.app')
@section('vendor-active', 'active')
@section('title', __('Vendor'))
@push('styles')
    <style>
        .error {
            color: red;
        }

        remove-input-field {
            height: 50px;
            margin-top: 27px;
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
                    <h5 class="card-title">Add Your Vendor Details</h5>
                </div>
                <form method="POST" action="{{ route('company.vendor.add') }}" data-url="{{ route('company.vendor.add') }}"
                    class="formSubmit fileUpload" enctype="multipart/form-data" id="UserForm">
                    @csrf
                    <input type="hidden" name="uuid" id="uuid" value="{{ $data->uuid ?? '' }}">
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="position-relative form-group">
                                <label for="name" class="">Vendor Name</label>
                                <input type="text" class="form-control" value="{{ old('name', $data->name ?? '') }}"
                                    name="name" id="name" placeholder=" Enter Vendor Name">
                                @if ($errors->has('name'))
                                    <div class="error">{{ $errors->first('name') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="position-relative form-group">
                                <label for="type" class="">Type</label>
                                <select class="form-control" name="type" value="{{ old('type', $data->type ?? '') }}"
                                    id="type">
                                    <option value="">----Select Vendor Type----</option>
                                    <option value="supplier"
                                        {{ isset($data) && $data->type == 'supplier' ? 'selected' : '' }}>
                                        Supplier</option>
                                    <option value="contractor"
                                        {{ isset($data) && $data->type == 'contractor' ? 'selected' : '' }}>Contractor
                                    </option>
                                    <option value="both" {{ isset($data) && $data->type == 'both' ? 'selected' : '' }}>
                                        Both
                                    </option>
                                </select>
                                @if ($errors->has('type'))
                                    <div class="error">{{ $errors->first('type') }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="position-relative form-group">
                                <label for="gst_no" class="">GST No(If any)</label>
                                <input type="text" class="form-control" value="{{ old('gst_no', $data->gst_no ?? '') }}"
                                    name="gst_no" id="gst_no" placeholder=" Enter Your GST No. (If Any)">
                                @if ($errors->has('gst_no'))
                                    <div class="error">{{ $errors->first('gst_no') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="position-relative form-group">
                                <label for="address" class="">Address</label>
                                <input type="text" name="address" id="address" class="form-control"
                                    value="{{ old('address', $data->address ?? '') }}" placeholder=" Enter Your Address">
                                @if ($errors->has('address'))
                                    <div class="error">{{ $errors->first('address') }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <hr>
                    <h5 class="card-title">Contact Details</h5>
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="position-relative form-group">
                                <label for="contact_person_name" class="">Contact Person Name</label>
                                <input type="text" class="form-control"
                                    value="{{ old('contact_person_name', $data->contact_person_name ?? '') }}"
                                    name="contact_person_name" id="contact_person_name"
                                    placeholder=" Enter Contact Person Name">
                                @if ($errors->has('contact_person_name'))
                                    <div class="error">{{ $errors->first('contact_person_name') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="position-relative form-group">
                                <label for="phone" class="">Mobile No</label>
                                <input type="text" class="form-control" value="{{ old('phone', $data->phone ?? '') }}"
                                    name="phone" id="phone" placeholder=" Enter Your Mobile No.">
                                @if ($errors->has('phone'))
                                    <div class="error">{{ $errors->first('phone') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="position-relative form-group">
                                <label for="email" class="">Email</label>
                                <input type="email" class="form-control" value="{{ old('email', $data->email ?? '') }}"
                                    name="email" id="email" placeholder=" Enter Your Email Id">
                                @if ($errors->has('email'))
                                    <div class="error">{{ $errors->first('email') }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <strong>Additional Fields</strong>
                    <div class="dynamicAddRemove" id="#dynamicAddRemove">

                        {{-- <input type="hidden" value="{{ isset($data) ? $data->additional_fields : '' }}"
                            id="additional_fields" class="additional_fields"> --}}

                        <input type="hidden" value="{{ isset($data) ? json_encode($data->additional_fields) : '' }}"
                            id="additional_fields" class="additional_fields">
                    </div>
                    <div class="col-md-6">
                        <div class="position-relative form-group">
                            <button type="button" name="add" id="dynamic-ar" class="btn btn-outline-primary">+Add
                                More
                                Fields</button>
                        </div>
                    </div>
                    <button class="mt-2 btn btn-primary">Submit</button>
                    <a href="{{ route('company.vendor.list') }}" class="mt-2 btn btn-secondary">&lt; Back</a>
                </form>
            </div>
        </div>
    </div>
@endsection
{{-- **************************************************************************************************** --}}
@push('scripts')
    <script>
        $(document).ready(function() {
            var i = 1;
            var data = $('.additional_fields').val();
            var $dynamicContainer = $(".dynamicAddRemove");

            function generateFieldHtml(name, value) {
                return `
                <div class="form-row">
                    <div class="col-md-4">
                        <div class="position-relative form-group">
                            <label class="">Field Name</label>
                            <input type="text" class="form-control field-name" value="${name}"
                                name="f[${i}][name]" placeholder=" Enter Field Name">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="position-relative form-group">
                            <label class="">Field Value</label>
                            <input type="text" class="form-control field-value" value="${value}"
                                name="f[${i}][value]" placeholder=" Enter Field Value">
                        </div>
                    </div>
                    <button type="button" class="btn btn-outline-danger remove-input-field">Delete</button>
                </div>`;
            }

            $("#dynamic-ar").on('click', function() {
                $(".dynamicAddRemove").append(generateFieldHtml('', ''));
                i++;
            });

            $(document).on('click', '.remove-input-field', function() {
                $(this).closest('.form-row').remove();
            });

            if (data) {
                var additionalField = JSON.parse(data);
                // alert(additionalField);
                $.each(additionalField, function(index, value) {
                    var name = value.name;
                    var fieldValue = value.value;
                    // alert(name);
                    var html = `
                    <div class="form-row">
                        <div class="col-md-4">
                            <div class="position-relative form-group">
                                <label for="field_name_${i}" class="">Field Name</label>
                                <input type="text" class="form-control" value="${name}" name="f[${i}][name]" id="field_name_${i}" placeholder=" Enter Field Name">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="position-relative form-group">
                                <label for="field_value_${i}" class="">Field Value</label>
                                <input type="text" name="f[${i}][value]" id="field_value_${i}" class="form-control" value="${fieldValue}" placeholder=" Enter Field Value">
                            </div>
                        </div>
                        <button type="button" class="btn btn-outline-danger remove-input-field">Delete</button>
                    </div>`;

                    $dynamicContainer.append(html);
                    i++;
                });

            }

        });
    </script>
@endpush
