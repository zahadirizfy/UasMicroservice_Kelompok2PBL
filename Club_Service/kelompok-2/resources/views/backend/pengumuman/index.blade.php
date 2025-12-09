@extends('backend.layouts.main')
@section('title', 'Daftar Pengumuman')
@section('navMhs', 'active')

@section('content')
    <div class="container mt-4">
        <h2 class="mb-4 text-center">Daftar Pengumuman</h2>
        <hr>

        @if (session('success'))
            <div style="background-color: #d4edda; color: #155724; padding: 10px; margin-bottom: 10px; border-radius: 5px;">
                {{ session('success') }}
            </div>
        @endif

        <div class="d-flex justify-content-between mb-3">
            <a href="{{ route('backend.pengumuman.create') }}" class="btn btn-primary"><i class="fas fa-plus me-1"></i>Tambah
                Pengumuman</a>

        </div>

        <div class="row">
            @forelse($pengumumans as $item)
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm h-100">
                        @if ($item->foto)
                            <img src="{{ asset('uploads/pengumuman/' . $item->foto) }}" class="card-img-top"
                                alt="Foto Pengumuman" style="height: 200px; object-fit: cover;">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $item->judul }}</h5>
                            <small class="text-light">{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</small>
                            <p class="card-text mt-2">{{ Str::limit($item->isi, 100) }}</p>

                            <div class="d-flex justify-content-between">
                                <button class="btn btn-sm btn-info text-white"
                                    onclick="showDetailModal(`{{ addslashes($item->judul) }}`, `{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}`, `{{ addslashes($item->isi) }}`, `{{ $item->foto ?? '' }}`)">
                                    Detail
                                </button>
                                <div>
                                    <a href="{{ route('backend.pengumuman.edit', $item->id) }}"
                                        class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('backend.pengumuman.destroy', $item->id) }}" method="POST"
                                        style="display:inline;" onsubmit="return handleDeletePengumuman()">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="col-12 text-center">
                        <p>Belum ada pengumuman.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Modal Detail -->
    <div id="detailModal" class="modal" onclick="closeModal()">
        <div class="modal-content-wrapper" onclick="event.stopPropagation()">
            <span class="close" onclick="closeModal()">&times;</span>
            <h3 id="modalJudul" class="modal-title text-white mt-3"></h3>
            <p id="modalTanggal" class="text-white mb-2"></p>
            <p id="modalIsi" class="modal-description text-white"></p>
            <div id="modalFoto" class="mt-3"></div>
        </div>
    </div>

    {{-- CSS --}}
    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 1050;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.85);
            overflow-y: auto;
        }

        .modal-content-wrapper {
            margin: 50px auto;
            max-width: 70%;
            padding: 30px;
            background: #222;
            border-radius: 15px;
        }

        .modal-title {
            font-size: 1.8rem;
            font-weight: bold;
        }

        .modal-description {
            font-size: 1.1rem;
            line-height: 1.5;
        }

        .close {
            color: white;
            float: right;
            font-size: 2rem;
            font-weight: bold;
            cursor: pointer;
        }
    </style>

    {{-- JS --}}
    <script>
        function handleDeletePengumuman() {
            const userRole = @json(Auth::user()->role);
            if (userRole !== 'admin' && userRole !== 'penyelenggara') {
                alert('Hanya admin atau penyelenggara yang dapat menghapus.');
                return false;
            }
            return confirm('Yakin ingin menghapus pengumuman ini?');
        }

        function showDetailModal(judul, tanggal, isi, foto) {
            const assetBaseUrl = '{{ asset('uploads/pengumuman') }}';
            document.getElementById('modalJudul').innerText = judul;
            document.getElementById('modalTanggal').innerText = `Tanggal: ${tanggal}`;
            document.getElementById('modalIsi').innerText = isi;

            if (foto) {
                document.getElementById('modalFoto').innerHTML =
                    `<img src="${assetBaseUrl}/${foto}" style="max-width: 100%; border-radius: 8px;">`;
            } else {
                document.getElementById('modalFoto').innerHTML = '';
            }

            document.getElementById('detailModal').style.display = 'block';
        }

        function closeModal() {
            document.getElementById('detailModal').style.display = 'none';
        }
    </script>
@endsection
