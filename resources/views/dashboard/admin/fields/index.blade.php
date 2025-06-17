@extends('layouts.app')

@section('title', 'Manajemen Bidang PKL')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Manajemen Bidang PKL</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Bidang PKL</li>
    </ol>

    @include('layouts.partials.flash-messages')

    <div class="row">
        <div class="col-xl-5">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-plus-circle me-1"></i>
                    {{ isset($editField) ? 'Edit Bidang PKL' : 'Tambah Bidang PKL Baru' }}
                </div>
                <div class="card-body">
                    <form action="{{ isset($editField) ? route('admin.fields.update', $editField->id) : route('admin.fields.store') }}" method="POST">
                        @csrf
                        @if(isset($editField))
                            @method('PUT')
                        @endif
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Bidang <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $editField->name ?? '') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi Bidang</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description', $editField->description ?? '') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-flex justify-content-end">
                            @if(isset($editField))
                                <a href="{{ route('admin.fields.index') }}" class="btn btn-secondary me-2">Batal</a>
                                <button type="submit" class="btn btn-primary">Perbarui</button>
                            @else
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-xl-7">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-list me-1"></i>
                    Daftar Bidang PKL
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="fieldsTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Nama Bidang</th>
                                    <th>Deskripsi</th>
                                    <th>Jumlah Perusahaan</th>
                                    <th width="15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($fields as $index => $field)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $field->name }}</td>
                                        <td>{{ $field->description ?: '-' }}</td>
                                        <td class="text-center">{{ $field->companies_count ?? 0 }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.fields.edit', $field->id) }}" class="btn btn-warning btn-sm">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.fields.destroy', $field->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus bidang ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Tidak ada data bidang</td>
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
        $('#fieldsTable').DataTable({
            responsive: true
        });
    });
</script>
@endsection 