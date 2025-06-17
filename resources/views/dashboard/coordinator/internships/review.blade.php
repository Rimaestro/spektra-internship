@extends('layouts.app')

@section('title', 'Review Pengajuan PKL')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Review Pengajuan PKL</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('coordinator.internships.pending') }}">Pengajuan PKL</a></li>
        <li class="breadcrumb-item active">Review</li>
    </ol>

    @include('layouts.partials.flash-messages')
    
    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-file-alt me-1"></i>
                    Detail Pengajuan PKL
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5 class="mb-3">Informasi Mahasiswa</h5>
                            <table class="table table-sm">
                                <tr>
                                    <th width="35%">Nama</th>
                                    <td>{{ $internship->student->name }}</td>
                                </tr>
                                <tr>
                                    <th>NIM</th>
                                    <td>{{ $internship->student->nim }}</td>
                                </tr>
                                <tr>
                                    <th>Program Studi</th>
                                    <td>{{ $internship->student->study_program }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{ $internship->student->email }}</td>
                                </tr>
                                <tr>
                                    <th>Telepon</th>
                                    <td>{{ $internship->student->phone ?? '-' }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5 class="mb-3">Informasi Perusahaan</h5>
                            <table class="table table-sm">
                                <tr>
                                    <th width="35%">Nama Perusahaan</th>
                                    <td>{{ $internship->company->name }}</td>
                                </tr>
                                <tr>
                                    <th>Alamat</th>
                                    <td>{{ $internship->company->address }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{ $internship->company->email }}</td>
                                </tr>
                                <tr>
                                    <th>Kontak Person</th>
                                    <td>{{ $internship->company->contact_person }}</td>
                                </tr>
                                <tr>
                                    <th>Bidang PKL</th>
                                    <td><span class="badge bg-info">{{ $internship->field->name }}</span></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h5 class="mb-3">Detail PKL</h5>
                            <table class="table table-bordered">
                                <tr>
                                    <th width="25%">Tanggal Pengajuan</th>
                                    <td>{{ $internship->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Periode PKL</th>
                                    <td>{{ $internship->start_date->format('d/m/Y') }} - {{ $internship->end_date->format('d/m/Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Durasi</th>
                                    <td>{{ $internship->start_date->diffInWeeks($internship->end_date) }} minggu ({{ $internship->start_date->diffInDays($internship->end_date) }} hari)</td>
                                </tr>
                                <tr>
                                    <th>Pembimbing Lapangan</th>
                                    <td>{{ $internship->field_supervisor_name ?? 'Belum ditentukan' }}</td>
                                </tr>
                                <tr>
                                    <th>Kontak Pembimbing</th>
                                    <td>{{ $internship->field_supervisor_contact ?? '-' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h5 class="mb-3">Dokumen Pendukung</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Jenis Dokumen</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Surat Pengajuan PKL</td>
                                            <td>
                                                <a href="{{ asset('storage/' . $internship->application_letter) }}" target="_blank" class="btn btn-primary btn-sm">
                                                    <i class="fas fa-file-pdf me-1"></i> Lihat Dokumen
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>CV (Curriculum Vitae)</td>
                                            <td>
                                                <a href="{{ asset('storage/' . $internship->cv) }}" target="_blank" class="btn btn-primary btn-sm">
                                                    <i class="fas fa-file-pdf me-1"></i> Lihat Dokumen
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    @if($internship->motivation_letter)
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h5 class="mb-3">Surat Motivasi</h5>
                            <div class="p-3 bg-light rounded">
                                {!! nl2br(e($internship->motivation_letter)) !!}
                            </div>
                        </div>
                    </div>
                    @endif

                    <form action="{{ route('coordinator.internships.process', $internship->id) }}" method="POST">
                        @csrf
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <h5 class="mb-3">Penugasan Dosen Pembimbing</h5>
                                <div class="mb-3">
                                    <label for="supervisor_id" class="form-label">Dosen Pembimbing <span class="text-danger">*</span></label>
                                    <select class="form-select @error('supervisor_id') is-invalid @enderror" id="supervisor_id" name="supervisor_id" required>
                                        <option value="">Pilih Dosen Pembimbing</option>
                                        @foreach($supervisors as $supervisor)
                                            <option value="{{ $supervisor->id }}">
                                                {{ $supervisor->name }} ({{ $supervisor->active_internships_count ?? 0 }} bimbingan aktif)
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="form-text">Pilih dosen pembimbing yang akan ditugaskan untuk PKL ini.</div>
                                    @error('supervisor_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-12">
                                <h5 class="mb-3">Catatan dan Persetujuan</h5>
                                <div class="mb-3">
                                    <label for="notes" class="form-label">Catatan Koordinator</label>
                                    <textarea class="form-control" id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                                    <div class="form-text">Tambahkan catatan tambahan jika diperlukan.</div>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Keputusan <span class="text-danger">*</span></label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status" id="statusApproved" value="approved" required>
                                        <label class="form-check-label" for="statusApproved">
                                            <span class="text-success">Setujui</span> - Pengajuan PKL diterima
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status" id="statusRejected" value="rejected" required>
                                        <label class="form-check-label" for="statusRejected">
                                            <span class="text-danger">Tolak</span> - Pengajuan PKL ditolak
                                        </label>
                                    </div>
                                </div>
                                
                                <div id="rejectionReasonContainer" class="mb-3 d-none">
                                    <label for="rejection_reason" class="form-label">Alasan Penolakan <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="rejection_reason" name="rejection_reason" rows="3">{{ old('rejection_reason') }}</textarea>
                                    <div class="form-text">Berikan alasan mengapa pengajuan PKL ini ditolak.</div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('coordinator.internships.pending') }}" class="btn btn-secondary me-2">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan Keputusan</button>
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
                    <div class="alert alert-info mb-3">
                        <h6 class="alert-heading mb-2"><i class="fas fa-exclamation-circle me-1"></i> Penting</h6>
                        <p class="mb-0">Mohon periksa semua informasi secara teliti sebelum memberikan persetujuan. Pastikan dokumen pendukung sudah sesuai dengan ketentuan.</p>
                    </div>
                    
                    <div class="card bg-light mb-3">
                        <div class="card-body">
                            <h6 class="card-title">Perusahaan: {{ $internship->company->name }}</h6>
                            <p class="mb-1 small"><strong>Kuota:</strong> {{ $internship->company->internships_count ?? 0 }} / {{ $internship->company->quota }}</p>
                            <p class="mb-0 small"><strong>Bidang:</strong> 
                                @foreach($internship->company->fields as $field)
                                    <span class="badge bg-info me-1">{{ $field->name }}</span>
                                @endforeach
                            </p>
                            <hr>
                            <p class="mb-0 small">
                                @if(($internship->company->internships_count ?? 0) < $internship->company->quota)
                                    <span class="text-success"><i class="fas fa-check-circle"></i> Kuota PKL masih tersedia</span>
                                @else
                                    <span class="text-danger"><i class="fas fa-exclamation-circle"></i> Kuota PKL sudah penuh</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    
                    <div class="card bg-light">
                        <div class="card-body">
                            <h6 class="card-title">Rekap Beban Dosen Pembimbing</h6>
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Dosen</th>
                                            <th class="text-center">Bimbingan Aktif</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($supervisors as $supervisor)
                                            <tr>
                                                <td>{{ $supervisor->name }}</td>
                                                <td class="text-center">{{ $supervisor->active_internships_count ?? 0 }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-check-square me-1"></i>
                    Checklist Persetujuan
                </div>
                <div class="card-body">
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="check1">
                        <label class="form-check-label" for="check1">
                            Dokumen pengajuan lengkap dan sesuai format
                        </label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="check2">
                        <label class="form-check-label" for="check2">
                            Periode PKL minimal 3 bulan
                        </label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="check3">
                        <label class="form-check-label" for="check3">
                            Perusahaan memiliki kuota PKL tersedia
                        </label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="check4">
                        <label class="form-check-label" for="check4">
                            Bidang PKL sesuai dengan program studi
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="check5">
                        <label class="form-check-label" for="check5">
                            Pembimbing tersedia dan sesuai
                        </label>
                    </div>
                    <hr>
                    <p class="small text-muted mb-0">Checklist ini hanya sebagai panduan dan tidak mempengaruhi proses penyimpanan data.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('input[name="status"]').change(function() {
            if ($(this).val() === 'rejected') {
                $('#rejectionReasonContainer').removeClass('d-none');
                $('#rejection_reason').attr('required', true);
                $('#supervisor_id').removeAttr('required');
            } else {
                $('#rejectionReasonContainer').addClass('d-none');
                $('#rejection_reason').removeAttr('required');
                $('#supervisor_id').attr('required', true);
            }
        });
    });
</script>
@endsection 