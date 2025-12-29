@extends('Company.layouts.app')
@section('units-active', 'active')
@section('title', __('Units'))
@push('styles')
@endpush

@section('content')
    <div class="app-main__outer">
        <div class="app-main__inner card">
            <!-- dashboard body -->
            <div class="dashboard_body">
                <div class="comp-top">
                    <a href="{{ route('company.units.add') }}" class="ads-btn">
                        <span><i class="fa-solid fa-plus"></i></span>Create new
                    </a>
                </div>
                <div class="comp-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="main-card mb-3 card">
                                <div class="card-body">
                                    <h5 class="card-title">List Units Details</h5>
                                    <div class="table-responsive">
                                        <table class="mb-0 table" id="dataTable">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <!-- <th>#</th> -->
                                                    <th>Unit</th>
                                                    <th>Unit Coversion</th>
                                                    <th>Unit Coversion Factor</th>
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
                                                            <!-- <td> -->
                                                            <!-- <img src="file:///C:/xampp/htdocs/php82/Konsite/koncite-html/assets/images/about-banner.png" alt="asdfe" srcset="">     -->
                                                            <!-- <img src="http://localhost/php82/Konsite/koncite-html/assets/images/about-banner.png" alt="asdfe" srcset=""> -->
                                                            <!-- C:\xampp\htdocs\php82\Konsite\construction-app-admin\public\company_assets\images\about-banner.png -->
                                                            <!-- <img src="../../../../php82/Konsite/koncite-html/assets/images/about-banner.png" alt="asdfe" srcset=""> -->
                                                            <!-- </td> -->
                                                            <td>
                                                                <p>{{ $data->unit }}</p>
                                                            </td>
                                                            <td>
                                                                <p>{{ idtoname($data->unit_coversion, 'unit', 'units') }}</p>
                                                            </td>
                                                            <td>
                                                                <p>{{ $data->unit_coversion_factor ?? '' }}</p>
                                                            </td>
                                                            <td>
                                                                <div class="custom-control custom-switch">
                                                                    <input type="checkbox"
                                                                        class="custom-control-input statusChange"
                                                                        id="switch{{ $data->uuid }}"
                                                                        data-uuid="{{ $data->uuid }}"
                                                                        data-message="{{ $data->is_active ? 'deactive' : 'active' }}"
                                                                        data-table="units" name="example"
                                                                        {{ $data->is_active == 1 ? 'checked' : '' }}>
                                                                    <label class="custom-control-label"
                                                                        for="switch{{ $data->uuid }}"></label>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <a href="{{ route('company.units.edit', $data->uuid) }}"><i
                                                                        class="fa fa-edit" style="cursor: pointer;"
                                                                        title="Edit"></i></a>
                                                                <a class="deleteData text-danger"
                                                                    data-uuid="{{ $data->uuid }}" data-model="company"
                                                                    data-table="units" href="javascript:void(0)"><i
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
