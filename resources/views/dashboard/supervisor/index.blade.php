@extends('layouts.app')

@section('title', 'Dashboard Dosen Pembimbing')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Dashboard Dosen Pembimbing</h1>
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
                            <div class="fs-4 fw-bold">{{ $totalStudents ?? 0 }}</div>
                        </div>
                        <i class="fas fa-users fa-2x opacity-50"></i>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="{{ route('supervisor.internships') }}">Lihat Detail</a>
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
                    <a class="small text-white stretched-link" href="{{ route('supervisor.reports') }}">Lihat Detail</a>
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
                    <a class="small text-white stretched-link" href="{{ route('supervisor.reports') }}">Lihat Detail</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-danger text-white mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="small">Laporan Ditolak</div>
                            <div class="fs-4 fw-bold">{{ $rejectedReports ?? 0 }}</div>
                        </div>
                        <i class="fas fa-times-circle fa-2x opacity-50"></i>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="{{ route('supervisor.reports') }}">Lihat Detail</a>
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
                    Mahasiswa Bimbingan
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="supervisedStudentsTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Nama Mahasiswa</th>
                                    <th>NIM</th>
                                    <th>Program Studi</th>
                                    <th>Perusahaan</th>
                                    <th>Progress</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($supervisedInternships ?? [] as $internship)
                                    <tr>
                                        <td>{{ $internship->student->name }}</td>
                                        <td>{{ $internship->student->nim }}</td>
                                        <td>{{ $internship->student->study_program }}</td>
                                        <td>{{ $internship->company->name }}</td>
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
                                            <a href="{{ route('supervisor.internships.show', $internship->id) }}" class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Tidak ada mahasiswa bimbingan</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center mt-3">
                        <a href="{{ route('supervisor.internships') }}" class="btn btn-primary btn-sm">
                            Lihat Semua Mahasiswa Bimbingan
                        </a>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-tasks me-1"></i>
                    Progres Pengumpulan Laporan Mingguan
                </div>
                <div class="card-body">
                    <canvas id="weeklyReportsChart" width="100%" height="40"></canvas>
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
                                <p class="card-text small mb-1">
                                    <strong>Perusahaan:</strong> {{ $report->internship->company->name }}
                                </p>
                                <div class="d-flex justify-content-end mt-2">
                                    <a href="{{ route('supervisor.reports') }}" class="btn btn-primary btn-sm">
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
                        <a href="{{ route('supervisor.reports') }}" class="btn btn-outline-primary btn-sm">
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
                                <div class="small mb-0">{{ $schedule->time }}</div>
                                <div class="small text-muted">
                                    <i class="fas fa-map-marker-alt"></i> {{ $schedule->location }}
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-muted py-4">
                            <i class="fas fa-calendar-alt fa-2x mb-2"></i>
                            <p class="mb-0">Tidak ada jadwal monitoring untuk bulan ini</p>
                        </div>
                    @endforelse

                    <div class="text-center mt-3">
                        <a href="#" class="btn btn-outline-primary btn-sm">
                            Lihat Semua Jadwal
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
        $('#supervisedStudentsTable').DataTable({
            responsive: true,
            paging: false,
            searching: false,
            info: false
        });
        
        // Chart untuk laporan mingguan
        var ctx = document.getElementById('weeklyReportsChart');
        var myLineChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ["Minggu 1", "Minggu 2", "Minggu 3", "Minggu 4", "Minggu 5"],
                datasets: [{
                    label: "Laporan Terverifikasi",
                    lineTension: 0.3,
                    backgroundColor: "rgba(2,117,216,0.2)",
                    borderColor: "rgba(2,117,216,1)",
                    pointRadius: 5,
                    pointBackgroundColor: "rgba(2,117,216,1)",
                    pointBorderColor: "rgba(255,255,255,0.8)",
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "rgba(2,117,216,1)",
                    pointHitRadius: 50,
                    pointBorderWidth: 2,
                    data: [
                        {{ $weeklyReportsData[0] ?? 0 }}, 
                        {{ $weeklyReportsData[1] ?? 0 }}, 
                        {{ $weeklyReportsData[2] ?? 0 }}, 
                        {{ $weeklyReportsData[3] ?? 0 }}, 
                        {{ $weeklyReportsData[4] ?? 0 }}
                    ],
                }],
            },
            options: {
                scales: {
                    xAxes: [{
                        gridLines: {
                            display: false
                        },
                        ticks: {
                            maxTicksLimit: 7
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            min: 0,
                            max: {{ $maxWeeklyReports ?? 10 }},
                            maxTicksLimit: 5
                        },
                        gridLines: {
                            color: "rgba(0, 0, 0, .125)",
                        }
                    }],
                },
                legend: {
                    display: false
                }
            }
        });
    });
</script>
@endsection 