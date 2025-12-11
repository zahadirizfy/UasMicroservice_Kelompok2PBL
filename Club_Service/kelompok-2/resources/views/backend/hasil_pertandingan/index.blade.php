@extends('backend.layouts.main')
@section('title', 'Hasil Pertandingan')
@section('navMhs', 'active')

@section('content')
<div class="text-center mb-4">
    <h2>Hasil Pertandingan</h2>
    <hr>
</div>

@if (session('success'))
    <div style="background-color: #d4edda; color: #155724; padding: 10px; margin-bottom: 10px; border-radius: 5px;">
        {{ session('success') }}
    </div>
@endif

<div class="d-flex justify-content-start gap-2 mb-3">
    <a href="{{ route('backend.hasil_pertandingan.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-1"></i> Tambah Pertandingan ke Daftar
    </a>
</div>

<table class="table table-bordered table-striped text-center" id="example">
    <thead class="table-dark">
        <tr>
            <th>No</th>
            <th>Nama Pertandingan</th>
            <th>Hasil Pertandingan</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($hasilPertandingans as $index => $hasil)
            @php
                $canDelete = Auth::user()->role === 'admin' || Auth::id() === $hasil->user_id;
            @endphp
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $hasil->pertandingan->nama_pertandingan ?? '-' }}</td>
                <td>
                    <a href="{{ route('backend.detail_hasil_pertandingan.index', $hasil->id) }}"
                       class="btn btn-primary btn-sm">
                       Input Hasil
                    </a>
                </td>
                <td>
                    <form action="{{ route('backend.hasil_pertandingan.destroy', $hasil->id) }}"
                          method="POST"
                          class="d-inline"
                          onsubmit="return {{ $canDelete ? 'confirmDelete()' : 'false' }};">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="btn btn-danger btn-sm {{ !$canDelete ? 'disabled' : '' }}"
                                title="{{ !$canDelete ? 'Hanya admin atau pemilik data yang dapat menghapus' : 'Hapus data' }}">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<script>
    function confirmDelete() {
        return confirm('Yakin ingin menghapus pertandingan ini dari daftar hasil?');
    }
</script>
@endsection
