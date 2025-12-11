@extends('backend.layouts.main')
@section('title', 'Halaman Penyelenggara Event')
@section('navEvent', 'active')

@section('content')
    <div class="text-center mb-4">
        <h2>Penyelenggara Event</h2>
        <hr>
    </div>

    @if (session('success'))
        <div style="background-color: #d4edda; color: #155724; padding: 10px; margin-bottom: 10px; border-radius: 5px;">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-3">
        <a href="{{ route('backend.penyelenggara_event.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Tambah Penyelenggara
        </a>
    </div>

    <div class="table-responsive">
        <table id="example" class="table table-bordered table-striped text-center tableExportArea">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Nama Penyelenggara</th>
                    <th>Kontak</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($penyelenggara_events as $penyelenggara)
                    @php
                        $canEditDelete = Auth::user()->role === 'admin' || Auth::id() === $penyelenggara->user_id;
                    @endphp
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $penyelenggara->nama_penyelenggara_event }}</td>
                        <td>{{ $penyelenggara->kontak }}</td>
                        <td class="text-nowrap">
                            <a href="{{ $canEditDelete ? route('backend.penyelenggara_event.edit', $penyelenggara->id) : '#' }}"
                               class="btn btn-warning btn-sm {{ !$canEditDelete ? 'disabled' : '' }}"
                               title="{{ !$canEditDelete ? 'Hanya admin atau pemilik data yang dapat edit' : 'Edit data' }}">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('backend.penyelenggara_event.destroy', $penyelenggara->id) }}"
                                  method="POST"
                                  style="display:inline;"
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
            return confirm('Yakin ingin menghapus data penyelenggara ini?');
        }
    </script>
@endsection
