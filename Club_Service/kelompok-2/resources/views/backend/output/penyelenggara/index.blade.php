@extends('backend.layouts.main')
@section('title', 'Output Data Penyelenggara Event')
@section('navEvent', 'active')

@section('content')
    <div class="text-center mb-4">
        <h2>Data Penyelenggara Event</h2>
        <hr>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Tombol Ekspor --}}
    <div class="mb-3 d-flex justify-content-end gap-2">
        <a href="{{ route('backend.output.penyelenggara.excel') }}" class="btn btn-success btn-sm">
            <i class="fas fa-file-excel"></i> Export Excel
        </a>
        <a href="{{ route('backend.output.penyelenggara.pdf') }}" target="_blank" class="btn btn-danger btn-sm">
            <i class="fas fa-file-pdf"></i> Export PDF
        </a>
        
    </div>

    <table class="table table-bordered table-striped text-center">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Nama Penyelenggara</th>
                <th>Kontak</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($penyelenggaras as $penyelenggara)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                     <td>{{ $penyelenggara->nama_penyelenggara_event }}</td>
                    <td>{{ $penyelenggara->kontak }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center text-muted">Belum ada data penyelenggara.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
