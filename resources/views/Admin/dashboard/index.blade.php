@extends('Admin.layouts.app')
@section('dashboard-active','active')
@section('title',__('Dashboard'))
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

        </div>
        {{-- <div class="row">
            <div class="col-md-12 col-lg-6">
                <div class="mb-3 card">
                    <div class="card-header-tab card-header">
                        <div class="card-header-title">
                            <i class="header-icon lnr-rocket icon-gradient bg-tempting-azure"> </i>
                            Latest Company registration
                        </div>
                        <div class="btn-actions-pane-right">
                            <div class="nav">
                                <select name="month" class="mb-2 form-control">
                                    <option value="">June - 2022</option>
                                    <option value="">May - 2022</option>
                                    <option value="">April - 2022</option>
                                    <option value="">March - 2022</option>
                                    <option value="">Feb - 2022</option>
                                    <option value="">Jan - 2022</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="tab-content">

                        <div class="tab-pane fade active show" id="tab-eg-55">
                            <div class="scroll-area-md">
                                <div class="scrollbar-container">
                                    <ul
                                        class="rm-list-borders rm-list-borders-scroll list-group margin-area list-group-flush">
                                        <li class="list-group-item">
                                            <div class="widget-content p-0">
                                                <div class="widget-content-wrapper">
                                                    <div class="widget-content-left mr-3">
                                                        <img width="42" class="rounded-circle"
                                                            src="assets/images/provider-logo1.png" alt="">
                                                    </div>
                                                    <div class="widget-content-left">
                                                        <div class="widget-heading">John Doe</div>
                                                        <div class="widget-subheading">GVehicle Care</div>
                                                    </div>
                                                    <div class="widget-content-right">
                                                        <div class="font-size-xlg text-muted">
                                                            <small class="opacity-5 pr-1">&#8377;</small>
                                                            <span>20913</span>
                                                            <small class="text-danger pl-2">
                                                                <i class="fa fa-angle-down"></i>
                                                            </small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="widget-content p-0">
                                                <div class="widget-content-wrapper">
                                                    <div class="widget-content-left mr-3">
                                                        <img width="42" class="rounded-circle"
                                                            src="assets/images/provider-logo2.png" alt="">
                                                    </div>
                                                    <div class="widget-content-left">
                                                        <div class="widget-heading">Vivek Agarwal</div>
                                                        <div class="widget-subheading">Car Care Pvt. Ltd.
                                                        </div>
                                                    </div>
                                                    <div class="widget-content-right">
                                                        <div class="font-size-xlg text-muted">
                                                            <small class="opacity-5 pr-1">&#8377;</small>
                                                            <span>16785</span>
                                                            <small class="text-success pl-2">
                                                                <i class="fa fa-angle-up"></i>
                                                            </small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="widget-content p-0">
                                                <div class="widget-content-wrapper">
                                                    <div class="widget-content-left mr-3">
                                                        <img width="42" class="rounded-circle"
                                                            src="assets/images/provider-logo1.png" alt="">
                                                    </div>
                                                    <div class="widget-content-left">
                                                        <div class="widget-heading">Anil D'Suza</div>
                                                        <div class="widget-subheading">ABC Car Wash</div>
                                                    </div>
                                                    <div class="widget-content-right">
                                                        <div class="font-size-xlg text-muted">
                                                            <small class="opacity-5 pr-1">&#8377;</small>
                                                            <span>13006</span>
                                                            <small class="text-success pl-2">
                                                                <i class="fa fa-angle-up"></i>
                                                            </small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="widget-content p-0">
                                                <div class="widget-content-wrapper">
                                                    <div class="widget-content-left mr-3">
                                                        <img width="42" class="rounded-circle"
                                                            src="assets/images/provider-logo2.png" alt="">
                                                    </div>
                                                    <div class="widget-content-left">
                                                        <div class="widget-heading">Mr. N Basu</div>
                                                        <div class="widget-subheading">Vehicle Care Solution
                                                        </div>
                                                    </div>
                                                    <div class="widget-content-right">
                                                        <div class="font-size-xlg text-muted">
                                                            <small class="opacity-5 pr-1">&#8377;</small>
                                                            <span>12907</span>
                                                            <small class="text-danger pl-2">
                                                                <i class="fa fa-angle-down"></i>
                                                            </small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>

                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 col-lg-6">
                <div class="mb-3 card">
                    <div class="card-header-tab card-header">
                        <div class="card-header-title">
                            <i class="header-icon lnr-rocket icon-gradient bg-tempting-azure"> </i>
                            Company subscription purchase
                        </div>
                        <div class="btn-actions-pane-right">
                            <div class="nav">
                                <select name="month" class="mb-2 form-control">
                                    <option value="">June - 2022</option>
                                    <option value="">May - 2022</option>
                                    <option value="">April - 2022</option>
                                    <option value="">March - 2022</option>
                                    <option value="">Feb - 2022</option>
                                    <option value="">Jan - 2022</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="tab-content">

                        <div class="tab-pane fade active show" id="tab-eg-55">
                            <div class="scroll-area-md">
                                <div class="scrollbar-container">
                                    <ul
                                        class="rm-list-borders rm-list-borders-scroll list-group margin-area list-group-flush">
                                        <li class="list-group-item">
                                            <div class="widget-content p-0">
                                                <div class="widget-content-wrapper">
                                                    <div class="widget-content-left mr-3">
                                                        <img width="42" class="rounded-circle"
                                                            src="assets/images/provider-logo1.png" alt="">
                                                    </div>
                                                    <div class="widget-content-left">
                                                        <div class="widget-heading">John Doe</div>
                                                        <div class="widget-subheading">GVehicle Care</div>
                                                    </div>
                                                    <div class="widget-content-right">
                                                        <div class="font-size-xlg text-muted">
                                                            <small class="opacity-5 pr-1">&#8377;</small>
                                                            <span>20913</span>
                                                            <small class="text-danger pl-2">
                                                                <i class="fa fa-angle-down"></i>
                                                            </small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="widget-content p-0">
                                                <div class="widget-content-wrapper">
                                                    <div class="widget-content-left mr-3">
                                                        <img width="42" class="rounded-circle"
                                                            src="assets/images/provider-logo2.png" alt="">
                                                    </div>
                                                    <div class="widget-content-left">
                                                        <div class="widget-heading">Vivek Agarwal</div>
                                                        <div class="widget-subheading">Car Care Pvt. Ltd.
                                                        </div>
                                                    </div>
                                                    <div class="widget-content-right">
                                                        <div class="font-size-xlg text-muted">
                                                            <small class="opacity-5 pr-1">&#8377;</small>
                                                            <span>16785</span>
                                                            <small class="text-success pl-2">
                                                                <i class="fa fa-angle-up"></i>
                                                            </small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="widget-content p-0">
                                                <div class="widget-content-wrapper">
                                                    <div class="widget-content-left mr-3">
                                                        <img width="42" class="rounded-circle"
                                                            src="assets/images/provider-logo1.png" alt="">
                                                    </div>
                                                    <div class="widget-content-left">
                                                        <div class="widget-heading">Anil D'Suza</div>
                                                        <div class="widget-subheading">ABC Car Wash</div>
                                                    </div>
                                                    <div class="widget-content-right">
                                                        <div class="font-size-xlg text-muted">
                                                            <small class="opacity-5 pr-1">&#8377;</small>
                                                            <span>13006</span>
                                                            <small class="text-success pl-2">
                                                                <i class="fa fa-angle-up"></i>
                                                            </small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="widget-content p-0">
                                                <div class="widget-content-wrapper">
                                                    <div class="widget-content-left mr-3">
                                                        <img width="42" class="rounded-circle"
                                                            src="assets/images/provider-logo2.png" alt="">
                                                    </div>
                                                    <div class="widget-content-left">
                                                        <div class="widget-heading">Mr. N Basu</div>
                                                        <div class="widget-subheading">Vehicle Care Solution
                                                        </div>
                                                    </div>
                                                    <div class="widget-content-right">
                                                        <div class="font-size-xlg text-muted">
                                                            <small class="opacity-5 pr-1">&#8377;</small>
                                                            <span>12907</span>
                                                            <small class="text-danger pl-2">
                                                                <i class="fa fa-angle-down"></i>
                                                            </small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="main-card mb-3 card">
                    <div class="card-header">Company payment report
                        <div class="btn-actions-pane-right">
                            <div role="group" class="btn-group-sm btn-group">
                                <button class="active btn btn-focus">This Month</button>
                                <button class="btn btn-focus">Last Month</button>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Name</th>
                                    <th class="text-center">City</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center text-muted">#1</td>
                                    <td>
                                        <div class="widget-content p-0">
                                            <div class="widget-content-wrapper">
                                                <div class="widget-content-left mr-3">
                                                    <div class="widget-content-left">
                                                        <img width="40" class="rounded-circle"
                                                            src="assets/images/avatars/4.jpg" alt="">
                                                    </div>
                                                </div>
                                                <div class="widget-content-left flex2">
                                                    <div class="widget-heading">John Doe</div>
                                                    <div class="widget-subheading opacity-7">8978979787
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">Delhi</td>
                                    <td class="text-center">
                                        <div class="badge badge-warning">Pending</div>
                                    </td>
                                    <td class="text-center">
                                        <button type="button" id="PopoverCustomT-1"
                                            class="btn btn-primary btn-sm">Details</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center text-muted">#2</td>
                                    <td>
                                        <div class="widget-content p-0">
                                            <div class="widget-content-wrapper">
                                                <div class="widget-content-left mr-3">
                                                    <div class="widget-content-left">
                                                        <img width="40" class="rounded-circle"
                                                            src="assets/images/avatars/3.jpg" alt="">
                                                    </div>
                                                </div>
                                                <div class="widget-content-left flex2">
                                                    <div class="widget-heading">Ruben Tillman</div>
                                                    <div class="widget-subheading opacity-7">6500123132
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">Mumbai</td>
                                    <td class="text-center">
                                        <div class="badge badge-success">Completed</div>
                                    </td>
                                    <td class="text-center">
                                        <button type="button" id="PopoverCustomT-2"
                                            class="btn btn-primary btn-sm">Details</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center text-muted">#3</td>
                                    <td>
                                        <div class="widget-content p-0">
                                            <div class="widget-content-wrapper">
                                                <div class="widget-content-left mr-3">
                                                    <div class="widget-content-left">
                                                        <img width="40" class="rounded-circle"
                                                            src="assets/images/avatars/2.jpg" alt="">
                                                    </div>
                                                </div>
                                                <div class="widget-content-left flex2">
                                                    <div class="widget-heading">B Patel</div>
                                                    <div class="widget-subheading opacity-7">080891311</div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">Nepal</td>
                                    <td class="text-center">
                                        <div class="badge badge-danger">In Progress</div>
                                    </td>
                                    <td class="text-center">
                                        <button type="button" id="PopoverCustomT-3"
                                            class="btn btn-primary btn-sm">Details</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center text-muted">#4</td>
                                    <td>
                                        <div class="widget-content p-0">
                                            <div class="widget-content-wrapper">
                                                <div class="widget-content-left mr-3">
                                                    <div class="widget-content-left">
                                                        <img width="40" class="rounded-circle"
                                                            src="assets/images/avatars/5.jpg" alt="">
                                                    </div>
                                                </div>
                                                <div class="widget-content-left flex2">
                                                    <div class="widget-heading">Ritu Verma</div>
                                                    <div class="widget-subheading opacity-7">567576810</div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">Kolkata</td>
                                    <td class="text-center">
                                        <div class="badge badge-info">Pending</div>
                                    </td>
                                    <td class="text-center">
                                        <button type="button" id="PopoverCustomT-4"
                                            class="btn btn-primary btn-sm">Details</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="d-block text-center card-footer">

                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-lg-4">
                <div class="card-shadow-danger mb-3 widget-chart widget-chart2 text-left card">
                    <div class="widget-content">
                        <div class="widget-content-outer">
                            <div class="widget-content-wrapper">
                                <div class="widget-content-left pr-2 fsize-1">
                                    <div class="widget-numbers mt-0 fsize-3 text-danger">&#8377; 8,91,991
                                    </div>
                                </div>

                            </div>
                            <div class="widget-content-left fsize-1">
                                <div class="text-muted opacity-6">Total Commission Earned</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="card-shadow-success mb-3 widget-chart widget-chart2 text-left card">
                    <div class="widget-content">
                        <div class="widget-content-outer">
                            <div class="widget-content-wrapper">
                                <div class="widget-content-left pr-2 fsize-1">
                                    <div class="widget-numbers mt-0 fsize-3 text-success">54%</div>
                                </div>
                                <div class="widget-content-right w-100">
                                    <div class="progress-bar-xs progress">
                                        <div class="progress-bar bg-success" role="progressbar" aria-valuenow="54"
                                            aria-valuemin="0" aria-valuemax="100" style="width: 54%;"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="widget-content-left fsize-1">
                                <div class="text-muted opacity-6">Monthly Booking</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="card-shadow-warning mb-3 widget-chart widget-chart2 text-left card">
                    <div class="widget-content">
                        <div class="widget-content-outer">
                            <div class="widget-content-wrapper">
                                <div class="widget-content-left pr-2 fsize-1">
                                    <div class="widget-numbers mt-0 fsize-3 text-warning">32%</div>
                                </div>
                                <div class="widget-content-right w-100">
                                    <div class="progress-bar-xs progress">
                                        <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="32"
                                            aria-valuemin="0" aria-valuemax="100" style="width: 32%;"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="widget-content-left fsize-1">
                                <div class="text-muted opacity-6">Spendings Target</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div> --}}
    </div>
</div>

@endsection()
@push('scripts')
@endpush
