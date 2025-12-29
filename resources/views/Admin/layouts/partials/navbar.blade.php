<div class="app-header header-shadow">
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
    <div class="app-header__content">
        <div class="app-header-left">
            <ul class="header-menu nav">
                <li class="nav-item">
                    <a href="{{ route('admin.home') }}" class="nav-link">
                        <i class="nav-link-icon fa fa-database"></i>
                        Dashboard
                    </a>
                </li>
                <li class="dropdown nav-item">
                    <a href="{{ route('admin.setting.contactDetails') }}" class="nav-link btn-open-options">
                        <i class="nav-link-icon fa fa-cog"></i>
                        Settings
                    </a>
                </li>
            </ul>
        </div>
        <div class="app-header-right">
            <div class="header-btn-lg pr-0">
                <div class="widget-content p-0">
                    <div class="widget-content-wrapper">
                        <div class="widget-content-left">
                            <div class="btn-group">
                                <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="p-0 btn">
                                    <img width="42" class="rounded-circle"
                                        src="{{ asset('assets/images/avatars/4.jpg') }}" alt="">
                                    <i class="fa fa-angle-down ml-2 opacity-8"></i>
                                </a>
                                <div tabindex="-1" role="menu" aria-hidden="true"
                                    class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="{{ route('admin.profile') }}">
                                        <i class="fa mr-1" aria-hidden="true"></i> My Account
                                    </a>
                                    <a class="dropdown-item editPassword" data-uuid="{{ auth()->user()->uuid }}"
                                        href="{{ route('admin.passwordUpdate', auth()->user()->uuid) }}">
                                        <i class="fa mr-1" aria-hidden="true"></i> Password Update
                                    </a>
                                    <div tabindex="-1" class="dropdown-divider"></div>
                                    <a href="{{ route('admin.logout') }}" class="dropdown-item">Logout</a>
                                </div>
                            </div>
                        </div>
                        <div class="widget-content-left ml-3 header-user-info">
                            <div class="widget-heading">
                                {{ auth()->user()->role->name }}
                            </div>
                            <div class="widget-subheading">
                                {{ auth()->user()->first_name }}
                            </div>
                        </div>
                        <div class="widget-content-right header-user-info ml-3"></div>
                    </div>
                </div>
            </div>
            @php
                $notifications = fetchAdminNotifaction();
                $notificationCount = $notifications->count();
            @endphp

            <!-- Notification Bell Icon -->
            <div class="header-btn-lg pr-0">
                <div class="widget-content p-0">
                    <div class="widget-content-wrapper">
                        <div class="widget-content-left">
                            <div class="btn-group notification-bell">
                                <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="p-2 btn"
                                    title="Notifications">
                                    <i class="fa fa-bell fa-lg">
                                        <span
                                            class="badge badge-pill badge-danger notification-badge">{{ $notificationCount }}</span>
                                    </i>
                                </a>
                                <div tabindex="-1" role="menu" aria-hidden="true"
                                    class="dropdown-menu dropdown-menu-right" style="width: 300px;">
                                    <h6 class="dropdown-header">Notifications</h6>
                                    @if ($notificationCount > 0)
                                        @foreach ($notifications as $notification)
                                            <a class="dropdown-item" href="#">
                                                <strong>{{ $notification->message }}</strong>
                                                <p class="notification-details">{{ $notification->details }}</p>
                                                {{-- <p class="notification-remarks text-muted">{{ $notification->remarks }} --}}
                                                </p>
                                            </a>
                                        @endforeach
                                    @else
                                        <div class="dropdown-item text-center text-muted">No new notifications</div>
                                    @endif
                                    <div tabindex="-1" class="dropdown-divider"></div>
                                    <a class="dropdown-item text-center" href="#">View all notifications</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>






{{-- <div class="app-header header-shadow">
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
    <div class="app-header__content">
        <div class="app-header-left">

            <ul class="header-menu nav">
                <li class="nav-item">
                    <a href="{{ route('admin.home') }}" class="nav-link">
                        <i class="nav-link-icon fa fa-database"> </i>
                        Dashboard
                    </a>
                </li>
                <li class="dropdown nav-item">
                    <a href="{{ route('admin.setting.contactDetails') }}" class="nav-link btn-open-options">
                        <i class="nav-link-icon fa fa-cog"></i>
                        Settings
                    </a>
                </li>
            </ul>
        </div>
        <div class="app-header-right">
            <div class="header-btn-lg pr-0">
                <div class="widget-content p-0">
                    <div class="widget-content-wrapper">
                        <div class="widget-content-left">
                            <div class="btn-group">
                                <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="p-0 btn">
                                    <img width="42" class="rounded-circle"
                                        src="{{ asset('assets/images/avatars/4.jpg') }}" alt="">
                                    <i class="fa fa-angle-down ml-2 opacity-8"></i>
                                </a>
                                <div tabindex="-1" role="menu" aria-hidden="true"
                                    class="dropdown-menu dropdown-menu-right">

                                    <a class="dropdown-item " href="{{ route('admin.profile') }}"><i class="fa mr-1"
                                            aria-hidden="true">My Account</i></a>


                                    <a class="dropdown-item editPassword" data-uuid="{{ auth()->user()->uuid }}"
                                        href="{{ route('admin.passwordUpdate', auth()->user()->uuid) }}"><i
                                            class="fa mr-1" aria-hidden="true">Password
                                            Update</i></a>

                                    <div tabindex="-1" class="dropdown-divider"></div>
                                    <a href="{{ route('admin.logout') }}" class="dropdown-item">Logout</a>

                                </div>
                            </div>
                        </div>

                        <div class="widget-content-left  ml-3 header-user-info">
                            <div class="widget-heading">
                                {{ auth()->user()->role->name }}
                            </div>
                            <div class="widget-subheading">
                                {{ auth()->user()->first_name }}
                            </div>

                        </div>
                        <div class="widget-content-right header-user-info ml-3">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}

{{-- <div class="ui-theme-settings">
    <div class="theme-settings__inner">
        <div class="scrollbar-container">
            <div class="theme-settings__options-wrapper">
                <h3 class="themeoptions-heading">General Settings
                </h3>
                <div class="p-3">
                    <form>
                        <ul class="list-group">

                            <li class="list-group-item">
                                <div class="widget-content p-0">
                                    <div class="">
                                        <div class="form-row">
                                            <div class="col-md-12">
                                                <div class="position-relative form-group"><label for="Name"
                                                        class="">Site Title</label><input name="site-name"
                                                        id="site-name" placeholder="Enter Site Title" value="Koncite"
                                                        type="text" class="form-control"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="widget-content p-0">
                                    <div class="widget-content-wrapper">
                                        <div class="form-row">
                                            <div class="col-md-12">
                                                <div class="position-relative form-group"><label for="Name"
                                                        class="">Update Logo</label><input name="site-logo"
                                                        id="site-logo" type="file" class="form-control"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="widget-content p-0">
                                    <div class="">
                                        <div class="form-row">
                                            <div class="col-md-12">
                                                <div class="position-relative form-group"><label for="Admin Email"
                                                        class="">Admin Contact
                                                        Email</label><input name="admin-contact-email"
                                                        id="admin-contact-email" value="admin@Koncite.in" type="email"
                                                        class="form-control"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="widget-content p-0">
                                    <div class="">
                                        <div class="form-row">
                                            <div class="col-md-12">
                                                <div class="position-relative form-group"><button
                                                        class="mt-2 btn btn-primary">Update</button></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </form>
                </div>
                <h3 class="themeoptions-heading">
                    <div>
                        Payment Settings
                    </div>

                </h3>
                <div class="p-3">
                    <form>
                        <ul class="list-group">

                            <li class="list-group-item">
                                <div class="widget-content p-0">
                                    <div class="">
                                        <div class="form-row">
                                            <div class="col-md-12">
                                                <div class="position-relative form-group"><label for="API Key"
                                                        class="">Razor Pay API Key</label><input name="api-key"
                                                        id="api-key" placeholder="Enter Site Title"
                                                        value="XUA12398093123AD4334243213KUlL0765456" type="text"
                                                        class="form-control"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            <li class="list-group-item">
                                <div class="widget-content p-0">
                                    <div class="">
                                        <div class="form-row">
                                            <div class="col-md-12">
                                                <div class="position-relative form-group"><label for="API Secret"
                                                        class="">Rajor Pay API
                                                        Secret</label><input name="api-secret" id="api-secret"
                                                        value="DSAD=!dkjasdjkn319121239y731273891239873kjdasdakda---0=@@udsajhaj"
                                                        type="text" class="form-control"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="widget-content p-0">
                                    <div class="">
                                        <div class="form-row">
                                            <div class="col-md-12">
                                                <div class="position-relative form-group"><button
                                                        class="mt-2 btn btn-primary">Update</button></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div> --}}
