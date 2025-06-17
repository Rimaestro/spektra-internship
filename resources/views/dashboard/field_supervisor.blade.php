@extends('layouts.app')

@section('title', 'Dashboard Pembimbing Lapangan')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Dashboard Pembimbing Lapangan</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>

    @include('layouts.partials.flash-messages')

    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="small">Mahasiswa Bimbingan</div>
                            <div class="fs-4 fw-bold">{{ $ongoingInternships ?? 0 }}</div>
                        </div>
                        <i class="fas fa-users fa-2x opacity-50"></i>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="{{ route('field-supervisor.internships') }}">Lihat Detail</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-warning text-white mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="small">Laporan Menunggu Persetujuan</div>
                            <div class="fs-4 fw-bold">{{ $pendingReports ?? 0 }}</div>
                        </div>
                        <i class="fas fa-clock fa-2x opacity-50"></i>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="{{ route('field-supervisor.reports.pending') }}">Lihat Detail</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-success text-white mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="small">Laporan Disetujui</div>
                            <div class="fs-4 fw-bold">{{ $approvedReports ?? 0 }}</div>
                        </div>
                        <i class="fas fa-clipboard-check fa-2x opacity-50"></i>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="{{ route('field-supervisor.reports.approved') }}">Lihat Detail</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-info text-white mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="small">Mahasiswa Selesai PKL</div>
                            <div class="fs-4 fw-bold">{{ $completedInternships ?? 0 }}</div>
                        </div>
                        <i class="fas fa-user-graduate fa-2x opacity-50"></i>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="{{ route('field-supervisor.internships.completed') }}">Lihat Detail</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-8">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-users me-1"></i>
                    Mahasiswa PKL Aktif
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="activeStudentsTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Nama Mahasiswa</th>
                                    <th>NIM</th>
                                    <th>Program Studi</th>
                                    <th>Tanggal Mulai</th>
                                    <th>Tanggal Selesai</th>
                                    <th>Progress</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($internships ?? [] as $internship)
                                    @if($internship->status == 'ongoing')
                                    <tr>
                                        <td>{{ $internship->student->name }}</td>
                                        <td>{{ $internship->student->nim }}</td>
                                        <td>{{ $internship->student->study_program }}</td>
                                        <td>{{ $internship->start_date->format('d/m/Y') }}</td>
                                        <td>{{ $internship->end_date->format('d/m/Y') }}</td>
                                        <td>
                                            @php
                                                $startDate = \Carbon\Carbon::parse($internship->start_date);
                                                $endDate = \Carbon\Carbon::parse($internship->end_date);
                                                $today = \Carbon\Carbon::now();
                                                $totalDays = $startDate->diffInDays($endDate);
                                                $passedDays = $startDate->diffInDays($today);
                                                $progress = $totalDays > 0 ? min(100, max(0, ($passedDays / $totalDays) * 100)) : 0;
                                            @endphp
                                            <div class="progress" style="height: 6px;">
                                                <div class="progress-bar" role="progressbar" style="width: {{ $progress }}%" aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <div class="small text-muted text-center mt-1">{{ round($progress) }}%</div>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('field-supervisor.internships.show', $internship->id) }}" class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endif
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Tidak ada mahasiswa PKL aktif saat ini</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center mt-3">
                        <a href="{{ route('field-supervisor.internships') }}" class="btn btn-primary btn-sm">
                            Lihat Semua Data PKL
                        </a>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-building me-1"></i>
                        Informasi Perusahaan
                    </div>
                    <a href="{{ route('field-supervisor.company.profile') }}" class="btn btn-sm btn-outline-primary">Edit Profil</a>
                </div>
                <div class="card-body">
                    @if($company)
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table">
                                <tr>
                                    <th width="35%">Nama Perusahaan</th>
                                    <td>{{ $company->name }}</td>
                                </tr>
                                <tr>
                                    <th>Alamat</th>
                                    <td>{{ $company->address }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{ $company->email }}</td>
                                </tr>
                                <tr>
                                    <th>Kontak</th>
                                    <td>{{ $company->phone }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6>Statistik PKL</h6>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Total Mahasiswa PKL:</span>
                                        <span class="fw-bold">{{ $company->internships_count ?? 0 }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Mahasiswa PKL Aktif:</span>
                                        <span class="fw-bold">{{ $ongoingInternships ?? 0 }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Kuota Tersedia:</span>
                                        <span class="fw-bold">{{ $company->quota - ($ongoingInternships ?? 0) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-1"></i>
                        Data perusahaan belum tersedia. Silahkan lengkapi profil perusahaan Anda.
                    </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-xl-4">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-clipboard me-1"></i>
                    Laporan Terbaru yang Perlu Divalidasi
                </div>
                <div class="card-body">
                    @forelse ($recentReports ?? [] as $report)
                        <div class="card bg-light mb-3">
                            <div class="card-body p-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="card-title mb-0">{{ $report->activity_title }}</h6>
                                    <span class="badge bg-warning">Menunggu Validasi</span>
                                </div>
                                <p class="card-text small mb-1">
                                    <strong>Mahasiswa:</strong> {{ $report->internship->student->name }}
                                </p>
                                <p class="card-text small mb-1">
                                    <strong>Tanggal:</strong> {{ $report->report_date->format('d/m/Y') }}
                                </p>
                                <div class="d-flex justify-content-end mt-2">
                                    <a href="{{ route('field-supervisor.reports.review', $report->id) }}" class="btn btn-primary btn-sm">
                                        Validasi
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-muted py-4">
                            <i class="fas fa-clipboard fa-2x mb-2"></i>
                            <p class="mb-0">Tidak ada laporan yang menunggu validasi</p>
                        </div>
                    @endforelse
                    
                    <div class="text-center mt-3">
                        <a href="{{ route('field-supervisor.reports.pending') }}" class="btn btn-outline-primary btn-sm">
                            Lihat Semua Laporan
                        </a>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-calendar-alt me-1"></i>
                    Jadwal Monitoring
                </div>
                <div class="card-body">
                    @forelse ($monitoringSchedules ?? [] as $schedule)
                        <div class="d-flex align-items-center border-bottom pb-3 mb-3">
                            <div class="bg-info text-white rounded p-2 me-3 text-center" style="width: 45px;">
                                <div class="small">{{ $schedule->date->format('M') }}</div>
                                <div class="fw-bold">{{ $schedule->date->format('d') }}</div>
                            </div>
                            <div>
                                <div class="fw-bold">{{ $schedule->title }}</div>
                                <div class="small mb-0">{{ $schedule->student_name }}</div>
                                <div class="small text-muted">
                                    <i class="fas fa-map-marker-alt"></i> {{ $schedule->location }}
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-muted py-4">
                            <i class="fas fa-calendar-alt fa-2x mb-2"></i>
                            <p class="mb-0">Belum ada jadwal monitoring</p>
                        </div>
                    @endforelse

                    <div class="text-center mt-3">
                        <a href="{{ route('field-supervisor.monitoring.schedule') }}" class="btn btn-outline-primary btn-sm">
                            Kelola Jadwal Monitoring
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#activeStudentsTable').DataTable({
            responsive: true,
            paging: false,
            searching: false,
            info: false
        });
    });
</script>
@endsection 