@extends('backend.layouts.app')

@section('title', 'Edit Pengumuman')

@section('content')
<div class="container mt-4 mb-5">
    <div class="card shadow border-0">
        <div class="card-header bg-gradient-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><i class="fas fa-edit me-2"></i> Edit Pengumuman</h4>
            <a href="{{ route('backend.pengumuman.index') }}" class="btn btn-sm btn-light">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
        </div>

        <div class="card-body">
            {{-- Tampilkan error validasi --}}
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

            <form action="{{ route('backend.pengumuman.update', $pengumuman->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    {{-- Judul --}}
                    <div class="col-md-6">
                        <label for="judul" class="form-label fw-semibold">Judul Pengumuman <span class="text-danger">*</span></label>
                        <input type="text" name="judul" id="judul"
                               class="form-control @error('judul') is-invalid @enderror"
                               value="{{ old('judul', $pengumuman->judul) }}" required>
                        @error('judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Tanggal --}}
                    <div class="col-md-6">
                        <label for="tanggal" class="form-label fw-semibold">Tanggal <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal" id="tanggal"
                               class="form-control @error('tanggal') is-invalid @enderror"
                               value="{{ old('tanggal', $pengumuman->tanggal) }}" required>
                        @error('tanggal')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Isi --}}
                    <div class="col-12">
                        <label for="isi" class="form-label fw-semibold">Isi Pengumuman <span class="text-danger">*</span></label>
                        <textarea name="isi" id="isi" rows="5"
                                  class="form-control @error('isi') is-invalid @enderror"
                                  placeholder="Masukkan isi pengumuman" required>{{ old('isi', $pengumuman->isi) }}</textarea>
                        @error('isi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Ganti Foto --}}
                    <div class="col-12">
                        <label for="foto" class="form-label fw-semibold">Ganti Foto</label>
                        <input type="file" name="foto" id="foto"
                               class="form-control @error('foto') is-invalid @enderror"
                               accept="image/jpeg,image/png,image/jpg" onchange="previewFoto(this)">
                        <small class="text-light">Format Gambar: (jpg, jpeg, png).</small>
                        @error('foto')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Preview Foto --}}
                    <div class="col-12 mt-3">
                        <label class="form-label fw-semibold">Preview Foto:</label><br>
                        <img id="preview-image"
                             src="{{ $pengumuman->foto ? asset('uploads/pengumuman/' . $pengumuman->foto) : '#' }}"
                             alt="Preview Foto"
                             class="img-fluid rounded border"
                             style="max-height: 300px; {{ $pengumuman->foto ? '' : 'display: none;' }}">
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

{{-- Script Preview Foto --}}
<script>
    function previewFoto(input) {
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
        preview.src = "{{ $pengumuman->foto ? asset('uploads/pengumuman/' . $pengumuman->foto) : '#' }}";
        preview.style.display = "{{ $pengumuman->foto ? 'block' : 'none' }}";
        document.getElementById('foto').value = "";
    }
</script>
@endsection
