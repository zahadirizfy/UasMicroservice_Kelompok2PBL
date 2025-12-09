@extends('backend.layouts.main')
@section('title', 'Halaman Galeri')
@section('navMhs', 'active')

@section('content')
<div class="container mt-4">
    <h2 class="text-center mb-4">Galeri</h2>
    <hr>

   @if (session('success'))
        <div style="background-color: #d4edda; color: #155724; padding: 10px; margin-bottom: 10px; border-radius: 5px;">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-3 d-flex align-items-center gap-2">
        <a href="{{ route('backend.galeri.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Tambah Galeri
        </a>
    </div>

    <div class="row row-cols-1 row-cols-md-3 g-4">
        @forelse ($galeris as $galeri)
            @php
                $canEditDelete = Auth::user()->role === 'admin' || Auth::id() === $galeri->user_id;
            @endphp
            <div class="col">
                <div class="card shadow-sm rounded-4 h-100">
                    <img src="{{ asset('uploads/' . $galeri->gambar) }}"
                         class="card-img-top"
                         alt="gambar"
                         style="height: 200px; object-fit: cover; border-top-left-radius: 5px; border-top-right-radius: 5px; cursor: pointer;"
                         onclick="openModal('{{ asset('uploads/' . $galeri->gambar) }}', '{{ addslashes($galeri->judul) }}')">
                    <div class="card-body">
                        <h5 class="card-title fw-bold">{{ $galeri->judul }}</h5>
                        <p class="card-text">{{ $galeri->deskripsi }}</p>
                    </div>
                    <div class="card-footer bg-transparent border-top-0 d-flex justify-content-between">
                        <a href="{{ $canEditDelete ? route('backend.galeri.edit', $galeri->id) : '#' }}"
                           class="btn btn-warning btn-sm {{ !$canEditDelete ? 'disabled' : '' }}"
                           title="{{ !$canEditDelete ? 'Hanya admin atau pemilik data yang dapat mengedit' : 'Edit data' }}">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('backend.galeri.destroy', $galeri->id) }}"
                              method="POST"
                              onsubmit="return {{ $canEditDelete ? 'confirmDelete()' : 'false' }}"
                              style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="btn btn-danger btn-sm {{ !$canEditDelete ? 'disabled' : '' }}"
                                    title="{{ !$canEditDelete ? 'Hanya admin atau pemilik data yang dapat menghapus' : 'Hapus data' }}">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center">
                <p>Belum ada galeri.</p>
            </div>
        @endforelse
    </div>
</div>

{{-- Modal Preview --}}
<div id="imageModal" class="modal" onclick="closeModal()">
    <span class="close" onclick="closeModal()">&times;</span>
    <div class="modal-content-wrapper" onclick="event.stopPropagation()">
        <img id="modalImage" class="modal-image mb-3">
        <h3 id="modalTitle" class="modal-title text-white mt-3"></h3>
    </div>
</div>

{{-- CSS Modal --}}
<style>
    .modal {
        display: none;
        position: fixed;
        z-index: 1050;
        padding-top: 60px;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow-y: auto;
        background-color: rgba(0, 0, 0, 0.9);
    }

    .modal-content-wrapper {
        text-align: center;
        max-width: 90%;
        margin: auto;
    }

    .modal-image {
        max-width: 100%;
        max-height: 75vh;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.4);
    }

    .modal-title {
        font-size: 1.8rem;
        font-weight: bold;
    }

    .close {
        position: absolute;
        top: 20px;
        right: 35px;
        color: #ffffff;
        font-size: 40px;
        font-weight: bold;
        cursor: pointer;
    }
</style>

{{-- Script --}}
<script>
    function openModal(imageSrc, title) {
        document.getElementById("imageModal").style.display = "block";
        document.getElementById("modalImage").src = imageSrc;
        document.getElementById("modalTitle").innerText = title;
    }

    function closeModal() {
        document.getElementById("imageModal").style.display = "none";
    }

    function confirmDelete() {
        return confirm('Yakin ingin menghapus galeri ini?');
    }
</script>
@endsection
