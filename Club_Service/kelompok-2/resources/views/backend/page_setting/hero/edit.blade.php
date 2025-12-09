@extends('backend.layouts.app')

@section('title', 'Edit Hero Section')

@section('content')
    <div class="container mt-4 mb-5">
        <div class="card shadow border-0">
            <div class="card-body">
                <h3 class="card-title text-center mb-4">Edit Hero Section</h3>
                <hr>

                <form action="{{ route('backend.hero.update', $hero->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Gambar Hero --}}
                    <div class="mb-3">
                        <label for="image" class="form-label fw-bold">Gambar Hero</label><br>
                        @if ($hero->gambar && file_exists(public_path($hero->gambar)))
                            <img src="{{ asset($hero->gambar) }}" alt="Gambar Hero Lama" width="200" class="mb-2 d-block rounded shadow-sm">
                        @else
                            <span class="text-muted d-block mb-2">Belum ada gambar</span>
                        @endif
                        <input type="file" name="image" id="image"
                            class="form-control @error('image') is-invalid @enderror" accept="image/*">
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Judul --}}
                    <div class="mb-3">
                        <label for="judul" class="form-label fw-bold">Judul <span class="text-danger">*</span></label>
                        <input type="text" name="judul" id="judul"
                            class="form-control @error('judul') is-invalid @enderror"
                            value="{{ old('judul', $hero->judul) }}" required>
                        @error('judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Deskripsi --}}
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label fw-bold">Deskripsi <span class="text-danger">*</span></label>
                        <textarea name="deskripsi" id="deskripsi" rows="4"
                            class="form-control @error('deskripsi') is-invalid @enderror" required>{{ old('deskripsi', $hero->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Tombol --}}
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('backend.hero.index') }}" class="btn btn-secondary">← Kembali</a>
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
