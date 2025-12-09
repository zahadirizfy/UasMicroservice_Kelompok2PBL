@extends('backend.layouts.main')
@section('title', 'Halaman Jadwal Pertandingan')
@section('navMhs', 'active')

@section('content')
<div class="text-center mb-4">
    <h2>Jadwal Pertandingan</h2>
    <hr>
</div>

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="mb-3">
    <a href="{{ route('backend.jadwal_pertandingan.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-1"></i> Tambah Jadwal Pertandingan
    </a>
</div>

<div class="table-responsive">
    <table id="example" class="table table-bordered table-striped text-center tableExportArea">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Nama Pertandingan</th>
                <th>Tanggal</th>
                <th>Waktu</th>
                <th>Lokasi</th>
                <th>Deskripsi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($jadwalpertandingans as $jadwal)
                @php
                    $canEditDelete = Auth::user()->role === 'admin' ||
                                     (optional($jadwal->pertandingan->penyelenggaraEvent)->user_id ?? null) === Auth::id();
                @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $jadwal->pertandingan->nama_pertandingan ?? '-' }}</td>
                    <td>{{ optional($jadwal->tanggal)->format('d/m/Y') }}</td>
                    <td>{{ optional(\Carbon\Carbon::parse($jadwal->waktu))->format('H:i') }}</td>
                    <td>{{ $jadwal->lokasi }}</td>
                    <td>{{ Str::limit($jadwal->deskripsi, 50) }}</td>
                    <td class="text-nowrap">
                        <a href="{{ $canEditDelete ? route('backend.jadwal_pertandingan.edit', $jadwal->id) : '#' }}"
                           class="btn btn-warning btn-sm {{ !$canEditDelete ? 'disabled' : '' }}"
                           title="{{ !$canEditDelete ? 'Hanya admin atau penyelenggara yang dapat edit' : 'Edit data' }}">
                            <i class="fas fa-edit"></i> Edit
                        </a>

                        <form action="{{ route('backend.jadwal_pertandingan.destroy', $jadwal->id) }}"
                              method="POST"
                              style="display:inline;"
                              onsubmit="return {{ $canEditDelete ? 'confirmDelete()' : 'false' }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="btn btn-danger btn-sm {{ !$canEditDelete ? 'disabled' : '' }}"
                                    title="{{ !$canEditDelete ? 'Hanya admin atau penyelenggara yang dapat hapus' : 'Hapus data' }}">
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
        return confirm('Yakin ingin menghapus jadwal pertandingan ini?');
    }
</script>

<style>
    td {
        max-width: 200px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
</style>
@endsection
