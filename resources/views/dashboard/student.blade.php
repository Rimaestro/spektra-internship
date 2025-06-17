@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-xl-3 col-sm-6 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Status PKL</p>
                                @if(isset($internship))
                                    <h5 class="font-weight-bolder">
                                        @if($internship->status == 'pending')
                                            <span class="text-warning">Menunggu Persetujuan</span>
                                        @elseif($internship->status == 'ongoing')
                                            <span class="text-success">Sedang Berlangsung</span>
                                        @elseif($internship->status == 'completed')
                                            <span class="text-info">Selesai</span>
                                        @elseif($internship->status == 'rejected')
                                            <span class="text-danger">Ditolak</span>
                                        @endif
                                    </h5>
                                @else
                                    <h5 class="font-weight-bolder text-danger">Belum Terdaftar</h5>
                                @endif
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                                <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if(isset($internship))
        <div class="col-xl-3 col-sm-6 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Progress</p>
                                <h5 class="font-weight-bolder">
                                    {{ isset($progressPercentage) ? $progressPercentage : 0 }}%
                                </h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                                <i class="ni ni-chart-bar-32 text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Laporan Harian</p>
                                <h5 class="font-weight-bolder">
                                    {{ isset($reportCount) ? $reportCount : 0 }}
                                </h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-info shadow-info text-center rounded-circle">
                                <i class="ni ni-paper-diploma text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Perusahaan</p>
                                <h5 class="font-weight-bolder">
                                    {{ $internship->company->name ?? 'Belum Ada' }}
                                </h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                                <i class="ni ni-building text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    @if(isset($internship) && $internship->status == 'ongoing')
    <div class="row mt-4">
        <div class="col-lg-7 mb-4">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h6 class="mb-0">Laporan Harian Terbaru</h6>
                        <a href="{{ route('student.daily-reports.create') }}" class="btn btn-sm btn-primary">
                            <i class="fa fa-plus"></i> Buat Laporan
                        </a>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tanggal</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Aktivitas</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status</th>
                                    <th class="text-secondary opacity-7"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($dailyReports) && $dailyReports->count() > 0)
                                    @foreach($dailyReports as $report)
                                    <tr>
                                        <td class="align-middle text-sm">
                                            <p class="text-xs font-weight-bold mb-0">{{ $report->report_date->format('d M Y') }}</p>
                                        </td>
                                        <td class="align-middle text-sm">
                                            <p class="text-xs font-weight-bold mb-0">{{ \Illuminate\Support\Str::limit($report->activities, 50) }}</p>
                                        </td>
                                        <td class="align-middle">
                                            @if($report->is_approved)
                                                <span class="badge badge-sm bg-gradient-success">Disetujui</span>
                                            @else
                                                <span class="badge badge-sm bg-gradient-warning">Menunggu</span>
                                            @endif
                                        </td>
                                        <td class="align-middle">
                                            <a href="{{ route('student.daily-reports.show', $report->id) }}" class="text-secondary font-weight-bold text-xs">
                                                Detail
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4" class="text-center py-3">Belum ada laporan harian</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-5 mb-4">
            <div class="card h-100">
                <div class="card-header pb-0">
                    <h6>Detail PKL</h6>
                </div>
                <div class="card-body p-3">
                    <div class="timeline timeline-one-side">
                        <div class="timeline-block mb-3">
                            <span class="timeline-step bg-primary">
                                <i class="ni ni-bell-55 text-white"></i>
                            </span>
                            <div class="timeline-content">
                                <h6 class="text-dark text-sm font-weight-bold mb-0">Mulai PKL</h6>
                                <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">{{ $internship->start_date->format('d M Y') }}</p>
                            </div>
                        </div>
                        <div class="timeline-block mb-3">
                            <span class="timeline-step bg-info">
                                <i class="ni ni-user-run text-white"></i>
                            </span>
                            <div class="timeline-content">
                                <h6 class="text-dark text-sm font-weight-bold mb-0">Berakhir PKL</h6>
                                <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">{{ $internship->end_date->format('d M Y') }}</p>
                            </div>
                        </div>
                        <div class="timeline-block mb-3">
                            <span class="timeline-step bg-success">
                                <i class="ni ni-trophy text-white"></i>
                            </span>
                            <div class="timeline-content">
                                <h6 class="text-dark text-sm font-weight-bold mb-0">Dosen Pembimbing</h6>
                                <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">{{ $internship->supervisor->name ?? 'Belum ditentukan' }}</p>
                            </div>
                        </div>
                        <div class="timeline-block mb-3">
                            <span class="timeline-step bg-warning">
                                <i class="ni ni-single-02 text-white"></i>
                            </span>
                            <div class="timeline-content">
                                <h6 class="text-dark text-sm font-weight-bold mb-0">Pembimbing Lapangan</h6>
                                <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">{{ $internship->fieldSupervisor->name ?? 'Belum ditentukan' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @elseif(isset($internship) && $internship->status == 'pending')
    <div class="row mt-4">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Detail Pengajuan PKL</h6>
                </div>
                <div class="card-body px-4">
                    <div class="alert alert-info" role="alert">
                        <strong>Pengajuan PKL dalam proses review!</strong> Silakan tunggu persetujuan dari Koordinator PKL.
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Perusahaan:</strong> {{ $internship->company->name }}</p>
                            <p><strong>Tanggal Mulai:</strong> {{ $internship->start_date->format('d M Y') }}</p>
                            <p><strong>Tanggal Selesai:</strong> {{ $internship->end_date->format('d M Y') }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Posisi:</strong> {{ $internship->position }}</p>
                            <p><strong>Tanggal Pengajuan:</strong> {{ $internship->created_at->format('d M Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @elseif(isset($internship) && $internship->status == 'rejected')
    <div class="row mt-4">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Pengajuan PKL Ditolak</h6>
                </div>
                <div class="card-body px-4">
                    <div class="alert alert-danger" role="alert">
                        <strong>Pengajuan PKL Anda ditolak!</strong> Silakan ajukan kembali ke perusahaan lain.
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Perusahaan:</strong> {{ $internship->company->name }}</p>
                            <p><strong>Alasan Penolakan:</strong> {{ $internship->rejection_reason ?? 'Tidak ada alasan spesifik' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Tanggal Pengajuan:</strong> {{ $internship->created_at->format('d M Y') }}</p>
                            <p><strong>Tanggal Penolakan:</strong> {{ $internship->updated_at->format('d M Y') }}</p>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('student.internships.create') }}" class="btn btn-primary">Ajukan PKL Baru</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @elseif(isset($internship) && $internship->status == 'completed')
    <div class="row mt-4">
        <div class="col-lg-7 mb-4">
            <div class="card">
                <div class="card-header pb-0">
                    <h6 class="mb-0">Evaluasi PKL</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Evaluator</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nilai</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Keterangan</th>
                                    <th class="text-secondary opacity-7"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($evaluations) && $evaluations->count() > 0)
                                    @foreach($evaluations as $evaluation)
                                    <tr>
                                        <td class="align-middle">
                                            <div class="d-flex px-3 py-1">
                                                <div>
                                                    <img src="{{ asset('img/team-1.jpg') }}" class="avatar me-3" alt="image">
                                                </div>
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ $evaluation->evaluator_type == 'supervisor' ? 'Dosen Pembimbing' : 'Pembimbing Lapangan' }}</h6>
                                                    <p class="text-xs text-secondary mb-0">
                                                        {{ $evaluation->evaluator_type == 'supervisor' ? $internship->supervisor->name : $internship->fieldSupervisor->name }}
                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle">
                                            <p class="text-xs font-weight-bold mb-0">{{ $evaluation->score }}</p>
                                        </td>
                                        <td class="align-middle">
                                            <p class="text-xs font-weight-bold mb-0">{{ \Illuminate\Support\Str::limit($evaluation->notes, 50) }}</p>
                                        </td>
                                        <td class="align-middle">
                                            <a href="{{ route('student.evaluations.show', $evaluation->id) }}" class="text-secondary font-weight-bold text-xs">
                                                Detail
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4" class="text-center py-3">Belum ada evaluasi</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-5 mb-4">
            <div class="card h-100">
                <div class="card-header pb-0">
                    <h6>Ringkasan PKL</h6>
                </div>
                <div class="card-body p-3">
                    <div class="alert alert-success mb-4" role="alert">
                        <strong>Selamat!</strong> PKL Anda telah selesai.
                    </div>
                    
                    <div class="mb-3">
                        <p><strong>Perusahaan:</strong> {{ $internship->company->name }}</p>
                        <p><strong>Periode:</strong> {{ $internship->start_date->format('d M Y') }} - {{ $internship->end_date->format('d M Y') }}</p>
                        <p><strong>Total Laporan:</strong> {{ $reportCount ?? 0 }}</p>
                        <p><strong>Nilai Akhir:</strong> 
                            @if(isset($evaluations) && $evaluations->count() > 0)
                                {{ $evaluations->avg('score') }}
                            @else
                                Belum Ada
                            @endif
                        </p>
                    </div>
                    
                    <div class="mt-4">
                        @if(isset($internship->report_file))
                        <a href="{{ route('student.internships.download-report', $internship->id) }}" class="btn btn-sm btn-info">
                            <i class="fa fa-download"></i> Download Laporan Akhir
                        </a>
                        @endif
                        
                        @if(isset($internship->certificate_file))
                        <a href="{{ route('student.internships.download-certificate', $internship->id) }}" class="btn btn-sm btn-primary">
                            <i class="fa fa-certificate"></i> Download Sertifikat
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @else
    <div class="row mt-4">
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h6 class="mb-0">Perusahaan Tersedia</h6>
                        <a href="{{ route('student.internships.create') }}" class="btn btn-sm btn-primary">
                            <i class="fa fa-plus"></i> Ajukan PKL
                        </a>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Perusahaan</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Alamat</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Kuota</th>
                                    <th class="text-secondary opacity-7"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($availableCompanies) && $availableCompanies->count() > 0)
                                    @foreach($availableCompanies as $company)
                                    <tr>
                                        <td>
                                            <div class="d-flex px-3 py-1">
                                                <div>
                                                    @if($company->logo)
                                                    <img src="{{ asset('storage/' . $company->logo) }}" class="avatar me-3" alt="{{ $company->name }}">
                                                    @else
                                                    <img src="{{ asset('img/company-placeholder.jpg') }}" class="avatar me-3" alt="{{ $company->name }}">
                                                    @endif
                                                </div>
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ $company->name }}</h6>
                                                    <p class="text-xs text-secondary mb-0">{{ $company->industry }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $company->address }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $company->quota }}</p>
                                        </td>
                                        <td class="align-middle">
                                            <a href="{{ route('student.companies.show', $company->id) }}" class="btn btn-link text-secondary mb-0">
                                                <i class="fa fa-eye text-xs"></i>
                                                Detail
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4" class="text-center py-3">Tidak ada perusahaan yang tersedia saat ini</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

</div>
@endsection 