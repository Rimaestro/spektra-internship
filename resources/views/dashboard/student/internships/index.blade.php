@extends('layouts.app')

@section('title', 'Daftar Pengajuan PKL')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Pengajuan PKL</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Daftar Pengajuan PKL</li>
    </ol>

    @include('layouts.partials.flash-messages')

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <a href="{{ route('student.apply.form') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle me-1"></i> Ajukan PKL Baru
            </a>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-list me-1"></i>
            Daftar Pengajuan PKL Anda
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="internshipsTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Perusahaan</th>
                            <th>Bidang</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Selesai</th>
                            <th>Status</th>
                            <th>Dosen Pembimbing</th>
                            <th>Pembimbing Lapangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($internships as $internship)
                            <tr>
                                <td>{{ $internship->company->name }}</td>
                                <td>{{ $internship->field->name }}</td>
                                <td>{{ $internship->start_date->format('d/m/Y') }}</td>
                                <td>{{ $internship->end_date->format('d/m/Y') }}</td>
                                <td>
                                    @if ($internship->status == 'pending')
                                        <span class="badge bg-warning">Menunggu Persetujuan</span>
                                    @elseif ($internship->status == 'approved')
                                        <span class="badge bg-success">Disetujui</span>
                                    @elseif ($internship->status == 'rejected')
                                        <span class="badge bg-danger">Ditolak</span>
                                    @elseif ($internship->status == 'completed')
                                        <span class="badge bg-info">Selesai</span>
                                    @else
                                        <span class="badge bg-secondary">{{ $internship->status }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($internship->supervisor)
                                        {{ $internship->supervisor->name }}
                                    @else
                                        <span class="text-muted">Belum ditentukan</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($internship->field_supervisor_name)
                                        {{ $internship->field_supervisor_name }}
                                    @else
                                        <span class="text-muted">Belum ditentukan</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('student.internships.show', $internship->id) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if($internship->status == 'pending')
                                            <form action="{{ route('student.internships.destroy', $internship->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pengajuan PKL ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                        @endif
                                        @if($internship->status == 'approved')
                                            <a href="{{ route('student.daily-reports.create', ['internship_id' => $internship->id]) }}" class="btn btn-success btn-sm" title="Buat Laporan Harian">
                                                <i class="fas fa-file-alt"></i>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">Anda belum memiliki pengajuan PKL</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @if($activeInternship)
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-tasks me-1"></i>
            Status Progress PKL Aktif
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h6 class="card-title">Detail PKL Aktif</h6>
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <tr>
                                        <th width="35%">Perusahaan</th>
                                        <td>{{ $activeInternship->company->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Bidang</th>
                                        <td>{{ $activeInternship->field->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Periode</th>
                                        <td>{{ $activeInternship->start_date->format('d M Y') }} - {{ $activeInternship->end_date->format('d M Y') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Dosen Pembimbing</th>
                                        <td>
                                            @if ($activeInternship->supervisor)
                                                {{ $activeInternship->supervisor->name }}
                                            @else
                                                <span class="text-muted">Belum ditentukan</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Pembimbing Lapangan</th>
                                        <td>
                                            @if ($activeInternship->field_supervisor_name)
                                                {{ $activeInternship->field_supervisor_name }}
                                            @else
                                                <span class="text-muted">Belum ditentukan</span>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h6 class="card-title">Progress PKL</h6>
                            <div class="text-center mb-2">
                                @php
                                    $startDate = \Carbon\Carbon::parse($activeInternship->start_date);
                                    $endDate = \Carbon\Carbon::parse($activeInternship->end_date);
                                    $today = \Carbon\Carbon::now();
                                    $totalDays = $startDate->diffInDays($endDate);
                                    $passedDays = $startDate->diffInDays($today);
                                    $progress = $totalDays > 0 ? min(100, max(0, ($passedDays / $totalDays) * 100)) : 0;
                                @endphp
                                <div class="progress mb-3" style="height: 10px;">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" style="width: {{ $progress }}%"></div>
                                </div>
                                <p class="mb-0">{{ round($progress) }}% selesai</p>
                                <p class="text-muted small mb-0">{{ $passedDays }} dari {{ $totalDays }} hari</p>
                            </div>

                            <div class="row text-center mt-3">
                                <div class="col">
                                    <div class="border rounded p-2">
                                        <h3 class="fw-bold text-primary">{{ $totalReports ?? 0 }}</h3>
                                        <span class="small text-muted">Total Laporan</span>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="border rounded p-2">
                                        <h3 class="fw-bold text-success">{{ $approvedReports ?? 0 }}</h3>
                                        <span class="small text-muted">Disetujui</span>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="border rounded p-2">
                                        <h3 class="fw-bold text-danger">{{ $rejectedReports ?? 0 }}</h3>
                                        <span class="small text-muted">Ditolak</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-3">
                <a href="{{ route('student.daily-reports.create', ['internship_id' => $activeInternship->id]) }}" class="btn btn-primary">
                    <i class="fas fa-plus-circle me-1"></i> Buat Laporan Harian Baru
                </a>
                <a href="{{ route('student.daily-reports.index') }}" class="btn btn-info ms-2">
                    <i class="fas fa-list me-1"></i> Lihat Semua Laporan
                </a>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#internshipsTable').DataTable({
            responsive: true,
            order: [[4, 'asc'], [2, 'desc']]
        });
    });
</script>
@endsection 