@extends('backend.layouts.app')
@section('title', 'Detail Hasil Pertandingan')

@section('content')
    <div class="container mt-4">
        <div class="text-center mb-4">
            <h2 class="fw-bold">Detail Hasil Pertandingan</h2>
            <hr>
            <h5>{{ $hasilPertandingan->pertandingan->nama_pertandingan }}</h5>
        </div>

        @if (session('success'))
            <div style="background-color: #d4edda; color: #155724; padding: 10px; margin-bottom: 10px; border-radius: 5px;">
                {{ session('success') }}
            </div>
        @endif

        {{-- Tombol Aksi --}}
        <div class="d-flex justify-content-between mb-3">
            <a href="{{ route('backend.detail_hasil_pertandingan.create', $hasilPertandingan->id) }}"
                class="btn btn-primary btn-sm">
                <i class="fas fa-plus me-1"></i> Tambah Hasil Peserta
            </a>
            <a href="{{ route('backend.hasil_pertandingan.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
        </div>

        {{-- Tabel --}}
        <table class="table table-bordered table-striped text-center" id="example">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>L1</th>
                    <th>L2</th>
                    <th>L3</th>
                    <th>L4</th>
                    <th>L5</th>
                    <th>Skor</th>
                    <th>Rangking</th>
                    <th>Catatan Juri</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($detailHasil as $index => $detail)
                    @php
                        $canEditDelete = Auth::user()->role === 'admin' || Auth::id() === $detail->user_id;
                    @endphp
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $detail->nama }}</td>
                        <td>{{ $detail->lemparan1 }}</td>
                        <td>{{ $detail->lemparan2 }}</td>
                        <td>{{ $detail->lemparan3 }}</td>
                        <td>{{ $detail->lemparan4 }}</td>
                        <td>{{ $detail->lemparan5 }}</td>
                        <td>{{ $detail->skor }}</td>
                        <td>{{ $detail->rangking }}</td>
                        <td>{{ $detail->catatan_juri }}</td>
                        <td class="text-nowrap">
                            <a href="{{ $canEditDelete ? route('backend.detail_hasil_pertandingan.edit', [$hasilPertandingan->id, $detail->id]) : '#' }}"
                                class="btn btn-warning btn-sm {{ !$canEditDelete ? 'disabled' : '' }}"
                                title="{{ !$canEditDelete ? 'Hanya admin atau pemilik data yang dapat edit' : 'Edit data' }}">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form
                                action="{{ route('backend.detail_hasil_pertandingan.destroy', [$hasilPertandingan->id, $detail->id]) }}"
                                method="POST" class="d-inline"
                                onsubmit="return {{ $canEditDelete ? 'confirmDelete()' : 'false' }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="btn btn-danger btn-sm {{ !$canEditDelete ? 'disabled' : '' }}"
                                    title="{{ !$canEditDelete ? 'Hanya admin atau pemilik data yang dapat hapus' : 'Hapus data' }}">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        function confirmDelete() {
            return confirm('Yakin ingin menghapus data hasil ini?');
        }
    </script>
@endsection
