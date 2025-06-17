@extends('layouts.app')

@section('title', 'Detail Laporan Harian')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Detail Laporan Harian</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('student.daily-reports.index') }}">Laporan Harian</a></li>
        <li class="breadcrumb-item active">Detail</li>
    </ol>

    @include('layouts.partials.flash-messages')
    
    <div class="row">
        <div class="col-xl-8 col-lg-7">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-file-alt me-1"></i>
                        Detail Laporan Harian - {{ $report->report_date->format('d F Y') }}
                    </div>
                    <div>
                        @if($report->status == 'pending')
                            <span class="badge bg-warning">Menunggu Persetujuan</span>
                        @elseif($report->status == 'approved')
                            <span class="badge bg-success">Disetujui</span>
                        @elseif($report->status == 'rejected')
                            <span class="badge bg-danger">Ditolak</span>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <h5 class="card-title">{{ $report->activity_title }}</h5>
                    <hr>
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <table class="table table-sm">
                                <tr>
                                    <th width="35%">Tanggal</th>
                                    <td>{{ $report->report_date->format('d/m/Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Jam Kerja</th>
                                    <td>{{ $report->work_hours }} jam</td>
                                </tr>
                                <tr>
                                    <th>Lokasi Kerja</th>
                                    <td>{{ $report->location }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-sm">
                                <tr>
                                    <th width="35%">Perusahaan</th>
                                    <td>{{ $report->internship->company->name }}</td>
                                </tr>
                                <tr>
                                    <th>Bidang PKL</th>
                                    <td>{{ $report->internship->field->name }}</td>
                                </tr>
                                <tr>
                                    <th>Waktu Dibuat</th>
                                    <td>{{ $report->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <h6 class="fw-bold">Deskripsi Aktivitas</h6>
                        <div class="p-3 bg-light rounded">
                            {!! nl2br(e($report->activity_description)) !!}
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <h6 class="fw-bold">Hasil Pembelajaran</h6>
                        <div class="p-3 bg-light rounded">
                            {!! nl2br(e($report->learning_outcomes)) !!}
                        </div>
                    </div>
                    
                    @if($report->challenges)
                    <div class="mb-4">
                        <h6 class="fw-bold">Kendala yang Dihadapi</h6>
                        <div class="p-3 bg-light rounded">
                            {!! nl2br(e($report->challenges)) !!}
                        </div>
                    </div>
                    @endif
                    
                    @if($report->attachment)
                    <div class="mb-4">
                        <h6 class="fw-bold">Lampiran</h6>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-paperclip me-2 text-primary"></i>
                            <a href="{{ asset('storage/' . $report->attachment) }}" target="_blank" class="text-decoration-none">
                                Lihat Lampiran
                            </a>
                        </div>
                    </div>
                    @endif
                    
                    @if($report->verification_notes)
                    <div class="mb-4">
                        <h6 class="fw-bold">Catatan Verifikasi</h6>
                        <div class="p-3 bg-light rounded">
                            {!! nl2br(e($report->verification_notes)) !!}
                        </div>
                    </div>
                    @endif
                    
                    @if($report->status == 'rejected' && $report->rejection_reason)
                    <div class="mb-4">
                        <h6 class="fw-bold">Alasan Penolakan</h6>
                        <div class="p-3 bg-danger text-white bg-opacity-75 rounded">
                            {!! nl2br(e($report->rejection_reason)) !!}
                        </div>
                    </div>
                    @endif
                    
                    @if($report->status == 'pending')
                    <div class="d-flex justify-content-end mt-4">
                        <a href="{{ route('student.daily-reports.index') }}" class="btn btn-secondary me-2">
                            <i class="fas fa-arrow-left me-1"></i> Kembali
                        </a>
                        <a href="{{ route('student.daily-reports.edit', $report->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-1"></i> Edit Laporan
                        </a>
                    </div>
                    @else
                    <div class="d-flex justify-content-end mt-4">
                        <a href="{{ route('student.daily-reports.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-5">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-info-circle me-1"></i>
                    Informasi Verifikasi
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        @if($report->status == 'pending')
                            <div class="py-2">
                                <i class="fas fa-clock fa-4x text-warning"></i>
                            </div>
                            <h5 class="mb-1 text-warning">Menunggu Persetujuan</h5>
                            <p class="text-muted mb-0 small">Laporan akan diperiksa oleh pembimbing</p>
                        @elseif($report->status == 'approved')
                            <div class="py-2">
                                <i class="fas fa-check-circle fa-4x text-success"></i>
                            </div>
                            <h5 class="mb-1 text-success">Laporan Disetujui</h5>
                            <p class="text-muted mb-0 small">Laporan telah diverifikasi dan disetujui</p>
                        @elseif($report->status == 'rejected')
                            <div class="py-2">
                                <i class="fas fa-times-circle fa-4x text-danger"></i>
                            </div>
                            <h5 class="mb-1 text-danger">Laporan Ditolak</h5>
                            <p class="text-muted mb-0 small">Silahkan buat laporan baru dengan perbaikan</p>
                        @endif
                    </div>

                    @if($report->status != 'pending')
                    <div class="alert {{ $report->status == 'approved' ? 'alert-success' : 'alert-danger' }} mb-3">
                        <div class="d-flex align-items-center mb-2">
                            <div class="flex-shrink-0 me-2">
                                @if($report->status == 'approved')
                                    <i class="fas fa-user-check"></i>
                                @else
                                    <i class="fas fa-user-times"></i>
                                @endif
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-0">{{ $report->verified_by_name }}</h6>
                                <div class="small">{{ $report->verified_at ? $report->verified_at->format('d/m/Y H:i') : '' }}</div>
                            </div>
                        </div>

                        @if($report->verification_notes)
                        <hr>
                        <p class="mb-0 small">{{ $report->verification_notes }}</p>
                        @endif
                    </div>
                    @endif

                    <table class="table table-sm">
                        <tr>
                            <th width="40%">Status</th>
                            <td>
                                @if($report->status == 'pending')
                                    <span class="badge bg-warning">Menunggu Persetujuan</span>
                                @elseif($report->status == 'approved')
                                    <span class="badge bg-success">Disetujui</span>
                                @elseif($report->status == 'rejected')
                                    <span class="badge bg-danger">Ditolak</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Tanggal Submit</th>
                            <td>{{ $report->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        @if($report->updated_at && $report->updated_at->ne($report->created_at))
                        <tr>
                            <th>Terakhir Diubah</th>
                            <td>{{ $report->updated_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        @endif
                        @if($report->verified_at)
                        <tr>
                            <th>Tanggal Verifikasi</th>
                            <td>{{ $report->verified_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        @endif
                        @if($report->verified_by)
                        <tr>
                            <th>Diverifikasi Oleh</th>
                            <td>{{ $report->verified_by_name }}</td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-map-marker-alt me-1"></i>
                    Lokasi Kerja
                </div>
                <div class="card-body">
                    @if($report->latitude && $report->longitude)
                    <div id="mapContainer" class="mb-3" style="height: 250px;"></div>
                    <p class="small text-muted mb-0">{{ $report->location }}</p>
                    @else
                    <p class="text-muted mb-0">{{ $report->location }}</p>
                    <p class="small text-muted mb-0">(Koordinat lokasi tidak tersedia)</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@if($report->latitude && $report->longitude)
@section('scripts')
<script>
    $(document).ready(function() {
        // Initialize map
        const mapContainer = document.getElementById('mapContainer');
        if (mapContainer) {
            const map = L.map('mapContainer').setView([{{ $report->latitude }}, {{ $report->longitude }}], 15);
            
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);
            
            L.marker([{{ $report->latitude }}, {{ $report->longitude }}])
                .addTo(map)
                .bindPopup('{{ $report->activity_title }}<br>{{ $report->report_date->format('d/m/Y') }}')
                .openPopup();
        }
    });
</script>
@endsection
@endif 