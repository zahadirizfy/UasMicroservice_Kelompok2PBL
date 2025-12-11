@extends('backend.layouts.main')
@section('title', 'Tambah About Section')

@section('content')
    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow border-0">
                    <div class="card-header bg-gradient-primary text-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0"><i class="fas fa-info-circle me-2"></i> Tambah About Section</h4>
                        <a href="{{ route('backend.about.index') }}" class="btn btn-sm btn-light">
                            <i class="fas fa-arrow-left me-1"></i> Kembali
                        </a>
                    </div>

                    <div class="card-body">

                        {{-- Pesan sukses --}}
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        {{-- Validasi error --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <strong>Terjadi kesalahan:</strong>
                                <ul class="mb-0 mt-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('backend.about.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row g-3">

                                {{-- Judul --}}
                                <div class="col-md-12">
                                    <label for="judul" class="form-label fw-semibold">Judul <span class="text-danger">*</span></label>
                                    <input type="text" id="judul" name="judul"
                                           class="form-control @error('judul') is-invalid @enderror"
                                           value="{{ old('judul') }}" required placeholder="Contoh: Porlempika">
                                    @error('judul')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Gambar Kiri --}}
                                <div class="col-md-6">
                                    <label for="image" class="form-label fw-semibold">Gambar Kiri <span class="text-danger">*</span></label>
                                    <input type="file" id="image" name="image"
                                           class="form-control @error('image') is-invalid @enderror"
                                           accept="image/*" required>
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Gambar Kanan --}}
                                <div class="col-md-6">
                                    <label for="second_image" class="form-label fw-semibold">Gambar Kanan (Video) <span class="text-danger">*</span></label>
                                    <input type="file" id="second_image" name="second_image"
                                           class="form-control @error('second_image') is-invalid @enderror"
                                           accept="image/*" required>
                                    @error('second_image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Deskripsi Singkat --}}
                                <div class="col-12">
                                    <label for="deskripsi_singkat" class="form-label fw-semibold">Deskripsi Singkat <span class="text-danger">*</span></label>
                                    <textarea id="deskripsi_singkat" name="deskripsi_singkat" rows="3"
                                              class="form-control @error('deskripsi_singkat') is-invalid @enderror"
                                              placeholder="Tulis deskripsi pendek tentang Porlempika" required>{{ old('deskripsi_singkat') }}</textarea>
                                    @error('deskripsi_singkat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Deskripsi Lengkap --}}
                                <div class="col-12">
                                    <label for="deskripsi_lengkap" class="form-label fw-semibold">Deskripsi Lengkap <span class="text-danger">*</span></label>
                                    <textarea id="deskripsi_lengkap" name="deskripsi_lengkap" rows="5"
                                              class="form-control @error('deskripsi_lengkap') is-invalid @enderror"
                                              placeholder="Tulis deskripsi lengkap sejarah, visi, atau peran Porlempika" required>{{ old('deskripsi_lengkap') }}</textarea>
                                    @error('deskripsi_lengkap')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Link Video --}}
                                <div class="col-12">
                                    <label for="video_link" class="form-label fw-semibold">Link Video (YouTube) <span class="text-danger">*</span></label>
                                    <input type="url" id="video_link" name="video_link"
                                           class="form-control @error('video_link') is-invalid @enderror"
                                           value="{{ old('video_link') }}" required placeholder="Contoh: https://youtube.com/watch?v=...">
                                    @error('video_link')
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
