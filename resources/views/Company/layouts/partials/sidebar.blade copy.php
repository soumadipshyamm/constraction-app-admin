<div class="app-sidebar sidebar-shadow">
    <!-- Sidebar Logo -->
    <div class="app-header__logo">
        @php
            $kj = Auth::guard('company')->user()->companyUserRole;
            $isSubscribed = isSubscribedFree();
        @endphp
        @if ($isSubscribed)
            <div class="widget-content-left widget_profile">
                <div class="p-0 btn prol_img">
                    <img class="rounded-circle" src="{{ asset('company_assets/images/user.png') }}" alt="User Profile">
                    <h6 class="widget-heading">
                        {{ auth()->guard('company')->user()->name ?? 'Guest' }}
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
        @endif
    </div>

    <div class="scrollbar-sidebar">
        <div class="app-sidebar__inner">
            @if ($isSubscribed)
                <ul class="vertical-nav-menu">
                    @php
                        $user = auth()->guard('company')->user();
                        $userRoleId = $user->company_role_id ?? null;
                        $userId = $user->id ?? null;
                        // Helper function to check permissions
                        $hasPermission = function ($permission) use ($userRoleId, $userId) {
                            return checkCompanyPermissions($permission, $userRoleId, $userId, 'view');
                        };
                    @endphp

                    {{-- Dashboard Section --}}
                    @if ($hasPermission('dashboard'))
                        <li class="app-sidebar__heading">Dashboard</li>
                        <li class="{{ request()->routeIs('company.home') ? 'active' : '' }}">
                            <a href="{{ route('company.home') }}" class="mm-@yield('dashboard-active')">
                                <span>
                                    <img src="{{ asset('company_assets/images/side-icon/dashboard.svg') }}"
                                        class="img-fluid" alt="Dashboard">
                                </span>
                                Dashboard
                            </a>
                        </li>
                    @endif

                    {{-- Master Section --}}
                    @if ($hasPermission('master'))
                        @php
                            $masterRoutes = [
                                'company.companies.*',
                                'company.project.*',
                                'company.subProject.*',
                                'company.profileDesignation.*',
                                'company.units.*',
                                'company.storeWarehouse.*',
                                'company.labour.*',
                                'company.assets.*',
                                'company.vendor.*',
                                'company.activities.*',
                                'company.materials.*',
                            ];

                            $masterItems = [
                                [
                                    'permission' => 'companies',
                                    'route' => 'company.companies.list',
                                    'icon' => '<i class="fa-regular fa-building fa-lg"></i>',
                                    'label' => 'Companies',
                                    'yield' => 'company-active',
                                ],
                                [
                                    'permission' => 'projects',
                                    'route' => 'company.project.list',
                                    'icon' => '<i class="fas fa-code-branch"></i>',
                                    'label' => 'Projects',
                                    'yield' => 'project-active',
                                ],
                                [
                                    'permission' => 'subproject',
                                    'route' => 'company.subProject.list',
                                    'icon' => '<i class="fas fa-sitemap"></i>',
                                    'label' => 'Subproject',
                                    'yield' => 'subProject-active',
                                ],
                                [
                                    'permission' => 'units',
                                    'route' => 'company.units.list',
                                    'icon' => '<i class="fa fa-balance-scale" aria-hidden="true"></i>',
                                    'label' => 'Units',
                                    'yield' => 'units-active',
                                ],
                                [
                                    'permission' => 'warehouses',
                                    'route' => 'company.storeWarehouse.list',
                                    'icon' => '<i class="fa fa-warehouse"></i>',
                                    'label' => 'Warehouses',
                                    'yield' => 'storeWarehouse-active',
                                ],
                                [
                                    'permission' => 'labours',
                                    'route' => 'company.labour.list',
                                    'icon' => '<i class="fa fa-users"></i>',
                                    'label' => 'Labours',
                                    'yield' => 'labour-active',
                                ],
                                [
                                    'permission' => 'assets-equipments',
                                    'route' => 'company.assets.list',
                                    'icon' => '<i class="fas fa-tools"></i>',
                                    'label' => 'Assets Equipments',
                                    'yield' => 'assets-active',
                                ],
                                [
                                    'permission' => 'vendors',
                                    'route' => 'company.vendor.list',
                                    'icon' => '<i class="fa fa-industry" aria-hidden="true"></i>',
                                    'label' => 'Vendors',
                                    'yield' => 'vendor-active',
                                ],
                                [
                                    'permission' => 'activities',
                                    'route' => 'company.activities.list',
                                    'icon' => '<i class="fa fa-tasks"></i>',
                                    'label' => 'Activities',
                                    'yield' => 'activities-active',
                                ],
                                [
                                    'permission' => 'materials',
                                    'route' => 'company.materials.list',
                                    'icon' => '<i class="fa fa-tools"></i>',
                                    'label' => 'Materials',
                                    'yield' => 'materials-active',
                                ],
                            ];
                        @endphp

                        <li class="app-sidebar__heading">Master</li>
                        <li class="app-sidebar__heading app_submenu">
                            <a href="#">
                                <span>
                                    <img src="{{ asset('company_assets/images/side-icon/master.svg') }}"
                                        class="img-fluid" alt="Masters">
                                </span>
                                Masters
                            </a>
                            <ul class="{{ isActiveRoute($masterRoutes, 'mm-collapse mm-show') }}">
                                @foreach ($masterItems as $item)
                                    @if ($hasPermission($item['permission']))
                                        <li class="{{ request()->routeIs($item['route']) ? 'active' : '' }}">
                                            <a href="{{ route($item['route']) }}" class="mm-@yield($item['yield'])">
                                                <span>{!! $item['icon'] !!}</span>
                                                {{ $item['label'] }}
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </li>
                    @endif

                    {{-- User Management Section --}}
                    @if ($hasPermission('user-managment'))
                        @php
                            $userManagementRoutes = ['company.userManagment.*', 'company.roleManagment.*'];

                            $userManagementItems = [
                                [
                                    'permission' => 'manage-teams',
                                    'route' => 'company.userManagment.list',
                                    'icon' => '<i class="fa-solid fa-people-group"></i>',
                                    'label' => 'Manage Teams',
                                    'yield' => 'user-active',
                                ],
                                [
                                    'permission' => 'user-roles-and-permissions',
                                    'route' => 'company.roleManagment.list',
                                    'icon' => '<i class="fa-solid fa-address-book"></i>',
                                    'label' => 'User Roles and Permissions',
                                    'yield' => 'role-active',
                                ],
                            ];
                        @endphp

                        <li class="app-sidebar__heading">User Management</li>
                        <li class="app-sidebar__heading app_submenu">
                            <a href="#">
                                <span>
                                    <img src="{{ asset('company_assets/images/side-icon/master.svg') }}"
                                        class="img-fluid" alt="Company Users">
                                </span>
                                Company Users
                            </a>
                            <ul class="{{ isActiveRoute($userManagementRoutes, 'mm-collapse mm-show') }}">
                                @foreach ($userManagementItems as $item)
                                    @if ($hasPermission($item['permission']))
                                        <li class="{{ request()->routeIs($item['route']) ? 'active' : '' }}">
                                            <a href="{{ route($item['route']) }}" class="mm-@yield($item['yield'])">
                                                {!! $item['icon'] !!}
                                                {{ $item['label'] }}
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </li>
                    @endif

                    {{-- PR Management Section --}}
                    @php
                        $prManagementItems = [
                            [
                                'permission' => 'pr-approval-manage',
                                'route' => 'company.pr.approval.add',
                                'icon' => '<i class="fa-regular fa-square-check"></i>',
                                'label' => 'PR Approval Manage',
                                'yield' => 'pr-management-active',
                            ],
                            [
                                'permission' => 'pr',
                                'route' => 'company.pr.list',
                                'icon' => '<i class="fa-solid fa-bars"></i>',
                                'label' => 'PR',
                                'yield' => 'purch-request-active',
                            ],
                        ];

                        $hasPRPermissions = collect($prManagementItems)->some(function ($item) use ($hasPermission) {
                            return $hasPermission($item['permission']);
                        });
                    @endphp

                    @if ($hasPRPermissions)
                        <li class="app-sidebar__heading">PR Management</li>
                        @foreach ($prManagementItems as $item)
                            @if ($hasPermission($item['permission']))
                                <li class="{{ request()->routeIs($item['route']) ? 'active' : '' }}">
                                    <a href="{{ route($item['route']) }}" class="mm-@yield($item['yield'])">
                                        {!! $item['icon'] !!}
                                        {{ $item['label'] }}
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    @endif

                    {{-- Reports Section --}}
                    @php
                        $hasWorkProgressReports = $hasPermission('work-progress-reports');
                        $hasInventoryReports = $hasPermission('inventory-reports');
                        $hasAnyReports = $hasWorkProgressReports || $hasInventoryReports;
                    @endphp

                    @if ($hasAnyReports)
                        <li class="app-sidebar__heading">Reports</li>

                        {{-- Work Progress Reports --}}
                        @if ($hasWorkProgressReports)
                            @php
                                $workProgressRoutes = [
                                    'company.report.workProgressDetails',
                                    'company.report.dprDetails',
                                    'company.report.resourcesUsageFromDPR',
                                    'company.report.matrialusedVsStoreIssue',
                                ];

                                $workProgressItems = [
                                    [
                                        'route' => 'company.report.workProgressDetails',
                                        'icon' => '<i class="fa-solid fa-arrow-trend-up"></i>',
                                        'label' => 'Work Progress Details',
                                        'yield' => 'workProgressDetails-active',
                                    ],
                                    [
                                        'route' => 'company.report.dprDetails',
                                        'icon' => '<i class="fas fa-chart-line"></i>',
                                        'label' => 'DPR',
                                        'yield' => 'dpr-active',
                                    ],
                                    [
                                        'route' => 'company.report.resourcesUsageFromDPR',
                                        'icon' => '<i class="fa-solid fa-users"></i>',
                                        'label' => 'Resources Usage From DPR',
                                        'yield' => 'resourcesUsageFromDPR-active',
                                    ],
                                    [
                                        'route' => 'company.report.matrialusedVsStoreIssue',
                                        'icon' => '<i class="fa-solid fa-truck-monster"></i>',
                                        'label' => 'Material Used Vs Store Issue',
                                        'yield' => 'matrialusedVsStoreIssue-active',
                                    ],
                                ];
                            @endphp

                            <li class="app-sidebar__heading app_submenu">
                                <a href="#">
                                    <span>
                                        <img src="{{ asset('company_assets/images/side-icon/master.svg') }}"
                                            class="img-fluid" alt="Work Progress Reports">
                                    </span>
                                    Work Progress Reports
                                </a>
                                <ul class="{{ isActiveRoute($workProgressRoutes, 'mm-collapse mm-show') }}">
                                    @foreach ($workProgressItems as $item)
                                        <li class="{{ request()->routeIs($item['route']) ? 'active' : '' }}">
                                            <a href="{{ route($item['route']) }}" class="mm-@yield($item['yield'])">
                                                {!! $item['icon'] !!}
                                                {{ $item['label'] }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @endif

                        {{-- Inventory Reports --}}
                        @if ($hasInventoryReports)
                            @php
                                $inventoryRoutes = [
                                    'company.report.inventorypr',
                                    'company.report.rfq',
                                    'company.report.grnSlip',
                                    'company.report.grnDetails',
                                    'company.report.issueSlip',
                                    'company.report.issueDetails',
                                    'company.report.issueReturn',
                                    'company.report.globalStockDetails',
                                    'company.report.stockStatement',
                                ];

                                $inventoryItems = [
                                    [
                                        'route' => 'company.report.inventorypr',
                                        'icon' => '<i class="fa-solid fa-truck-fast"></i>',
                                        'label' => 'PR',
                                        'yield' => 'inventorypr-active',
                                    ],
                                    [
                                        'route' => 'company.report.rfq',
                                        'icon' => '<i class="fa-solid fa-truck"></i>',
                                        'label' => 'RFQ',
                                        'yield' => 'rfq-active',
                                    ],
                                    [
                                        'route' => 'company.report.grnSlip',
                                        'icon' => '<i class="fa-solid fa-receipt"></i>',
                                        'label' => 'GRN (MRN) Slip',
                                        'yield' => 'grnSlip-active',
                                    ],
                                    [
                                        'route' => 'company.report.grnDetails',
                                        'icon' => '<i class="fa-solid fa-list"></i>',
                                        'label' => 'GRN (MRN) Details',
                                        'yield' => 'grnDetails-active',
                                    ],
                                    [
                                        'route' => 'company.report.issueSlip',
                                        'icon' => '<i class="fas fa-shopping-basket"></i>',
                                        'label' => 'ISSUE Slip',
                                        'yield' => 'issueSlip-active',
                                    ],
                                    [
                                        'route' => 'company.report.issueDetails',
                                        'icon' => '<i class="fa-solid fa-check-to-slot"></i>',
                                        'label' => 'Issue (Outward) Details',
                                        'yield' => 'issueDetails-active',
                                    ],
                                    [
                                        'route' => 'company.report.issueReturn',
                                        'icon' => '<i class="fa-solid fa-bezier-curve"></i>',
                                        'label' => 'Issue Return',
                                        'yield' => 'issueReturn-active',
                                    ],
                                    [
                                        'route' => 'company.report.globalStockDetails',
                                        'icon' => '<i class="fa-solid fa-folder-open"></i>',
                                        'label' => 'Global Stock Details',
                                        'yield' => 'GlobalProjectStock-active',
                                    ],
                                    [
                                        'route' => 'company.report.stockStatement',
                                        'icon' => '<i class="fa-solid fa-box"></i>',
                                        'label' => 'Project Stock Statement',
                                        'yield' => 'ProjectStockStatement-active',
                                    ],
                                ];
                            @endphp

                            <li class="app-sidebar__heading app_submenu">
                                <a href="#">
                                    <span>
                                        <img src="{{ asset('company_assets/images/side-icon/master.svg') }}"
                                            class="img-fluid" alt="Inventory Reports">
                                    </span>
                                    Inventory Reports
                                </a>
                                <ul class="{{ isActiveRoute($inventoryRoutes, 'mm-collapse mm-show') }}">
                                    @foreach ($inventoryItems as $item)
                                        <li class="{{ request()->routeIs($item['route']) ? 'active' : '' }}">
                                            <a href="{{ route($item['route']) }}" class="mm-@yield($item['yield'])">
                                                {!! $item['icon'] !!}
                                                {{ $item['label'] }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @endif
                    @endif

                    {{-- @if ($kj->slug == 'super-admin') --}}
                    @if ($hasPermission('subscription'))
                        {{-- @dd( $kj->slug) --}}
                        {{-- Render Subscription --}}
                        {{-- @if (isset($menuStructure['subscription']) && $hasPermission($menuStructure['subscription']['permission'])) --}}

                        <li class="app-sidebar__heading">
                            <a href="{{ route('company.subscription.scriptionlist') }}">
                                <span>
                                    <img src="{{ asset('company_assets/images/side-icon/offers.svg') }}"
                                        class="img-fluid" alt="">
                                </span>
                                Subscription
                            </a>
                        </li>
                    @endif
                    {{-- @endif --}}

                    <li class="app-sidebar__heading">
                        <a href="{{ route('company.logout') }}" class="dropdown-item">
                            <span>
                                <img src="{{ asset('company_assets/images/side-icon/logout.svg') }}" class="img-fluid"
                                    alt="">
                            </span>
                            Logout
                        </a>
                    </li>
                </ul>
            @endif
        </div>
    </div>
</div>




