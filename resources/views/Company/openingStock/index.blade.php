@extends('Company.layouts.app')
@section('openingStock-active', 'active')
@section('title', __('Opening Stock'))
@push('styles')
@endpush

@section('content')
    <div class="app-main__outer">
        <div class="app-main__inner card">
            <!-- dashboard body -->
            <div class="dashboard_body">
                <div class="comp-top">
                    {{-- <!-- <a href="{{ route('company.assets.add') }}" class="ads-btn">
                        <span><i class="fa-solid fa-plus"></i></span>Create new
                    </a> --> --}}
                    <a href="{{ route('company.openingstock.bulkbulkupload') }}" class="btn btn-secondary">
                        <span><i class="fa-solid fa-plus"></i></span>Bulk upload</a>
                </div>
                <div class="comp-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="main-card mb-3 card">
                                <div class="card-body">
                                    <h5 class="card-title">List Labour Details</h5>
                                    <div class="table-responsive">
                                        <table class="mb-0 table dataTable">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Code</th>
                                                    <th>Asset/Equipments/Machinery</th>
                                                    <th>Specification</th>
                                                    <th>Units</th>
                                                    <th>Quantity</th>
                                                    {{-- <!-- <th>Status</th> --> --}}
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
                                                                <p>{{ $data->code }}</p>
                                                            </td>
                                                            <td>
                                                                <p>{{ $data->assets }}</p>
                                                            </td>
                                                            <td>
                                                                <p>{{ $data->specification }}</p>
                                                            </td>
                                                            <td>
                                                                <p>{{ $data->units->unit ?? '' }}</p>
                                                            </td>
                                                            <td>
                                                                <p>{{ $data->site_usage_unit }}</p>
                                                            </td>

                                                             {{-- <td>
                                                        <div class="custom-control custom-switch">
                                                            <input type="checkbox" class="custom-control-input statusChange" id="switch{{ $data->uuid }}" data-uuid="{{ $data->uuid }}" data-message="{{ $data->is_active ? 'deactive' : 'active' }}" data-table="assets" data-model="company" name="example" {{ $data->is_active == 1 ? 'checked' : '' }}>
                                                            <label class="custom-control-label" for="switch{{ $data->uuid }}"></label>
                                                        </div>
                                                    </td>  --}}
                                                            <td>
                                                                <a
                                                                    href="{{ route('company.openingstock.edit', $data->uuid) }}"><i
                                                                        class="fa fa-edit" style="cursor: pointer;"
                                                                        title="Edit"></i></a>

                                                                <a class="deleteData text-danger"
                                                                    data-uuid="{{ $data->uuid }}"
                                                                    data-table="opening_stocks" data-model="company"
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
@endpush
