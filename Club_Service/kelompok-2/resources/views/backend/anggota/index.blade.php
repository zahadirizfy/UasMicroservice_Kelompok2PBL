@extends('backend.layouts.main')
@section('title', 'Halaman Anggota')
@section('navMhs', 'active')

@section('content')
    <div class="text-center mb-4">
        <h2>Daftar Anggota</h2>
        <hr>
    </div>

    @if (session('success'))
        <div style="background-color: #d4edda; color: #155724; padding: 10px; margin-bottom: 10px; border-radius: 5px;">
            {{ session('success') }}
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ route('backend.anggota.create') }}" class="btn btn-primary">
            <i class="fa fa-plus"></i> Tambah Anggota
        </a>
    </div>

    <div class="row">
        @forelse ($anggotas as $anggota)
            <div class="col-md-4 col-lg-3 mb-4">
                <div class="card h-100 shadow-sm">
                    @if ($anggota->foto)
                        <img src="{{ asset('storage/' . $anggota->foto) }}"
                             class="card-img-top"
                             alt="Foto {{ $anggota->nama }}"
                             style="height: 200px; object-fit: cover; border-top-left-radius: 5px; border-top-right-radius: 5px; cursor: pointer;"
                             onclick="openModal('{{ asset('storage/' . $anggota->foto) }}', `{{ addslashes($anggota->nama) }}`)">
                    @else
                        <div class="card-img-top d-flex justify-content-center align-items-center bg-secondary text-white"
                            style="height: 200px;">
                            Tidak Ada Foto
                        </div>
                    @endif
                    <div class="card-body">
                        <h5 class="card-title mb-1">{{ $anggota->nama }}</h5>
                        <p class="card-text mb-1"><strong>Klub:</strong> {{ $anggota->klub }}</p>
                        <p class="card-text mb-1"><strong>Tgl Lahir:</strong> {{ $anggota->tgl_lahir }}</p>
                        <p class="card-text mb-1"><strong>Peran:</strong> {{ $anggota->peran }}</p>
                        <p class="card-text"><strong>WA:</strong> {{ $anggota->kontak }}</p>

                        @php
                            $canEditDelete = Auth::user()->role === 'admin' || Auth::id() === $anggota->user_id;
                        @endphp

                        @if($canEditDelete)
                            <a href="{{ route('backend.rekap_latihan.index', $anggota->id) }}"
                               class="btn btn-sm btn-secondary">Rekap Latihan</a>
                        @else
                            <button class="btn btn-sm btn-secondary" disabled
                                    title="Hanya admin atau pemilik data yang dapat akses rekap">Rekap Latihan</button>
                        @endif
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <a href="{{ $canEditDelete ? route('backend.anggota.edit', $anggota->id) : '#' }}"
                           class="btn btn-sm btn-warning {{ !$canEditDelete ? 'disabled' : '' }}"
                           title="{{ !$canEditDelete ? 'Hanya admin atau pemilik data yang dapat edit' : 'Edit data' }}">
                            <i class="fas fa-edit"></i> Edit
                        </a>

                        <form action="{{ route('backend.anggota.destroy', $anggota->id) }}" method="POST"
                              class="d-inline"
                              onsubmit="return {{ $canEditDelete ? 'confirmDelete()' : 'false' }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="btn btn-sm btn-danger {{ !$canEditDelete ? 'disabled' : '' }}"
                                    title="{{ !$canEditDelete ? 'Hanya admin atau pemilik data yang dapat hapus' : 'Hapus data' }}">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center">
                <p>Belum ada data anggota.</p>
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
            return confirm('Yakin ingin menghapus data ini?');
        }
    </script>
@endsection
