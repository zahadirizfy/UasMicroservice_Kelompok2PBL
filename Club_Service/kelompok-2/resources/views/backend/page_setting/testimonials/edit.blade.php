@extends('backend.layouts.app')

@section('title', 'Edit Testimonial')

@section('content')
<div class="container mt-4 mb-5">
    <div class="card shadow border-0">
        <div class="card-body">
            <h3 class="card-title text-center mb-4">Edit Testimonial</h3>
            <hr>

            <form action="{{ route('backend.testimonials.update', $testimonial->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Foto --}}
                <div class="mb-3">
                    <label for="image" class="form-label fw-bold">Foto</label><br>
                    @if ($testimonial->image && file_exists(public_path('uploads/testimonials/' . $testimonial->image)))
                        <img src="{{ asset('uploads/testimonials/' . $testimonial->image) }}"
                             alt="Foto Lama" width="150" class="mb-2 d-block rounded shadow-sm">
                    @else
                        <span class="badge bg-secondary mb-2">Belum ada foto</span>
                    @endif
                    <input type="file" name="image" id="image"
                           class="form-control @error('image') is-invalid @enderror" accept="image/*">
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Nama --}}
                <div class="mb-3">
                    <label for="name" class="form-label fw-bold">Nama <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="name"
                           class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name', $testimonial->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Profesi --}}
                <div class="mb-3">
                    <label for="profession" class="form-label fw-bold">Profesi <span class="text-danger">*</span></label>
                    <input type="text" name="profession" id="profession"
                           class="form-control @error('profession') is-invalid @enderror"
                           value="{{ old('profession', $testimonial->profession) }}" required>
                    @error('profession')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Quote --}}
                <div class="mb-3">
                    <label for="quote" class="form-label fw-bold">Quote <span class="text-danger">*</span></label>
                    <textarea name="quote" id="quote" rows="4"
                              class="form-control @error('quote') is-invalid @enderror" required>{{ old('quote', $testimonial->quote) }}</textarea>
                    @error('quote')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Tombol --}}
                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('backend.testimonials.index') }}" class="btn btn-secondary">← Kembali</a>
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
