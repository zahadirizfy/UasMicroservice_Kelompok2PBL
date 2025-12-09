@extends('backend.layouts.app')

@section('title', 'Edit Juri')

@section('content')
    <div class="container mt-4 mb-5">
        <div class="card shadow border-0">
            <div class="card-body">
                <h3 class="card-title text-center mb-4">Edit Data Juri</h3>
                <hr>

                <form action="{{ route('backend.juri.update', $juri->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Nama Juri --}}
                    <div class="col-mb-3">
                        <label for="nama_juri" class="form-label fw-semibold">Nama Juri <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama_juri') is-invalid @enderror" id="nama_juri"
                            name="nama_juri" placeholder="Contoh: Budi Santosa" value="{{ old('nama_juri') }}" required>
                        @error('nama_juri')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Sertifikat --}}
                    <div class="mb-3">
                        <label for="sertifikat" class="form-label fw-bold">Sertifikat (PDF) <span
                                class="text-danger">*</span></label><br>
                        @if ($juri->sertifikat && file_exists(public_path('storage/' . $juri->sertifikat)))
                            <a href="{{ asset('storage/' . $juri->sertifikat) }}" target="_blank"
                                class="d-block mb-2 text-success">
                                📄 Lihat Sertifikat Lama
                            </a>
                        @else
                            <span class="text-muted d-block mb-2">Belum ada sertifikat</span>
                        @endif
                        <input type="file" name="sertifikat" id="sertifikat"
                            class="form-control @error('sertifikat') is-invalid @enderror" accept=".pdf">
                        @error('sertifikat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Tanggal Lahir --}}
                    <div class="mb-3">
                        <label for="tanggal_lahir" class="form-label fw-bold">Tanggal Lahir <span
                                class="text-danger">*</span></label>
                        <input type="date" name="tanggal_lahir" id="tanggal_lahir"
                            class="form-control @error('tanggal_lahir') is-invalid @enderror"
                            value="{{ old('tanggal_lahir', $juri->tanggal_lahir) }}">
                        @error('tanggal_lahir')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Tombol --}}
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('backend.juri.index') }}" class="btn btn-secondary">← Kembali</a>
                        <div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Simpan
                            </button>
                            <button type="reset" class="btn btn-warning">
                                <i class="fas fa-rotate-left me-1"></i> Reset
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
