<div class="app-sidebar sidebar-shadow">
    <div class="app-header__logo">
        <div class="logo-src"></div>
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
    <div class="app-header__mobile-menu">
        <div>
            <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
            </button>
        </div>
    </div>
    <div class="app-header__menu">
        <span>
            <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                <span class="btn-icon-wrapper">
                    <i class="fa fa-ellipsis-v fa-w-6"></i>
                </span>
            </button>
        </span>
    </div>
    <div class="scrollbar-sidebar">
        <div class="app-sidebar__inner">
            <ul class="vertical-nav-menu">
                <li class="app-sidebar__heading">Dashboard</li>
                <li>
                    <a href="{{ route('company.home') }}" class="mm-@yield('dashboard-active')">
                        <i class="metismenu-icon pe-7s-rocket"></i>
                        Dashboard
                    </a>
                </li>
                <li class="app-sidebar__heading">Master</li>
                <li>
                    <a href="{{ route('company.companies.list') }}" class="mm-@yield('company-active')"><i
                            class="metismenu-icon pe-7s-display2"></i>
                        Companies
                    </a>
                </li>
                <li>
                    <a href="{{ route('company.project.list') }}" class="mm-@yield('project-active')">
                        <i class="metismenu-icon pe-7s-display2"></i>
                        Projects
                    </a>
                </li>
                <li>
                    <a href="{{ route('company.subProject.list') }}" class="mm-@yield('subProject-active')">
                        <i class="metismenu-icon pe-7s-display2"></i>
                        Sub-Projects
                    </a>
                </li>
                <li>
                    <a href="{{ route('company.profileDesignation.list') }}"
                        class="mm-@yield('profileDesignation-active')">
                        <i class="metismenu-icon pe-7s-display2"></i>
                        Profile Role
                    </a>
                </li>
                <li>
                    <a href="{{ route('company.units.list') }}" class="mm-@yield('units-active')">
                        <i class="metismenu-icon pe-7s-display2"></i>
                        Unit Master
                    </a>
                </li>
                <li>
                    <a href="{{ route('company.storeWarehouse.list') }}"
                        class="mm-@yield('storeWarehouse-active')">
                        <i class="metismenu-icon pe-7s-display2"></i>
                        Additional Stores/Warehouse
                    </a>
                </li>
                <li>
                    <a href="{{ route('company.teams.list') }}" class="mm-@yield('teams-active')">
                        <i class="metismenu-icon pe-7s-display2"></i>
                        Teams
                    </a>
                </li>
                <li>
                    <a href="{{ route('company.labour.list') }}" class="mm-@yield('labour-active')">
                        <i class="metismenu-icon pe-7s-display2"></i>
                        Labours
                    </a>
                </li>
                <li>
                    <a href="{{ route('company.assets.list') }}" class="mm-@yield('assets-active')">
                        <i class="metismenu-icon pe-7s-display2"></i>
                        Assets/Equipments
                    </a>
                </li>
                <li>
                    <a href="{{ route('company.vendor.list') }}" class="mm-@yield('vendor-active')">
                        <i class="metismenu-icon pe-7s-display2"></i>
                        Vendors
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="metismenu-icon pe-7s-display2"></i>
                        Activities
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="metismenu-icon pe-7s-display2"></i>
                        Meterials
                    </a>
                </li>



                <li class="app-sidebar__heading">User Management</li>
                <li>
                    <a href="#">
                        <i class="metismenu-icon pe-7s-users"></i>
                        Admin Users
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul>
                        <li>
                            <a href="admin-users.html">
                                <i class="metismenu-icon"></i>
                                Manage Admin Users
                            </a>
                        </li>
                        <li>
                            <a href="admin-roles.html">
                                <i class="metismenu-icon">
                                </i>Admin User Roles and Permissions
                            </a>
                        </li>

                    </ul>
                </li>
                <li>
                    <a href="#">
                        <i class="metismenu-icon pe-7s-car"></i>
                        Manage Companies
                    </a>

                </li>
                <li>
                    <a href="service-providers.html">
                        <i class="metismenu-icon pe-7s-display2"></i>
                        Manage Project Managers
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="metismenu-icon pe-7s-car"></i>
                        Manage Site Engineer
                    </a>

                </li>
                <li>
                    <a href="#">
                        <i class="metismenu-icon pe-7s-display2"></i>
                        Manage Store Keepers
                    </a>
                </li>


                <li class="app-sidebar__heading">Reports</li>
                <li>
                    <a href="#">
                        <i class="metismenu-icon pe-7s-mouse">
                        </i>Subscription Transactions Report
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="metismenu-icon pe-7s-mouse">
                        </i>User Report
                    </a>
                </li>

                <li class="app-sidebar__heading">Notifications</li>
                <li>
                    <a href="#">
                        <i class="metismenu-icon pe-7s-mouse">
                        </i>Notifications
                    </a>
                </li>
                <li class="app-sidebar__heading">Log Out</li>
                <li>
                    <a href="#">
                        <i class="metismenu-icon pe-7s-eyedropper">
                        </i>Log Out
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
