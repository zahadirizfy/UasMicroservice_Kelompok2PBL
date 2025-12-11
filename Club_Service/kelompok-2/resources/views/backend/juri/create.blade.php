@extends('backend.layouts.main')
@section('title', 'Tambah Juri')

@section('content')
<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow border-0">
                <div class="card-header bg-gradient-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><i class="fas fa-user-tie me-2"></i> Tambah Juri</h4>
                    <a href="{{ route('backend.juri.index') }}" class="btn btn-sm btn-light">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>
                <div class="card-body">

                    {{-- Tampilkan pesan sukses --}}
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    {{-- Form tambah juri --}}
                    <form action="{{ route('backend.juri.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row g-3">
                            {{-- Nama Juri --}}
                            <div class="col-md-6">
                                <label for="nama_juri" class="form-label fw-semibold">Nama Juri <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nama_juri') is-invalid @enderror"
                                    id="nama_juri" name="nama_juri" placeholder="Contoh: Budi Santosa"
                                    value="{{ old('nama_juri') }}" required>
                                @error('nama_juri')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Tanggal Lahir --}}
                            <div class="col-md-6">
                                <label for="tanggal_lahir" class="form-label fw-semibold">Tanggal Lahir <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                    id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required>
                                @error('tanggal_lahir')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Upload Sertifikat --}}
                            <div class="col-12">
                                <label for="sertifikat" class="form-label fw-semibold">Upload Sertifikat (PDF) <span class="text-danger">*</span></label>
                                <input type="file" class="form-control @error('sertifikat') is-invalid @enderror"
                                    id="sertifikat" name="sertifikat" accept=".pdf" required>
                                @error('sertifikat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-4 d-flex justify-content-end gap-2">
                           <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Simpan
                            </button>
                            <button type="reset" class="btn btn-warning">
                                <i class="fas fa-rotate-left me-1"></i> Reset
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
