@extends('Admin.layouts.app')
@section('dashboard-active', 'active')
@section('title', __('Dashboard'))
@push('styles')
    <style>
        .dashboard-container {
            /* background-color: #f0f4f8; */
            padding: 20px;
            border-radius: 8px;
            /* box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); */
            /* max-width: 600px; */
            margin: auto;
        }

        .filters {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .filters input[type="date"] {
            width: 100px;
        }

        .registered-companies {
            display: flex;
            justify-content: space-around;
            font-size: 24px;
            font-weight: bold;
        }
    </style>
@endpush
@section('content')
    <div class="app-main__outer">
        <div class="app-main__inner">
            <div class="app-page-title">
                <div class="page-title-wrapper">
                    <div class="page-title-heading">
                        <div class="page-title-icon">
                            <i class="pe-7s-car icon-gradient bg-mean-fruit">
                            </i>
                        </div>
                        <div> Dashboard
                            <div class="page-title-subheading">View analytical Dashboard
                            </div>
                        </div>
                    </div>
                    <div class="page-title-actions">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3 col-xl-3">
                    <div class="card mb-3 widget-content bg-midnight-bloom">
                        <div class="widget-content-wrapper text-white">
                            <div class="widget-content-left">
                                <div class="widget-heading">Number of Active Company</div>
                                <div class="widget-subheading">Lifetime data</div>
                            </div>
                            <div class="widget-content-right">
                                <div class="widget-numbers text-white"><span>{{ $totalCompany ?? 0 }}</span></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-xl-3">
                    <div class="card mb-3 widget-content bg-arielle-smile">
                        <div class="widget-content-wrapper text-white">
                            <div class="widget-content-left">
                                <div class="widget-heading">Number of Active Projects</div>
                                <div class="widget-subheading">Lifetime data</div>
                            </div>
                            <div class="widget-content-right">
                                <div class="widget-numbers text-white"><span>{{ $activeProject ?? 0 }}</span></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-xl-3">
                    <div class="card mb-3 widget-content bg-arielle-smile">
                        <div class="widget-content-wrapper text-white">
                            <div class="widget-content-left">
                                <div class="widget-heading">Number of Active Uses</div>
                                <div class="widget-subheading">Lifetime data</div>
                            </div>
                            <div class="widget-content-right">
                                <div class="widget-numbers text-white"><span>{{ $totalUser ?? 0 }}</span></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-xl-3">
                    <div class="card mb-3 widget-content bg-grow-early">
                        <div class="widget-content-wrapper text-white">
                            <div class="widget-content-left">
                                <div class="widget-heading">Total Revenue</div>
                                <div class="widget-subheading">This Year</div>
                            </div>
                            <div class="widget-content-right">
                                <div class="widget-numbers text-white"><span> 10,9801</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection()
@push('scripts')
    <script>
        $(function() {
            $(".date-picker").datepicker({
                dateFormat: "yy-mm-dd",
                changeMonth: true,
                changeYear: true
            });

            const currentDate = new Date();
            const oneMonthDate = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, currentDate
                .getDate());
            const sixMonthDate = new Date(currentDate.getFullYear(), currentDate.getMonth() + 6, currentDate
                .getDate());
            const oneYearDate = new Date(currentDate.getFullYear() + 1, currentDate.getMonth(), currentDate
                .getDate());

            $("#reg_company_current_date").datepicker("setDate", currentDate);
            $("#reg_company_one_month_date").datepicker("setDate", oneMonthDate);
            $("#reg_company_six_month_date").datepicker("setDate", sixMonthDate);
            $("#reg_company_year_date").datepicker("setDate", oneYearDate);
        });
    </script>
@endpush
