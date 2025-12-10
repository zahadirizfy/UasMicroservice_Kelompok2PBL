@extends('backend.layouts.main')
@section('title', 'Tambah Pertandingan')

@section('content')
<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow border-0">
                <div class="card-header bg-gradient-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><i class="fas fa-trophy me-2"></i> Tambah Pertandingan</h4>
                    <a href="{{ route('backend.pertandingan.index') }}" class="btn btn-sm btn-light">
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
                                    <li>• {{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Form Tambah Pertandingan --}}
                    <form action="{{ route('backend.pertandingan.store') }}" method="POST">
                        @csrf

                        <div class="row g-3">
                            {{-- Nama Pertandingan --}}
                            <div class="col-md-6">
                                <label for="nama_pertandingan" class="form-label fw-semibold">
                                    Nama Pertandingan <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                    class="form-control @error('nama_pertandingan') is-invalid @enderror"
                                    id="nama_pertandingan" name="nama_pertandingan"
                                    value="{{ old('nama_pertandingan') }}"
                                    placeholder="Contoh: Kejuaraan Nasional Atletik 2025" required>
                                @error('nama_pertandingan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Penyelenggara Event --}}
                            <div class="col-md-6">
                                <label for="penyelenggara_event_id" class="form-label fw-semibold">
                                    Nama Penyelenggara <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('penyelenggara_event_id') is-invalid @enderror"
                                    id="penyelenggara_event_id" name="penyelenggara_event_id" required>
                                    <option value="" disabled selected>-- Pilih Penyelenggara --</option>
                                    @foreach ($penyelenggaras as $penyelenggara)
                                        <option value="{{ $penyelenggara->id }}"
                                            {{ old('penyelenggara_event_id') == $penyelenggara->id ? 'selected' : '' }}>
                                            {{ $penyelenggara->nama_penyelenggara_event }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('penyelenggara_event_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Juri --}}
                            <div class="col-md-12">
                                <label for="juri_id" class="form-label fw-semibold">
                                    Juri <span class="text-danger">*</span>
                                </label>
                                <select id="juri_id" name="juri_id"
                                    class="form-select @error('juri_id') is-invalid @enderror" required>
                                    <option value="" disabled selected>-- Pilih Juri --</option>
                                    @foreach ($juris as $juri)
                                        <option value="{{ $juri->id }}"
                                            {{ old('juri_id') == $juri->id ? 'selected' : '' }}>
                                            {{ $juri->nama_juri }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('juri_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Tombol --}}
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
