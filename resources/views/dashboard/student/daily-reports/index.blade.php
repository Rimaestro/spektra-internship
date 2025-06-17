@extends('layouts.app')

@section('title', 'Laporan Harian PKL')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Laporan Harian PKL</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Laporan Harian</li>
    </ol>

    @include('layouts.partials.flash-messages')

    <div class="row mb-3">
        <div class="col-md-6">
            <div class="d-flex">
                @if($activeInternship)
                <a href="{{ route('student.daily-reports.create', ['internship_id' => $activeInternship->id]) }}" class="btn btn-primary">
                    <i class="fas fa-plus-circle me-1"></i> Buat Laporan Baru
                </a>
                @else
                <button class="btn btn-primary" disabled>
                    <i class="fas fa-plus-circle me-1"></i> Buat Laporan Baru
                </button>
                <small class="text-muted ms-2 mt-2">Anda harus memiliki PKL aktif untuk membuat laporan.</small>
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <form action="{{ route('student.daily-reports.index') }}" method="GET" class="d-flex justify-content-end">
                <div class="input-group" style="width: 300px;">
                    <input type="text" class="form-control" placeholder="Cari laporan..." name="search" value="{{ request('search') }}">
                    <button class="btn btn-outline-secondary" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-list me-1"></i>
            Daftar Laporan Harian
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dailyReportsTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Judul Aktivitas</th>
                            <th>Perusahaan</th>
                            <th>Jam Kerja</th>
                            <th>Status</th>
                            <th>Divalidasi Oleh</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($reports as $report)
                            <tr>
                                <td>{{ $report->report_date->format('d/m/Y') }}</td>
                                <td>{{ $report->activity_title }}</td>
                                <td>{{ $report->internship->company->name }}</td>
                                <td>{{ $report->work_hours }} jam</td>
                                <td>
                                    @if ($report->status == 'pending')
                                        <span class="badge bg-warning">Tertunda</span>
                                    @elseif ($report->status == 'approved')
                                        <span class="badge bg-success">Disetujui</span>
                                    @elseif ($report->status == 'rejected')
                                        <span class="badge bg-danger">Ditolak</span>
                                    @else
                                        <span class="badge bg-secondary">{{ $report->status }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($report->verified_by)
                                        {{ $report->verified_by_name }}
                                        <br>
                                        <small class="text-muted">{{ $report->verified_at ? $report->verified_at->format('d/m/Y H:i') : '' }}</small>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('student.daily-reports.show', $report->id) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if($report->status == 'pending')
                                            <a href="{{ route('student.daily-reports.edit', $report->id) }}" class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @endif
                                        @if ($report->attachment)
                                            <a href="{{ asset('storage/' . $report->attachment) }}" target="_blank" class="btn btn-success btn-sm" title="Lihat Lampiran">
                                                <i class="fas fa-paperclip"></i>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Belum ada laporan harian</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-end mt-3">
                {{ $reports->links() }}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-4 col-md-6">
            <div class="card bg-light mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="mb-0">Statistik Laporan</h6>
                    </div>
                    <div class="row text-center">
                        <div class="col-4">
                            <div class="border rounded py-2">
                                <h3 class="fw-bold text-primary m-0">{{ $totalReports ?? 0 }}</h3>
                                <div class="small text-muted">Total</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="border rounded py-2">
                                <h3 class="fw-bold text-success m-0">{{ $approvedReports ?? 0 }}</h3>
                                <div class="small text-muted">Disetujui</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="border rounded py-2">
                                <h3 class="fw-bold text-danger m-0">{{ $pendingReports ?? 0 }}</h3>
                                <div class="small text-muted">Tertunda</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="card bg-light mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="mb-0">Total Jam Kerja</h6>
                    </div>
                    <div class="text-center py-2">
                        <h1 class="fw-bold text-primary m-0">{{ $totalWorkHours ?? 0 }}</h1>
                        <div class="text-muted">jam</div>
                    </div>
                    <div class="progress mt-2" style="height: 6px;">
                        @php
                            $requiredHours = 320; // Misalnya 320 jam diperlukan untuk PKL
                            $progressPercentage = min(100, ($totalWorkHours ?? 0) / $requiredHours * 100);
                        @endphp
                        <div class="progress-bar" role="progressbar" style="width: {{ $progressPercentage }}%" aria-valuenow="{{ $progressPercentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="text-center mt-1">
                        <small class="text-muted">{{ $totalWorkHours ?? 0 }} dari {{ $requiredHours }} jam yang dibutuhkan ({{ round($progressPercentage) }}%)</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-12">
            <div class="card bg-light mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="mb-0">Laporan Terbaru</h6>
                        <a href="{{ route('student.daily-reports.index') }}" class="small">Lihat Semua</a>
                    </div>
                    @forelse($latestReports ?? [] as $latestReport)
                        <div class="d-flex align-items-center border-bottom pb-2 mb-2">
                            <div class="flex-grow-1">
                                <div class="small fw-bold">{{ $latestReport->activity_title }}</div>
                                <div class="small text-muted">{{ $latestReport->report_date->format('d/m/Y') }}</div>
                            </div>
                            <div>
                                @if ($latestReport->status == 'pending')
                                    <span class="badge bg-warning">Tertunda</span>
                                @elseif ($latestReport->status == 'approved')
                                    <span class="badge bg-success">Disetujui</span>
                                @elseif ($latestReport->status == 'rejected')
                                    <span class="badge bg-danger">Ditolak</span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-muted py-3">
                            Belum ada laporan harian
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#dailyReportsTable').DataTable({
            responsive: true,
            "order": [[0, 'desc']],
            "pageLength": 10,
            "searching": false,
            "paging": false,
            "info": false
        });
    });
</script>
@endsection 