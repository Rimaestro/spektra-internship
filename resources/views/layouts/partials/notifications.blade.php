<!-- Notification Component -->
<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" id="navbarDropdownNotifications" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="fas fa-bell"></i>
        @if($unreadNotifications > 0)
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                {{ $unreadNotifications > 99 ? '99+' : $unreadNotifications }}
                <span class="visually-hidden">notifikasi belum dibaca</span>
            </span>
        @endif
    </a>
    <ul class="dropdown-menu dropdown-menu-end notifications-dropdown" aria-labelledby="navbarDropdownNotifications">
        <div class="notifications-header d-flex justify-content-between align-items-center p-3 border-bottom">
            <h6 class="m-0 fw-bold">Notifikasi</h6>
            @if($unreadNotifications > 0)
                <a href="{{ route('notifications.mark-all-read') }}" class="text-decoration-none small text-primary">
                    Tandai semua dibaca
                </a>
            @endif
        </div>
        
        <div class="notifications-body" style="max-height: 350px; overflow-y: auto;">
            @forelse($notifications as $notification)
                <li>
                    <a class="dropdown-item notification-item p-3 {{ $notification->read_at ? '' : 'unread' }}" href="{{ route('notifications.show', $notification->id) }}">
                        <div class="d-flex align-items-start">
                            <div class="notification-icon me-3">
                                @switch($notification->type)
                                    @case('internship_status')
                                        <div class="icon-circle bg-primary">
                                            <i class="fas fa-briefcase text-white"></i>
                                        </div>
                                        @break
                                    @case('daily_report')
                                        <div class="icon-circle bg-success">
                                            <i class="fas fa-file-alt text-white"></i>
                                        </div>
                                        @break
                                    @case('evaluation')
                                        <div class="icon-circle bg-info">
                                            <i class="fas fa-clipboard-check text-white"></i>
                                        </div>
                                        @break
                                    @case('supervisor_assigned')
                                        <div class="icon-circle bg-warning">
                                            <i class="fas fa-user-tie text-white"></i>
                                        </div>
                                        @break
                                    @case('final_report')
                                        <div class="icon-circle bg-danger">
                                            <i class="fas fa-file-pdf text-white"></i>
                                        </div>
                                        @break
                                    @default
                                        <div class="icon-circle bg-secondary">
                                            <i class="fas fa-bell text-white"></i>
                                        </div>
                                @endswitch
                            </div>
                            <div class="notification-content flex-grow-1">
                                <div class="small text-muted">
                                    {{ $notification->created_at->diffForHumans() }}
                                    @if(!$notification->read_at)
                                        <span class="badge bg-danger ms-1">Baru</span>
                                    @endif
                                </div>
                                <p class="mb-1 notification-title">{{ $notification->title }}</p>
                                <p class="mb-0 small text-muted notification-text">{{ Str::limit($notification->message, 100) }}</p>
                            </div>
                        </div>
                    </a>
                </li>
                @if(!$loop->last)
                    <li><hr class="dropdown-divider m-0"></li>
                @endif
            @empty
                <li>
                    <div class="dropdown-item p-3 text-center text-muted">
                        <i class="fas fa-bell-slash mb-2"></i>
                        <p class="mb-0">Tidak ada notifikasi</p>
                    </div>
                </li>
            @endforelse
        </div>
        
        <div class="notifications-footer p-2 text-center border-top">
            <a href="{{ route('notifications.index') }}" class="text-decoration-none">Lihat semua notifikasi</a>
        </div>
    </ul>
</li>

<style>
.notifications-dropdown {
    width: 350px;
    padding: 0;
}
.notification-icon .icon-circle {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}
.notification-item.unread {
    background-color: rgba(13, 110, 253, 0.05);
}
.notification-item:hover {
    background-color: rgba(13, 110, 253, 0.1);
}
.notification-title {
    font-weight: 500;
}
@media (max-width: 576px) {
    .notifications-dropdown {
        width: 300px;
    }
}
</style> 