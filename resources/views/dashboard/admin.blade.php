@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('header', 'Dashboard Admin')

@section('content')
<div class="container-fluid">
    <!-- Stats Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title">Total Pengguna</h6>
                            <h2 class="mb-0">{{ $totalUsers }}</h2>
                        </div>
                        <i class="bi bi-people fs-1"></i>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a href="{{ route('admin.users') }}" class="text-white text-decoration-none small">Lihat Detail</a>
                    <i class="bi bi-chevron-right small text-white"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title">Total Perusahaan</h6>
                            <h2 class="mb-0">{{ $totalCompanies }}</h2>
                        </div>
                        <i class="bi bi-building fs-1"></i>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a href="{{ route('admin.companies.index') }}" class="text-white text-decoration-none small">Lihat Detail</a>
                    <i class="bi bi-chevron-right small text-white"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title">Total PKL</h6>
                            <h2 class="mb-0">{{ $totalInternships }}</h2>
                        </div>
                        <i class="bi bi-briefcase fs-1"></i>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a href="#" class="text-white text-decoration-none small">Lihat Detail</a>
                    <i class="bi bi-chevron-right small text-white"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title">PKL Aktif</h6>
                            <h2 class="mb-0">{{ $activeInternships }}</h2>
                        </div>
                        <i class="bi bi-clock-history fs-1"></i>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a href="#" class="text-white text-decoration-none small">Lihat Detail</a>
                    <i class="bi bi-chevron-right small text-white"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Row -->
    <div class="row">
        <!-- Left Column -->
        <div class="col-lg-8">
            <!-- Recent Users -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Pengguna Terbaru</h5>
                    <a href="{{ route('admin.users') }}" class="btn btn-sm btn-primary">Lihat Semua</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Tanggal Daftar</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentUsers as $user)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($user->profile_photo)
                                                <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="{{ $user->name }}" class="rounded-circle me-2" width="32" height="32">
                                            @else
                                                <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px">
                                                    <i class="bi bi-person-fill"></i>
                                                </div>
                                            @endif
                                            <span>{{ $user->name }}</span>
                                        </div>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <span class="badge bg-{{ $user->isAdmin() ? 'danger' : ($user->isStudent() ? 'primary' : 'info') }}">
                                            {{ ucfirst($user->role->name) }}
                                        </span>
                                    </td>
                                    <td>{{ $user->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-3">Tidak ada data pengguna terbaru.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="col-lg-4">
            <!-- Recent Companies -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Perusahaan Terbaru</h5>
                    <a href="{{ route('admin.companies.index') }}" class="btn btn-sm btn-primary">Lihat Semua</a>
                </div>
                <div class="card-body">
                    @forelse($recentCompanies as $company)
                    <div class="d-flex align-items-center mb-3">
                        <div class="flex-shrink-0">
                            @if($company->logo)
                                <img src="{{ asset('storage/' . $company->logo) }}" alt="{{ $company->name }}" class="rounded" width="48" height="48">
                            @else
                                <div class="rounded bg-secondary text-white d-flex align-items-center justify-content-center" style="width: 48px; height: 48px">
                                    <i class="bi bi-building"></i>
                                </div>
                            @endif
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0">{{ $company->name }}</h6>
                            <p class="text-muted mb-0 small">{{ $company->city }} &bull; {{ $company->industry_type }}</p>
                        </div>
                        <div>
                            <span class="badge bg-{{ $company->is_active ? 'success' : 'danger' }} ms-2">
                                {{ $company->is_active ? 'Aktif' : 'Non-aktif' }}
                            </span>
                        </div>
                    </div>
                    @empty
                    <p class="text-center text-muted py-3">Tidak ada perusahaan terbaru.</p>
                    @endforelse
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Aksi Cepat</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.users.create') }}" class="btn btn-outline-primary">
                            <i class="bi bi-person-plus me-2"></i> Tambah Pengguna
                        </a>
                        <a href="{{ route('admin.companies.create') }}" class="btn btn-outline-success">
                            <i class="bi bi-building-add me-2"></i> Tambah Perusahaan
                        </a>
                        <a href="{{ route('admin.fields.create') }}" class="btn btn-outline-info">
                            <i class="bi bi-list-check me-2"></i> Tambah Bidang PKL
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 