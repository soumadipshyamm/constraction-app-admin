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
                <div class="comp-top">
                    <a href="{{ route('company.labour.add') }}" class="ads-btn">
                        <span><i class="fa-solid fa-plus"></i></span>Create new
                    </a>
                    <a href="{{ route('company.labour.bulkbulkupload') }}" class="btn btn-secondary">
                        <span><i class="fa-solid fa-plus"></i></span>Bulk Upload
                    </a>
                    <a href="{{ route('company.labour.export') }}" class="ads-btn">
                        <i class="fa fa-download" aria-hidden="true" title="Download Labour Data in Excel"></i></span></a>
                </div>
                <div class="comp-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="main-card mb-3 card">
                                <div class="card-body">
                                    <h5 class="card-title">List Labour Details</h5>
                                    <div class="table-responsive">
                                        <table class="mb-0 table" id="dataTable">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Name</th>
                                                    <th>Code</th>
                                                    <th>Category</th>
                                                    <th>Units</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if ($datas)
                                                    @forelse($datas as $key => $data)
                                                        <tr>
                                                            <td>
                                                                <p>#{{ $key + 1 }}</p>
                                                            </td>
                                                            <td>
                                                                <p>{{ $data->name }}</p>
                                                            </td>
                                                            <td>
                                                                <p>{{ $data->code??'---' }}</p>
                                                            </td>
                                                            <td>
                                                                <p>{{ $data->category }}</p>
                                                            </td>
                                                            <td>
                                                                <p>{{ $data->units->unit ?? '' }}</p>
                                                            </td>
                                                            <td>
                                                                <div class="custom-control custom-switch">
                                                                    <input type="checkbox"
                                                                        class="custom-control-input statusChange"
                                                                        id="switch{{ $data->uuid }}"
                                                                        data-uuid="{{ $data->uuid }}"
                                                                        data-message="{{ $data->is_active ? 'deactive' : 'active' }}"
                                                                        data-table="labours" data-model="company"
                                                                        name="example"
                                                                        {{ $data->is_active == 1 ? 'checked' : '' }}>
                                                                    <label class="custom-control-label"
                                                                        for="switch{{ $data->uuid }}"></label>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <a href="{{ route('company.labour.edit', $data->uuid) }}"><i
                                                                        class="fa fa-edit" style="cursor: pointer;"
                                                                        title="Edit"></i></a>
                                                                <a class="deleteData text-danger" data-model="company"
                                                                    data-uuid="{{ $data->uuid }}" data-table="labours"
                                                                    href="javascript:void(0)"><i class="fa fa-trash-alt"
                                                                        style="cursor: pointer;" title="Remove">
                                                                    </i></a>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <p>!No Data Found</p>
                                                    @endforelse
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
@endpush
