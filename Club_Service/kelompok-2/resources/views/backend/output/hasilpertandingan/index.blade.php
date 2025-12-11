@extends('backend.layouts.main')

@section('title', 'Output Hasil Pertandingan')

@section('content')
    <div class="container-fluid mt-4">
        <h2 class="mb-4 text-center">Data Hasil Pertandingan</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card shadow border-0">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped text-center">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Pertandingan</th>
                                <th>Tanggal</th>
                                <th>Waktu</th>
                                <th>Lokasi</th>
                                <th>Penyelenggara</th>
                                <th>Juri</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pertandingans as $pertandingan)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $pertandingan->nama_pertandingan }}</td>
                                    <td class="text-center">
                                        {{ optional($pertandingan->jadwalPertandingan)->tanggal
                                            ? \Carbon\Carbon::parse($pertandingan->jadwalPertandingan->tanggal)->format('d-m-Y')
                                            : '-' }}
                                    </td>
                                    <td class="text-center">
                                        {{ optional($pertandingan->jadwalPertandingan)->waktu
                                            ? \Carbon\Carbon::parse($pertandingan->jadwalPertandingan->waktu)->format('H:i')
                                            : '-' }}
                                    </td>
                                    <td>{{ optional($pertandingan->jadwalPertandingan)->lokasi ?? '-' }}</td>
                                    <td>{{ optional($pertandingan->penyelenggaraEvent)->nama_penyelenggara_event ?? '-' }}
                                    </td>
                                    <td>{{ optional($pertandingan->juri)->nama_juri ?? '-' }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('backend.output.hasilpertandingan.excel', $pertandingan->id) }}"
                                            class="btn btn-sm btn-success mb-1">
                                            <i class="fas fa-file-excel me-1"></i> Excel
                                        </a>
                                        <a href="{{ route('backend.output.hasilpertandingan.pdf', $pertandingan->id) }}"
                                            class="btn btn-sm btn-danger mb-1" target="_blank">
                                            <i class="fas fa-file-pdf me-1"></i> PDF
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-light">Belum ada data pertandingan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
