<div class="navbar-shapes">
    <div class="shape-1"></div>
    <div class="shape-2"></div>
</div>
<nav class="navbar navbar-expand-md navbar-dark sticky-top navbar-glassmorphism">
    <div class="container-fluid">
        <a class="navbar-brand logo-animated" href="{{ route('dashboard') }}">
            <div class="logo-container">
                <img src="{{ asset('images/logo.png') }}" alt="SPEKTRA Logo" width="30" height="30" class="d-inline-block align-text-top me-2">
                <span class="brand-text">SPEKTRA</span>
            </div>
        </a>
        <button class="navbar-toggler custom-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <!-- Left Side Navbar -->
            <ul class="navbar-nav me-auto mb-2 mb-md-0">
                @auth
                    <li class="nav-item">
                        <a class="nav-link nav-link-hover {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>
                    </li>
                @endauth
            </ul>

            <!-- Right Side Navbar -->
            <ul class="navbar-nav ms-auto">
                @guest
                    <!-- Login Link -->
                    <li class="nav-item">
                        <a class="nav-link nav-link-hover {{ request()->routeIs('login') ? 'active' : '' }}" href="{{ route('login') }}">
                            <i class="bi bi-box-arrow-in-right"></i> Login
                        </a>
                    </li>
                    <!-- Register Link -->
                    <li class="nav-item">
                        <a class="nav-link nav-link-hover {{ request()->routeIs('register') ? 'active' : '' }}" href="{{ route('register') }}">
                            <i class="bi bi-person-plus"></i> Register
                        </a>
                    </li>
                @else
                    <!-- Notifications -->
                    <li class="nav-item dropdown">
                        <a class="nav-link nav-link-hover" href="#" id="notificationsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-bell notification-icon"></i>
                            <span class="badge notification-badge rounded-pill">0</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-glassmorphism" aria-labelledby="notificationsDropdown">
                            <li><h6 class="dropdown-header">Notifikasi</h6></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item text-center text-muted" href="#">
                                    Tidak ada notifikasi baru
                                </a>
                            </li>
                        </ul>
                    </li>
                    
                    <!-- User Menu -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle nav-link-hover" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="user-avatar">
                                @if(Auth::user()->profile_photo)
                                    <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt="{{ Auth::user()->name }}" class="rounded-circle" width="32" height="32">
                                @else
                                    <i class="bi bi-person-circle"></i>
                                @endif
                            </div>
                            <span class="ms-1">{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-glassmorphism" aria-labelledby="userDropdown">
                            <li>
                                <a class="dropdown-item dropdown-item-hover" href="#">
                                    <i class="bi bi-person"></i> Profil
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item dropdown-item-hover" href="#">
                                    <i class="bi bi-gear"></i> Pengaturan
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item dropdown-item-hover" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="bi bi-box-arrow-right"></i> Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>