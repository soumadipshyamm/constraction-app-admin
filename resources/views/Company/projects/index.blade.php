@extends('Company.layouts.app')
@section('project-active', 'active')
@section('title', __('Project'))
@push('styles')
    <style>
        .companyn_img img {
            width: 50px;
            border-radius: 50%;
            height: 40px;
        }
    </style>
@endpush
@section('content')

    <div class="app-main__outer">
        <div class="app-main__inner card">
            <!-- dashboard body -->
            <div class="dashboard_body">
                <div class="breadcrumbs">
                    <ul>
                        <li> <a href="#">Project</a></li>
                    </ul>
                </div>
                <div class="comp-top comp-top-between">
                    <a href="{{ route('company.project.add') }}" class="ads-btn">
                        <span><i class="fa-solid fa-plus"></i></span>Create
                        new
                    </a>
                    <div class="comp-topright">
                        <a href="{{ route('company.project.export') }}" class="ads-btn">
                            <i class="fa fa-download" aria-hidden="true" title="Download Project Data in Excel"></i>
                        </a>
                        <div class="search-box">
                            <select class="form-control project_status" value="{{ old('project_status') }}"
                                name="project_status" id="project">
                                <option value="">--Select Status---</option>
                                <option value="no">On going Project</option>
                                <option value="yes">Completed Project</option>
                            </select>
                        </div>
                        <div class="comp-topright">
                            <div class="search-box">
                                <i class="fa-solid fa-magnifying-glass"></i>
                                <input type="hidden" name="page" value="1" id="filter_page">
                                <input type="search" class="form-control search_keyword" name="search_keyword"
                                    id="search_keyword" placeholder="Search Project">
                            </div>

                        </div>
                    </div>
                </div>
                <div class="comp-body">
                    <div class="row">
                        <div class="accordion companyig_box" id="constGroup">
                            @include('Company.projects.include.project-list')
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
            $(".search_keyword").keyup(function() {
                let project = $(this).val();
                $.ajax({
                    url: "{{ route('company.project.list') }}",
                    type: "GET",
                    data: {
                        search_keyword: project
                    },
                    success: function(data) {
                        $("#constGroup").html(data);
                    },
                    error: function(error) {
                        aler(error);

                    },
                });
            });

            $(".project_status").on('change', function() {
                let project_status = $(this).val();
                $.ajax({
                    url: "{{ route('company.project.list') }}",
                    type: "GET",
                    data: {
                        project_status: project_status
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
