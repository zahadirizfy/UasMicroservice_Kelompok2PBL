@extends('backend.layouts.app')

@section('title', 'Edit Contact')

@section('content')
<div class="container mt-4 mb-5">
    <div class="card shadow border-0">
        <div class="card-header bg-gradient-primary text-white">
            <h4 class="mb-0"><i class="fas fa-address-book me-2"></i> Edit Contact</h4>
        </div>
        <div class="card-body">

            {{-- Pesan sukses --}}
            @if (session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
                </div>
            @endif

            {{-- Form --}}
            <form action="{{ route('backend.contact.update', $contact->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    {{-- Alamat --}}
                    <div class="col-12">
                        <label for="address" class="form-label fw-semibold">Alamat <span class="text-danger">*</span></label>
                        <textarea name="address" id="address" rows="3"
                            class="form-control @error('address') is-invalid @enderror" required>{{ old('address', $contact->address ?? '') }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Telepon --}}
                    <div class="col-md-6">
                        <label for="phone" class="form-label fw-semibold">Telepon <span class="text-danger">*</span></label>
                        <input type="number" name="phone" id="phone"
                            class="form-control @error('phone') is-invalid @enderror"
                            value="{{ old('phone', $contact->phone ?? '') }}" required>
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div class="col-md-6">
                        <label for="email" class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" id="email"
                            class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email', $contact->email ?? '') }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- X --}}
                     <div class="col-md-6">
                        <label for="x" class="form-label fw-semibold">Twitter <span class="text-danger">*</span></label>
                        <input type="url" name="x" id="x"
                            class="form-control @error('x') is-invalid @enderror"
                            value="{{ old('x', $contact->x ?? '') }}">
                        @error('x')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                     {{-- FB --}}
                     <div class="col-md-6">
                        <label for="fb" class="form-label fw-semibold">Facebook <span class="text-danger">*</span></label>
                        <input type="url" name="fb" id="fb"
                            class="form-control @error('fb') is-invalid @enderror"
                            value="{{ old('fb', $contact->fb ?? '') }}">
                        @error('fb')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- IG --}}
                     <div class="col-md-6">
                        <label for="ig" class="form-label fw-semibold">Instagram <span class="text-danger">*</span></label>
                        <input type="url" name="ig" id="ig"
                            class="form-control @error('ig') is-invalid @enderror"
                            value="{{ old('ig', $contact->ig ?? '') }}">
                        @error('ig')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- LN --}}
                     <div class="col-md-6">
                        <label for="ln" class="form-label fw-semibold">Linkedln <span class="text-danger">*</span></label>
                        <input type="url" name="ln" id="ln"
                            class="form-control @error('ln') is-invalid @enderror"
                            value="{{ old('ln', $contact->ln ?? '') }}">
                        @error('ln')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Latitude --}}
                    <div class="col-md-6">
                        <label for="latitude" class="form-label fw-semibold">Latitude</label>
                        <input type="text" name="latitude" id="latitude"
                            class="form-control @error('latitude') is-invalid @enderror"
                            value="{{ old('latitude', $contact->latitude ?? '') }}">
                        @error('latitude')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Longitude --}}
                    <div class="col-md-6">
                        <label for="longitude" class="form-label fw-semibold">Longitude</label>
                        <input type="text" name="longitude" id="longitude"
                            class="form-control @error('longitude') is-invalid @enderror"
                            value="{{ old('longitude', $contact->longitude ?? '') }}">
                        @error('longitude')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Tombol --}}
                <div class="mt-4 d-flex justify-content-between">
                    <a href="{{ route('backend.contact.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                    <div>
                        <button type="reset" class="btn btn-warning me-2">
                            <i class="fas fa-rotate-left me-1"></i> Reset
                        </button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save me-1"></i> Simpan
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
