@extends('Company.layouts.app')
@section('vendor-active', 'active')
@section('title', __('Vendor'))
@push('styles')
    <style>
        .dt-buttons-container {
            text-align: right;
            /* Add your custom styling here */
            /* For example: */
            margin-bottom: 10px;
        }
    </style>
@endpush

@section('content')
    <div class="app-main__outer">
        <div class="app-main__inner card">
            <!-- dashboard body -->
            <div class="dashboard_body">
                <div class="comp-top">
                    <a href="{{ route('company.vendor.add') }}" class="ads-btn">
                        <span><i class="fa-solid fa-plus"></i></span>Create new
                    </a>
                    <a href="{{ route('company.vendor.bulkbulkupload') }}" class="btn btn-secondary">
                        <span><i class="fa-solid fa-plus"></i></span>Bulk Upload
                    </a>
                    <a href="{{ route('company.vendor.export') }}" class="ads-btn">
                        <span> <i class="fa fa-download" aria-hidden="true"
                                title="Download Project Data in Excel"></i></span>
                    </a>
                </div>
                <div class="comp-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="main-card mb-3 card">
                                <div class="card-body">
                                    <h5 class="card-title">List Vendor Details</h5>
                                    <div class="table-responsive">
                                        <table class="mb-0 table" id="dataTable">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Name</th>
                                                    <th>Gst No</th>
                                                    <th>Address</th>
                                                    <th>Type</th>
                                                    <th>Contact Person Name</th>
                                                    <th>Phone</th>
                                                    <th>Email</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if ($datas)
                                                    @forelse($datas as $key => $data)
                                                        {{-- @dd($data->additional_fields); --}}
                                                        <tr>
                                                            <td>
                                                                <p>#{{ $key + 1 }}</p>
                                                            </td>
                                                            <td>
                                                                <p>{{ $data->name }}</p>
                                                            </td>
                                                            <td>
                                                                <p>{{ $data->gst_no }}</p>
                                                            </td>
                                                            <td class="word_break">
                                                                <p>{{ $data->address }}</p>
                                                            </td>
                                                            <td>
                                                                <p>{{ $data->type }}</p>
                                                            </td>
                                                            <td>
                                                                <p>{{ $data->contact_person_name }}</p>
                                                            </td>
                                                            <td>
                                                                <p>{{ $data->phone }}</p>
                                                            </td>
                                                            <td>
                                                                <p>{{ $data->email }}</p>
                                                            </td>
                                                            {{-- <td>
                                            @foreach ($data->additional_fields as $key => $value)
                                                <td>{{ $value['name'] }}</td>
                                                <td>{{ $value['value'] }}</td>
                                                @endforeach
                                                </td> --}}
                                                            <td>
                                                                <div class="custom-control custom-switch">
                                                                    <input type="checkbox"
                                                                        class="custom-control-input statusChange"
                                                                        id="switch{{ $data->uuid }}"
                                                                        data-uuid="{{ $data->uuid }}"
                                                                        data-message="{{ $data->is_active ? 'deactive' : 'active' }}"
                                                                        data-table="vendors" data-model="company"
                                                                        name="example"
                                                                        {{ $data->is_active == 1 ? 'checked' : '' }}>
                                                                    <label class="custom-control-label"
                                                                        for="switch{{ $data->uuid }}"></label>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <a href="{{ route('company.vendor.edit', $data->uuid) }}"><i
                                                                        class="fa fa-edit" style="cursor: pointer;"
                                                                        title="Edit"></i></a>

                                                                <a
                                                                    href="{{ route('company.vendor.preview', $data->uuid) }}"><i
                                                                        class="fa fa-eye" style="cursor: pointer;"
                                                                        title="Edit"></i></a>

                                                                <a class="deleteData text-danger"
                                                                    data-uuid="{{ $data->uuid }}" data-table="vendors"
                                                                    data-model="company" href="javascript:void(0)"><i
                                                                        class="fa fa-trash-alt" style="cursor: pointer;"
                                                                        title="Remove">
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
@endpush
