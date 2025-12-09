@extends('backend.layouts.app')

@section('title', 'Edit Klub')

@section('content')
    <div class="container mt-4 mb-5">
        <div class="card shadow border-0">
            <div class="card-body">
                <h3 class="card-title text-center mb-4">Edit Klub</h3>
                <hr>

                <form action="{{ route('backend.club.update', $club->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Nama Klub --}}
                    <div class="mb-3">
                        <label for="nama" class="form-label fw-bold">Nama Klub <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama"
                            name="nama" value="{{ old('nama', $club->nama) }}" required>
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Lokasi --}}
                    <div class="mb-3">
                        <label for="lokasi" class="form-label fw-bold">Lokasi <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('lokasi') is-invalid @enderror" id="lokasi"
                            name="lokasi" value="{{ old('lokasi', $club->lokasi) }}" required>
                        @error('lokasi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Deskripsi --}}
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label fw-bold">Deskripsi</label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="4">{{ old('deskripsi', $club->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Tombol --}}
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('backend.club.index') }}" class="btn btn-secondary">← Kembali</a>
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
