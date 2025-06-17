@extends('layouts.app')

@section('title', 'Form Evaluasi PKL')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Evaluasi PKL</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('supervisor.internships') }}">Mahasiswa Bimbingan</a></li>
        <li class="breadcrumb-item"><a href="{{ route('supervisor.internships.show', $internship->id) }}">Detail PKL</a></li>
        <li class="breadcrumb-item active">Evaluasi</li>
    </ol>

    @include('layouts.partials.flash-messages')

    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-clipboard-check me-1"></i>
                    Form Evaluasi PKL
                </div>
                <div class="card-body">
                    <form action="{{ route('supervisor.internships.evaluate.submit', $internship->id) }}" method="POST">
                        @csrf
                        
                        <div class="mb-4 pb-2 border-bottom">
                            <h5 class="mb-3">Informasi PKL</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-sm">
                                        <tr>
                                            <th width="40%">Nama Mahasiswa</th>
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
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-sm">
                                        <tr>
                                            <th width="40%">Perusahaan</th>
                                            <td>{{ $internship->company->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Bidang PKL</th>
                                            <td>{{ $internship->field->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Periode</th>
                                            <td>{{ $internship->start_date->format('d/m/Y') }} - {{ $internship->end_date->format('d/m/Y') }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <h5 class="mb-3">Penilaian Kompetensi</h5>
                            <p class="text-muted small mb-3">Berikan nilai sesuai dengan kinerja mahasiswa selama PKL (skala 1-100)</p>

                            <div class="row">
                                <div class="col-lg-6">
                                    <table class="table table-bordered">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Aspek Penilaian</th>
                                                <th width="100">Nilai</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <label for="technical_skills">Keterampilan Teknis</label>
                                                    <div class="form-text small">Kemampuan teknis sesuai bidang PKL</div>
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control @error('technical_skills') is-invalid @enderror" 
                                                        id="technical_skills" name="technical_skills" min="0" max="100" 
                                                        value="{{ old('technical_skills', $evaluation->technical_skills ?? '') }}" required>
                                                    @error('technical_skills')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label for="problem_solving">Pemecahan Masalah</label>
                                                    <div class="form-text small">Kemampuan menganalisis dan menyelesaikan masalah</div>
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control @error('problem_solving') is-invalid @enderror" 
                                                        id="problem_solving" name="problem_solving" min="0" max="100" 
                                                        value="{{ old('problem_solving', $evaluation->problem_solving ?? '') }}" required>
                                                    @error('problem_solving')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label for="communication">Komunikasi</label>
                                                    <div class="form-text small">Kemampuan berkomunikasi secara efektif</div>
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control @error('communication') is-invalid @enderror" 
                                                        id="communication" name="communication" min="0" max="100" 
                                                        value="{{ old('communication', $evaluation->communication ?? '') }}" required>
                                                    @error('communication')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label for="teamwork">Kerja Tim</label>
                                                    <div class="form-text small">Kemampuan bekerja dalam tim</div>
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control @error('teamwork') is-invalid @enderror" 
                                                        id="teamwork" name="teamwork" min="0" max="100" 
                                                        value="{{ old('teamwork', $evaluation->teamwork ?? '') }}" required>
                                                    @error('teamwork')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-lg-6">
                                    <table class="table table-bordered">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Aspek Penilaian</th>
                                                <th width="100">Nilai</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <label for="discipline">Kedisiplinan</label>
                                                    <div class="form-text small">Kehadiran dan ketepatan waktu</div>
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control @error('discipline') is-invalid @enderror" 
                                                        id="discipline" name="discipline" min="0" max="100" 
                                                        value="{{ old('discipline', $evaluation->discipline ?? '') }}" required>
                                                    @error('discipline')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label for="initiative">Inisiatif dan Kreativitas</label>
                                                    <div class="form-text small">Kemampuan mengambil inisiatif</div>
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control @error('initiative') is-invalid @enderror" 
                                                        id="initiative" name="initiative" min="0" max="100" 
                                                        value="{{ old('initiative', $evaluation->initiative ?? '') }}" required>
                                                    @error('initiative')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label for="adaptability">Adaptabilitas</label>
                                                    <div class="form-text small">Kemampuan beradaptasi dengan lingkungan kerja</div>
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control @error('adaptability') is-invalid @enderror" 
                                                        id="adaptability" name="adaptability" min="0" max="100" 
                                                        value="{{ old('adaptability', $evaluation->adaptability ?? '') }}" required>
                                                    @error('adaptability')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label for="work_quality">Kualitas Hasil Kerja</label>
                                                    <div class="form-text small">Ketepatan dan kualitas hasil kerja</div>
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control @error('work_quality') is-invalid @enderror" 
                                                        id="work_quality" name="work_quality" min="0" max="100" 
                                                        value="{{ old('work_quality', $evaluation->work_quality ?? '') }}" required>
                                                    @error('work_quality')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="text-end mt-2">
                                <button type="button" class="btn btn-sm btn-secondary" id="calculateAverage">Hitung Rata-rata</button>
                            </div>
                            
                            <div class="row mt-3">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="final_score" class="form-label">Nilai Akhir</label>
                                        <input type="number" class="form-control @error('final_score') is-invalid @enderror" 
                                            id="final_score" name="final_score" min="0" max="100" 
                                            value="{{ old('final_score', $evaluation->final_score ?? '') }}" required readonly>
                                        @error('final_score')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="grade" class="form-label">Grade</label>
                                        <input type="text" class="form-control" id="grade" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <h5 class="mb-3">Evaluasi Kualitatif</h5>

                            <div class="mb-3">
                                <label for="strength" class="form-label">Kelebihan Mahasiswa</label>
                                <textarea class="form-control @error('strength') is-invalid @enderror" id="strength" name="strength" rows="3" required>{{ old('strength', $evaluation->strength ?? '') }}</textarea>
                                <div class="form-text">Jelaskan kelebihan mahasiswa selama melaksanakan PKL.</div>
                                @error('strength')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="weakness" class="form-label">Kekurangan Mahasiswa</label>
                                <textarea class="form-control @error('weakness') is-invalid @enderror" id="weakness" name="weakness" rows="3" required>{{ old('weakness', $evaluation->weakness ?? '') }}</textarea>
                                <div class="form-text">Jelaskan kekurangan mahasiswa selama melaksanakan PKL.</div>
                                @error('weakness')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="notes" class="form-label">Catatan Tambahan</label>
                                <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3">{{ old('notes', $evaluation->notes ?? '') }}</textarea>
                                <div class="form-text">Tambahkan catatan lain yang perlu diperhatikan.</div>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <h5 class="mb-3">Status PKL</h5>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="statusContinue" value="continue" {{ old('status', $evaluation->status ?? '') == 'continue' ? 'checked' : '' }}>
                                <label class="form-check-label" for="statusContinue">
                                    PKL dapat dilanjutkan
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="statusCompleted" value="completed" {{ old('status', $evaluation->status ?? '') == 'completed' ? 'checked' : '' }}>
                                <label class="form-check-label" for="statusCompleted">
                                    PKL telah selesai
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="statusFailed" value="failed" {{ old('status', $evaluation->status ?? '') == 'failed' ? 'checked' : '' }}>
                                <label class="form-check-label" for="statusFailed">
                                    PKL tidak lulus (perlu mengulang)
                                </label>
                            </div>
                            @error('status')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <a href="{{ route('supervisor.internships.show', $internship->id) }}" class="btn btn-secondary me-2">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan Evaluasi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-info-circle me-1"></i>
                    Panduan Evaluasi
                </div>
                <div class="card-body">
                    <div class="alert alert-info mb-3">
                        <h6 class="alert-heading">Rentang Nilai</h6>
                        <hr>
                        <p class="mb-1">Gunakan rentang nilai berikut untuk evaluasi:</p>
                        <ul class="ps-3 mb-0">
                            <li>A = 86-100 (Sangat Baik)</li>
                            <li>B = 71-85 (Baik)</li>
                            <li>C = 56-70 (Cukup)</li>
                            <li>D = 41-55 (Kurang)</li>
                            <li>E = 0-40 (Sangat Kurang)</li>
                        </ul>
                    </div>
                    
                    <div class="alert alert-warning">
                        <h6 class="alert-heading">Bobot Penilaian</h6>
                        <hr>
                        <p class="mb-1">Komponen penilaian memiliki bobot yang sama.</p>
                        <p class="mb-0">Nilai akhir merupakan rata-rata dari semua komponen penilaian.</p>
                    </div>
                    
                    <div class="alert alert-success">
                        <h6 class="alert-heading">Tips Evaluasi</h6>
                        <hr>
                        <ul class="ps-3 mb-0">
                            <li>Gunakan bukti laporan harian sebagai dasar evaluasi</li>
                            <li>Berikan feedback yang jujur dan konstruktif</li>
                            <li>Diskusikan evaluasi dengan pembimbing lapangan</li>
                        </ul>
                    </div>
                    
                    <div class="alert alert-danger">
                        <h6 class="alert-heading">Perhatian</h6>
                        <hr>
                        <p class="mb-0">Evaluasi akan menjadi penentu kelulusan PKL mahasiswa. Pastikan penilaian objektif dan sesuai dengan kinerja mahasiswa.</p>
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
        // Hitung nilai rata-rata
        $('#calculateAverage').click(function() {
            const technicalSkills = parseInt($('#technical_skills').val()) || 0;
            const problemSolving = parseInt($('#problem_solving').val()) || 0;
            const communication = parseInt($('#communication').val()) || 0;
            const teamwork = parseInt($('#teamwork').val()) || 0;
            const discipline = parseInt($('#discipline').val()) || 0;
            const initiative = parseInt($('#initiative').val()) || 0;
            const adaptability = parseInt($('#adaptability').val()) || 0;
            const workQuality = parseInt($('#work_quality').val()) || 0;
            
            const total = technicalSkills + problemSolving + communication + teamwork + 
                          discipline + initiative + adaptability + workQuality;
            const average = total / 8;
            
            $('#final_score').val(Math.round(average));
            updateGrade(Math.round(average));
        });
        
        // Update grade berdasarkan nilai
        function updateGrade(score) {
            let grade = '';
            
            if (score >= 86) {
                grade = 'A';
            } else if (score >= 71) {
                grade = 'B';
            } else if (score >= 56) {
                grade = 'C';
            } else if (score >= 41) {
                grade = 'D';
            } else {
                grade = 'E';
            }
            
            $('#grade').val(grade);
        }
        
        // Otomatis hitung nilai ketika nilai diubah
        $('.form-control[type=number]').on('change', function() {
            $('#calculateAverage').click();
        });
        
        // Inisialisasi awal jika sudah ada nilai
        if ($('#final_score').val()) {
            updateGrade(parseInt($('#final_score').val()));
        }
    });
</script>
@endsection 