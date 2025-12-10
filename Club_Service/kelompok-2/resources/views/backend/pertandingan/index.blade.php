@extends('backend.layouts.main')
@section('title', 'Halaman Pertandingan')
@section('navMhs', 'active')

@section('content')
<div class="text-center mb-4">
    <h2>Pertandingan</h2>
    <hr>
</div>

@if (session('success'))
    <div style="background-color: #d4edda; color: #155724; padding: 10px; margin-bottom: 10px; border-radius: 5px;">
        {{ session('success') }}
    </div>
@endif

<div class="mb-3">
    <a href="{{ route('backend.pertandingan.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-1"></i> Tambah Pertandingan
    </a>
</div>

<div class="table-responsive">
    <table id="example" class="table table-bordered table-striped text-center tableExportArea">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Nama Pertandingan</th>
                <th>Penyelenggara</th>
                <th>Juri</th>
                <th>Peserta</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pertandingans as $pertandingan)
                @php
                    $canManage = Auth::user()->role === 'admin' ||
                        (Auth::user()->role === 'penyelenggara' && Auth::id() === optional($pertandingan->penyelenggaraEvent)->user_id);
                @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $pertandingan->nama_pertandingan }}</td>
                    <td>{{ $pertandingan->penyelenggaraEvent->nama_penyelenggara_event ?? '-' }}</td>
                    <td>{{ $pertandingan->juri->nama_juri ?? '-' }}</td>
                    <td>
                        @if($canManage)
                            <a href="{{ route('backend.peserta.index', $pertandingan->id) }}"
                               class="btn btn-info btn-sm"
                               title="Kelola peserta pertandingan">
                               <i class="fas fa-users"></i> Kelola Peserta
                            </a>
                        @else
                            <button class="btn btn-secondary btn-sm" disabled
                                    title="Hanya admin atau penyelenggara event ini yang dapat mengelola peserta">
                                <i class="fas fa-users"></i> Kelola Peserta
                            </button>
                        @endif
                    </td>
                    <td class="text-nowrap">
                        @if($canManage)
                            <a href="{{ route('backend.pertandingan.edit', $pertandingan->id) }}"
                               class="btn btn-warning btn-sm" title="Edit data">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('backend.pertandingan.destroy', $pertandingan->id) }}"
                                  method="POST" style="display:inline;"
                                  onsubmit="return confirmDelete()">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" title="Hapus data">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        @else
                            <button class="btn btn-secondary btn-sm" disabled
                                    title="Hanya admin atau penyelenggara event ini yang dapat edit">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button class="btn btn-secondary btn-sm" disabled
                                    title="Hanya admin atau penyelenggara event ini yang dapat hapus">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    function confirmDelete() {
        return confirm('Yakin ingin menghapus pertandingan ini?');
    }
</script>
@endsection
