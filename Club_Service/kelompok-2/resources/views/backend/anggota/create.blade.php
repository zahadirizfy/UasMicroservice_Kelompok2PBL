@extends('backend.layouts.main')
@section('title', 'Tambah Anggota')

@section('content')
<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow border-0">
                <div class="card-header bg-gradient-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><i class="fas fa-user-plus me-2"></i> Tambah Anggota</h4>
                    <a href="{{ route('backend.anggota.index') }}" class="btn btn-sm btn-light">
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

                    {{-- Form Tambah Anggota --}}
                    <form action="{{ route('backend.anggota.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="nama" class="form-label fw-semibold">Nama <span class="text-danger">*</span></label>
                                <input type="text" name="nama" id="nama"
                                    class="form-control @error('nama') is-invalid @enderror"
                                    value="{{ old('nama') }}" placeholder="Masukkan nama lengkap">
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="tgl_lahir" class="form-label fw-semibold">Tanggal Lahir <span class="text-danger">*</span></label>
                                <input type="date" name="tgl_lahir" id="tgl_lahir"
                                    class="form-control @error('tgl_lahir') is-invalid @enderror"
                                    value="{{ old('tgl_lahir') }}">
                                @error('tgl_lahir')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="peran" class="form-label fw-semibold">Peran <span class="text-danger">*</span></label>
                                <select name="peran" id="peran"
                                    class="form-select @error('peran') is-invalid @enderror">
                                    <option value="">-- Pilih Peran --</option>
                                    <option value="Atlet" {{ old('peran') == 'Atlet' ? 'selected' : '' }}>Atlet</option>
                                    <option value="Pengurus" {{ old('peran') == 'Pengurus' ? 'selected' : '' }}>Pengurus</option>
                                    <option value="Atlet & Pengurus" {{ old('peran') == 'Atlet & Pengurus' ? 'selected' : '' }}>
                                        Atlet & Pengurus</option>
                                </select>
                                @error('peran')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="kontak" class="form-label fw-semibold">Nomor WA <span class="text-danger">*</span></label>
                                <input type="text" name="kontak" id="kontak"
                                    class="form-control @error('kontak') is-invalid @enderror"
                                    value="{{ old('kontak') }}" placeholder="08xxxxxxxxxx">
                                @error('kontak')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="klub" class="form-label fw-semibold">Klub</label>
                                <input type="text" name="klub" id="klub"
                                    class="form-control @error('klub') is-invalid @enderror"
                                    value="{{ old('klub') }}" placeholder="Masukkan nama klub">
                                @error('klub')
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

                                {{-- Preview Foto --}}
                                <div class="mt-3">
                                    <img id="preview-image" src="#" alt="Preview Foto"
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

{{-- Script Preview Foto --}}
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

            const reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    }

    function resetPreview() {
        const preview = document.getElementById('preview-image');
        preview.src = '#';
        preview.style.display = 'none';
    }
</script>
@endsection
