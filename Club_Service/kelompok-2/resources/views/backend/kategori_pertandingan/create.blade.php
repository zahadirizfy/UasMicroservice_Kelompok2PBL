@extends('backend.layouts.main')
@section('title', 'Tambah Kategori Pertandingan')

@section('content')
<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow border-0">
                <div class="card-header bg-gradient-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><i class="fas fa-list-alt me-2"></i> Tambah Kategori Pertandingan</h4>
                    <a href="{{ route('backend.kategori_pertandingan.index') }}" class="btn btn-sm btn-light">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>
                <div class="card-body">

                    {{-- Pesan sukses --}}
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    {{-- Pesan error validasi --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Form Tambah Kategori --}}
                    <form action="{{ route('backend.kategori_pertandingan.store') }}" method="POST">
                        @csrf

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="nama" class="form-label fw-semibold">Nama Kategori <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama"
                                    name="nama" placeholder="Contoh: Putra U-18" value="{{ old('nama') }}" required>
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="aturan" class="form-label fw-semibold">Aturan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('aturan') is-invalid @enderror" id="aturan"
                                    name="aturan" placeholder="Contoh: Minimal 3 kali percobaan" value="{{ old('aturan') }}" required>
                                @error('aturan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="batasan" class="form-label fw-semibold">Batasan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('batasan') is-invalid @enderror" id="batasan"
                                    name="batasan" placeholder="Contoh: Usia maksimal 18 tahun" value="{{ old('batasan') }}" required>
                                @error('batasan')
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
