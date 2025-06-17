@extends('layouts.app')

@section('title', 'Pengajuan PKL')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Pengajuan PKL</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Pengajuan PKL</li>
    </ol>

    @include('layouts.partials.flash-messages')

    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-file-alt me-1"></i>
                    Form Pengajuan PKL
                </div>
                <div class="card-body">
                    <form action="{{ route('student.apply.submit') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="company_id" class="form-label">Perusahaan <span class="text-danger">*</span></label>
                            <select class="form-select @error('company_id') is-invalid @enderror" id="company_id" name="company_id" required>
                                <option value="">Pilih Perusahaan</option>
                                @foreach($companies as $company)
                                    <option value="{{ $company->id }}" {{ old('company_id') == $company->id ? 'selected' : '' }}>
                                        {{ $company->name }} ({{ $company->address }})
                                    </option>
                                @endforeach
                            </select>
                            <div class="form-text">Pastikan perusahaan yang dipilih masih memiliki kuota PKL tersedia.</div>
                            @error('company_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Bidang PKL yang Tersedia</label>
                            <div class="card">
                                <div class="card-body py-2" id="availableFields">
                                    <div class="text-center text-muted py-3">
                                        <i>Silahkan pilih perusahaan terlebih dahulu</i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="field_id" class="form-label">Bidang PKL <span class="text-danger">*</span></label>
                            <select class="form-select @error('field_id') is-invalid @enderror" id="field_id" name="field_id" required disabled>
                                <option value="">Pilih Bidang</option>
                            </select>
                            @error('field_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="start_date" class="form-label">Tanggal Mulai <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('start_date') is-invalid @enderror" id="start_date" name="start_date" value="{{ old('start_date') }}" required>
                                @error('start_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="end_date" class="form-label">Tanggal Selesai <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('end_date') is-invalid @enderror" id="end_date" name="end_date" value="{{ old('end_date') }}" required>
                                @error('end_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="application_letter" class="form-label">Surat Pengajuan PKL <span class="text-danger">*</span></label>
                            <input type="file" class="form-control @error('application_letter') is-invalid @enderror" id="application_letter" name="application_letter" required accept=".pdf">
                            <div class="form-text">Format file: PDF, maksimal 2MB</div>
                            @error('application_letter')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="cv" class="form-label">Curriculum Vitae <span class="text-danger">*</span></label>
                            <input type="file" class="form-control @error('cv') is-invalid @enderror" id="cv" name="cv" required accept=".pdf">
                            <div class="form-text">Format file: PDF, maksimal 2MB</div>
                            @error('cv')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="motivation_letter" class="form-label">Surat Motivasi</label>
                            <textarea class="form-control @error('motivation_letter') is-invalid @enderror" id="motivation_letter" name="motivation_letter" rows="5">{{ old('motivation_letter') }}</textarea>
                            <div class="form-text">Jelaskan motivasi dan tujuan Anda melaksanakan PKL di perusahaan tersebut</div>
                            @error('motivation_letter')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="supervisor_name" class="form-label">Nama Pembimbing Lapangan (jika sudah ada)</label>
                            <input type="text" class="form-control @error('supervisor_name') is-invalid @enderror" id="supervisor_name" name="supervisor_name" value="{{ old('supervisor_name') }}">
                            @error('supervisor_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="supervisor_contact" class="form-label">Kontak Pembimbing Lapangan (jika sudah ada)</label>
                            <input type="text" class="form-control @error('supervisor_contact') is-invalid @enderror" id="supervisor_contact" name="supervisor_contact" value="{{ old('supervisor_contact') }}">
                            @error('supervisor_contact')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-primary">Ajukan PKL</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-info-circle me-1"></i>
                    Informasi Pengajuan PKL
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <h5 class="alert-heading"><i class="fas fa-clock me-1"></i> Timeline Pengajuan</h5>
                        <hr>
                        <ol class="ps-3 mb-0">
                            <li>Mahasiswa mengajukan permohonan PKL</li>
                            <li>Koordinator PKL memeriksa dan menyetujui/menolak</li>
                            <li>Jika disetujui, Koordinator akan menentukan dosen pembimbing</li>
                            <li>Perusahaan menyetujui/menolak permohonan PKL</li>
                            <li>Jika disetujui, PKL dapat dimulai sesuai tanggal yang ditentukan</li>
                        </ol>
                    </div>
                    
                    <div class="alert alert-warning">
                        <h5 class="alert-heading"><i class="fas fa-file-alt me-1"></i> Dokumen yang Dibutuhkan</h5>
                        <hr>
                        <ul class="ps-3 mb-0">
                            <li>Surat Pengajuan PKL (format PDF)</li>
                            <li>CV terbaru (format PDF)</li>
                            <li>Surat Motivasi (opsional)</li>
                        </ul>
                    </div>
                    
                    <div class="alert alert-success">
                        <h5 class="alert-heading"><i class="fas fa-lightbulb me-1"></i> Tips</h5>
                        <hr>
                        <ul class="ps-3 mb-0">
                            <li>Pastikan perusahaan yang Anda pilih masih memiliki kuota PKL yang tersedia</li>
                            <li>Perhatikan jangka waktu PKL (minimal 3 bulan)</li>
                            <li>Lampirkan dokumen terbaru dan lengkap</li>
                            <li>Tuliskan surat motivasi dengan jelas dan menarik</li>
                        </ul>
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
        // Ketika perusahaan dipilih
        $('#company_id').change(function() {
            const companyId = $(this).val();
            
            // Reset field selection
            $('#field_id').empty().append('<option value="">Pilih Bidang</option>').prop('disabled', true);
            
            // Reset available fields
            $('#availableFields').html('<div class="text-center text-muted py-3"><i>Silahkan pilih perusahaan terlebih dahulu</i></div>');
            
            if (companyId) {
                // Fetch fields for selected company via AJAX
                $.ajax({
                    url: '/api/companies/' + companyId + '/fields',
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        if (data.length > 0) {
                            // Display available fields
                            let fieldsHtml = '';
                            $.each(data, function(key, field) {
                                fieldsHtml += `<span class="badge bg-info me-2 mb-2">${field.name}</span>`;
                                
                                // Add to dropdown
                                $('#field_id').append(`<option value="${field.id}">${field.name}</option>`);
                            });
                            
                            $('#availableFields').html(fieldsHtml);
                            $('#field_id').prop('disabled', false);
                        } else {
                            $('#availableFields').html('<div class="text-center text-danger py-3"><i>Tidak ada bidang PKL yang tersedia di perusahaan ini</i></div>');
                        }
                    },
                    error: function(err) {
                        console.error('Error fetching fields:', err);
                        $('#availableFields').html('<div class="text-center text-danger py-3"><i>Gagal memuat data bidang</i></div>');
                    }
                });
            }
        });

        // Validasi tanggal
        $('#end_date').change(function() {
            const startDate = new Date($('#start_date').val());
            const endDate = new Date($(this).val());
            
            if (endDate <= startDate) {
                alert('Tanggal selesai harus setelah tanggal mulai');
                $(this).val('');
            }
        });
    });
</script>
@endsection 