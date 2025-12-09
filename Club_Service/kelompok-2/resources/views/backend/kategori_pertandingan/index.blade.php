@extends('backend.layouts.main')

@section('title', 'Kategori Pertandingan')

@section('content')
<div class="text-center mb-4">
    <h2>Kategori Pertandingan</h2>
    <hr>
</div>

@if (session('success'))
    <div style="background-color: #d4edda; color: #155724; padding: 10px; margin-bottom: 10px; border-radius: 5px;">
        {{ session('success') }}
    </div>
@endif

<div class="mb-3">
    <a href="{{ route('backend.kategori_pertandingan.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-1"></i> Tambah Kategori Pertandingan
    </a>
</div>

<div class="table-responsive">
    <table id="example" class="table table-bordered table-striped text-center tableExportArea">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Nama Kategori</th>
                <th>Aturan</th>
                <th>Batasan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($kategoripertandingans as $index => $kategori)
                @php
                    $canEditDelete = Auth::user()->role === 'admin' || Auth::id() === $kategori->user_id;
                @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $kategori->nama }}</td>
                    <td>{{ Str::limit($kategori->aturan, 50) }}</td>
                    <td>{{ Str::limit($kategori->batasan, 50) }}</td>
                    <td class="text-nowrap">
                        <a href="{{ $canEditDelete ? route('backend.kategori_pertandingan.edit', $kategori->id) : '#' }}"
                           class="btn btn-warning btn-sm {{ !$canEditDelete ? 'disabled' : '' }}"
                           title="{{ !$canEditDelete ? 'Hanya admin atau pembuat data yang dapat edit' : 'Edit data' }}">
                            <i class="fas fa-edit"></i> Edit
                        </a>

                        <form action="{{ route('backend.kategori_pertandingan.destroy', $kategori->id) }}"
                              method="POST"
                              style="display:inline;"
                              onsubmit="return {{ $canEditDelete ? 'confirmDelete()' : 'false' }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="btn btn-danger btn-sm {{ !$canEditDelete ? 'disabled' : '' }}"
                                    title="{{ !$canEditDelete ? 'Hanya admin atau pembuat data yang dapat hapus' : 'Hapus data' }}">
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
        return confirm('Yakin ingin menghapus kategori pertandingan ini?');
    }
</script>
@endsection
