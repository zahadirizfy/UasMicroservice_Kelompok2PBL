@extends('backend.layouts.main')
@section('title', 'Output Data Club')
@section('navMhs', 'active')

@section('content')
    <div class="text-center mb-4">
        <h2>Data Klub</h2>
        <hr>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Tombol Export --}}
    <div class="mb-3 d-flex justify-content-end gap-2">
        <a href="{{ route('backend.output.club.excel') }}" class="btn btn-success">
            <i class="fas fa-file-excel me-1"></i> Export Excel
        </a>
        <a href="{{ route('backend.output.club.pdf') }}" class="btn btn-danger" target="_blank">
            <i class="fas fa-file-pdf me-1"></i> Export PDF
        </a>
    </div>

    <table class="table table-bordered table-striped text-center">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Nama Klub</th>
                <th>Lokasi</th>
                <th>Deskripsi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($clubs as $club)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $club->nama }}</td>
                    <td>{{ $club->lokasi }}</td>
                    <td>{{ $club->deskripsi }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
