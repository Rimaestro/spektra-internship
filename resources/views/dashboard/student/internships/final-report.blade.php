@extends('layouts.app')

@section('title', 'Upload Laporan Akhir PKL')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Laporan Akhir PKL</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('student.internships.index') }}">PKL</a></li>
        <li class="breadcrumb-item active">Laporan Akhir</li>
    </ol>

    @include('layouts.partials.flash-messages')
    
    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-file-pdf me-1"></i>
                    Upload Laporan Akhir PKL
                </div>
                <div class="card-body">
                    @if(!$internship->final_report_submitted || ($internship->final_report_status == 'rejected'))
                    <form action="{{ route('student.internships.final-report.submit', $internship->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-4">
                            <h5 class="fw-bold mb-3">Informasi PKL</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-sm">
                                        <tr>
                                            <th width="40%">Perusahaan</th>
                                            <td>{{ $internship->company->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Bidang</th>
                                            <td>{{ $internship->field->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Periode</th>
                                            <td>{{ $internship->start_date->format('d M Y') }} - {{ $internship->end_date->format('d M Y') }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-sm">
                                        <tr>
                                            <th width="40%">Dosen Pembimbing</th>
                                            <td>{{ $internship->supervisor->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Pembimbing Lapangan</th>
                                            <td>{{ $internship->field_supervisor_name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Status</th>
                                            <td>
                                                @if($internship->status == 'ongoing')
                                                    <span class="badge bg-primary">Sedang Berlangsung</span>
                                                @elseif($internship->status == 'completed')
                                                    <span class="badge bg-success">Selesai</span>
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    
                        <div class="mb-4">
                            <h5 class="fw-bold mb-3">Dokumen Laporan</h5>
                            
                            <div class="mb-3">
                                <label for="final_report" class="form-label">File Laporan Akhir PKL <span class="text-danger">*</span></label>
                                <input type="file" class="form-control @error('final_report') is-invalid @enderror" id="final_report" name="final_report" accept=".pdf" required>
                                <div class="form-text">Upload file laporan dalam format PDF (maks. 10MB)</div>
                                @error('final_report')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="presentation_file" class="form-label">File Presentasi</label>
                                <input type="file" class="form-control @error('presentation_file') is-invalid @enderror" id="presentation_file" name="presentation_file" accept=".pptx,.pdf">
                                <div class="form-text">Upload file presentasi dalam format PPTX atau PDF (maks. 10MB)</div>
                                @error('presentation_file')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="letter_of_completion" class="form-label">Surat Keterangan Selesai PKL <span class="text-danger">*</span></label>
                                <input type="file" class="form-control @error('letter_of_completion') is-invalid @enderror" id="letter_of_completion" name="letter_of_completion" accept=".pdf" required>
                                <div class="form-text">Upload surat keterangan telah menyelesaikan PKL dari perusahaan dalam format PDF</div>
                                @error('letter_of_completion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="internship_journal" class="form-label">Jurnal Harian PKL <span class="text-danger">*</span></label>
                                <input type="file" class="form-control @error('internship_journal') is-invalid @enderror" id="internship_journal" name="internship_journal" accept=".pdf" required>
                                <div class="form-text">Upload jurnal harian PKL yang telah divalidasi pembimbing lapangan dalam format PDF</div>
                                @error('internship_journal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="additional_documents" class="form-label">Dokumen Tambahan</label>
                                <input type="file" class="form-control @error('additional_documents') is-invalid @enderror" id="additional_documents" name="additional_documents[]" multiple>
                                <div class="form-text">Upload dokumen tambahan jika ada (maks. 5 file)</div>
                                @error('additional_documents')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @error('additional_documents.*')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <h5 class="fw-bold mb-3">Deskripsi Laporan</h5>
                            
                            <div class="mb-3">
                                <label for="title" class="form-label">Judul Laporan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $finalReport->title ?? '') }}" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="abstract" class="form-label">Abstrak <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('abstract') is-invalid @enderror" id="abstract" name="abstract" rows="5" required>{{ old('abstract', $finalReport->abstract ?? '') }}</textarea>
                                <div class="form-text">Tuliskan abstrak dari laporan PKL Anda (maks. 500 kata)</div>
                                @error('abstract')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="keywords" class="form-label">Kata Kunci <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('keywords') is-invalid @enderror" id="keywords" name="keywords" value="{{ old('keywords', $finalReport->keywords ?? '') }}" required>
                                <div class="form-text">Pisahkan kata kunci dengan koma (contoh: Sistem Informasi, Web, Database)</div>
                                @error('keywords')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        @if($internship->final_report_status == 'rejected' && $finalReport && $finalReport->rejection_notes)
                        <div class="alert alert-danger mb-4">
                            <h6 class="alert-heading fw-bold">Catatan Revisi:</h6>
                            <p class="mb-0">{!! nl2br(e($finalReport->rejection_notes)) !!}</p>
                        </div>
                        @endif
                        
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('student.internships.show', $internship->id) }}" class="btn btn-secondary me-2">Kembali</a>
                            <button type="submit" class="btn btn-primary">
                                @if($internship->final_report_status == 'rejected')
                                    Submit Revisi Laporan
                                @else
                                    Upload Laporan
                                @endif
                            </button>
                        </div>
                    </form>
                    
                    @elseif($internship->final_report_status == 'pending')
                    <div class="alert alert-warning">
                        <h5 class="alert-heading fw-bold"><i class="fas fa-clock me-2"></i>Laporan Menunggu Persetujuan</h5>
                        <p class="mb-0">Laporan akhir PKL Anda sedang dalam proses review oleh dosen pembimbing. Silahkan periksa status secara berkala.</p>
                    </div>
                    
                    <div class="mb-4">
                        <h5 class="fw-bold mb-3">Detail Submission</h5>
                        <table class="table table-bordered">
                            <tr>
                                <th width="30%">Tanggal Submit</th>
                                <td>{{ $finalReport->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            <tr>
                                <th>Judul</th>
                                <td>{{ $finalReport->title }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td><span class="badge bg-warning">Menunggu Persetujuan</span></td>
                            </tr>
                        </table>
                    </div>
                    
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('student.internships.show', $internship->id) }}" class="btn btn-secondary">Kembali</a>
                    </div>
                    @else
                    <div class="alert alert-success">
                        <h5 class="alert-heading fw-bold"><i class="fas fa-check-circle me-2"></i>Laporan Telah Disetujui</h5>
                        <p class="mb-0">Selamat! Laporan akhir PKL Anda telah disetujui oleh dosen pembimbing.</p>
                    </div>
                    
                    <div class="mb-4">
                        <h5 class="fw-bold mb-3">Detail Submission</h5>
                        <table class="table table-bordered">
                            <tr>
                                <th width="30%">Tanggal Submit</th>
                                <td>{{ $finalReport->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Disetujui</th>
                                <td>{{ $finalReport->approved_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            <tr>
                                <th>Judul</th>
                                <td>{{ $finalReport->title }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td><span class="badge bg-success">Disetujui</span></td>
                            </tr>
                        </table>
                    </div>
                    
                    <div class="mb-4">
                        <h5 class="fw-bold mb-3">Dokumen</h5>
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="fas fa-file-pdf me-2 text-danger"></i>
                                    Laporan Akhir PKL
                                </div>
                                <a href="{{ asset('storage/' . $finalReport->report_file) }}" target="_blank" class="btn btn-sm btn-primary">
                                    <i class="fas fa-download me-1"></i> Download
                                </a>
                            </li>
                            @if($finalReport->presentation_file)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="fas fa-file-powerpoint me-2 text-warning"></i>
                                    File Presentasi
                                </div>
                                <a href="{{ asset('storage/' . $finalReport->presentation_file) }}" target="_blank" class="btn btn-sm btn-primary">
                                    <i class="fas fa-download me-1"></i> Download
                                </a>
                            </li>
                            @endif
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="fas fa-file-alt me-2 text-info"></i>
                                    Surat Keterangan Selesai PKL
                                </div>
                                <a href="{{ asset('storage/' . $finalReport->letter_of_completion) }}" target="_blank" class="btn btn-sm btn-primary">
                                    <i class="fas fa-download me-1"></i> Download
                                </a>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="fas fa-book me-2 text-success"></i>
                                    Jurnal Harian PKL
                                </div>
                                <a href="{{ asset('storage/' . $finalReport->journal_file) }}" target="_blank" class="btn btn-sm btn-primary">
                                    <i class="fas fa-download me-1"></i> Download
                                </a>
                            </li>
                        </ul>
                    </div>
                    
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('student.internships.show', $internship->id) }}" class="btn btn-secondary">Kembali</a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-info-circle me-1"></i>
                    Panduan Laporan Akhir PKL
                </div>
                <div class="card-body">
                    <div class="alert alert-info mb-3">
                        <h6 class="alert-heading mb-2"><i class="fas fa-exclamation-circle me-1"></i> Penting</h6>
                        <p class="mb-0">Pastikan laporan akhir PKL mengikuti format yang telah ditetapkan. Kelengkapan dokumen akan berpengaruh pada nilai akhir PKL.</p>
                    </div>
                    
                    <h6 class="fw-bold mb-2">Format Dokumen Laporan</h6>
                    <ul class="small ps-3 mb-3">
                        <li>File dalam format PDF</li>
                        <li>Ukuran kertas A4</li>
                        <li>Margin: kiri 4 cm, kanan 3 cm, atas 3 cm, bawah 3 cm</li>
                        <li>Font: Times New Roman 12 pt</li>
                        <li>Spasi: 1,5</li>
                        <li>Minimal 30 halaman (tidak termasuk lampiran)</li>
                    </ul>
                    
                    <h6 class="fw-bold mb-2">Sistematika Laporan</h6>
                    <ol class="small ps-3 mb-3">
                        <li>Cover</li>
                        <li>Lembar Pengesahan</li>
                        <li>Kata Pengantar</li>
                        <li>Daftar Isi</li>
                        <li>BAB I - Pendahuluan</li>
                        <li>BAB II - Profil Perusahaan</li>
                        <li>BAB III - Deskripsi Kegiatan PKL</li>
                        <li>BAB IV - Pembahasan</li>
                        <li>BAB V - Penutup</li>
                        <li>Daftar Pustaka</li>
                        <li>Lampiran</li>
                    </ol>
                    
                    <h6 class="fw-bold mb-2">Kelengkapan Dokumen</h6>
                    <ul class="small ps-3 mb-0">
                        <li>Laporan Akhir PKL (wajib)</li>
                        <li>File Presentasi (opsional)</li>
                        <li>Surat Keterangan Selesai PKL (wajib)</li>
                        <li>Jurnal Harian PKL (wajib)</li>
                        <li>Dokumen pendukung lainnya (opsional)</li>
                    </ul>
                </div>
            </div>

            @if(isset($finalReportHistory) && count($finalReportHistory) > 0)
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-history me-1"></i>
                    Riwayat Revisi
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        @foreach($finalReportHistory as $index => $history)
                        <li class="list-group-item p-3 {{ $index == 0 ? 'border-start border-4 border-primary' : '' }}">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="mb-0">Revisi #{{ count($finalReportHistory) - $index }}</h6>
                                <span class="badge {{ $history->status == 'rejected' ? 'bg-danger' : ($history->status == 'approved' ? 'bg-success' : 'bg-warning') }}">
                                    {{ $history->status == 'rejected' ? 'Ditolak' : ($history->status == 'approved' ? 'Disetujui' : 'Menunggu') }}
                                </span>
                            </div>
                            <div class="small text-muted mb-2">
                                Tanggal Submit: {{ $history->created_at->format('d/m/Y H:i') }}
                            </div>
                            @if($history->status == 'rejected' && $history->rejection_notes)
                            <div class="small">
                                <strong>Catatan Revisi:</strong><br>
                                {!! nl2br(e($history->rejection_notes)) !!}
                            </div>
                            @endif
                        </li>
                        @endforeach
                    </ul>
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
        // Word counter for abstract
        $('#abstract').on('input', function() {
            const wordCount = this.value.trim().split(/\s+/).filter(Boolean).length;
            if (wordCount > 500) {
                $(this).addClass('is-invalid');
                $(this).after('<div class="invalid-feedback">Abstrak melebihi 500 kata.</div>');
            } else {
                $(this).removeClass('is-invalid');
                $(this).next('.invalid-feedback').remove();
            }
        });
    });
</script>
@endsection 