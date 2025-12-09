@extends('backend.layouts.main')
@section('title', 'Tambah Pengumuman')

@section('content')
<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow border-0">
                <div class="card-header bg-gradient-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><i class="fas fa-bullhorn me-2"></i> Tambah Pengumuman</h4>
                    <a href="{{ route('backend.pengumuman.index') }}" class="btn btn-sm btn-light">
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
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Form Tambah Pengumuman --}}
                    <form action="{{ route('backend.pengumuman.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="judul" class="form-label fw-semibold">Judul Pengumuman <span class="text-danger">*</span></label>
                                <input type="text" name="judul" id="judul"
                                    class="form-control @error('judul') is-invalid @enderror"
                                    value="{{ old('judul') }}" placeholder="Masukkan judul pengumuman" required>
                                @error('judul')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="tanggal" class="form-label fw-semibold">Tanggal <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal" id="tanggal"
                                    class="form-control @error('tanggal') is-invalid @enderror"
                                    value="{{ old('tanggal') }}" required>
                                @error('tanggal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="isi" class="form-label fw-semibold">Isi Pengumuman <span class="text-danger">*</span></label>
                                <textarea name="isi" id="isi" rows="5"
                                    class="form-control @error('isi') is-invalid @enderror"
                                    placeholder="Tulis isi pengumuman...">{{ old('isi') }}</textarea>
                                @error('isi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="foto" class="form-label fw-semibold">Foto <span class="text-danger">*</span></label>
                                <input type="file" name="foto" id="foto"
                                    class="form-control @error('foto') is-invalid @enderror"
                                    accept="image/jpeg,image/png,image/jpg" onchange="previewImage(event)">
                                <small class="text-light">Format Gambar: (jpg, jpeg, png).</small>
                                @error('foto')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                {{-- Preview Gambar --}}
                                <div class="mt-3">
                                    <img id="preview-image" src="#" alt="Preview Gambar"
                                         class="img-fluid rounded border"
                                         style="display: none; max-height: 300px;">
                                </div>
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

{{-- Script preview gambar --}}
<script>
    function previewImage(event) {
        const input = event.target;
        const preview = document.getElementById('preview-image');

        if (input.files && input.files[0]) {
            const file = input.files[0];

            if (!file.type.match('image.*')) {
                preview.style.display = 'none';
                return;
            }

            if (window.FileReader) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                alert("Browser Anda tidak mendukung pratinjau gambar.");
            }
        }
    }

    function resetPreview() {
        const preview = document.getElementById('preview-image');
        preview.src = '#';
        preview.style.display = 'none';
    }
</script>
@endsection
