@extends('backend.layouts.main')
@section('title', 'Halaman Atlet')
@section('navMhs', 'active')

@section('content')
    <div class="text-center mb-4">
        <h2>Daftar Atlet</h2>
        <hr>
    </div>

    @if (session('success'))
        <div style="background-color: #d4edda; color: #155724; padding: 10px; margin-bottom: 10px; border-radius: 5px;">
            {{ session('success') }}
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ route('backend.atlet.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Tambah Atlet
        </a>
    </div>

    <div class="row">
        @forelse ($atlets as $atlet)
            <div class="col-md-4 col-lg-3 mb-4">
                <div class="card h-100 shadow-sm">
                    @if ($atlet->foto)
                        <img src="{{ asset('storage/' . $atlet->foto) }}"
                             alt="Foto {{ $atlet->nama }}"
                             class="card-img-top"
                             style="height: 200px; object-fit: cover; border-top-left-radius: 5px; border-top-right-radius: 5px; cursor: pointer;"
                             onclick="openModal('{{ asset('storage/' . $atlet->foto) }}', '{{ addslashes($atlet->nama) }}')">
                    @else
                        <div class="card-img-top bg-secondary d-flex align-items-center justify-content-center text-white" style="height: 200px;">
                            Tidak Ada Foto
                        </div>
                    @endif

                    <div class="card-body">
                        <h5 class="card-title">{{ $atlet->nama }}</h5>
                        <p class="mb-1"><strong>Klub:</strong> {{ $atlet->club->nama ?? '-' }}</p>
                        <p class="mb-1"><strong>Prestasi:</strong> {{ $atlet->prestasi ?: '-' }}</p>
                    </div>

                    @php
                        $canEditDelete = Auth::user()->role === 'admin' || Auth::id() === $atlet->user_id;
                    @endphp

                    <div class="card-footer d-flex justify-content-between">
                        <a href="{{ $canEditDelete ? route('backend.atlet.edit', $atlet->id) : '#' }}"
                           class="btn btn-warning btn-sm {{ !$canEditDelete ? 'disabled' : '' }}"
                           title="{{ !$canEditDelete ? 'Hanya admin atau pemilik data yang dapat edit' : 'Edit data' }}">
                            <i class="fas fa-edit"></i> Edit
                        </a>

                        <form action="{{ route('backend.atlet.destroy', $atlet->id) }}" method="POST"
                              class="d-inline"
                              onsubmit="return {{ $canEditDelete ? 'confirmDelete()' : 'false' }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="btn btn-danger btn-sm {{ !$canEditDelete ? 'disabled' : '' }}"
                                    title="{{ !$canEditDelete ? 'Hanya admin atau pemilik data yang dapat hapus' : 'Hapus data' }}">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center">
                <p>Belum ada data atlet.</p>
            </div>
        @endforelse
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
            color: white;
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
            return confirm('Yakin ingin menghapus data atlet ini?');
        }
    </script>
@endsection
