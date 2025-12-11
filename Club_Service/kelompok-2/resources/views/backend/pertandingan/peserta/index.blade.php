@extends('backend.layouts.app')

@section('title', 'Peserta Pertandingan')

@section('content')
    <div class="container mt-4 mb-5">
        <h2 class="mb-4 text-center">Peserta Pertandingan: {{ $pertandingan->nama_pertandingan }}</h2>
        <hr>

        @if (session('success'))
        <div style="background-color: #d4edda; color: #155724; padding: 10px; margin-bottom: 10px; border-radius: 5px;">
            {{ session('success') }}
        </div>
    @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-1"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Form Tambah Peserta --}}
        <div class="mb-4">
            <form action="{{ route('backend.peserta.store', $pertandingan->id) }}" method="POST" class="row gy-2 align-items-end">
                @csrf
                <div class="col-md-8">
                    <label for="atlet_id" class="form-label">Pilih Atlet</label>
                    <select name="atlet_id" class="form-select" required>
                        <option value="">-- Pilih Atlet --</option>
                        @foreach ($semuaAtlet as $atlet)
                            @if (!$pertandingan->atlets->contains($atlet->id))
                                <option value="{{ $atlet->id }}">{{ $atlet->nama }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-plus"></i> Tambah Peserta
                    </button>
                </div>
            </form>
        </div>

        {{-- Daftar Peserta --}}
        <div class="table-responsive">
            <table class="table table-bordered text-center">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama Atlet</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pertandingan->atlets as $peserta)
                        @php
                            $canDelete = Auth::user()->role === 'admin' ||
                                (Auth::user()->role === 'penyelenggara' && Auth::id() === optional($pertandingan->penyelenggaraEvent)->user_id);
                        @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $peserta->nama }}</td>
                            <td>
                                <form action="{{ route('backend.peserta.destroy', [$pertandingan->id, $peserta->id]) }}"
                                      method="POST"
                                      onsubmit="return {{ $canDelete ? 'confirmDelete()' : 'false' }}"
                                      style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="btn btn-danger btn-sm {{ !$canDelete ? 'disabled' : '' }}"
                                            title="{{ !$canDelete ? 'Hanya admin atau penyelenggara event ini yang dapat menghapus' : 'Hapus peserta' }}">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">Belum ada peserta ditambahkan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            <a href="{{ route('backend.pertandingan.index') }}" class="btn btn-secondary">
                ← Kembali ke Daftar Pertandingan
            </a>
        </div>
    </div>

    <script>
        function confirmDelete() {
            return confirm('Yakin ingin menghapus peserta ini?');
        }
    </script>
@endsection
