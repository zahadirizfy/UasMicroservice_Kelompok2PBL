@extends('backend.layouts.main')
@section('title', 'Halaman Club')
@section('navMhs', 'active')

@section('content')
    <div class="text-center mb-4">
        <h2>Klub</h2>
        <hr>
    </div>

    @if (session('success'))
        <div style="background-color: #d4edda; color: #155724; padding: 10px; margin-bottom: 10px; border-radius: 5px;">
            {{ session('success') }}
        </div>
    @endif

    <div style="display: flex; align-items: center; gap: 10px;">
        <a href="{{ route('backend.club.create') }}" class="btn btn-primary"
            style="font-size: 17px; padding: 6px 12px; height: 38px; display: flex; align-items: center;">
            <i class="fas fa-plus me-1"></i> Tambah Klub
        </a>
    </div>

    <table id="example" class="table table-bordered table-striped mt-3 text-center tableExportArea">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Nama Klub</th>
                <th>Lokasi</th>
                <th>Deskripsi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($clubs as $club)
                @php
                    $canEditDelete = Auth::user()->role === 'admin' || Auth::id() === $club->user_id;
                @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $club->nama }}</td>
                    <td>{{ $club->lokasi }}</td>
                    <td>{{ $club->deskripsi }}</td>
                    <td>
                        <a href="{{ $canEditDelete ? route('backend.club.edit', $club->id) : '#' }}"
                           class="btn btn-warning {{ !$canEditDelete ? 'disabled' : '' }}"
                           title="{{ !$canEditDelete ? 'Hanya admin atau pemilik data yang dapat edit' : 'Edit data' }}">
                           <i class="fas fa-edit"></i> Edit
                        </a>

                        <form action="{{ route('backend.club.destroy', $club->id) }}"
                              method="POST"
                              style="display:inline;"
                              onsubmit="return {{ $canEditDelete ? 'confirmDelete()' : 'false' }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="btn btn-danger {{ !$canEditDelete ? 'disabled' : '' }}"
                                    title="{{ !$canEditDelete ? 'Hanya admin atau pemilik data yang dapat hapus' : 'Hapus data' }}">
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
            return confirm('Yakin ingin menghapus data klub ini?');
        }
    </script>
@endsection
