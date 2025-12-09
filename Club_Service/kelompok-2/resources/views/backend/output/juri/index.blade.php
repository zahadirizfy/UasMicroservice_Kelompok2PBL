@extends('backend.layouts.main')
@section('title', 'Output Data Juri')
@section('navMhs', 'active')

@section('content')
    <div class="text-center mb-4">
        <h2>Data Juri</h2>
        <hr>
    </div>

    {{-- Alert sukses --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Tombol Export --}}
    <div class="mb-3 text-end">
        <a href="{{ route('backend.output.juri.excel') }}" class="btn btn-success btn-sm me-2">
            <i class="fas fa-file-excel"></i> Export Excel
        </a>
        <a href="{{ route('backend.output.juri.pdf') }}" class="btn btn-danger btn-sm" target="_blank">
            <i class="fas fa-file-pdf"></i> Export PDF
        </a>
    </div>

    {{-- Tabel --}}
    <div class="table-responsive">
        <table class="table table-bordered table-striped text-center align-middle tableExportArea">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Nama Juri</th>
                    <th>Tanggal Lahir</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($juris as $juri)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $juri->nama_juri }}</td>
                        <td>{{ \Carbon\Carbon::parse($juri->tanggal_lahir)->format('d-m-Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-muted">Belum ada data juri.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
