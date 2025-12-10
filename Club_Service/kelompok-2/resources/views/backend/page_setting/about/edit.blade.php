@extends('backend.layouts.app')

@section('title', 'Edit About Section')

@section('content')
    <div class="container mt-4 mb-5">
        <div class="card shadow border-0">
            <div class="card-body">
                <h3 class="card-title text-center mb-4">Edit About Section</h3>
                <hr>

                <form action="{{ route('backend.about.update', $about->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Judul --}}
                    <div class="mb-3">
                        <label for="judul" class="form-label fw-bold">Judul <span class="text-danger">*</span></label>
                        <input type="text" name="judul" id="judul"
                            class="form-control @error('judul') is-invalid @enderror"
                            value="{{ old('judul', $about->judul) }}" required>
                        @error('judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Gambar Kiri --}}
                    <div class="mb-3">
                        <label for="image" class="form-label fw-bold">Gambar Kiri</label><br>
                        @if ($about->image && file_exists(public_path($about->image)))
                            <img src="{{ asset($about->image) }}" alt="Gambar Kiri Lama" width="200"
                                class="mb-2 d-block rounded shadow-sm">
                        @else
                            <span class="text-muted d-block mb-2">Belum ada gambar</span>
                        @endif
                        <input type="file" name="image" id="image"
                            class="form-control @error('image') is-invalid @enderror" accept="image/*">
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Gambar Kanan --}}
                    <div class="mb-3">
                        <label for="second_image" class="form-label fw-bold">Gambar Kanan (Video)</label><br>
                        @if ($about->second_image && file_exists(public_path($about->second_image)))
                            <img src="{{ asset($about->second_image) }}" alt="Gambar Kanan Lama" width="200"
                                class="mb-2 d-block rounded shadow-sm">
                        @else
                            <span class="text-muted d-block mb-2">Belum ada gambar</span>
                        @endif
                        <input type="file" name="second_image" id="second_image"
                            class="form-control @error('second_image') is-invalid @enderror" accept="image/*">
                        @error('second_image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Deskripsi Singkat --}}
                    <div class="mb-3">
                        <label for="deskripsi_singkat" class="form-label fw-bold">Deskripsi Singkat <span class="text-danger">*</span></label>
                        <textarea name="deskripsi_singkat" id="deskripsi_singkat" rows="3"
                            class="form-control @error('deskripsi_singkat') is-invalid @enderror" required>{{ old('deskripsi_singkat', $about->deskripsi_singkat) }}</textarea>
                        @error('deskripsi_singkat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Deskripsi Lengkap --}}
                    <div class="mb-3">
                        <label for="deskripsi_lengkap" class="form-label fw-bold">Deskripsi Lengkap <span class="text-danger">*</span></label>
                        <textarea name="deskripsi_lengkap" id="deskripsi_lengkap" rows="5"
                            class="form-control @error('deskripsi_lengkap') is-invalid @enderror" required>{{ old('deskripsi_lengkap', $about->deskripsi_lengkap) }}</textarea>
                        @error('deskripsi_lengkap')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Link Video --}}
                    <div class="mb-3">
                        <label for="video_link" class="form-label fw-bold">Link Video (YouTube) <span class="text-danger">*</span></label>
                        <input type="url" name="video_link" id="video_link"
                            class="form-control @error('video_link') is-invalid @enderror"
                            value="{{ old('video_link', $about->video_link) }}" required>
                        @error('video_link')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Tombol --}}
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('backend.about.index') }}" class="btn btn-secondary">← Kembali</a>
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
