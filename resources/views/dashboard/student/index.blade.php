@extends('layouts.app')

@section('title', 'Dashboard Mahasiswa')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Dashboard</h1>
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
                            <div class="small">PKL Aktif</div>
                            <div class="fs-4 fw-bold">{{ $activeInternshipCount ?? 0 }}</div>
                        </div>
                        <i class="fas fa-user-graduate fa-2x opacity-50"></i>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="{{ route('student.internships.index') }}">Lihat Detail</a>
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
                            <div class="fs-4 fw-bold">{{ $approvedReportCount ?? 0 }}</div>
                        </div>
                        <i class="fas fa-clipboard-check fa-2x opacity-50"></i>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="{{ route('student.daily-reports.index') }}">Lihat Detail</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-warning text-white mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="small">Laporan Pending</div>
                            <div class="fs-4 fw-bold">{{ $pendingReportCount ?? 0 }}</div>
                        </div>
                        <i class="fas fa-clock fa-2x opacity-50"></i>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="{{ route('student.daily-reports.index') }}">Lihat Detail</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-info text-white mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="small">Total Jam Kerja</div>
                            <div class="fs-4 fw-bold">{{ $totalWorkHours ?? 0 }}</div>
                        </div>
                        <i class="fas fa-business-time fa-2x opacity-50"></i>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="{{ route('student.daily-reports.index') }}">Lihat Detail</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            @if($activeInternship)
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-info-circle me-1"></i>
                    Informasi PKL Aktif
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h6 class="fw-bold">{{ $activeInternship->company->name }}</h6>
                            <p class="text-muted mb-0">{{ $activeInternship->company->address }}</p>
                            <p class="mb-0">
                                <span class="badge bg-info">{{ $activeInternship->field->name }}</span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-sm">
                                <tr>
                                    <th width="40%">Tanggal Mulai</th>
                                    <td>{{ $activeInternship->start_date->format('d M Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Selesai</th>
                                    <td>{{ $activeInternship->end_date->format('d M Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        <span class="badge bg-success">Aktif</span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title">Dosen Pembimbing</h6>
                                    @if($activeInternship->supervisor)
                                        <p class="mb-1"><strong>{{ $activeInternship->supervisor->name }}</strong></p>
                                        <p class="mb-1 small">{{ $activeInternship->supervisor->email }}</p>
                                        <p class="mb-0 small">{{ $activeInternship->supervisor->phone ?? '-' }}</p>
                                    @else
                                        <p class="text-muted mb-0">Belum ditentukan</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title">Pembimbing Lapangan</h6>
                                    @if($activeInternship->field_supervisor_name)
                                        <p class="mb-1"><strong>{{ $activeInternship->field_supervisor_name }}</strong></p>
                                        <p class="mb-1 small">{{ $activeInternship->field_supervisor_email ?? '-' }}</p>
                                        <p class="mb-0 small">{{ $activeInternship->field_supervisor_contact ?? '-' }}</p>
                                    @else
                                        <p class="text-muted mb-0">Belum ditentukan</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-3">
                        <h6 class="mb-2">Progress PKL</h6>
                        @php
                            $startDate = \Carbon\Carbon::parse($activeInternship->start_date);
                            $endDate = \Carbon\Carbon::parse($activeInternship->end_date);
                            $today = \Carbon\Carbon::now();
                            $totalDays = $startDate->diffInDays($endDate);
                            $passedDays = $startDate->diffInDays($today);
                            $progress = $totalDays > 0 ? min(100, max(0, ($passedDays / $totalDays) * 100)) : 0;
                        @endphp
                        
                        <div class="progress mb-2" style="height: 20px;">
                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: {{ $progress }}%" aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100">{{ round($progress) }}%</div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <small>{{ $activeInternship->start_date->format('d M Y') }}</small>
                            <small>{{ $passedDays }} dari {{ $totalDays }} hari</small>
                            <small>{{ $activeInternship->end_date->format('d M Y') }}</small>
                        </div>
                    </div>

                    <div class="mt-4 text-center">
                        <a href="{{ route('student.daily-reports.create', ['internship_id' => $activeInternship->id]) }}" class="btn btn-primary">
                            <i class="fas fa-plus-circle me-1"></i> Buat Laporan Hari Ini
                        </a>
                        <a href="{{ route('student.daily-reports.index') }}" class="btn btn-outline-primary ms-2">
                            <i class="fas fa-list me-1"></i> Daftar Laporan
                        </a>
                    </div>
                </div>
            </div>
            @else
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-info-circle me-1"></i>
                    Informasi PKL
                </div>
                <div class="card-body text-center py-5">
                    <i class="fas fa-file-alt fa-4x text-muted mb-3"></i>
                    <h5>Anda belum memiliki PKL aktif</h5>
                    <p class="mb-4">Silahkan ajukan permohonan PKL untuk memulai praktek kerja lapangan Anda.</p>
                    <a href="{{ route('student.apply.form') }}" class="btn btn-primary">
                        <i class="fas fa-plus-circle me-1"></i> Ajukan PKL Baru
                    </a>
                </div>
            </div>
            @endif
        </div>
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-bell me-1"></i>
                    Notifikasi
                </div>
                <div class="card-body">
                    @if(count($notifications ?? []) > 0)
                        @foreach($notifications as $notification)
                            <div class="d-flex align-items-center border-bottom pb-3 mb-3">
                                @if($notification->type == 'report_approved')
                                    <div class="bg-success text-white rounded-3 p-2 me-3">
                                        <i class="fas fa-check"></i>
                                    </div>
                                @elseif($notification->type == 'report_rejected')
                                    <div class="bg-danger text-white rounded-3 p-2 me-3">
                                        <i class="fas fa-times"></i>
                                    </div>
                                @elseif($notification->type == 'internship_approved')
                                    <div class="bg-primary text-white rounded-3 p-2 me-3">
                                        <i class="fas fa-check-double"></i>
                                    </div>
                                @elseif($notification->type == 'internship_rejected')
                                    <div class="bg-danger text-white rounded-3 p-2 me-3">
                                        <i class="fas fa-ban"></i>
                                    </div>
                                @else
                                    <div class="bg-info text-white rounded-3 p-2 me-3">
                                        <i class="fas fa-info"></i>
                                    </div>
                                @endif
                                <div class="flex-grow-1">
                                    <div class="small fw-bold">{{ $notification->title }}</div>
                                    <div class="small text-muted">{{ $notification->message }}</div>
                                    <div class="small text-muted">{{ $notification->created_at->diffForHumans() }}</div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center text-muted py-4">
                            <i class="fas fa-bell-slash fa-2x mb-2"></i>
                            <p class="mb-0">Tidak ada notifikasi baru</p>
                        </div>
                    @endif
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-tasks me-1"></i>
                    Aktivitas Terbaru
                </div>
                <div class="card-body">
                    @if(count($recentReports ?? []) > 0)
                        @foreach($recentReports as $report)
                            <div class="d-flex align-items-center border-bottom pb-2 mb-2">
                                <div class="flex-shrink-0 me-2">
                                    @if($report->status == 'approved')
                                        <span class="badge bg-success"><i class="fas fa-check"></i></span>
                                    @elseif($report->status == 'rejected')
                                        <span class="badge bg-danger"><i class="fas fa-times"></i></span>
                                    @else
                                        <span class="badge bg-warning"><i class="fas fa-clock"></i></span>
                                    @endif
                                </div>
                                <div class="flex-grow-1">
                                    <div class="small fw-bold">{{ $report->activity_title }}</div>
                                    <div class="small text-muted">{{ $report->report_date->format('d M Y') }}</div>
                                </div>
                            </div>
                        @endforeach
                        <div class="text-center mt-3">
                            <a href="{{ route('student.daily-reports.index') }}" class="small">Lihat Semua Aktivitas</a>
                        </div>
                    @else
                        <div class="text-center text-muted py-4">
                            <i class="fas fa-clipboard fa-2x mb-2"></i>
                            <p class="mb-0">Belum ada laporan aktivitas</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-building me-1"></i>
                    Perusahaan Mitra dengan Kuota Tersedia
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="availableCompaniesTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Nama Perusahaan</th>
                                    <th>Alamat</th>
                                    <th>Bidang PKL</th>
                                    <th>Kuota Tersedia</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($availableCompanies ?? [] as $company)
                                    <tr>
                                        <td>{{ $company->name }}</td>
                                        <td>{{ $company->address }}</td>
                                        <td>
                                            @foreach($company->fields as $field)
                                                <span class="badge bg-info me-1">{{ $field->name }}</span>
                                            @endforeach
                                        </td>
                                        <td>{{ $company->available_quota }} / {{ $company->quota }}</td>
                                        <td>
                                            <a href="{{ route('student.apply.form', ['company_id' => $company->id]) }}" class="btn btn-primary btn-sm">
                                                <i class="fas fa-file-signature me-1"></i> Ajukan
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Tidak ada perusahaan dengan kuota tersedia</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
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
        $('#availableCompaniesTable').DataTable({
            responsive: true,
            paging: false,
            searching: false,
            info: false
        });
    });
</script>
@endsection 