<div class="position-sticky pt-3">
    <div class="user-info p-3 mb-3 bg-primary bg-opacity-25 rounded">
        <div class="d-flex align-items-center">
            @if(Auth::user()->profile_photo)
                <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt="{{ Auth::user()->name }}" class="rounded-circle me-3" width="50" height="50">
            @else
                <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px">
                    <i class="bi bi-person-circle fs-4"></i>
                </div>
            @endif
            <div>
                <h6 class="mb-0 fw-bold">{{ Auth::user()->name }}</h6>
                <small class="text-muted">{{ ucfirst(Auth::user()->role->name) }}</small>
            </div>
        </div>
    </div>
    
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
        </li>
        
        @if(Auth::user()->isAdmin())
            <!-- Admin Navigation -->
            <li class="sidebar-heading">
                Manajemen Data
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.companies.*') ? 'active' : '' }}" href="{{ route('admin.companies.index') }}">
                    <i class="bi bi-building"></i> Perusahaan
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.fields.*') ? 'active' : '' }}" href="{{ route('admin.fields.index') }}">
                    <i class="bi bi-list-check"></i> Bidang PKL
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users') }}">
                    <i class="bi bi-people"></i> Pengguna
                </a>
            </li>
            
        @elseif(Auth::user()->isStudent())
            <!-- Student Navigation -->
            <li class="sidebar-heading">
                PKL Mahasiswa
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('student.internships.*') ? 'active' : '' }}" href="{{ route('student.internships.index') }}">
                    <i class="bi bi-briefcase"></i> PKL Saya
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('student.daily-reports.*') ? 'active' : '' }}" href="{{ route('student.daily-reports.index') }}">
                    <i class="bi bi-journal-text"></i> Laporan Harian
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('student.apply.*') ? 'active' : '' }}" href="{{ route('student.apply.form') }}">
                    <i class="bi bi-send"></i> Pengajuan PKL
                </a>
            </li>
            
        @elseif(Auth::user()->isSupervisor())
            <!-- Supervisor Navigation -->
            <li class="sidebar-heading">
                Dosen Pembimbing
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('supervisor.internships') ? 'active' : '' }}" href="{{ route('supervisor.internships') }}">
                    <i class="bi bi-mortarboard"></i> Mahasiswa Bimbingan
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('supervisor.reports') ? 'active' : '' }}" href="{{ route('supervisor.reports') }}">
                    <i class="bi bi-check2-circle"></i> Verifikasi Laporan
                </a>
            </li>
            
        @elseif(Auth::user()->isFieldSupervisor())
            <!-- Field Supervisor Navigation -->
            <li class="sidebar-heading">
                Pembimbing Lapangan
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('field.internships') ? 'active' : '' }}" href="{{ route('field.internships') }}">
                    <i class="bi bi-person-workspace"></i> Mahasiswa PKL
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('field.reports') ? 'active' : '' }}" href="{{ route('field.reports') }}">
                    <i class="bi bi-check2-circle"></i> Verifikasi Laporan
                </a>
            </li>
            
        @elseif(Auth::user()->isCoordinator())
            <!-- Coordinator Navigation -->
            <li class="sidebar-heading">
                Koordinator PKL
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('coordinator.internships') ? 'active' : '' }}" href="{{ route('coordinator.internships') }}">
                    <i class="bi bi-diagram-3"></i> Manajemen PKL
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('coordinator.statistics') ? 'active' : '' }}" href="{{ route('coordinator.statistics') }}">
                    <i class="bi bi-graph-up"></i> Statistik
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('coordinator.reports.export') ? 'active' : '' }}" href="{{ route('coordinator.reports.export') }}">
                    <i class="bi bi-file-earmark-spreadsheet"></i> Laporan
                </a>
            </li>
        @endif
        
        <!-- Common Navigation -->
        <li class="sidebar-heading">
            Pengaturan
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="bi bi-person-gear"></i> Profil Saya
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="bi bi-box-arrow-right"></i> Logout
            </a>
        </li>
    </ul>
</div> 