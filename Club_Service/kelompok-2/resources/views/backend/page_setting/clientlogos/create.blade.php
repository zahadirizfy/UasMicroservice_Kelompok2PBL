@extends('backend.layouts.main')
@section('title', 'Tambah Client Logo')

@section('content')
    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow border-0">
                    <div class="card-header bg-gradient-primary text-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0"><i class="fas fa-handshake me-2"></i> Tambah Client Logo</h4>
                        <a href="{{ route('backend.clientlogos.index') }}" class="btn btn-sm btn-light">
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
                                <strong>Terjadi kesalahan:</strong>
                                <ul class="mb-0 mt-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('backend.clientlogos.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row g-3">
                                {{-- Upload Logo --}}
                                <div class="col-md-12">
                                    <label for="logo" class="form-label fw-semibold">Upload Logo <span class="text-danger">*</span></label>
                                    <input type="file" id="logo" name="logo"
                                           class="form-control @error('logo') is-invalid @enderror"
                                           accept="image/*" required>
                                    @error('logo')
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
@endsection
