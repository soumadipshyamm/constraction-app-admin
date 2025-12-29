<div class="app-sidebar sidebar-shadow">
    <div class="app-header__logo">
        <div class="logo-src"></div>
        <div class="header__pane ml-auto">
            <div>
                <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
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
                @if (checkAdminPermissions('dashboard', auth()->user()->admin_role_id, auth()->user()->id, 'view'))
                    <li class="app-sidebar__heading">Dashboard</li>
                    <li>
                        <a href="{{ route('admin.home') }}" class="mm-@yield('dashboard-active')">
                            <i class="metismenu-icon pe-7s-rocket"></i>
                            Dashboard
                        </a>
                    </li>
                @endif
                @if (checkAdminPermissions('admin-user', auth()->user()->admin_role_id, auth()->user()->id, 'view'))

                    <li class="app-sidebar__heading">User Management</li>
                    <li>
                        <a href="#" class=" mm-@yield('user-active')">
                            <i class="metismenu-icon pe-7s-users"></i>
                            Admin Users
                            <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                        </a>
                        <ul>

                            <li>
                                <a href="{{ route('admin.userManagment.list') }}" class="mm-@yield('user-active')">
                                    <i class="metismenu-icon"></i>
                                    Manage Admin Users
                                </a>
                            </li>

                            @if (checkAdminPermissions('admin-role-permissions', auth()->user()->admin_role_id, auth()->user()->id, 'view'))
                                <li>
                                    <a href="{{ route('admin.roleManagment.list') }}" class="mm-@yield('role-active')">
                                        <i class="metismenu-icon">
                                        </i>Admin User Roles Permissions
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if (checkAdminPermissions('admin-company', auth()->user()->admin_role_id, auth()->user()->id, 'view'))
                    <li>
                        <a href="#" class="mm-@yield('company-active')">
                            <i class="metismenu-icon pe-7s-car"></i>
                            Manage Companies
                            <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                        </a>
                        <ul class="@yield('company-collapse')">
                            <li>
                                <a href="{{ route('admin.companyManagment.list') }}" class="mm-@yield('company-active')">
                                    <i class="metismenu-icon pe-7s-car"></i>
                                    Manage Companies
                                </a>
                            </li>

                            {{-- <li>
                            <a href="" class="mm-@yield('site-engineer-active')">
                                <i class="metismenu-icon pe-7s-car"></i>
                                Manage Site Engineer
                            </a>
                        </li>

                        <li>
                            <a href="#" class="mm-@yield('project-active')">
                                <i class="metismenu-icon pe-7s-display2"></i>
                                Manage Project Managers
                            </a>
                        </li>

                        <li>
                            <a href="#" class="mm-@yield('store-active')">
                                <i class="metismenu-icon pe-7s-display2"></i>
                                Manage Store Keepers
                            </a>
                        </li> --}}
                        </ul>
                    </li>
                @endif
                @if (checkAdminPermissions('admin-management-pages', auth()->user()->admin_role_id, auth()->user()->id, 'view'))
                    <li class="app-sidebar__heading">Content Management</li>
                    {{-- <li>
                    <a href="#" class="mm-@yield('page-active')">
                        <i class="metismenu-icon pe-7s-display2"></i>
                        Pages Manage
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul> --}}
                    <li>
                        <a href="{{ route('admin.pageManagment.list') }}" class="mm-@yield('site-page-active')">
                            <i class="metismenu-icon pe-7s-display2"></i>
                            Site Pages Managment
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.homePage.list') }}" class="mm-@yield('home-page-active')">
                            <i class="metismenu-icon pe-7s-display2"></i>
                            Home Page Managment
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.bannerManagment.list') }}" class="mm-@yield('banner-active')">
                            <i class="metismenu-icon pe-7s-display2"></i>
                            Banner Managment
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.menuManagment.list') }}" class="mm-@yield('menu-managment-active')">
                            <i class="metismenu-icon pe-7s-display2"></i>
                            Menu Manage
                        </a>
                    </li>
                @endif
                <li class="app-sidebar__heading">Subscription Management</li>
                <li>
                    <a href="{{ route('admin.subscription.list') }}" class="mm-@yield('subscription-managment-active')">
                        <i class="metismenu-icon pe-7s-display2"></i>
                        Subscription management
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.additionalFeatures.list') }}" class="mm-@yield('additional-purchase-active')">
                        <i class="metismenu-icon pe-7s-display2"></i>
                        Additional Purchase
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.transactions.list') }}" class="mm-@yield('subscription-transactions-active')">
                        <i class="metismenu-icon pe-7s-mouse">
                        </i>Subscription Transactions
                    </a>
                </li>
                <li class="app-sidebar__heading">Report</li>
                <li>
                    <a href="{{ route('admin.setting.contactReport') }}" class="mm-@yield('contact-report-active')">
                        <i class="metismenu-icon pe-7s-config"></i>
                        Contact Report
                    </a>
                </li>
                <li class="app-sidebar__heading">Settings</li>
                <li>
                    <a href="{{ route('admin.setting.contactDetails') }}" class="mm-@yield('contact-details-active')">
                        <i class="metismenu-icon pe-7s-config"></i>
                        Contact Details
                    </a>
                </li>

                {{-- <li>
                    <a href="{{ route('setting.list') }}" class="mm-@yield('setting-active')">
                <i class="metismenu-icon pe-7s-config"></i>
                Settings
                </a>
                </li> --}}

                <!-- <li class="app-sidebar__heading">Reports</li>
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
                </li> -->

                {{-- <li class="app-sidebar__heading">Notifications</li> --}}
                {{-- <li>
                    <a href="#">
                        <i class="metismenu-icon pe-7s-mouse">
                        </i>Notifications
                    </a>
                </li> --}}
                <li class="app-sidebar__heading">Log Out</li>
                <li>
                    <a href="{{ route('admin.logout') }}" class="dropdown-item">

                        <i class="metismenu-icon pe-7s-eyedropper">
                        </i>Log Out
                    </a>
                </li>
            </ul>
        </div>
    </div>




















</div>
