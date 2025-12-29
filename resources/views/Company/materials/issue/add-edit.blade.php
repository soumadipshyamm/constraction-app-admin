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
            <form method="POST" action="{{ route('company.materials.addOpeningStock') }}"
                data-url="{{ route('company.materials.addOpeningStock') }}" class="formSubmit fileUpload"
                enctype="multipart/form-data" id="UserForm">
                @csrf
                <input type="hidden" name="uuid" id="uuid" value="{{ $data->uuid??'' }}">
                <div class="form-row">
                    <div class="col-md-3">
                        <div class="position-relative form-group">
                            <label for="class" class="">Project</label>
                            <input class="form-control" value="{{$data->projects->project_name??'' }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="position-relative form-group">
                            <label for="warehouses" class="">Store/Warehouses</label>
                            <input class="form-control" value="{{ $data->stores->name??'' }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="position-relative form-group">
                            <label for="opeing_stock_date" class="">Opening Stock Date</label>
                            <input class="form-control"
                                value="{{ old('opeing_stock_date',$data->opeing_stock_date??'') }}" readonly>

                        </div>
                    </div>

                </div>
                <hr>
                <div class="form-row">
                    <div class="col-md-6">
                        <div class="position-relative form-group">
                            <label for="class" class="">Materials Class </label>
                            <input class="form-control" value="{{ old('class',$data->materials->class??'') }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="position-relative form-group">
                            <label for="code" class="">Materials Code</label>
                            <input class="form-control" value="{{ old('code',$data->materials->code??'') }}"
                                {{!empty($data->code)?'readonly':''}} ) readonly>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-6">
                        <div class="position-relative form-group">
                            <label for="name" class="">Materials Name</label>
                            <input class="form-control"
                                value="{{ old('name',(!empty($data)?$data->materials->name:'')) }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="position-relative form-group">
                            <label for="" class="">Specification</label>
                            <input class="form-control"
                                value="{{ old('specification',(!empty($data)?$data->materials->specification:'')) }}"
                                readonly>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-6">
                        <div class="position-relative form-group">
                            <label for="" class="">Unit Type</label>
                            <input class="form-control" value="{{ (!empty($data)?$data->materials->units->unit:'') }}"
                                readonly>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="form-row">
                    <div class="col-md-6">
                        <div class="position-relative form-group">
                            <label for="quantity" class="">Quantity</label>
                            <input type="number" class="form-control" name="quantity"
                                value="{{ old('quantity',$data->qty??'') }}" id="quantity" placeholder="Enter Quantity">
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

@endpush