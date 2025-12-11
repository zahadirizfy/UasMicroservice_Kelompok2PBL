@extends('backend.layouts.app')

@section('title', 'Edit Struktur Organisasi')

@section('content')
    <div class="container mt-4 mb-5">
        <div class="card shadow border-0">
            <div class="card-body">
                <h3 class="card-title text-center mb-4">Edit Struktur Organisasi</h3>
                <hr>

                <form action="{{ route('backend.organization.update', $structure->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Foto --}}
                    <div class="mb-3">
                        <label for="photo" class="form-label fw-bold">Foto</label><br>
                        @if ($structure->photo && file_exists(public_path($structure->photo)))
                            <img src="{{ asset($structure->photo) }}" alt="Foto Anggota" width="120" class="mb-2 d-block rounded shadow-sm">
                        @else
                            <span class="text-muted d-block mb-2">Belum ada foto</span>
                        @endif
                        <input type="file" name="photo" id="photo"
                            class="form-control @error('photo') is-invalid @enderror" accept="image/*">
                        @error('photo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Nama --}}
                    <div class="mb-3">
                        <label for="name" class="form-label fw-bold">Nama <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $structure->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Jabatan --}}
                    <div class="mb-3">
                        <label for="position" class="form-label fw-bold">Jabatan <span class="text-danger">*</span></label>
                        <input type="text" name="position" id="position"
                            class="form-control @error('position') is-invalid @enderror"
                            value="{{ old('position', $structure->position) }}" required>
                        @error('position')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Deskripsi --}}
                    <div class="mb-3">
                        <label for="description" class="form-label fw-bold">Deskripsi</label>
                        <textarea name="description" id="description" rows="4"
                            class="form-control @error('description') is-invalid @enderror">{{ old('description', $structure->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Tombol --}}
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('backend.organization.index') }}" class="btn btn-secondary">← Kembali</a>
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
