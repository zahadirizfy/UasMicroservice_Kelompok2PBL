@extends('backend.layouts.app')

@section('title', 'Edit Galeri')

@section('content')
    <div class="container mt-4 mb-5">
        <div class="card shadow border-0">
            <div class="card-header bg-gradient-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0"><i class="fas fa-images me-2"></i> Edit Galeri</h4>
                <a href="{{ route('backend.galeri.index') }}" class="btn btn-sm btn-light">
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

                <form action="{{ route('backend.galeri.update', $galeri->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        {{-- Judul --}}
                        <div class="col-md-6">
                            <label for="judul" class="form-label fw-semibold">Judul <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="judul" id="judul"
                                class="form-control @error('judul') is-invalid @enderror"
                                value="{{ old('judul', $galeri->judul) }}" required>
                            @error('judul')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Upload Gambar Baru --}}
                        <div class="col-md-6">
                            <label for="gambar" class="form-label fw-semibold">Ganti Gambar <span
                                    class="text-danger">*</span></label>
                            <input type="file" name="gambar" id="gambar"
                                class="form-control @error('gambar') is-invalid @enderror" accept="image/*"
                                onchange="previewGambar(this)">
                            <small class="text-light">Format Gambar: (jpg, jpeg, png).</small>
                            @error('gambar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Deskripsi --}}
                        <div class="col-12">
                            <label for="deskripsi" class="form-label fw-semibold">Deskripsi</label>
                            <textarea name="deskripsi" id="deskripsi" rows="4" class="form-control @error('deskripsi') is-invalid @enderror"
                                placeholder="Tulis deskripsi jika diperlukan...">{{ old('deskripsi', $galeri->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Preview Gambar --}}
                        <div class="col-12 mt-3">
                            <label class="form-label fw-semibold">Preview Gambar:</label><br>
                            <img id="preview-image" src="{{ $galeri->gambar ? asset('uploads/' . $galeri->gambar) : '#' }}"
                                alt="Preview Gambar" class="img-fluid rounded border"
                                style="max-height: 300px; {{ $galeri->gambar ? '' : 'display: none;' }}">
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

    {{-- Script Preview Gambar --}}
    <script>
        function previewGambar(input) {
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
            preview.src = "{{ $galeri->gambar ? asset('uploads/' . $galeri->gambar) : '#' }}";
            preview.style.display = "{{ $galeri->gambar ? 'block' : 'none' }}";
            document.getElementById('gambar').value = "";
        }
    </script>
@endsection
