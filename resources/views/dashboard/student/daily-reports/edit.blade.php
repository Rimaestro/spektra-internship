@extends('layouts.app')

@section('title', 'Edit Laporan Harian')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Edit Laporan Harian</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('student.daily-reports.index') }}">Laporan Harian</a></li>
        <li class="breadcrumb-item active">Edit Laporan</li>
    </ol>

    @include('layouts.partials.flash-messages')

    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-edit me-1"></i>
                    Form Edit Laporan Harian
                </div>
                <div class="card-body">
                    <form action="{{ route('student.daily-reports.update', $report->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <input type="hidden" name="internship_id" value="{{ $report->internship_id }}">
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="report_date" class="form-label">Tanggal <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('report_date') is-invalid @enderror" id="report_date" name="report_date" value="{{ old('report_date', $report->report_date->format('Y-m-d')) }}" required>
                                @error('report_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="work_hours" class="form-label">Jam Kerja <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" class="form-control @error('work_hours') is-invalid @enderror" id="work_hours" name="work_hours" value="{{ old('work_hours', $report->work_hours) }}" min="1" max="24" required>
                                    <span class="input-group-text">jam</span>
                                </div>
                                @error('work_hours')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="activity_title" class="form-label">Judul Aktivitas <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('activity_title') is-invalid @enderror" id="activity_title" name="activity_title" value="{{ old('activity_title', $report->activity_title) }}" required>
                            @error('activity_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="activity_description" class="form-label">Deskripsi Aktivitas <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('activity_description') is-invalid @enderror" id="activity_description" name="activity_description" rows="5" required>{{ old('activity_description', $report->activity_description) }}</textarea>
                            @error('activity_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="learning_outcomes" class="form-label">Hasil Pembelajaran <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('learning_outcomes') is-invalid @enderror" id="learning_outcomes" name="learning_outcomes" rows="3" required>{{ old('learning_outcomes', $report->learning_outcomes) }}</textarea>
                            <div class="form-text">Jelaskan apa yang Anda pelajari dari aktivitas hari ini.</div>
                            @error('learning_outcomes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="challenges" class="form-label">Kendala yang Dihadapi</label>
                            <textarea class="form-control @error('challenges') is-invalid @enderror" id="challenges" name="challenges" rows="3">{{ old('challenges', $report->challenges) }}</textarea>
                            <div class="form-text">Jelaskan kendala yang Anda hadapi selama melaksanakan aktivitas (opsional).</div>
                            @error('challenges')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="attachment" class="form-label">Lampiran (opsional)</label>
                            <input type="file" class="form-control @error('attachment') is-invalid @enderror" id="attachment" name="attachment">
                            <div class="form-text">
                                File pendukung seperti gambar atau dokumen (maksimal 5MB).
                                @if($report->attachment)
                                <br>
                                <strong>Lampiran saat ini:</strong> 
                                <a href="{{ asset('storage/' . $report->attachment) }}" target="_blank">Lihat Lampiran</a>
                                <div class="form-check mt-2">
                                    <input class="form-check-input" type="checkbox" id="remove_attachment" name="remove_attachment" value="1">
                                    <label class="form-check-label" for="remove_attachment">
                                        Hapus lampiran saat ini
                                    </label>
                                </div>
                                @endif
                            </div>
                            @error('attachment')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="location" class="form-label">Lokasi Kerja <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                <input type="text" class="form-control @error('location') is-invalid @enderror" id="location" name="location" value="{{ old('location', $report->location) }}" required>
                                <button type="button" class="btn btn-outline-secondary" id="detectLocation">
                                    <i class="fas fa-crosshairs"></i> Deteksi
                                </button>
                            </div>
                            <div class="form-text">Masukkan lokasi tempat Anda bekerja hari ini.</div>
                            @error('location')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude', $report->latitude) }}">
                        <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude', $report->longitude) }}">
                        
                        <div class="d-flex justify-content-end mt-4">
                            <a href="{{ route('student.daily-reports.show', $report->id) }}" class="btn btn-secondary me-2">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-info-circle me-1"></i>
                    Informasi
                </div>
                <div class="card-body">
                    <div class="alert alert-warning mb-3">
                        <h6 class="alert-heading mb-2"><i class="fas fa-exclamation-triangle me-1"></i> Perhatian</h6>
                        <p class="mb-0">Laporan yang sudah diverifikasi tidak dapat diedit. Hanya laporan dengan status "Menunggu Persetujuan" yang dapat diubah.</p>
                    </div>

                    <div class="mb-3">
                        <h6 class="fw-bold mb-2">Informasi PKL</h6>
                        <table class="table table-sm">
                            <tr>
                                <th width="40%">Perusahaan</th>
                                <td>{{ $report->internship->company->name }}</td>
                            </tr>
                            <tr>
                                <th>Bidang PKL</th>
                                <td>{{ $report->internship->field->name }}</td>
                            </tr>
                            <tr>
                                <th>Pembimbing</th>
                                <td>{{ $report->internship->supervisor ? $report->internship->supervisor->name : 'Belum ditentukan' }}</td>
                            </tr>
                        </table>
                    </div>
                    
                    <div class="alert alert-info">
                        <h6 class="alert-heading mb-2"><i class="fas fa-lightbulb me-1"></i> Tips</h6>
                        <p class="mb-0">Pastikan untuk menyertakan detail aktivitas yang jelas dan hasil pembelajaran yang spesifik untuk mempermudah proses verifikasi.</p>
                    </div>
                </div>
            </div>

            @if($report->latitude && $report->longitude)
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-map-marker-alt me-1"></i>
                    Lokasi Saat Ini
                </div>
                <div class="card-body">
                    <div id="mapContainer" style="height: 250px;"></div>
                    <p class="small text-muted mt-2 mb-0">{{ $report->location }}</p>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Validasi tanggal tidak boleh di masa depan
        const today = new Date();
        const yyyy = today.getFullYear();
        let mm = today.getMonth() + 1;
        let dd = today.getDate();
        if (mm < 10) mm = '0' + mm;
        if (dd < 10) dd = '0' + dd;
        const formattedToday = yyyy + '-' + mm + '-' + dd;
        
        $('#report_date').attr('max', formattedToday);
        
        // Deteksi lokasi
        $('#detectLocation').click(function() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    const latitude = position.coords.latitude;
                    const longitude = position.coords.longitude;
                    
                    $('#latitude').val(latitude);
                    $('#longitude').val(longitude);
                    
                    // Reverse geocoding untuk mendapatkan alamat lokasi
                    fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${latitude}&lon=${longitude}`)
                        .then(response => response.json())
                        .then(data => {
                            $('#location').val(data.display_name);
                        })
                        .catch(error => {
                            $('#location').val(`${latitude}, ${longitude}`);
                            console.error('Error getting location name:', error);
                        });
                }, function(error) {
                    let message;
                    switch(error.code) {
                        case error.PERMISSION_DENIED:
                            message = "Izin untuk mengakses lokasi ditolak.";
                            break;
                        case error.POSITION_UNAVAILABLE:
                            message = "Informasi lokasi tidak tersedia.";
                            break;
                        case error.TIMEOUT:
                            message = "Waktu permintaan lokasi habis.";
                            break;
                        case error.UNKNOWN_ERROR:
                            message = "Terjadi kesalahan yang tidak diketahui.";
                            break;
                    }
                    alert(`Gagal mendeteksi lokasi: ${message}`);
                });
            } else {
                alert("Geolocation tidak didukung oleh browser Anda.");
            }
        });

        @if($report->latitude && $report->longitude)
        // Initialize map if coordinates are available
        const map = L.map('mapContainer').setView([{{ $report->latitude }}, {{ $report->longitude }}], 15);
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
        
        L.marker([{{ $report->latitude }}, {{ $report->longitude }}])
            .addTo(map)
            .bindPopup('Lokasi saat ini')
            .openPopup();
        @endif
    });
</script>
@endsection 