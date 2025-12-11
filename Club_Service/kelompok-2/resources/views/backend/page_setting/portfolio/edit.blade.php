@extends('backend.layouts.app')

@section('title', 'Edit Portfolio')

@section('content')
    <div class="container mt-4 mb-5">
        <div class="card shadow border-0">
            <div class="card-body">
                <h3 class="card-title text-center mb-4">Edit Portfolio</h3>
                <hr>

                <form action="{{ route('backend.portfolio.update', $portfolio->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Gambar Portfolio --}}
                    <div class="mb-3">
                        <label for="image" class="form-label fw-bold">Gambar Portfolio</label><br>
                        @if ($portfolio->image && file_exists(public_path($portfolio->image)))
                            <img src="{{ asset($portfolio->image) }}" alt="Gambar Portfolio" width="200" class="mb-2 d-block rounded shadow-sm">
                        @else
                            <span class="text-muted d-block mb-2">Belum ada gambar</span>
                        @endif
                        <input type="file" name="image" id="image"
                            class="form-control @error('image') is-invalid @enderror" accept="image/*">
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Title --}}
                    <div class="mb-3">
                        <label for="title" class="form-label fw-bold">Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="title"
                            class="form-control @error('title') is-invalid @enderror"
                            value="{{ old('title', $portfolio->title) }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Category --}}
                    <div class="mb-3">
                        <label for="category" class="form-label fw-bold">Category</label>
                        <input type="text" name="category" id="category"
                            class="form-control @error('category') is-invalid @enderror"
                            value="{{ old('category', $portfolio->category) }}">
                        @error('category')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Description --}}
                    <div class="mb-3">
                        <label for="description" class="form-label fw-bold">Description</label>
                        <textarea name="description" id="description" rows="4"
                            class="form-control @error('description') is-invalid @enderror">{{ old('description', $portfolio->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Tombol --}}
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('backend.portfolio.index') }}" class="btn btn-secondary">← Kembali</a>
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
