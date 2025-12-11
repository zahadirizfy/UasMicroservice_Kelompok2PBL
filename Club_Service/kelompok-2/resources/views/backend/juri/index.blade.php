@extends('backend.layouts.main')
@section('title', 'Halaman Juri')
@section('navMhs', 'active')

@section('content')
    <div class="text-center mb-4">
        <h2>Juri</h2>
        <hr>
    </div>

    @if (session('success'))
        <div style="background-color: #d4edda; color: #155724; padding: 10px; margin-bottom: 10px; border-radius: 5px;">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-3">
        <a href="{{ route('backend.juri.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Tambah Juri
        </a>
    </div>

    <div class="table-responsive">
        <table id="example" class="table table-bordered table-striped text-center tableExportArea">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Tanggal Lahir</th>
                    <th>Sertifikat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($juris as $juri)
                    @php
                        $canEditDelete = Auth::user()->role === 'admin' || Auth::id() === $juri->user_id;
                    @endphp
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $juri->nama_juri }}</td>
                        <td>{{ \Carbon\Carbon::parse($juri->tanggal_lahir)->format('d-m-Y') }}</td>
                        <td>
                            @if ($juri->sertifikat)
                                <a href="{{ asset('storage/' . $juri->sertifikat) }}" target="_blank">Lihat Sertifikat</a>
                            @else
                                <span class="text-muted">Tidak ada</span>
                            @endif
                        </td>
                        <td class="text-nowrap">
                            <a href="{{ $canEditDelete ? route('backend.juri.edit', $juri->id) : '#' }}"
                               class="btn btn-warning btn-sm {{ !$canEditDelete ? 'disabled' : '' }}"
                               title="{{ !$canEditDelete ? 'Hanya admin atau pemilik data yang dapat edit' : 'Edit data' }}">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('backend.juri.destroy', $juri->id) }}"
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
            return confirm('Yakin ingin menghapus data juri ini?');
        }
    </script>
@endsection
