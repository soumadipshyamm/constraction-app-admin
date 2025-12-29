<li class="dropdown dropdown-notification nav-item">
    <a class="nav-link nav-link-label" href="#" data-toggle="dropdown"><i class="ficon ft-bell"></i>
        <span
            class="badge badge-pill badge-default badge-danger badge-default badge-up">{{ $notifications?->count() }}</span>
    </a>
    <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
        <li class="dropdown-menu-header">
            <h6 class="dropdown-header m-0"><span class="grey darken-2">Notifications</span></h6>
            <span
                class="notification-tag badge badge-default badge-danger float-right m-0">{{ $notifications?->count() }}
                New</span>
        </li>
        <li class="scrollable-container media-list w-100">
            @forelse ($notifications as $notification)
                <a href="javascript:void(0)">
                    <div class="media">
                        <div class="media-left align-self-center"><i class="ft-plus-square icon-bg-circle bg-cyan"></i>
                        </div>
                        <div class="media-body">
                            <h6 class="media-heading">{{ $notification->type }}</h6>
                            <p class="notification-text font-small-3 text-muted">{!! $notification->data !!}</p><small>
                                <time class="media-meta text-muted"
                                    datetime="2015-06-11T18:29:20+08:00">{{ $notification->created_at->diffForHumans() }}</time></small>
                        </div>
                    </div>
                </a>
            @empty
                <a href="javascript:void(0)">
                    <div class="media">
                        <p class="notification-text font-small-3 text-muted">No new notifications</p>
                    </div>
                </a>
            @endforelse

        </li>
        @if (auth()->user()->unreadNotifications()->count())
            <li class="dropdown-menu-footer">
                <a class="dropdown-item text-muted text-center  markAsRead" href="javascript:void(0)">Read all
                    notifications</a>
            </li>
        @endif
    </ul>
</li>
