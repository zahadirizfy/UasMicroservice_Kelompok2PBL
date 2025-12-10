@extends('backend.layouts.main')
@section('title', 'Tambah Testimonial')

@section('content')
<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow border-0">
                <div class="card-header bg-gradient-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><i class="fas fa-quote-left me-2"></i> Tambah Testimonial</h4>
                    <a href="{{ route('backend.testimonials.index') }}" class="btn btn-sm btn-light">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>

                <div class="card-body">

                    {{-- Pesan sukses --}}
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    {{-- Form --}}
                    <form action="{{ route('backend.testimonials.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row g-3">
                            {{-- Foto --}}
                            <div class="col-12">
                                <label for="image" class="form-label fw-semibold">Foto <span class="text-danger">*</span></label>
                                <input type="file"
                                       class="form-control @error('image') is-invalid @enderror"
                                       id="image" name="image" accept="image/*" required>
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Nama --}}
                            <div class="col-12">
                                <label for="name" class="form-label fw-semibold">Nama <span class="text-danger">*</span></label>
                                <input type="text"
                                       class="form-control @error('name') is-invalid @enderror"
                                       id="name" name="name" placeholder="Contoh: Usain Bolt"
                                       value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Profesi --}}
                            <div class="col-12">
                                <label for="profession" class="form-label fw-semibold">Profesi <span class="text-danger">*</span></label>
                                <input type="text"
                                       class="form-control @error('profession') is-invalid @enderror"
                                       id="profession" name="profession" placeholder="Contoh: Pelari Olimpiade"
                                       value="{{ old('profession') }}" required>
                                @error('profession')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Quote --}}
                            <div class="col-12">
                                <label for="quote" class="form-label fw-semibold">Quote <span class="text-danger">*</span></label>
                                <textarea name="quote" id="quote" rows="4"
                                          class="form-control @error('quote') is-invalid @enderror" required>{{ old('quote') }}</textarea>
                                @error('quote')
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
