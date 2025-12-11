@extends('backend.layouts.main')

@section('title', 'Tambah Hasil Pertandingan')

@section('content')
<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow border-0">
                <div class="card-header bg-gradient-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><i class="fas fa-flag-checkered me-2"></i> Tambah Hasil Pertandingan</h4>
                    <a href="{{ route('backend.hasil_pertandingan.index') }}" class="btn btn-sm btn-light">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>
                <div class="card-body">

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form action="{{ route('backend.hasil_pertandingan.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="pertandingan_id" class="form-label fw-semibold">Pilih Pertandingan <span class="text-danger">*</span></label>
                            <select name="pertandingan_id" id="pertandingan_id"
                                class="form-select @error('pertandingan_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Pertandingan --</option>
                                @foreach ($pertandingans as $pertandingan)
                                    <option value="{{ $pertandingan->id }}">
                                        {{ $pertandingan->nama_pertandingan }}
                                    </option>
                                @endforeach
                            </select>
                            @error('pertandingan_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mt-4 d-flex justify-content-end gap-2">

                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Simpan
                            </button>
                             
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
