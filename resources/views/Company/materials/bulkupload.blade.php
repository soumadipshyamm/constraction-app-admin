@extends('Company.layouts.app')
@section('materials-active', 'active')
@section('title', __('Materials'))
@push('styles')
@endpush
@section('content')
<div class="app-main__outer">
    <div class="app-main__inner card">
        <!-- dashboard body -->

        <div class="dashboard_body">
            <form action="{{ route('company.materials.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="page-title-actions">
                    <a href="{{ route('company.materials.list') }}" class="mt-2 btn btn-secondary">&lt; Back</a>
                </div>
                <div class="tablesec-head blukup_head">
                    <div class="row">
                        <div class="col-md-7">
                            <div class="excel_btnbox">
                                <a href="{{ route('company.materials.export') }}" class="excelbtn"><span><img src="{{ asset('company_assets/images/excel.png') }}" class="img-fluid" alt="excel"></span>Export Materials Data</a>
                            </div>
                            <div class="excel_btnbox">
                                <a href="{{ route('company.materials.demoExport') }}" class="excelbtn"><span><img src="{{ asset('company_assets/images/excel.png') }}" class="img-fluid" alt="excel"></span>Demo Import Materials
                                    Data</a>
                            </div>
                            <div class="excel_btnbox">
                                <a class="excelbtn" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample"><span><img src="{{ asset('company_assets/images/excel.png') }}" class="img-fluid" alt="excel"></span>Import Materials Data</a>
                            </div>
                            <div class="collapse" id="collapseExample">
                                <div class="card card-body">
                                    <input type="file" name="file" class="form-control" required>
                                    <br>
                                    <div>
                                        <button class="btn btn-success">Import Data</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
</script>
@endpush