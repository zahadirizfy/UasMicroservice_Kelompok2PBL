@extends('backend.layouts.app')

@section('title', 'Edit Penyelenggara Event')

@section('content')
<div class="container mt-4 mb-5">
    <div class="card shadow border-0">
        <div class="card-body">
            <h3 class="card-title text-center mb-4">Edit Penyelenggara Event</h3>
            <hr>

            {{-- Tampilkan pesan sukses --}}
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            {{-- Tampilkan error validasi --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Terjadi kesalahan:</strong>
                    <ul class="mb-0 mt-1">
                        @foreach ($errors->all() as $error)
                            <li>• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Form Edit --}}
            <form action="{{ route('backend.penyelenggara_event.update', $penyelenggara_event->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Nama Penyelenggara --}}
                <div class="mb-3">
                    <label for="nama_penyelenggara_event" class="form-label fw-bold">Nama Penyelenggara <span class="text-danger">*</span></label>
                    <input type="text" id="nama_penyelenggara_event" name="nama_penyelenggara_event"
                        class="form-control @error('nama_penyelenggara_event') is-invalid @enderror"
                        value="{{ old('nama_penyelenggara_event', $penyelenggara_event->nama_penyelenggara_event) }}" required>
                    @error('nama_penyelenggara_event')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                 <div class="mb-3">
                    <label for="kontak" class="form-label">Kontak <span class="text-danger">*</span></label>
                    <input type="number" class="form-control @error('kontak') is-invalid @enderror" id="kontak"
                        name="kontak" value="{{ old('kontak', $penyelenggara_event->kontak) }}">
                    @error('kontak')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Tombol Aksi --}}
                <div class="d-flex justify-content-between">
                    <a href="{{ route('backend.penyelenggara_event.index') }}" class="btn btn-secondary">← Kembali</a>
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
