@extends('backend.layouts.app')

@section('title', 'Edit Anggota')

@section('content')
    <div class="container mt-4 mb-5">
        <div class="card shadow border-0">
            <div class="card-header bg-gradient-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0"><i class="fas fa-user-edit me-2"></i> Edit Anggota</h4>
                <a href="{{ route('backend.anggota.index') }}" class="btn btn-sm btn-light">
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

                <form action="{{ route('backend.anggota.update', $anggota->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        {{-- Nama --}}
                        <div class="col-md-6">
                            <label for="nama" class="form-label fw-semibold">Nama <span
                                    class="text-danger">*</span></label>
                            <input type="text" id="nama" name="nama"
                                class="form-control @error('nama') is-invalid @enderror"
                                value="{{ old('nama', $anggota->nama) }}" required>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Klub --}}
                        <div class="col-md-6">
                            <label for="klub" class="form-label fw-semibold">Klub</label>
                            <input type="text" id="klub" name="klub"
                                class="form-control @error('klub') is-invalid @enderror"
                                value="{{ old('klub', $anggota->klub) }}">
                            @error('klub')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Tanggal Lahir --}}
                        <div class="col-md-6">
                            <label for="tgl_lahir" class="form-label fw-semibold">Tanggal Lahir <span
                                    class="text-danger">*</span></label>
                            <input type="date" id="tgl_lahir" name="tgl_lahir"
                                class="form-control @error('tgl_lahir') is-invalid @enderror"
                                value="{{ old('tgl_lahir', $anggota->tgl_lahir) }}" required>
                            @error('tgl_lahir')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Peran --}}
                        <div class="col-md-6">
                            <label for="peran" class="form-label fw-semibold">Peran <span
                                    class="text-danger">*</span></label>
                            <select id="peran" name="peran" class="form-select @error('peran') is-invalid @enderror"
                                required>
                                <option value="">-- Pilih Peran --</option>
                                <option value="Atlet" {{ old('peran', $anggota->peran) == 'Atlet' ? 'selected' : '' }}>
                                    Atlet</option>
                                <option value="Pengurus"
                                    {{ old('peran', $anggota->peran) == 'Pengurus' ? 'selected' : '' }}>Pengurus</option>
                                <option value="Atlet & Pengurus"
                                    {{ old('peran', $anggota->peran) == 'Atlet & Pengurus' ? 'selected' : '' }}>Atlet &
                                    Pengurus</option>
                            </select>
                            @error('peran')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Kontak --}}
                        <div class="col-md-6">
                            <label for="kontak" class="form-label fw-semibold">Nomor WA <span
                                    class="text-danger">*</span></label>
                            <input type="number" id="kontak" name="kontak"
                                class="form-control @error('kontak') is-invalid @enderror"
                                value="{{ old('kontak', $anggota->kontak) }}" required>
                            @error('kontak')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Ganti Foto --}}
                        <div class="col-md-6">
                            <label for="foto" class="form-label fw-semibold">Ganti Foto</label>
                            <input type="file" id="foto" name="foto"
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
                                src="{{ $anggota->foto && file_exists(public_path('storage/' . $anggota->foto)) ? asset('storage/' . $anggota->foto) : '#' }}"
                                alt="Preview Foto" class="img-fluid rounded border"
                                style="max-height: 300px; {{ $anggota->foto ? '' : 'display: none;' }}">
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
                reader.onload = function(e) {
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
            preview.src =
                "{{ $anggota->foto && file_exists(public_path('storage/' . $anggota->foto)) ? asset('storage/' . $anggota->foto) : '#' }}";
            preview.style.display = "{{ $anggota->foto ? 'block' : 'none' }}";
            document.getElementById('foto').value = "";
        }
    </script>
@endsection
