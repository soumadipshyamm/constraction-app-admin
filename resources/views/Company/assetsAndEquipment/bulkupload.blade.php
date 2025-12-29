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
                <form action="{{ route('company.assets.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="page-title-actions">
                        <a href="{{ route('company.assets.list') }}" class="mt-2 btn btn-secondary">&lt; Back</a>

                    </div>
                    <div class="tablesec-head blukup_head">
                        <div class="row">
                            <div class="col-md-7">
                                <div class="excel_btnbox">
                                    <a href="{{ route('company.assets.export') }}" class="excelbtn"><span><img
                                                src="{{ asset('company_assets/images/excel.png') }}" class="img-fluid"
                                                alt="excel"></span>Export Opening stock Data</a>
                                </div>
                                <div class="excel_btnbox">
                                    <a href="{{ route('company.assets.demoExport') }}" class="excelbtn"><span><img
                                                src="{{ asset('company_assets/images/excel.png') }}" class="img-fluid"
                                                alt="excel"></span>Demo Import Opening stock
                                        Data</a>
                                </div>
                                <div class="excel_btnbox">
                                    <a class="excelbtn" data-bs-toggle="collapse" href="#collapseExample" role="button"
                                        aria-expanded="false" aria-controls="collapseExample"><span><img
                                                src="{{ asset('company_assets/images/excel.png') }}" class="img-fluid"
                                                alt="excel"></span>Import Opening stock
                                        Data</a>
                                </div>
                                <!-- ******************************************************************************************************** -->
                                <div class="collapse" id="collapseExample">
                                    <div class="form-row">
                                        <div class="col-md-4">
                                            <div class="position-relative form-group">
                                                <label for="class" class="">Project</label>
                                                <select class="form-control" value="{{ old('project') }}" name="project"
                                                    id="project">
                                                    <option value="">----Select Project----</option>
                                                    {{ getProject('') }}
                                                </select>
                                                @if ($errors->has('project'))
                                                    <div class="error">{{ $errors->first('project') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="position-relative form-group">
                                                <label for="warehouses" class="">Store/Warehouses</label>
                                                <select class="form-control" value="{{ old('warehouses') }}"
                                                    name="warehouses" id="warehouses">
                                                    <option value="">----Select Store/Warehouses----
                                                    </option>
                                                </select>
                                                @if ($errors->has('warehouses'))
                                                    <div class="error">{{ $errors->first('warehouses') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
@endpush
