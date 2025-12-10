@extends('backend.layouts.app')

@section('title', 'Edit Jadwal Pertandingan')

@section('content')
    <div class="container mt-4 mb-5">
        <div class="card shadow border-0">
            <div class="card-body">
                <h3 class="card-title text-center mb-4">Edit Jadwal Pertandingan</h3>
                <hr>

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('backend.jadwal_pertandingan.update', $jadwalpertandingan->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Nama Pertandingan --}}
                    <div class="mb-3">
                        <label for="pertandingan_id" class="form-label fw-bold">Nama Pertandingan <span class="text-danger">*</span></label>

                        <select class="form-select" id="pertandingan_id" name="pertandingan_id_disabled" disabled>
                            @foreach ($pertandingans as $pertandingan)
                                <option value="{{ $pertandingan->id }}"
                                    {{ old('pertandingan_id', $jadwalpertandingan->pertandingan_id) == $pertandingan->id ? 'selected' : '' }}>
                                    {{ $pertandingan->nama_pertandingan }}
                                </option>
                            @endforeach
                        </select>

                        <!-- Input hidden agar value tetap terkirim ke server -->
                        <input type="hidden" name="pertandingan_id"
                            value="{{ old('pertandingan_id', $jadwalpertandingan->pertandingan_id) }}">
                    </div>


                    {{-- Lokasi --}}
                    <div class="mb-3">
                        <label for="lokasi" class="form-label fw-bold">Lokasi <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('lokasi') is-invalid @enderror" id="lokasi"
                            name="lokasi" value="{{ old('lokasi', $jadwalpertandingan->lokasi) }}" required>
                        @error('lokasi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Tanggal --}}
                    <div class="mb-3">
                        <label for="tanggal" class="form-label fw-bold">Tanggal <span class="text-danger">*</span></label>
                        <input type="date" class="form-control @error('tanggal') is-invalid @enderror" id="tanggal"
                            name="tanggal" value="{{ old('tanggal', $jadwalpertandingan->tanggal) }}" required>
                        @error('tanggal')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Waktu --}}
                    <div class="mb-3">
                        <label for="waktu" class="form-label fw-bold">Waktu <span class="text-danger">*</span></label>
                        <input type="time" class="form-control @error('waktu') is-invalid @enderror" id="waktu"
                            name="waktu" value="{{ old('waktu', $jadwalpertandingan->waktu) }}" required>
                        @error('waktu')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Deskripsi --}}
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label fw-bold">Deskripsi</label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi', $jadwalpertandingan->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Tombol --}}
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('backend.jadwal_pertandingan.index') }}" class="btn btn-secondary">← Kembali</a>
                        <div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Simpan
                            </button>
                            <button type="reset" class="btn btn-warning">
                                <i class="fas fa-rotate-left me-1"></i> Reset
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
