@extends('backend.layouts.main')

@section('title', 'Tambah Atlet')

@section('content')
    <div class="container mt-4 mb-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow border-0">
                    <div
                        class="card-header bg-gradient-primary text-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0"><i class="fas fa-user-plus me-2"></i> Tambah Atlet</h4>
                        <a href="{{ route('backend.atlet.index') }}" class="btn btn-sm btn-light">
                            <i class="fas fa-arrow-left me-1"></i> Kembali
                        </a>
                    </div>

                    <div class="card-body">
                        {{-- Alert sukses --}}
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        {{-- Alert error --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>• {{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('backend.atlet.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row g-3">
                                {{-- Nama --}}
                                <div class="col-md-6">
                                    <label for="nama" class="form-label fw-semibold">Nama <span
                                            class="text-danger">*</span></label>
                                    <input type="text" id="nama" name="nama"
                                        class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}"
                                        placeholder="Masukkan nama atlet">
                                    @error('nama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>


                                {{-- Klub --}}
                                <div class="col-md-6">
                                    <label for="club_id" class="form-label fw-semibold">Klub (Opsional)</label>
                                    <select name="club_id" id="club_id"
                                        class="form-select @error('club_id') is-invalid @enderror">
                                        <option value="">-- Pilih Klub --</option>
                                        @foreach ($clubs as $club)
                                            <option value="{{ $club->id }}"
                                                {{ old('club_id') == $club->id ? 'selected' : '' }}>
                                                {{ $club->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('club_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Foto --}}
                                <div class="col-md-6">
                                    <label for="foto" class="form-label fw-semibold">Foto <span
                                            class="text-danger">*</span></label>
                                    <input type="file" id="foto" name="foto"
                                        class="form-control @error('foto') is-invalid @enderror" accept="image/*"
                                        onchange="previewImage(event)">
                                    <small class="text-light">Format Gambar: (jpg, jpeg, png).</small>
                                    @error('foto')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                    {{-- Preview --}}
                                    <div class="mt-3">
                                        <img id="preview-image" src="#" alt="Preview Foto"
                                            class="img-fluid rounded border" style="display: none; max-height: 300px;">
                                    </div>
                                </div>




                                {{-- Prestasi --}}
                                <div class="col-md-6">
                                    <label for="prestasi" class="form-label fw-semibold">Prestasi</label>
                                    <textarea name="prestasi" id="prestasi" rows="3" class="form-control @error('prestasi') is-invalid @enderror"
                                        placeholder="Contoh: Juara 1 Kejurda 2023">{{ old('prestasi') }}</textarea>
                                    @error('prestasi')
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

    {{-- Script Preview Gambar --}}
    <script>
        function previewImage(event) {
            const input = event.target;
            const preview = document.getElementById('preview-image');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function resetPreview() {
            const preview = document.getElementById('preview-image');
            preview.src = "#";
            preview.style.display = "none";
        }
    </script>
@endsection
