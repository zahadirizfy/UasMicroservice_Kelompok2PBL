@extends('backend.layouts.main')
@section('title', 'Tambah Penyelenggara Event')

@section('content')
<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow border-0">
                <div class="card-header text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><i class="fas fa-calendar-check me-2"></i> Tambah Penyelenggara Event</h4>
                    <a href="{{ route('backend.penyelenggara_event.index') }}" class="btn btn-sm btn-light">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>
                <div class="card-body">
                    {{-- Pesan Sukses --}}
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    {{-- Validasi --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Form --}}
                    <form action="{{ route('backend.penyelenggara_event.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="nama_penyelenggara_event" class="form-label fw-semibold">Nama Penyelenggara <span class="text-danger">*</span></label>
                            <input type="text"
                                class="form-control @error('nama_penyelenggara_event') is-invalid @enderror"
                                id="nama_penyelenggara_event"
                                name="nama_penyelenggara_event"
                                value="{{ old('nama_penyelenggara_event') }}"
                                placeholder="Contoh: KONI Provinsi Jawa Barat" required>
                            @error('nama_penyelenggara_event')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="kontak" class="form-label fw-semibold">Kontak <span class="text-danger">*</span></label>
                            <input type="tel"
                                class="form-control @error('kontak') is-invalid @enderror"
                                id="kontak"
                                name="kontak"
                                value="{{ old('kontak') }}"
                                placeholder="Contoh: 081234567890" required>
                            @error('kontak')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
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
@endsection
