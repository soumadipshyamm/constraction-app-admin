<div class="app-sidebar sidebar-shadow">
    <!-- side bar logo  -->
    <div class="app-header__logo">
        <div class="widget-content-left widget_profile">
            <div class="p-0 btn prol_img">
                <img class="rounded-circle" src="{{ asset('company_assets/images/user.png') }}" alt="">
                <h6 class="widget-heading">
                    {{ auth()->guard('company')->name }}
                </h6>
            </div>
        </div>
        <div class="header__pane ml-auto">
            <div>
                <button type="button" class="hamburger close-sidebar-btn hamburger--elastic"
                    data-class="closed-sidebar">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </button>
            </div>
        </div>
    </div>
    <!-- <div class="app-header__menu">
            <span>
                <button type="button"
                    class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                    <span class="btn-icon-wrapper">
                        <i class="fa fa-ellipsis-v fa-w-6"></i>
                    </span>
                </button>
            </span>
        </div> -->
    <div class="scrollbar-sidebar">
        <div class="app-sidebar__inner">
            <ul class="vertical-nav-menu">
                @if (checkCompanyPermissions(
                        'dashboard',
                        auth()->guard('company')->user()->company_role_id,
                        auth()->guard('company')->user()->id,
                        'view'))
                    <li class="app-sidebar__heading">Dashboard</li>
                    <li>
                        <a href="{{ route('company.home') }}" class="mm-@yield('dashboard-active')">
                            <span>
                                <img src="{{ asset('company_assets/images/side-icon/dashboard.svg') }}"
                                    class="img-fluid" alt="">
                            </span>
                            Dashboard
                        </a>
                    </li>
                @endif
                {{-- @dd(auth()->guard('company')->user()->company_role_id); --}}


                @if (checkCompanyPermissions(
                        'master',
                        auth()->guard('company')->user()->company_role_id,
                        auth()->guard('company')->user()->id,
                        'view'))
                    <li class="app-sidebar__heading">Master</li>
                    <li class="app-sidebar__heading app_submenu">

                        <a href="#">
                            <span>
                                <img src="{{ asset('company_assets/images/side-icon/master.svg') }}" class="img-fluid"
                                    alt="">
                            </span>
                            Masters
                        </a>
                        <ul class="{{ Session::get('navbar') == 'show' ? 'mm-collapse mm-show' : '' }}">
                            <li>
                                <a href="{{ route('company.companies.list') }}" class="mm-@yield('company-active')">
                                    Companies
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('company.project.list') }}" class="mm-@yield('project-active')">
                                    Projects
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('company.subProject.list') }}" class="mm-@yield('subProject-active')">
                                    Subproject
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('company.profileDesignation.list') }}" class="mm-@yield('profileDesignation-active')">
                                    Role/Designation
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('company.units.list') }}" class="mm-@yield('units-active')">
                                    Units
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('company.storeWarehouse.list') }}" class="mm-@yield('storeWarehouse-active')">
                                    Stores/ Warehouses
                                </a>
                            </li>
                            <!-- <li>
                            <a href="{{ route('company.teams.list') }}" class="mm-@yield('teams-active')">
                                Teams
                            </a>
                        </li> -->
                            <li>
                                <a href="{{ route('company.labour.list') }}" class="mm-@yield('labour-active')">
                                    Labours
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('company.assets.list') }}" class="mm-@yield('assets-active')">
                                    Assets Equipments
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('company.vendor.list') }}" class="mm-@yield('vendor-active')">
                                    Vendors
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('company.activities.list') }}" class="mm-@yield('activities-active')">
                                    Activities
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('company.materials.list') }}" class="mm-@yield('materials-active')">
                                    Materials
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
                @if (checkCompanyPermissions(
                        'user-managment',
                        auth()->guard('company')->user()->company_role_id,
                        auth()->guard('company')->user()->id,
                        'view'))
                    <li class="app-sidebar__heading">User Management</li>
                    <li class="app-sidebar__heading app_submenu">
                        <a href="#">
                            <span>
                                <img src="{{ asset('company_assets/images/side-icon/master.svg') }}" class="img-fluid"
                                    alt="">
                            </span>
                            Company Users
                        </a>
                        <ul>
                            <li>
                                <a href="{{ route('company.userManagment.list') }}" class="mm-@yield('user-active')">
                                    <i class="metismenu-icon"></i>
                                    Manage Teams
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('company.roleManagment.list') }}" class="mm-@yield('role-active')">
                                    <i class="metismenu-icon">
                                    </i>User Roles and Permissions
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
                <li class="app-sidebar__heading  mm-active">
                    <a href="#">
                        <span>
                            <img src="{{ asset('company_assets/images/side-icon/transaction.svg') }}" class="img-fluid"
                                alt="">
                        </span>
                        Transactions
                    </a>
                </li>

                @if (checkCompanyPermissions(
                        'user-managment',
                        auth()->guard('company')->user()->company_role_id,
                        auth()->guard('company')->user()->id,
                        'view'))
                    <li class="app-sidebar__heading"> Reports</li>
                    <li class="app-sidebar__heading app_submenu">
                        <a href="#">
                            <span>
                                <img src="{{ asset('company_assets/images/side-icon/master.svg') }}" class="img-fluid"
                                    alt="">
                            </span>
                            Reports
                        </a>
                        <ul>
                            {{-- Master Data  --}}
                            {{-- <li class="app-sidebar__heading app_submenu">
                                <a href="#">
                                    <span>
                                        <img src="{{ asset('company_assets/images/side-icon/master.svg') }}"
                                            class="img-fluid" alt="">
                                    </span>
                                    Master Reports
                                </a>
                                <ul>
                                    <li>
                                        <a href="{{ route('company.report.list') }}"
                                            class="mm-@yield('user-active')">
                                            <i class="metismenu-icon"></i>
                                            Company List
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('company.userManagment.list') }}"
                                            class="mm-@yield('user-active')">
                                            <i class="metismenu-icon"></i>
                                            sub projects
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('company.userManagment.list') }}"
                                            class="mm-@yield('user-active')">
                                            <i class="metismenu-icon"></i>
                                            Material List
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('company.userManagment.list') }}"
                                            class="mm-@yield('user-active')">
                                            <i class="metismenu-icon"></i>
                                            Labours List
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('company.userManagment.list') }}"
                                            class="mm-@yield('user-active')">
                                            <i class="metismenu-icon"></i>
                                            Machine/Asset List
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('company.userManagment.list') }}"
                                            class="mm-@yield('user-active')">
                                            <i class="metismenu-icon"></i>
                                            Vendor List
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('company.userManagment.list') }}"
                                            class="mm-@yield('user-active')">
                                            <i class="metismenu-icon"></i>
                                            Teams List
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('company.userManagment.list') }}"
                                            class="mm-@yield('user-active')">
                                            <i class="metismenu-icon"></i>
                                            Unit Of Measurement List
                                        </a>
                                    </li>
                                </ul>
                            </li> --}}

                            {{-- Work progress Reports --}}
                            {{-- <li class="app-sidebar__heading app_submenu">
                                <a href="#">
                                    <span>
                                        <img src="{{ asset('company_assets/images/side-icon/master.svg') }}"
                                            class="img-fluid" alt="">
                                    </span>
                                    Work progress Reports
                                </a>
                                <ul>
                                    <li>
                                        <a href="{{ route('company.userManagment.list') }}"
                                            class="mm-@yield('user-active')">
                                            <i class="metismenu-icon"></i>
                                            Work Progress Details
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('company.userManagment.list') }}"
                                            class="mm-@yield('user-active')">
                                            <i class="metismenu-icon"></i>
                                            DPR
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('company.userManagment.list') }}"
                                            class="mm-@yield('user-active')">
                                            <i class="metismenu-icon"></i>
                                            Resources Usage From DPR
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('company.userManagment.list') }}"
                                            class="mm-@yield('user-active')">
                                            <i class="metismenu-icon"></i>
                                            Matrial Used Vs Store Issue
                                        </a>
                                    </li>
                                </ul>
                            </li> --}}

                            {{-- Inventory Reports --}}
                            {{-- <li class="app-sidebar__heading app_submenu">
                                <a href="#">
                                    <span>
                                        <img src="{{ asset('company_assets/images/side-icon/master.svg') }}"
                                            class="img-fluid" alt="">
                                    </span>
                                    Inventory Reports
                                </a>
                                <ul>
                                    <li>
                                        <a href="{{ route('company.userManagment.list') }}"
                                            class="mm-@yield('user-active')">
                                            <i class="metismenu-icon"></i>
                                            PR
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('company.userManagment.list') }}"
                                            class="mm-@yield('user-active')">
                                            <i class="metismenu-icon"></i>
                                            RFQ
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('company.userManagment.list') }}"
                                            class="mm-@yield('user-active')">
                                            <i class="metismenu-icon"></i>
                                            PO
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('company.userManagment.list') }}"
                                            class="mm-@yield('user-active')">
                                            <i class="metismenu-icon"></i>
                                            GRN (MRN) Slip
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('company.userManagment.list') }}"
                                            class="mm-@yield('user-active')">
                                            <i class="metismenu-icon"></i>
                                            GRN (MRN ) Details
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('company.userManagment.list') }}"
                                            class="mm-@yield('user-active')">
                                            <i class="metismenu-icon"></i>
                                            ISSUE Slip
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('company.userManagment.list') }}"
                                            class="mm-@yield('user-active')">
                                            <i class="metismenu-icon"></i>
                                            Issue (Outward )Details
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('company.userManagment.list') }}"
                                            class="mm-@yield('user-active')">
                                            <i class="metismenu-icon"></i>
                                            Issue Return
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('company.userManagment.list') }}"
                                            class="mm-@yield('user-active')">
                                            <i class="metismenu-icon"></i>
                                            Global stock Details
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('company.userManagment.list') }}"
                                            class="mm-@yield('user-active')">
                                            <i class="metismenu-icon"></i>
                                            Stock Statement
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('company.userManagment.list') }}"
                                            class="mm-@yield('user-active')">
                                            <i class="metismenu-icon"></i>
                                            PO Vs GRN
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('company.userManagment.list') }}"
                                            class="mm-@yield('user-active')">
                                            <i class="metismenu-icon"></i>
                                            PR Vs RFQ
                                        </a>
                                    </li>
                                </ul>
                            </li> --}}

                            {{-- Contractor Reports --}}
                            {{-- <li class="app-sidebar__heading app_submenu">
                                <a href="#">
                                    <span>
                                        <img src="{{ asset('company_assets/images/side-icon/master.svg') }}"
                                            class="img-fluid" alt="">
                                    </span>
                                    Contractor Reports
                                </a>
                                <ul>
                                    <li>
                                        <a href="{{ route('company.userManagment.list') }}"
                                            class="mm-@yield('user-active')">
                                            <i class="metismenu-icon"></i>
                                            Labour Contractor
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('company.userManagment.list') }}"
                                            class="mm-@yield('user-active')">
                                            <i class="metismenu-icon"></i>
                                            Work Contractor
                                        </a>
                                    </li>
                                </ul>
                            </li> --}}

                            {{-- User Related --}}
                            {{-- <li class="app-sidebar__heading app_submenu">
                                <a href="#">
                                    <span>
                                        <img src="{{ asset('company_assets/images/side-icon/master.svg') }}"
                                            class="img-fluid" alt="">
                                    </span>
                                    User Related
                                </a>
                                <ul>
                                    <li>
                                        <a href="{{ route('company.userManagment.list') }}"
                                            class="mm-@yield('user-active')">
                                            <i class="metismenu-icon"></i>
                                            Pending Approval
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('company.userManagment.list') }}"
                                            class="mm-@yield('user-active')">
                                            <i class="metismenu-icon"></i>
                                            Active User
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('company.userManagment.list') }}"
                                            class="mm-@yield('user-active')">
                                            <i class="metismenu-icon"></i>
                                            Approval rights
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('company.userManagment.list') }}"
                                            class="mm-@yield('user-active')">
                                            <i class="metismenu-icon"></i>
                                            User access rights
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('company.userManagment.list') }}"
                                            class="mm-@yield('user-active')">
                                            <i class="metismenu-icon"></i>
                                            User Labels
                                        </a>
                                    </li>
                                </ul>
                            </li> --}}
                        </ul>
                    </li>
                @endif
                <li class="app-sidebar__heading">
                    <a href="#">
                        <span>
                            <img src="{{ asset('company_assets/images/side-icon/settings.svg') }}" class="img-fluid"
                                alt="">
                        </span>
                        Settings
                    </a>
                </li>
                <li class="app-sidebar__heading">
                    <a href="#">
                        <span>
                            <img src="{{ asset('company_assets/images/side-icon/offers.svg') }}" class="img-fluid"
                                alt="">
                        </span>
                        Offers
                    </a>
                </li>
                <li class="app-sidebar__heading">
                    <a href="#">
                        <span>
                            <img src="{{ asset('company_assets/images/side-icon/help.svg') }}" class="img-fluid"
                                alt="">
                        </span>
                        Help
                    </a>
                </li>

                <li class="app-sidebar__heading">
                    <a href="{{ route('company.logout') }}" class="dropdown-item"> <span>
                            <img src="{{ asset('company_assets/images/side-icon/logout.svg') }}" class="img-fluid"
                                alt="">
                        </span>Logout</a>
                </li>
            </ul>
        </div>
    </div>
</div>
