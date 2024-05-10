@extends('Company.layouts.app')
@section('storeWarehouse-active', 'active')
@section('title', __('Store/Warehouse'))
@push('styles')
@endpush

@section('content')
    <div class="app-main__outer">
        <div class="app-main__inner card">
            <!-- dashboard body -->
            <div class="dashboard_body">
                <div class="comp-top comp-top-between">
                    <a href="{{ route('company.storeWarehouse.add') }}" class="ads-btn">
                        <span><i class="fa-solid fa-plus"></i></span>Create new
                    </a>
                    <div class="comp-topright">
                        <a href="{{ route('company.storeWarehouse.export') }}" class="ads-btn">
                            <i class="fa fa-download" aria-hidden="true" title="Download store/warehouse Data in Excel"></i>
                        </a>
                        <div class="search-box">
                            <select class="form-control mySelect2 project" value="{{ old('project') }}" name="project"
                                id="project">
                                <option value="">----Select Project----</option>
                                {{ getProject('$data->project_id') }}
                            </select>
                            @if ($errors->has('project'))
                                <div class="error">{{ $errors->first('project') }}</div>
                            @endif
                        </div>
                        <div class="search-box">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <input type="hidden" name="page" value="1" id="filter_page">
                            <input type="search" class="form-control" name="search_keyword" id="search_keyword"
                                placeholder="Search Store/Warehouse">
                        </div>

                    </div>
                </div>
                <div class="comp-body">
                    <div class="row">
                        <div class="accordion companyig_box" id="constGroup">
                            @include('Company.storeWarehouse.include.store-list')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $("#search_keyword").keyup(function() {
                let company = $(this).val();
                // alert(company);
                let data = {
                    search_keyword: company
                };
                $.ajax({
                    url: "{{ route('company.storeWarehouse.list') }}",
                    type: "GET",
                    data: data,
                    success: function(data) {
                        $("#constGroup").html(data);
                    },
                    error: function(error) {
                        aler(error);
                    },
                });
            });
            $(".project").on('change', function() {
                let project = $(this).val();

                $.ajax({
                    url: "{{ route('company.storeWarehouse.list') }}",
                    type: "GET",
                    data: {
                        project: project
                    },
                    success: function(data) {
                        $("#constGroup").html(data);
                    },
                    error: function(error) {
                        aler(error);

                    },
                });
            });
        })
    </script>
@endpush
