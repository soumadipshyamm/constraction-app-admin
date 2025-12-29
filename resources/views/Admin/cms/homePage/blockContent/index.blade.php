@extends('Admin.layouts.app')
@section('home-page-active','active')
@section('title',__('Pages'))
@push('styles')

@endpush
@section('content')
<div class="app-main__outer">
    <div class="app-main__inner">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-tools icon-gradient bg-happy-itmeo">
                        </i>
                    </div>
                    <div>List Home Pages Section Details
                    </div>
                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        {{-- <h5 class="card-title">List Page Details</h5> --}}
                        <div class="table-responsive">
                            <table class="mb-0 table dataTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        {{-- <th>Banner</th> --}}
                                        <th>Section Name</th>
                                        <th>Section Title</th>
                                        {{-- <th>Page Contented</th> --}}
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($datas)
                                    @forelse($datas as $key => $data)
                                    @if( $data->slug!= 'banner-section')


                                    <tr>
                                        <td>
                                            <p>#{{ $key + 1 }}</p>
                                        </td>

                                        <td>
                                            <p>{{ $data->name }}</p>
                                        </td>
                                        <td>
                                            <p>{{ $data->slug }}</p>
                                        </td>
                                        <td>
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input statusChange"
                                                    id="switch{{ $data->uuid }}" data-uuid="{{ $data->uuid }}"
                                                    data-message="{{ $data->is_active ? 'deactive' : 'active' }}"
                                                    data-table="home_pages" name="example" {{ $data->is_active == 1
                                                ?
                                                'checked' : '' }}>
                                                <label class="custom-control-label"
                                                    for="switch{{ $data->uuid }}"></label>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.homePage.edit',$data->uuid) }}"><i
                                                    class="fa fa-edit" style="cursor: pointer;" title="Edit"></i></a>
                                        </td>
                                    </tr>
                                    @endif
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
@endsection
@push('scripts')
@endpush
