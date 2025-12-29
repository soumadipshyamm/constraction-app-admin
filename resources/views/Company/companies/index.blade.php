@extends('Company.layouts.app')
@section('companies-active', 'active')
@section('title', __('Companies'))
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
    <!-- dashboard main body -->
    <div class="app-main__outer">
        <div class="app-main__inner card">
            <!-- dashboard body -->
            <div class="dashboard_body">
                <div class="comp-top comp-top-between">
                    <a href="{{ route('company.companies.add') }}" class="ads-btn">
                        <span><i class="fa-solid fa-plus"></i></span>Create
                        new
                    </a>

                    {{-- <!-- <form id="filter_form" action="{{ route('company.companies.list') }}" method="GET"> --> --}}

                    <div class="comp-topright">
                        <a href="{{ route('company.companies.export') }}" class="ads-btn">
                            <i class="fa fa-download" aria-hidden="true" title="Download Companies Data in Excel"></i>
                        </a>
                        <div class="search-box">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <input type="hidden" name="page" value="1" id="filter_page">
                            <input type="search" class="form-control" name="search_keyword" id="search_keyword"
                                placeholder="Search Company">
                        </div>
                    </div>

                  
                    <!-- </form> -->
                </div>
                <div class="comp-body">
                    <div class="row">
                        <div class="accordion company_box" id="constGroup">
                            @include('Company.companies.include.companies_list')
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
                        url: "{{ route('company.companies.list') }}",
                        type: "GET",
                        data: data,
                        success: function(data) {
                            $("#constGroup").html(data);
                        },
                        error: function(error) {
                            aler(error);
                            // $(".control-sidebar").hide();
                            // swal.fire({
                            //     icon: "error",
                            //     title: "Oops...",
                            //     text: "Something went wrong!",
                            //     error: data,
                            // });
                        },
                    });
                });
            })
        </script>
    @endpush
