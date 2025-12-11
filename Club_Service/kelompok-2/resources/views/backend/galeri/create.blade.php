@extends('backend.layouts.main')

@section('title', 'Tambah Galeri')

@section('content')
<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow border-0">
                <div class="card-header bg-gradient-success text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><i class="fas fa-image me-2"></i> Tambah Galeri</h4>
                    <a href="{{ route('backend.galeri.index') }}" class="btn btn-sm btn-light">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    {{-- Validasi --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Periksa kembali input Anda:</strong>
                            <ul class="mb-0 mt-1">
                                @foreach ($errors->all() as $error)
                                    <li>• {{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('backend.galeri.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row g-3">
                            {{-- Judul --}}
                            <div class="col-md-6">
                                <label for="judul" class="form-label fw-semibold">Judul <span class="text-danger">*</span></label>
                                <input type="text" name="judul" id="judul"
                                    class="form-control @error('judul') is-invalid @enderror"
                                    placeholder="Contoh: Kegiatan Pelatihan Nasional"
                                    value="{{ old('judul') }}" required>
                                @error('judul')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Gambar --}}
                            <div class="col-md-6">
                                <label for="gambar" class="form-label fw-semibold">Gambar <span class="text-danger">*</span></label>
                                <input type="file" name="gambar" id="gambar"
                                    class="form-control @error('gambar') is-invalid @enderror"
                                    accept="image/*" onchange="previewGambar(this)" required>
                                <small class="text-light">Format Gambar: (jpg, jpeg, png).</small>
                                @error('gambar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Deskripsi --}}
                            <div class="col-12">
                                <label for="deskripsi" class="form-label fw-semibold">Deskripsi</label>
                                <textarea name="deskripsi" id="deskripsi"
                                    class="form-control @error('deskripsi') is-invalid @enderror"
                                    rows="4"
                                    placeholder="Contoh: Dokumentasi kegiatan pelatihan atlet junior di bulan Mei...">{{ old('deskripsi') }}</textarea>
                                @error('deskripsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Preview Gambar --}}
                            <div class="col-12 mt-2">
                                <label class="form-label fw-semibold">Preview Gambar:</label><br>
                                <img id="preview-image" class="img-fluid rounded border" style="max-height: 300px; display: none;">
                            </div>
                        </div>

                        {{-- Tombol Aksi --}}
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

{{-- Script Preview Gambar --}}
<script>
    function previewGambar(input) {
        const preview = document.getElementById('preview-image');
        const file = input.files[0];

        if (file && file.type.match('image.*')) {
            const reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            preview.src = '#';
            preview.style.display = 'none';
        }
    }

    function resetPreview() {
        const preview = document.getElementById('preview-image');
        preview.src = '#';
        preview.style.display = 'none';
        document.getElementById('gambar').value = "";
    }
</script>
@endsection
