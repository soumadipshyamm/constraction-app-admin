<div class="row">
    <div class="col-md-12">
        <div class="main_wrapper">
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button class="nav-link active" id="nav-overview-tab" data-bs-toggle="tab"
                        data-bs-target="#nav-overview" type="button" role="tab" aria-controls="nav-overview"
                        aria-selected="true">Overview</button>
                    <button class="nav-link" id="nav-work-tab" data-bs-toggle="tab" data-bs-target="#nav-work"
                        type="button" role="tab" aria-controls="nav-work" aria-selected="false">Work
                        Progress</button>
                    <button class="nav-link" id="nav-stock-tab" data-bs-toggle="tab" data-bs-target="#nav-stock"
                        type="button" role="tab" aria-controls="nav-stock" aria-selected="false">Stock</button>
                </div>
            </nav>
            <div class="main_card mb-3">
                <div class="card_content">
                    <div class="tab-content" id="nav-tabContent">
                        {{-- ****************************Overviews**************************************** --}}
                        @php
                            $prList = prList(' ');
                            $totalPrList = count($prList);
                        @endphp

                        <div class="tab-pane fade show active" id="nav-overview" role="tabpanel"
                            aria-labelledby="nav-overview-tab">
                            <div class="tabcon_inner">
                                <form id="filter-form" class="filter-form">
                                    @csrf
                                    <div class="tabcin_head">
                                        <div class="singletabcin_head">
                                            <label for="">Project <span class="text-danger">*</span></label>
                                            <select class="form-control from_project " value="{{ old('from_project') }}"
                                                name="from_project" id="from_project">
                                                <option value="">----Select Project----</option>
                                                {{ getProject('$data->project_id') }}
                                            </select>
                                            @if ($errors->has('project'))
                                                <div class="error">{{ $errors->first('project') }}</div>
                                            @endif
                                        </div>
                                        <div class="singletabcin_head">
                                            <label for="">Sub Project </label>
                                            <select class="form-control mySelect2 from_subproject"
                                                value="{{ old('from_subproject') }}" name="from_subproject"
                                                id="from_subproject">
                                                <option value="">----Select SubProject----</option>
                                            </select>
                                            @if ($errors->has('subproject'))
                                                <div class="error">{{ $errors->first('subproject') }}</div>
                                            @endif
                                        </div>
                                        @php
                                            $yesterday = \Carbon\Carbon::yesterday();
                                        @endphp
                                        <div class="singletabcin_head">
                                            <label for="">Date</label>
                                            <input type="date" class="form-control" name="date" id="date"
                                                value="{{ $yesterday->format('Y-m-d') }}">
                                        </div>
                                    </div>
                                </form>
                                <div class="tabcin">
                                    <div class="row">
                                        <div class="col-md-12">
                                            @if (isset($prList))
                                                <h3 class="heading_title mb-3">PR Pending Approvals List
                                                    ({{ $totalPrList ?? 0 }} )</h3>
                                                <div class="pr-list-container">
                                                    @foreach ($prList as $key => $prvalue)
                                                        @if (isset($prvalue?->request_id))
                                                            <div class="alert alert-warning alert-dismissible fade show d-flex justify-content-between align-items-center"
                                                                role="alert">
                                                                <div class="d-flex flex-grow-1 align-items-center">
                                                                    <strong class="me-2">PR No:
                                                                        {{ $prvalue?->request_id }} |
                                                                        <span class="me-3">
                                                                            Project:
                                                                            {{ $prvalue?->projects?->project_name }} |
                                                                            Sub-Project:
                                                                            {{ $prvalue?->subprojects?->name }} |
                                                                            Date: {{ $prvalue?->date }} |
                                                                            User: {{ $prvalue?->users?->name }}
                                                                        </span>
                                                                    </strong>
                                                                </div>
                                                                <div class="d-flex align-items-center">
                                                                    <button type="button" class="btn">
                                                                        <a href="{{ route('company.pr.details', $prvalue?->uuid) }}"
                                                                            class="text-decoration-none"
                                                                            target="_blank">View
                                                                            Details</a>
                                                                    </button>
                                                                    <button type="button" class="btn-close ms-2"
                                                                        data-bs-dismiss="alert"
                                                                        aria-label="Close"></button>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="tabcin_status">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="workstatus_box">
                                                <h3 class="heading_title mb-3 fw-bold">Work Status as on Date
                                                </h3>
                                                <div class="wrks_inner">
                                                    <div class="left_wrkwrpper">
                                                        <div class="left_workinner">
                                                            <p class="leftwrk_txt">
                                                                In progress
                                                            </p>
                                                            <p class="rghtwrk_txt" id="inProgress">
                                                                00
                                                            </p>
                                                        </div>
                                                        <div class="left_workinner">
                                                            <p class="leftwrk_txt">
                                                                Completed
                                                            </p>
                                                            <p class="rghtwrk_txt" id="completed">
                                                                00
                                                            </p>
                                                        </div>
                                                        <div class="left_workinner">
                                                            <p class="leftwrk_txt">
                                                                Not Started
                                                            </p>
                                                            <p class="rghtwrk_txt" id="notStart">
                                                                00
                                                            </p>
                                                        </div>
                                                        <div class="left_workinner">
                                                            <p class="leftwrk_txt">
                                                                Total Activities
                                                            </p>
                                                            <p class="rghtwrk_txt" id="totalActivites">
                                                                00
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="right_wrkwrpper">
                                                        <div class="works_chart">
                                                            <div id="chartContainer" style="height: 200px;">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 pl-0">
                                            <h3 class="heading_title mb-3 fw-bold">Cost Details
                                            </h3>
                                            <div class="costdetails_box">
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <strong>Remaining</strong>
                                                        <p>Estimated Cost for Project</p>
                                                        <p> Estimate cost for executed qty</p>
                                                        <p>Balance Estimate cost</p>
                                                        <p>Excess Estimate cost</p>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <strong>Amount</strong>
                                                        <p id="estimatedCost"></p>
                                                        <p id="estimatedCostForExecutedQty"></p>
                                                        <p id="balanceEstimate"></p>
                                                        <p id="excessEstimateCost"></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="costdetails_box">
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <strong>Timeline & Progress</strong>
                                                        <p>Project Duration </p>
                                                        <p>Completed </p>
                                                        <p>Remaining </p>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <strong>Days</strong>
                                                        <p id="totalDuration">00</p>
                                                        <p id="projectcompleted">00</p>
                                                        <p id="remaining">00</p>
                                                    </div>
                                                </div>
                                                <div class="progressbar_box">
                                                    <div class="progress m-1">
                                                        <div class="progress-bar bg-info" id="planeProgress"
                                                            role="progressbar" style="width: 0%" aria-valuenow="0"
                                                            aria-valuemin="0" aria-valuemax="100">0%</div>
                                                    </div>
                                                    <div class="progress m-1">
                                                        <div class="progress-bar bg-warning" id="actualProgress"
                                                            role="progressbar" style="width: 0%" aria-valuenow="0"
                                                            aria-valuemin="0" aria-valuemax="100">0%</div>
                                                    </div>
                                                    <div class="progress m-1">
                                                        <div class="progress-bar bg-danger" id="variation"
                                                            role="progressbar" style="width: 0%" aria-valuenow="0"
                                                            aria-valuemin="0" aria-valuemax="100">0%</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tabcin_progress">
                                    <div id="progressChart" style="height: 220px; width: 100%;">
                                    </div>
                                </div>
                                <div class="tabcin_details">
                                    <h3 class="heading_title">DPR</h3>
                                    <div class="tabcdetails_top">
                                        <div class="col-md-4">
                                            <div class="tabdt_left" id="dprusers">
                                            </div>
                                        </div>
                                        <div class="tabdt_right">
                                            <h3 class="heading_title">Safety & Hinderances for the day</h3>
                                            <div class="table-responsive" id="dprConatiner">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- **************************************************************** --}}
                                <div class="strength_sec">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="labour_box">
                                                <div class="single_content">
                                                    <p class="singcon_left">
                                                        <strong>Labour Strength</strong>
                                                    </p>
                                                    <p>
                                                        {{-- <span>Qty</span><strong id="totalLabourCount"> 0 nos</strong> --}}
                                                        <strong id="totalLabourTotal"> 0 nos</strong>
                                                        <span>
                                                            <a href="{{ route('company.report.labourStrength') }}" class="view_btn">View</a>
                                                        </span>
                                                    </p>
                                                </div>
                                                <div class="" id="vendorLabourContainer"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="labour_box">
                                                <div class="single_content">
                                                    <p class="singcon_left">
                                                        <strong>Pending Approvals</strong>
                                                    </p>
                                                    <p>
                                                        <strong>{{ $totalPrList ?? 0 }}</strong>
                                                        <span>
                                                            <a href="{{ route('company.pr.list') }}"
                                                                class="view_btn">View</a>
                                                        </span>
                                                    </p>
                                                </div>
                                                <div class="single_content">
                                                    <p class="singcon_left">
                                                        <strong>Purchase Requests raised for the day</strong>
                                                    </p>
                                                    <p>
                                                        <strong id="purchaseRequests">0</strong>
                                                        <span>
                                                            <a href="{{ route('company.report.inventorypr') }}"
                                                                class="view_btn">View</a>
                                                        </span>
                                                    </p>
                                                </div>
                                                <div class="single_content">
                                                    <p class="singcon_left">
                                                        <strong>Goods Receipt Entries for the
                                                            day</strong>
                                                    </p>
                                                    <p>
                                                        <strong id="goodsReceipt">0</strong>
                                                        <span>
                                                            <a href="{{ route('company.report.grnDetails') }}"
                                                                class="view_btn">View</a>
                                                        </span>
                                                    </p>
                                                </div>
                                                <div class="single_content">
                                                    <p class="singcon_left">
                                                        <strong>Issue /Outward Entries for the
                                                            day</strong>
                                                    </p>
                                                    <p>
                                                        <strong id="issueOutward">0</strong>
                                                        <span>
                                                            <a href="{{ route('company.report.issueDetails') }}"
                                                                class="view_btn">View</a>
                                                        </span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="labour_box">
                                                <div class="single_content">
                                                    <p class="singcon_left">
                                                        <strong>PO Raised for the day</strong>
                                                    </p>
                                                    <p>
                                                        <strong id="pORaised">0</strong>
                                                        <span>
                                                            <a href="#" class="view_btn">View</a>
                                                        </span>
                                                    </p>
                                                </div>
                                                <div class="single_content">
                                                    <p class="singcon_left">
                                                        <strong>Material Return to Store for the
                                                            day</strong>
                                                    </p>
                                                    <p>
                                                        <strong id="materialReturn">0</strong>
                                                        <span>
                                                            <a href="{{ route('company.report.issueReturn') }}"
                                                                class="view_btn">View</a>
                                                        </span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- ******************************Work process***************************************************************************************************** --}}
                        <div class="tab-pane fade" id="nav-work" role="tabpanel" aria-labelledby="nav-work-tab">
                            <div class="tabcon_inner">
                                <form id="filter-form-work-process" class="filter-form filter-form-work-process">
                                    <div class="tabcin_head">
                                        <div class="singletabcin_head">
                                            <label for="">Project <span class="text-danger">*</span></label>
                                            <select class="form-control from_project "
                                                value="{{ old('from_project') }}" name="from_project_work_process"
                                                id="from_project_work_process">
                                                <option value="">----Select Project----</option>
                                                {{ getProject('$data->project_id') }}
                                            </select>
                                            @if ($errors->has('project'))
                                                <div class="error">{{ $errors->first('project') }}</div>
                                            @endif
                                        </div>
                                        <div class="singletabcin_head">
                                            <label for="">Sub Project </label>
                                            <select class="form-control  from_subproject from_subproject_work_process"
                                                value="{{ old('from_subproject') }}"
                                                name="from_subproject_work_process" id="from_subproject_work_process">
                                                <option value="">----Select SubProject----</option>
                                            </select>
                                            @if ($errors->has('subproject'))
                                                <div class="error">{{ $errors->first('subproject') }}</div>
                                            @endif
                                        </div>
                                        <div>
                                            <input type="hidden" class="form-control" name="date" id="date"
                                                value="{{ $yesterday->format('Y-m-d') }}">
                                        </div>
                                    </div>
                                </form>
                                <div class="work_project">
                                    <h3 class="heading_title">Project Name</h3>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="costdetails_box workpro_single">
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <p><strong>Total Estimate cost for project </strong></p>
                                                        <p><strong>Total Estimate cost for executed qty</strong>
                                                        </p>
                                                        <p><strong>Balance cost</strong></p>
                                                        <p><strong>Excess Estimate cost</strong></p>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <p class="estimatedCost">0000</p>
                                                        <p class="estimatedCostForExecutedQty">000</p>
                                                        <p class="balanceEstimate">0000</p>
                                                        <p class="excessEstimateCost"></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="workprogress_chart">
                                                <div id="workprogressChart" style="height: 220px; width: 100%;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="status_tab">
                                    <form id="filter-form-work-process-details"
                                        class="filter-form filter-form-work-process-details">
                                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link active filterformworkprocessdetails"
                                                    id="pills-inprogress-tab" data-bs-toggle="pill"
                                                    data-bs-target="#pills-inprogress" type="button" role="tab"
                                                    aria-controls="pills-inprogress" data-name="inprogress"
                                                    aria-selected="true">Inprogress<span></span></button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link filterformworkprocessdetails"
                                                    id="pills-completed-tab" data-bs-toggle="pill"
                                                    data-bs-target="#pills-completed" type="button" role="tab"
                                                    data-name="completed" aria-controls="pills-completed"
                                                    aria-selected="false">Completed
                                                    <span></span></button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link filterformworkprocessdetails"
                                                    id="pills-notstart-tab" data-bs-toggle="pill"
                                                    data-bs-target="#pills-notstart" type="button" role="tab"
                                                    data-name="notstart" aria-controls="pills-notstart"
                                                    aria-selected="false">Not
                                                    started
                                                    <span></span></button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link filterformworkprocessdetails"
                                                    id="pills-delay-tab" data-bs-toggle="pill"
                                                    data-bs-target="#pills-delay" type="button" role="tab"
                                                    data-name="delay" aria-controls="pills-delay"
                                                    aria-selected="false">Delay
                                                    Activities
                                                    <span></span></button>
                                            </li>
                                        </ul>
                                    </form>
                                    <div class="tab-content" id="pills-tabContent">
                                        <div class="tab-pane fade show active" id="pills-inprogress" role="tabpanel"
                                            aria-labelledby="pills-inprogress-tab">
                                            <div class="processdetails_box">
                                                <div class="process_table">
                                                    <div class="table-responsive" id="inprogressActive">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="pills-completed" role="tabpanel"
                                            aria-labelledby="pills-completed-tab">
                                            <div class="processdetails_box">
                                                <div class="process_table">
                                                    <div class="table-responsive" id="completedActive">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="pills-notstart" role="tabpanel"
                                            aria-labelledby="pills-notstart-tab">
                                            <div class="processdetails_box">
                                                <div class="process_table">
                                                    <div class="table-responsive" id="notStartActiveDatas">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="pills-delay" role="tabpanel"
                                            aria-labelledby="pills-delay-tab">
                                            <div class="processdetails_box">
                                                <div class="process_table">
                                                    <div class="table-responsive" id="delayActive">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- ******************************************Stock*********************************************************** --}}
                        <div class="tab-pane fade" id="nav-stock" role="tabpanel" aria-labelledby="nav-stock-tab">
                            <div class="tabcon_inner">
                                <form id="filter-form-stocks" class="filter-form">
                                    <div class="tabcin_head">
                                        <div class="singletabcin_head">
                                            <label for="">Project <span class="text-danger">*</span></label>
                                            <select class="form-control from_project"
                                                value="{{ old('from_project') }}" name="from_project"
                                                id="from_project_stocks">
                                                <option>---select project---</option>
                                                {{ getProject('$data->project_id') }}
                                            </select>
                                            @if ($errors->has('project'))
                                                <div class="error">{{ $errors->first('project') }}</div>
                                            @endif
                                        </div>
                                        <div class="singletabcin_head">
                                            <label for="">Store </label>
                                            <select class="form-control from_store" value="{{ old('from_store') }}"
                                                name="from_store" id="from_subproject_stocks">
                                                {{-- {{ getStoreWarehouses('') }} --}}
                                            </select>
                                            @if ($errors->has('project'))
                                                <div class="error">{{ $errors->first('stores') }}</div>
                                            @endif
                                        </div>
                                        @php
                                            $yesterday = \Carbon\Carbon::yesterday();
                                        @endphp
                                        <div class="singletabcin_head">
                                            <label for="">Date</label>
                                            <input type="date" class="form-control" name="date"
                                                id="date_stocks" value="{{ $yesterday->format('Y-m-d') }}">
                                        </div>
                                    </div>
                                </form>
                                <div class="status_tab">
                                    <form id="filter-inventory-stock-details"
                                        class="filter-form filter-inventory-stock-details">
                                        <ul class="nav nav-pills mb-3" id="materialpills-tab" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link active store_material_tab"
                                                    id="pills-material-tab" data-bs-toggle="pill"
                                                    data-bs-target="#pills-material" type="button" role="tab"
                                                    aria-controls="pills-material" data-name="material"
                                                    aria-selected="true">Material</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link store_material_tab" id="pills-machine-tab"
                                                    data-bs-toggle="pill" data-bs-target="#pills-machine"
                                                    type="button" role="tab" aria-controls="pills-machine"
                                                    data-name="machine" aria-selected="false">Machines/Tools</button>
                                            </li>
                                        </ul>
                                    </form>
                                    <div class="tab-content" id="pills-tabContent">
                                        <div class="tab-pane fade show active" id="pills-material" role="tabpanel"
                                            aria-labelledby="pills-material-tab">
                                            <div class="processdetails_box">
                                                <div class="process_table">
                                                    <div class="table-responsive  stockMaterialTable"
                                                        id="stockMaterialTable">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="pills-machine" role="tabpanel"
                                            aria-labelledby="pills-machine-tab">
                                            <div class="processdetails_box">
                                                <div class="process_table">
                                                    <div class="table-responsive  stockMachineTable"
                                                        id="stockMachineTable">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
