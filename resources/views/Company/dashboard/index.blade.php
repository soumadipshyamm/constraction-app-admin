@extends('Company.layouts.app')
@section('dashboard-active', 'active')
@section('title', __('Dashboard'))
@push('styles')
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
                        <div>Dashboard
                            {{-- <div class="page-title-subheading">View analytical Dashboard
                        </div> --}}
                        </div>
                    </div>
                    <div class="page-title-actions">

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-xl-4">
                    <div class="card mb-3 widget-content bg-midnight-bloom">
                        <div class="widget-content-wrapper text-white">
                            <div class="widget-content-left">
                                <div class="widget-heading">Number of Active Company</div>
                                <div class="widget-subheading">Lifetime data</div>
                            </div>
                            <div class="widget-content-right">
                                <div class="widget-numbers text-white"><span>13</span></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-4">
                    <div class="card mb-3 widget-content bg-arielle-smile">
                        <div class="widget-content-wrapper text-white">
                            <div class="widget-content-left">
                                <div class="widget-heading">Number of Active Projects</div>
                                <div class="widget-subheading">Lifetime data</div>
                            </div>
                            <div class="widget-content-right">
                                <div class="widget-numbers text-white"><span>1031</span></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-4">
                    <div class="card mb-3 widget-content bg-grow-early">
                        <div class="widget-content-wrapper text-white">
                            <div class="widget-content-left">
                                <div class="widget-heading">Total Revenue</div>
                                <div class="widget-subheading">This Year</div>
                            </div>
                            <div class="widget-content-right">
                                <div class="widget-numbers text-white"><span>&#8377; 10,9801</span></div>
                            </div>
                        </div>
                    </div>
                </div>
                @include('Company.dashboard.include.overview')
            </div>
        </div>
        <div class="app-wrapper-footer">
            <div class="app-footer">
                <div class="app-footer__inner">
                    <div class="app-footer-left">

                    </div>
                    <div class="app-footer-right">
                        <ul class="nav">

                            <li class="nav-item">
                                <a href="javascript:void(0);" class="nav-link">
                                    <div class="badge badge-success mr-1 ml-0">
                                        <small>Copyright</small>
                                    </div>
                                    Koncite
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection()
@push('scripts')
    <script src="https://cdn.canvasjs.com/jquery.canvasjs.min.js"></script>
    <script src={{ asset('company_assets/js/ajax/dashboardchart.js') }}></script>
    <script>
        $(document).ready(function() {
            $("#chartContainer").CanvasJSChart(options);
            $("#monthlychartContainer").CanvasJSChart(monthlyreport);

        });
    </script>
    <script>
        $(document).ready(function($e) {
            $('#from_project').change(function() {
                var projectId = $(this).val();
                // alert(projectId);
                $.get(baseUrl + 'company/activities/subprojects/' + projectId, function(data) {
                    $('#from_subproject').empty();
                    $.each(data, function(key, value) {
                        // console.log(value.sub_project);
                        $.each(value.sub_project, function(subkey, subvalue) {
                            // console.log(subvalue);
                            // alert(subvalue);
                            $('#from_subproject').append('<option value = "' +
                                subvalue.id +
                                '">' +
                                subvalue.name +
                                '</option>');
                        });
                    });
                });
            });
        });


        $('#filter-form').on('change', function() {
            var project = $('#from_project').val();
            var subproject = $('#from_subproject').val();
            var date = $('#date').val();
            console.log(project + '/' + subproject + '/' + date);
            alert(project + '/' + subproject + '/' + date);
            // $.ajax({
            // url: "{{ route('company.activities.copyActivites') }}",
            // type: "GET",
            // data: {
            // project: project,
            // subproject: subproject
            // },
            // success: function(response) {
            // $('.comp-body').show()
            // $("#constGroup").html(response);
            // },
            // error: function(error) {
            // alert(error);
            // }
            // });
        });
    </script>
    {{-- <script type="text/javascript">
        var labels = {{ Js::from($labels) }};
        var users = {{ Js::from($data) }};

        const data = {
            labels: labels,
            datasets: [{
                label: 'My First dataset',
                backgroundColor: 'rgb(255, 99, 132)',
                borderColor: 'rgb(255, 99, 132)',
                data: users,
            }]
        };

        const config = {
            type: 'line',
            data: data,
            options: {}
        };

        const myChart = new Chart(
            document.getElementById('myChart'),
            config
        );
    </script> --}}
@endpush
