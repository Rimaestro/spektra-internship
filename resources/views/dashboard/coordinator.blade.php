@extends('layouts.app')

@section('title', 'Dashboard Koordinator PKL')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Dashboard Koordinator PKL</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>

    @include('layouts.partials.flash-messages')

    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-warning text-white mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="small">Pengajuan PKL Baru</div>
                            <div class="fs-4 fw-bold">{{ $pendingInternships ?? 0 }}</div>
                        </div>
                        <i class="fas fa-file-alt fa-2x opacity-50"></i>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="{{ route('coordinator.internships.pending') }}">Lihat Detail</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="small">PKL Aktif</div>
                            <div class="fs-4 fw-bold">{{ $activeInternships ?? 0 }}</div>
                        </div>
                        <i class="fas fa-users fa-2x opacity-50"></i>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="{{ route('coordinator.internships.active') }}">Lihat Detail</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-success text-white mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="small">PKL Selesai</div>
                            <div class="fs-4 fw-bold">{{ $completedInternships ?? 0 }}</div>
                        </div>
                        <i class="fas fa-user-graduate fa-2x opacity-50"></i>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="{{ route('coordinator.internships.completed') }}">Lihat Detail</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-info text-white mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="small">Perusahaan Mitra</div>
                            <div class="fs-4 fw-bold">{{ $activeCompanies ?? 0 }}/{{ $totalCompanies ?? 0 }}</div>
                        </div>
                        <i class="fas fa-building fa-2x opacity-50"></i>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="{{ route('coordinator.companies') }}">Lihat Detail</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-8">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-file-alt me-1"></i>
                    Pengajuan PKL Terbaru
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="pendingInternshipsTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Tanggal Pengajuan</th>
                                    <th>Nama Mahasiswa</th>
                                    <th>NIM</th>
                                    <th>Program Studi</th>
                                    <th>Perusahaan</th>
                                    <th>Bidang</th>
                                    <th>Periode</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($recentApplications ?? [] as $internship)
                                    <tr>
                                        <td>{{ $internship->created_at->format('d/m/Y') }}</td>
                                        <td>{{ $internship->student->name }}</td>
                                        <td>{{ $internship->student->nim }}</td>
                                        <td>{{ $internship->student->study_program }}</td>
                                        <td>{{ $internship->company->name }}</td>
                                        <td>{{ $internship->field->name }}</td>
                                        <td>{{ $internship->start_date->format('d/m/Y') }} - {{ $internship->end_date->format('d/m/Y') }}</td>
                                        <td>
                                            <a href="{{ route('coordinator.internships.review', $internship->id) }}" class="btn btn-primary btn-sm">
                                                <i class="fas fa-check-circle"></i> Review
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">Tidak ada pengajuan PKL terbaru</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center mt-3">
                        <a href="{{ route('coordinator.internships.pending') }}" class="btn btn-primary btn-sm">
                            Lihat Semua Pengajuan
                        </a>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-chart-pie me-1"></i>
                            Distribusi Program Studi
                        </div>
                        <div class="card-body">
                            <canvas id="studyProgramChart" width="100%" height="180"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-chart-bar me-1"></i>
                            Tren PKL Bulanan
                        </div>
                        <div class="card-body">
                            <canvas id="monthlyTrendChart" width="100%" height="180"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-4">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-tasks me-1"></i>
                    Tugas Hari Ini
                </div>
                <div class="card-body">
                    <div class="list-group">
                        @if($pendingInternships > 0)
                        <a href="{{ route('coordinator.internships.pending') }}" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">Persetujuan Pengajuan PKL</h6>
                                <span class="badge bg-warning rounded-pill">{{ $pendingInternships }}</span>
                            </div>
                            <p class="mb-1 small">Mahasiswa menunggu persetujuan pengajuan PKL</p>
                        </a>
                        @endif
                        
                        @if($pendingSupervisors > 0)
                        <a href="{{ route('coordinator.supervisors.assign') }}" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">Penugasan Dosen Pembimbing</h6>
                                <span class="badge bg-info rounded-pill">{{ $pendingSupervisors }}</span>
                            </div>
                            <p class="mb-1 small">PKL yang membutuhkan penugasan dosen pembimbing</p>
                        </a>
                        @endif
                        
                        @if($documentsToVerify > 0)
                        <a href="{{ route('coordinator.documents.pending') }}" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">Verifikasi Dokumen</h6>
                                <span class="badge bg-primary rounded-pill">{{ $documentsToVerify }}</span>
                            </div>
                            <p class="mb-1 small">Dokumen laporan akhir yang perlu diverifikasi</p>
                        </a>
                        @endif
                        
                        @if($pendingInternships == 0 && $pendingSupervisors == 0 && $documentsToVerify == 0)
                        <div class="text-center py-4 text-muted">
                            <i class="fas fa-check-circle fa-2x mb-2"></i>
                            <p class="mb-0">Tidak ada tugas mendesak hari ini</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-building me-1"></i>
                    Perusahaan Terpopuler
                </div>
                <div class="card-body">
                    @forelse($topCompanies ?? [] as $index => $company)
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h6 class="mb-0">{{ $company->name }}</h6>
                                <small class="text-muted">{{ $company->address }}</small>
                            </div>
                            <span class="badge bg-primary">{{ $company->internships_count ?? 0 }} Mahasiswa</span>
                        </div>
                        @if(!$loop->last)
                            <hr class="my-2">
                        @endif
                    @empty
                        <div class="text-center text-muted py-3">
                            <p class="mb-0">Belum ada data perusahaan</p>
                        </div>
                    @endforelse
                    
                    <div class="text-center mt-3">
                        <a href="{{ route('coordinator.companies') }}" class="btn btn-outline-primary btn-sm">
                            Lihat Semua Perusahaan
                        </a>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-user-tie me-1"></i>
                    Pembimbing Aktif
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Nama Dosen</th>
                                    <th class="text-center">Mahasiswa Bimbingan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($activeSupervisors ?? [] as $supervisor)
                                    <tr>
                                        <td>{{ $supervisor->name }}</td>
                                        <td class="text-center">{{ $supervisor->internships_count }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center">Belum ada dosen pembimbing aktif</td>
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
        $('#pendingInternshipsTable').DataTable({
            responsive: true,
            paging: false,
            searching: false,
            info: false
        });
        
        // Chart distribusi program studi
        var studyProgramCtx = document.getElementById('studyProgramChart');
        var studyProgramChart = new Chart(studyProgramCtx, {
            type: 'pie',
            data: {
                labels: [
                    @foreach($studyProgramData ?? [] as $program => $count)
                        "{{ $program }}",
                    @endforeach
                ],
                datasets: [{
                    data: [
                        @foreach($studyProgramData ?? [] as $program => $count)
                            {{ $count }},
                        @endforeach
                    ],
                    backgroundColor: ['#007bff', '#28a745', '#ffc107', '#17a2b8', '#dc3545', '#6f42c1', '#fd7e14'],
                }],
            },
            options: {
                responsive: true,
                legend: {
                    position: 'bottom',
                    labels: {
                        boxWidth: 15
                    }
                }
            }
        });
        
        // Chart tren bulanan
        var monthlyCtx = document.getElementById('monthlyTrendChart');
        var monthlyChart = new Chart(monthlyCtx, {
            type: 'bar',
            data: {
                labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Ags", "Sep", "Okt", "Nov", "Des"],
                datasets: [{
                    label: 'Pengajuan PKL',
                    data: [
                        {{ $monthlyData[0] ?? 0 }}, {{ $monthlyData[1] ?? 0 }}, 
                        {{ $monthlyData[2] ?? 0 }}, {{ $monthlyData[3] ?? 0 }}, 
                        {{ $monthlyData[4] ?? 0 }}, {{ $monthlyData[5] ?? 0 }}, 
                        {{ $monthlyData[6] ?? 0 }}, {{ $monthlyData[7] ?? 0 }}, 
                        {{ $monthlyData[8] ?? 0 }}, {{ $monthlyData[9] ?? 0 }}, 
                        {{ $monthlyData[10] ?? 0 }}, {{ $monthlyData[11] ?? 0 }}
                    ],
                    backgroundColor: 'rgba(0, 123, 255, 0.5)',
                    borderColor: 'rgba(0, 123, 255, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            stepSize: 1
                        }
                    }]
                },
                legend: {
                    display: false
                }
            }
        });
    });
</script>
@endsection 