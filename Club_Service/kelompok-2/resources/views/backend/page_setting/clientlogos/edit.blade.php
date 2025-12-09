@extends('backend.layouts.app')

@section('title', 'Edit Client Logo')

@section('content')
    <div class="container mt-4 mb-5">
        <div class="card shadow border-0">
            <div class="card-body">
                <h3 class="card-title text-center mb-4">Edit Client Logo</h3>
                <hr>

                <form action="{{ route('backend.clientlogos.update', $clientlogo->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Logo Lama --}}
                    <div class="mb-3">
                        <label for="logo" class="form-label fw-bold">Logo</label><br>
                        @if ($clientlogo->logo && file_exists(public_path($clientlogo->logo)))
                            <img src="{{ asset($clientlogo->logo) }}" alt="Logo Lama" width="200"
                                class="mb-2 d-block rounded shadow-sm">
                        @else
                            <span class="text-muted d-block mb-2">Belum ada logo</span>
                        @endif
                        <input type="file" name="logo" id="logo"
                            class="form-control @error('logo') is-invalid @enderror" accept="image/*">
                        @error('logo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Tombol --}}
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('backend.clientlogos.index') }}" class="btn btn-secondary">← Kembali</a>
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
