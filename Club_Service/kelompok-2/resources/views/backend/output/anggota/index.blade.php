@extends('backend.layouts.main')
@section('title', 'Cetak Kartu Anggota')

@section('content')
    <div class="text-center mb-4">
        <h2>Data Anggota</h2>
        <hr>
    </div>

    <div class="mb-3 d-flex justify-content-between">
        <h5>Total Anggota: {{ $anggotas->count() }}</h5>
        <div>
            <a href="{{ route('backend.output.anggota.excel') }}" class="btn btn-success">
                <i class="fas fa-file-excel"></i> Export Excel
            </a>
            <a href="{{ route('backend.output.anggota.pdf') }}" class="btn btn-danger">
                <i class="fas fa-file-pdf"></i> Export PDF
            </a>
        </div>
    </div>

    <div class="row">
        @forelse ($anggotas as $anggota)
            <div class="col-md-4 col-lg-3 mb-4">
                <div class="card h-100 shadow-sm">
                    @if ($anggota->foto)
                        <img src="{{ asset('storage/' . $anggota->foto) }}"
                             class="card-img-top"
                             alt="Foto {{ $anggota->nama }}"
                             style="height: 200px; object-fit: cover; border-top-left-radius: 5px; border-top-right-radius: 5px;">
                    @else
                        <div class="card-img-top d-flex justify-content-center align-items-center bg-secondary text-white"
                             style="height: 200px;">
                            Tidak Ada Foto
                        </div>
                    @endif
                    <div class="card-body">
                        <h5 class="card-title mb-1">{{ $anggota->nama }}</h5>
                        <p class="card-text mb-1"><strong>Klub:</strong> {{ $anggota->klub }}</p>
                        <p class="card-text mb-1"><strong>Tgl Lahir:</strong> {{ $anggota->tgl_lahir }}</p>
                        <p class="card-text mb-1"><strong>Peran:</strong> {{ $anggota->peran }}</p>
                        <p class="card-text"><strong>WA:</strong> {{ $anggota->kontak }}</p>
                    </div>
                    <div class="card-footer text-center">
                        <a href="{{ route('backend.output.anggota.cetak', $anggota->id) }}" target="_blank" class="btn btn-success btn-sm">
                            <i class="fas fa-id-card"></i> Cetak Kartu
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center">
                <p>Belum ada data anggota.</p>
            </div>
        @endforelse
    </div>
@endsection
