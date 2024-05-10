@extends('Company.layouts.app')
@section('materials-active','active')
@section('title',__('Materials'))
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
            <!-- <div class="comp-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="main-card mb-3 card">
                            <div class="card-body">
                                <h5 class="card-title">List Materials Details</h5>
                                <div class="table-responsive">
                                    <table class="mb-0 table ">
                                        <thead>
                                            <tr>
                                                <th>Project Name</th>
                                                <th>Store/ Warehouse</th>
                                                <th>Class of Materials</th>
                                                <th>Materials Code</th>
                                                <th>Materials Name</th>
                                                <th>Specification</th>
                                                <th>Unit</th>
                                                <th>Opening QTY</th>
                                            </tr>
                                        </thead>
                                        <tbody class="datatable_body">
                                            @if($data)

                                            <tr>
                                                <td>
                                                    <p>{{ $data->projects->project_name??'' }}
                                                    </p>
                                                </td>
                                                <td>
                                                    <p>{{ $data->stores->name??'' }}</p>
                                                </td>
                                                <td>
                                                    <p>{{ $data->materials->class??'' }}
                                                    </p>
                                                </td>
                                                <td>
                                                    <p>{{ $data->materials->code??'' }}
                                                    </p>
                                                </td>
                                                <td>
                                                    <p>{{ $data->materials->name??'' }}
                                                    </p>
                                                </td>
                                                <td>
                                                    <p>{{ $data->materials->specification??'' }}
                                                    </p>
                                                </td>
                                                <td>
                                                    <p>{{ $data->materials->units->unit??'' }}
                                                    </p>
                                                </td>
                                                <td>
                                                    <p>{{ $data->qty??'' }}
                                                    </p>
                                                </td>

                                            </tr>

                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
            <form method="POST" action="{{ route('company.materials.addOpeningStock') }}" data-url="{{ route('company.materials.addOpeningStock') }}" class="formSubmit fileUpload" enctype="multipart/form-data" id="UserForm">
                @csrf
                <input type="hidden" name="uuid" id="uuid" value="{{ $data->uuid??'' }}">
                <div class="form-row">
                    <div class="col-md-3">
                        <div class="position-relative form-group">
                            <label for="class" class="">Project</label>
                            <select class="form-control" value="{{ old('project') }}" name="project" id="project">
                                <option value="">----Select Project----</option>
                                {{ getProject($data->project_id ??'') }}
                            </select>
                            @if($errors->has('project'))
                            <div class="error">{{ $errors->first('project') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="position-relative form-group">
                            <label for="warehouses" class="">Store/Warehouses</label>
                            <select class="form-control" value="{{ old('warehouses') }}" name="warehouses" id="warehouses">
                                <option value="">----Select Store/Warehouses----</option>
                                {{getStoreWarehouses($data->store_id ??'')}}
                            </select>
                            @if($errors->has('warehouses'))
                            <div class="error">{{ $errors->first('warehouses') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="position-relative form-group">
                            <label for="opeing_stock_date" class="">Opening Stock Date</label>
                            <input type="date" class="form-control" name="opeing_stock_date" value="{{ old('opeing_stock_date',$data->opeing_stock_date??'') }}" id="opeing_stock_date" placeholder="">
                            @if($errors->has('opeing_stock_date'))
                            <div class="error">{{ $errors->first('opeing_stock_date') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="position-relative form-group">
                            <label for="material_id" class="">Materials</label>
                            <select class="form-control" value="{{ old('material_id') }}" name="material_id" id="material_id">
                                <option value="">----Select Material----</option>
                                {{getMaterials($data->material_id ??'')}}
                            </select>
                            @if($errors->has('material_id'))
                            <div class="error">{{ $errors->first('material_id') }}</div>
                            @endif
                        </div>
                    </div>
                </div>
                <hr>
                <div class="bodyAdd"></div>
                <hr>
                <div class="form-row">
                    <div class="col-md-6">
                        <div class="position-relative form-group">
                            <label for="quantity" class="">Quantity</label>
                            <input type="number" class="form-control" name="quantity" value="{{ old('quantity',$data->qty??'') }}" id="quantity" placeholder="Enter Quantity">
                            @if($errors->has('quantity'))
                            <div class="error">{{ $errors->first('quantity') }}</div>
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
<script>
    $(document).ready(function() {
        $('#material_id').on('load', function() {
            let materialId = $(this).val();
            $.ajax({
                type: "GET",
                url: baseUrl + "ajax/getMaterials/" + materialId,
                datatype: "json",
                success: function(response) {
                    // alert('response');
                    // console.log(response);
                    if (response) {
                        $('.bodyAdd').html(`  <div class="form-row">
                    <div class="col-md-6">
                        <div class="position-relative form-group">
                            <label for="class" class="">Materials Class </label>
                            <input class="form-control" value="${response.class}" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="position-relative form-group">
                            <label for="code" class="">Materials Code</label>
                            <input class="form-control" value="${response.code}" readonly>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-6">
                        <div class="position-relative form-group">
                            <label for="name" class="">Materials Name</label>
                            <input class="form-control" value="${response.name}" readonly>

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="position-relative form-group">
                            <label for="" class="">Specification</label>
                            <input class="form-control"
                                value="${response.specification}"
                                readonly>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-6">
                        <div class="position-relative form-group">
                            <label for="" class="">Unit Type</label>
                            <input class="form-control" value="${response.units.unit}" readonly>

                        </div>
                    </div>
                </div>`);
                    } else {
                        $('.bodyAdd').html(` `);
                    }

                    $(document).trigger('bodyAdd');
                },
            });
        });
    });
</script>
@endpush

<!-- 

class
: 
"asdfghjk"
code
: 
"6504099a70f2f"
company_id
: 
2
created_at
: 
"2023-09-15T07:36:58.000000Z"
deleted_at
: 
null
id
: 
2
is_active
: 
1
name
: 
"labour"
projects
: 
null
specification
: 
"dfghjmk,l.,kjh cvbnm,.,mjnhg dfghujyhgfdc vbnm, fgbn"
stores
: 
null
unit_id
: 
17
units
: 
company_id
: 
2
created_at
: 
"2023-09-11T20:44:19.000000Z"
deleted_at
: 
null
id
: 
17
is_active
: 
1
unit
: 
"kd"
unit_coversion
: 
null
unit_coversion_factor
: 
null
updated_at
: 
"2023-09-11T20:44:19.000000Z"
uuid
: 
"bdf0c081-5672-4189-a81a-3cfe5a36da16" -->