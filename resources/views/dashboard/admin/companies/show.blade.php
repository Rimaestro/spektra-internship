@extends('layouts.app')

@section('title', 'Detail Perusahaan')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Detail Perusahaan</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.companies.index') }}">Perusahaan</a></li>
        <li class="breadcrumb-item active">Detail</li>
    </ol>

    @include('layouts.partials.flash-messages')

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-building me-1"></i>
                {{ $company->name }}
            </div>
            <div>
                <a href="{{ route('admin.companies.edit', $company->id) }}" class="btn btn-warning btn-sm">
                    <i class="fas fa-edit me-1"></i> Edit
                </a>
                <a href="{{ route('admin.companies.index') }}" class="btn btn-secondary btn-sm ms-1">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-8">
                    <div class="mb-3">
                        <h5 class="text-muted mb-1">Informasi Perusahaan</h5>
                        <hr>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-3 fw-bold">Status</div>
                        <div class="col-md-9">
                            @if($company->is_active)
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-danger">Non-aktif</span>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-3 fw-bold">Nama Perusahaan</div>
                        <div class="col-md-9">{{ $company->name }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-3 fw-bold">Alamat</div>
                        <div class="col-md-9">{{ $company->address }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-3 fw-bold">Email</div>
                        <div class="col-md-9">{{ $company->email }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-3 fw-bold">Kontak Person</div>
                        <div class="col-md-9">{{ $company->contact_person }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-3 fw-bold">Telepon</div>
                        <div class="col-md-9">{{ $company->phone }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-3 fw-bold">Website</div>
                        <div class="col-md-9">
                            @if($company->website)
                                <a href="{{ $company->website }}" target="_blank">{{ $company->website }}</a>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-3 fw-bold">Kuota PKL</div>
                        <div class="col-md-9">{{ $company->quota }} mahasiswa</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-3 fw-bold">Bidang PKL</div>
                        <div class="col-md-9">
                            @forelse($company->fields as $field)
                                <span class="badge bg-info me-1 mb-1">{{ $field->name }}</span>
                            @empty
                                <span class="text-muted">Tidak ada bidang yang terdaftar</span>
                            @endforelse
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-3 fw-bold">Deskripsi</div>
                        <div class="col-md-9">
                            {!! nl2br(e($company->description)) ?: '<span class="text-muted">-</span>' !!}
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-light">
                        <div class="card-body">
                            <h5 class="text-muted mb-3">Statistik PKL</h5>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span>Total Mahasiswa PKL:</span>
                                    <span class="badge bg-primary">{{ $company->internships_count ?? 0 }}</span>
                                </div>
                                <div class="progress mb-3" style="height: 6px;">
                                    @php
                                        $percentage = $company->quota > 0 ? min(100, ($company->internships_count ?? 0) / $company->quota * 100) : 0;
                                    @endphp
                                    <div class="progress-bar" role="progressbar" style="width: {{ $percentage }}%;" 
                                        aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <small class="text-muted">{{ $company->internships_count ?? 0 }} dari {{ $company->quota }} kuota terisi</small>
                            </div>

                            <h6 class="mt-4 mb-2">Status Mahasiswa PKL</h6>
                            <div class="mb-1 d-flex justify-content-between align-items-center">
                                <small>Aktif</small>
                                <span class="badge bg-success">{{ $activeInternships ?? 0 }}</span>
                            </div>
                            <div class="mb-1 d-flex justify-content-between align-items-center">
                                <small>Menunggu Persetujuan</small>
                                <span class="badge bg-warning">{{ $pendingInternships ?? 0 }}</span>
                            </div>
                            <div class="mb-1 d-flex justify-content-between align-items-center">
                                <small>Selesai</small>
                                <span class="badge bg-info">{{ $completedInternships ?? 0 }}</span>
                            </div>
                            <div class="mb-1 d-flex justify-content-between align-items-center">
                                <small>Ditolak</small>
                                <span class="badge bg-danger">{{ $rejectedInternships ?? 0 }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <h5 class="mb-3">Daftar Mahasiswa PKL di {{ $company->name }}</h5>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="internshipsTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Nama Mahasiswa</th>
                                <th>NIM</th>
                                <th>Program Studi</th>
                                <th>Bidang PKL</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Selesai</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($company->internships ?? [] as $internship)
                                <tr>
                                    <td>{{ $internship->student->name }}</td>
                                    <td>{{ $internship->student->nim }}</td>
                                    <td>{{ $internship->student->study_program }}</td>
                                    <td>{{ $internship->field->name }}</td>
                                    <td>{{ $internship->start_date->format('d/m/Y') }}</td>
                                    <td>{{ $internship->end_date->format('d/m/Y') }}</td>
                                    <td>
                                        @if($internship->status == 'pending')
                                            <span class="badge bg-warning">Menunggu Persetujuan</span>
                                        @elseif($internship->status == 'approved')
                                            <span class="badge bg-success">Disetujui</span>
                                        @elseif($internship->status == 'rejected')
                                            <span class="badge bg-danger">Ditolak</span>
                                        @elseif($internship->status == 'completed')
                                            <span class="badge bg-info">Selesai</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">Tidak ada mahasiswa PKL</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#internshipsTable').DataTable({
            responsive: true
        });
    });
</script>
@endsection 