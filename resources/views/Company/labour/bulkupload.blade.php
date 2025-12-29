@extends('Company.layouts.app')
@section('labour-active', 'active')
@section('title', __('Labour'))
@push('styles')
@endpush
@section('content')
<div class="app-main__outer">
    <div class="app-main__inner card">
        <!-- dashboard body -->

        <div class="dashboard_body">
            <form action="{{ route('company.labour.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="page-title-actions">
                    <a href="{{ route('company.labour.list') }}" class="mt-2 btn btn-secondary">&lt; Back</a>
                </div>

                <div class="tablesec-head blukup_head">
                    <div class="row">
                        <div class="col-md-7">
                            <div class="excel_btnbox">
                                <a href="{{ route('company.labour.export') }}" class="excelbtn"><span><img
                                            src="{{ asset('company_assets/images/excel.png') }}" class="img-fluid"
                                            alt="excel"></span>Export Labours Data</a>
                            </div>
                            <div class="excel_btnbox">
                                <a href="{{ route('company.labour.demoExport') }}" class="excelbtn"><span><img
                                            src="{{ asset('company_assets/images/excel.png') }}" class="img-fluid"
                                            alt="excel"></span>Demo Import Labours
                                    Data</a>
                            </div>
                            <div class="excel_btnbox">
                                <a class="excelbtn" data-bs-toggle="collapse" href="#collapseExample" role="button"
                                    aria-expanded="false" aria-controls="collapseExample"><span><img
                                            src="{{ asset('company_assets/images/excel.png') }}" class="img-fluid"
                                            alt="excel"></span>Import Labours
                                    Data</a>
                            </div>
                            <div class="collapse" id="collapseExample">
                                <div class="card card-body">
                                    {{-- <div class="file-upload-cutom-box"> --}}
                                    {{-- <input id="uploadFile" class="f-input" placeholder="Upload Bulk Data">
                                            <div class="fileUpload btn btn--browse">
                                                <span>Browse</span> --}}
                                    {{-- <input id="uploadBtn" type="file" name="file" class="upload" required> --}}
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js">
</script>
@endpush
