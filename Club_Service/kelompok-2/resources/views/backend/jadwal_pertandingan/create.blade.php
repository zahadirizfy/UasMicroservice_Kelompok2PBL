@extends('backend.layouts.main')

@section('title', 'Tambah Jadwal Pertandingan')

@section('content')
<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow border-0">
                <div class="card-header bg-gradient-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><i class="fas fa-calendar-alt me-2"></i> Tambah Jadwal Pertandingan</h4>
                    <a href="{{ route('backend.jadwal_pertandingan.index') }}" class="btn btn-sm btn-light">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>
                <div class="card-body">

                    {{-- Tampilkan pesan sukses --}}
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    {{-- Tampilkan pesan error --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Form Tambah Jadwal --}}
                    <form action="{{ route('backend.jadwal_pertandingan.store') }}" method="POST">
                        @csrf

                        <div class="row g-3">
                            {{-- Nama Pertandingan --}}
                            <div class="col-md-6">
                                <label for="pertandingan_id" class="form-label fw-semibold">Nama Pertandingan <span class="text-danger">*</span></label>
                                <select id="pertandingan_id" name="pertandingan_id" class="form-select @error('pertandingan_id') is-invalid @enderror" required>
                                    <option value="">-- Pilih Pertandingan --</option>
                                    @foreach ($pertandingans as $p)
                                        <option value="{{ $p->id }}" {{ old('pertandingan_id') == $p->id ? 'selected' : '' }}>
                                            {{ $p->nama_pertandingan }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('pertandingan_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Tanggal --}}
                            <div class="col-md-6">
                                <label for="tanggal" class="form-label fw-semibold">Tanggal <span class="text-danger">*</span></label>
                                <input type="date" id="tanggal" name="tanggal" class="form-control @error('tanggal') is-invalid @enderror" value="{{ old('tanggal') }}" required>
                                @error('tanggal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Lokasi --}}
                            <div class="col-md-6">
                                <label for="lokasi" class="form-label fw-semibold">Lokasi <span class="text-danger">*</span></label>
                                <input type="text" id="lokasi" name="lokasi" class="form-control @error('lokasi') is-invalid @enderror" value="{{ old('lokasi') }}" required>
                                @error('lokasi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Waktu --}}
                            <div class="col-md-6">
                                <label for="waktu" class="form-label fw-semibold">Waktu <span class="text-danger">*</span></label>
                                <input type="time" id="waktu" name="waktu" class="form-control @error('waktu') is-invalid @enderror" value="{{ old('waktu') }}" required>
                                @error('waktu')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Deskripsi --}}
                            <div class="col-12">
                                <label for="deskripsi" class="form-label fw-semibold">Deskripsi</label>
                                <textarea id="deskripsi" name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" rows="3" placeholder="Opsional...">{{ old('deskripsi') }}</textarea>
                                @error('deskripsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
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
@endsection
