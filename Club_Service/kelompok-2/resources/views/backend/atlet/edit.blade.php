@extends('backend.layouts.app')

@section('title', 'Edit Atlet')

@section('content')
    <div class="container mt-4 mb-5">
        <div class="card shadow border-0">
            <div class="card-header bg-gradient-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0"><i class="fas fa-user-edit me-2"></i> Edit Atlet</h4>
                <a href="{{ route('backend.atlet.index') }}" class="btn btn-sm btn-light">
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

                <form action="{{ route('backend.atlet.update', $atlet->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        {{-- Nama --}}
                        <div class="col-md-6">
                            <label for="nama" class="form-label fw-semibold">Nama <span
                                    class="text-danger">*</span></label>
                            <input type="text" id="nama" name="nama"
                                class="form-control @error('nama') is-invalid @enderror"
                                value="{{ old('nama', $atlet->nama) }}" required>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Klub --}}
                        <div class="col-md-6">
                            <label for="club_id" class="form-label fw-semibold">Klub (Opsional)</label>
                            <select id="club_id" name="club_id"
                                class="form-select @error('club_id') is-invalid @enderror">
                                <option value="">-- Pilih Klub --</option>
                                @foreach ($clubs as $club)
                                    <option value="{{ $club->id }}"
                                        {{ old('club_id', $atlet->club_id) == $club->id ? 'selected' : '' }}>
                                        {{ $club->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('club_id')
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

                        {{-- Prestasi --}}
                        <div class="col-md-6">
                            <label for="prestasi" class="form-label fw-semibold">Prestasi</label>
                            <textarea id="prestasi" name="prestasi" class="form-control @error('prestasi') is-invalid @enderror" rows="3">{{ old('prestasi', $atlet->prestasi) }}</textarea>
                            @error('prestasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Preview Foto --}}
                        <div class="col-12 mt-3">
                            <label class="form-label fw-semibold">Preview Foto:</label><br>
                            <img id="preview-image"
                                src="{{ $atlet->foto && file_exists(public_path('storage/' . $atlet->foto)) ? asset('storage/' . $atlet->foto) : '#' }}"
                                alt="Preview Foto" class="img-fluid rounded border"
                                style="max-height: 300px; {{ $atlet->foto ? '' : 'display: none;' }}">
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
                "{{ $atlet->foto && file_exists(public_path('storage/' . $atlet->foto)) ? asset('storage/' . $atlet->foto) : '#' }}";
            preview.style.display = "{{ $atlet->foto ? 'block' : 'none' }}";
            document.getElementById('foto').value = "";
        }
    </script>
@endsection
