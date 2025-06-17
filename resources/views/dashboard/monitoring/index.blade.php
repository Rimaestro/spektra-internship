@extends('layouts.app')

@section('title', 'Monitoring PKL')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Monitoring PKL</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Monitoring PKL</li>
    </ol>

    @include('layouts.partials.flash-messages')

    <div class="row mb-3">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-chart-line me-1"></i>
                        Statistik PKL
                    </div>
                    <div>
                        <select class="form-select form-select-sm" id="periodFilter">
                            <option value="all">Semua Periode</option>
                            @foreach($periods as $period)
                                <option value="{{ $period }}">{{ $period }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-xl-3 col-md-6 mb-3">
                            <div class="card border-left-primary h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col-auto">
                                            <i class="fas fa-users fa-2x text-primary"></i>
                                        </div>
                                        <div class="col ml-3">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Total Mahasiswa PKL
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold" id="totalInternships">{{ $stats['totalInternships'] }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xl-3 col-md-6 mb-3">
                            <div class="card border-left-success h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col-auto">
                                            <i class="fas fa-check-circle fa-2x text-success"></i>
                                        </div>
                                        <div class="col ml-3">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                PKL Selesai
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold" id="completedInternships">{{ $stats['completedInternships'] }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xl-3 col-md-6 mb-3">
                            <div class="card border-left-info h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col-auto">
                                            <i class="fas fa-spinner fa-2x text-info"></i>
                                        </div>
                                        <div class="col ml-3">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                PKL Berlangsung
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold" id="ongoingInternships">{{ $stats['ongoingInternships'] }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xl-3 col-md-6 mb-3">
                            <div class="card border-left-warning h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col-auto">
                                            <i class="fas fa-clock fa-2x text-warning"></i>
                                        </div>
                                        <div class="col ml-3">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Menunggu Persetujuan
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold" id="pendingInternships">{{ $stats['pendingInternships'] }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-chart-pie me-1"></i>
                                    Distribusi Status PKL
                                </div>
                                <div class="card-body">
                                    <canvas id="internshipStatusChart" width="100%" height="50"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-chart-bar me-1"></i>
                                    Distribusi Perusahaan
                                </div>
                                <div class="card-body">
                                    <canvas id="companiesChart" width="100%" height="50"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-search me-1"></i>
                    Filter Monitoring
                </div>
                <div class="card-body">
                    <form id="monitoringFilterForm">
                        <div class="mb-3">
                            <label for="statusFilter" class="form-label">Status PKL</label>
                            <select class="form-select" id="statusFilter" name="status">
                                <option value="">Semua Status</option>
                                <option value="pending">Menunggu Persetujuan</option>
                                <option value="approved">Disetujui</option>
                                <option value="ongoing">Sedang Berlangsung</option>
                                <option value="completed">Selesai</option>
                                <option value="rejected">Ditolak</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="companyFilter" class="form-label">Perusahaan</label>
                            <select class="form-select" id="companyFilter" name="company_id">
                                <option value="">Semua Perusahaan</option>
                                @foreach($companies as $company)
                                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="supervisorFilter" class="form-label">Dosen Pembimbing</label>
                            <select class="form-select" id="supervisorFilter" name="supervisor_id">
                                <option value="">Semua Dosen</option>
                                @foreach($supervisors as $supervisor)
                                    <option value="{{ $supervisor->id }}">{{ $supervisor->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="fieldFilter" class="form-label">Bidang PKL</label>
                            <select class="form-select" id="fieldFilter" name="field_id">
                                <option value="">Semua Bidang</option>
                                @foreach($fields as $field)
                                    <option value="{{ $field->id }}">{{ $field->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="dateRangeFilter" class="form-label">Rentang Tanggal</label>
                            <div class="input-group">
                                <input type="date" class="form-control" id="startDateFilter" name="start_date">
                                <span class="input-group-text">hingga</span>
                                <input type="date" class="form-control" id="endDateFilter" name="end_date">
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-filter me-1"></i> Terapkan Filter
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-download me-1"></i>
                    Ekspor Data
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Format Ekspor</label>
                        <div class="d-grid gap-2">
                            <a href="{{ route('monitoring.export', ['format' => 'pdf']) }}" target="_blank" class="btn btn-danger">
                                <i class="fas fa-file-pdf me-1"></i> Ekspor PDF
                            </a>
                            <a href="{{ route('monitoring.export', ['format' => 'excel']) }}" class="btn btn-success">
                                <i class="fas fa-file-excel me-1"></i> Ekspor Excel
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-table me-1"></i>
                Data Monitoring PKL
            </div>
            <div class="d-flex">
                <input type="text" class="form-control form-control-sm me-2" id="searchInput" placeholder="Cari mahasiswa atau perusahaan...">
                <select class="form-select form-select-sm" id="itemsPerPage">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="monitoringTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Mahasiswa</th>
                            <th>NIM</th>
                            <th>Perusahaan</th>
                            <th>Bidang</th>
                            <th>Periode</th>
                            <th>Pembimbing</th>
                            <th>Progress</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($internships as $internship)
                        <tr>
                            <td>{{ $internship->student->name }}</td>
                            <td>{{ $internship->student->nim }}</td>
                            <td>{{ $internship->company->name }}</td>
                            <td>{{ $internship->field->name }}</td>
                            <td>{{ $internship->start_date->format('d/m/Y') }} - {{ $internship->end_date->format('d/m/Y') }}</td>
                            <td>{{ $internship->supervisor->name ?? 'Belum ditentukan' }}</td>
                            <td>
                                @php
                                    $startDate = $internship->start_date;
                                    $endDate = $internship->end_date;
                                    $today = now();
                                    
                                    if ($today < $startDate) {
                                        $progress = 0;
                                    } elseif ($today > $endDate) {
                                        $progress = 100;
                                    } else {
                                        $totalDays = $startDate->diffInDays($endDate);
                                        $passedDays = $startDate->diffInDays($today);
                                        $progress = ($passedDays / $totalDays) * 100;
                                    }
                                @endphp
                                <div class="progress">
                                    <div class="progress-bar {{ $progress < 50 ? 'bg-info' : ($progress < 75 ? 'bg-primary' : 'bg-success') }}" 
                                         role="progressbar" 
                                         style="width: {{ $progress }}%;" 
                                         aria-valuenow="{{ $progress }}" 
                                         aria-valuemin="0" 
                                         aria-valuemax="100">
                                        {{ round($progress) }}%
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($internship->status == 'pending')
                                    <span class="badge bg-warning">Menunggu Persetujuan</span>
                                @elseif($internship->status == 'approved')
                                    <span class="badge bg-info">Disetujui</span>
                                @elseif($internship->status == 'ongoing')
                                    <span class="badge bg-primary">Sedang Berlangsung</span>
                                @elseif($internship->status == 'completed')
                                    <span class="badge bg-success">Selesai</span>
                                @elseif($internship->status == 'rejected')
                                    <span class="badge bg-danger">Ditolak</span>
                                @else
                                    <span class="badge bg-secondary">{{ $internship->status }}</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('monitoring.show', $internship->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('monitoring.reports', $internship->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-clipboard-list"></i>
                                    </a>
                                    <a href="{{ route('monitoring.evaluation', $internship->id) }}" class="btn btn-sm btn-success">
                                        <i class="fas fa-chart-bar"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="text-muted small">
                    Menampilkan <span id="displayedItems">{{ count($internships) }}</span> dari <span id="totalItems">{{ $stats['totalInternships'] }}</span> data
                </div>
                <div>
                    {{ $internships->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    $(document).ready(function() {
        // Status Chart
        const statusCtx = document.getElementById('internshipStatusChart');
        const statusData = {
            labels: ['Menunggu Persetujuan', 'Disetujui', 'Berlangsung', 'Selesai', 'Ditolak'],
            datasets: [{
                data: [
                    {{ $stats['pendingInternships'] }},
                    {{ $stats['approvedInternships'] }},
                    {{ $stats['ongoingInternships'] }},
                    {{ $stats['completedInternships'] }},
                    {{ $stats['rejectedInternships'] }}
                ],
                backgroundColor: ['#f6c23e', '#36b9cc', '#4e73df', '#1cc88a', '#e74a3b']
            }]
        };
        new Chart(statusCtx, {
            type: 'pie',
            data: statusData,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        // Companies Chart
        const companiesCtx = document.getElementById('companiesChart');
        const companiesData = {
            labels: {!! json_encode($companyStats['labels']) !!},
            datasets: [{
                label: 'Jumlah Mahasiswa PKL',
                data: {!! json_encode($companyStats['data']) !!},
                backgroundColor: 'rgba(78, 115, 223, 0.7)',
                borderColor: 'rgba(78, 115, 223, 1)',
                borderWidth: 1
            }]
        };
        new Chart(companiesCtx, {
            type: 'bar',
            data: companiesData,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });

        // Handle period filter change
        $('#periodFilter').change(function() {
            const period = $(this).val();
            // Make AJAX call to update statistics based on period
            $.ajax({
                url: "{{ route('monitoring.stats') }}",
                data: { period: period },
                success: function(response) {
                    // Update statistics
                    $('#totalInternships').text(response.totalInternships);
                    $('#completedInternships').text(response.completedInternships);
                    $('#ongoingInternships').text(response.ongoingInternships);
                    $('#pendingInternships').text(response.pendingInternships);
                    
                    // Update charts
                    // ...
                }
            });
        });

        // Handle search input
        $('#searchInput').on('keyup', function() {
            const value = $(this).val().toLowerCase();
            $("#monitoringTable tbody tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                updateDisplayedItemsCount();
            });
        });

        // Handle items per page change
        $('#itemsPerPage').change(function() {
            const value = $(this).val();
            // Make AJAX call to update pagination
            // ...
        });

        function updateDisplayedItemsCount() {
            const visibleRows = $("#monitoringTable tbody tr:visible").length;
            $('#displayedItems').text(visibleRows);
        }

        // Monitoring filter form submission
        $('#monitoringFilterForm').submit(function(e) {
            e.preventDefault();
            const formData = $(this).serialize();
            
            $.ajax({
                url: "{{ route('monitoring.filter') }}",
                data: formData,
                success: function(response) {
                    // Update table with filtered data
                    // ...
                    
                    // Update statistics
                    // ...
                }
            });
        });
    });
</script>
@endsection 